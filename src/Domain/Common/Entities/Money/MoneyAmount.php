<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Money;

use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Entities\ValueObject;
use DDD\Infrastructure\Exceptions\BadRequestException;

class MoneyAmount extends ValueObject
{
    public Currency $currency;

    public ?float $amount = 0.0;

    public function __construct(float $amount = 0.0, string|Currency|null $currency = null)
    {
        $this->amount = $amount;
        if ($currency) {
            if (is_string($currency)) {
                $currency = Currency::byIsoCode($currency);
            }
        }
        if (!$currency) {
            $currency = new Currency();
        }
        $this->currency = $currency;
        parent::__construct();
    }

    public function setCurrencyByIsoCode(string $currencyIsoCode): void
    {
        $this->currency = Currency::byIsoCode($currencyIsoCode);
    }

    /**
     * @param MoneyAmount|null $other
     * @return bool
     */
    public function isEqualTo(?DefaultObject $other = null): bool
    {
        if (!($other instanceof MoneyAmount)) {
            return false;
        }
        return $this->amount === $other->amount && $this->currency->uniqueKey() === $other->currency->uniqueKey();
    }

    /**
     * Adds another MoneyAmount or scalar amount in-place. Returns $this for chaining.
     *
     * Same-currency invariant: when adding a MoneyAmount, both must agree on isoCode —
     * no implicit conversion. Use {@see self::convertToCurrency()} (where available on
     * a consumer subclass) to align currencies first if needed.
     *
     * @throws BadRequestException When adding a MoneyAmount whose currency differs from this one's.
     */
    public function add(MoneyAmount|float|int $other): static
    {
        if ($other instanceof MoneyAmount && $this->currency->isoCode !== $other->currency->isoCode) {
            throw new BadRequestException("Can't add MoneyAmounts with different currencies");
        }
        $amountToAdd = $other instanceof MoneyAmount ? $other->amount : $other;
        $this->amount += $amountToAdd;
        return $this;
    }

    /**
     * Subtracts another MoneyAmount or scalar amount in-place. Returns $this for chaining.
     *
     * Same-currency invariant: as with {@see self::add()}, both operands must agree on
     * isoCode — no implicit conversion.
     *
     * @throws BadRequestException When subtracting a MoneyAmount whose currency differs from this one's.
     */
    public function subtract(MoneyAmount|float|int $other): static
    {
        if ($other instanceof MoneyAmount && $this->currency->isoCode !== $other->currency->isoCode) {
            throw new BadRequestException("Can't subtract MoneyAmounts with different currencies");
        }
        $amountToSubtract = $other instanceof MoneyAmount ? $other->amount : $other;
        $this->amount -= $amountToSubtract;
        return $this;
    }

    /**
     * Format: `<amount with 2 decimals, comma separator> <isoCode>` — e.g. `"12,50 EUR"`.
     * German-locale decimal-comma convention matches existing UI conventions in downstream
     * consumers (RC, Radbonus). Null amount renders as `"0,00 <isoCode>"`.
     */
    public function __toString(): string
    {
        $formattedAmount = number_format($this->amount ?? 0.0, 2, ',', '');
        return $formattedAmount . ' ' . $this->currency->isoCode;
    }
}