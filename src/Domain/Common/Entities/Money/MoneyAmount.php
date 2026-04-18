<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Money;

use DDD\Domain\Base\Entities\DefaultObject;
use DDD\Domain\Base\Entities\ValueObject;

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
}