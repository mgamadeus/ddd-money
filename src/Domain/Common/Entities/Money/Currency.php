<?php

declare(strict_types=1);

namespace DDD\Domain\Common\Entities\Money;

use DDD\Domain\Base\Entities\ValueObject;
use DDD\Infrastructure\Validation\Constraints\Choice;

class Currency extends ValueObject
{
    public const string ARS = 'ARS';
    public const string AUD = 'AUD';
    public const string BRL = 'BRL';
    public const string CAD = 'CAD';
    public const string CHF = 'CHF';
    public const string CLP = 'CLP';
    public const string COP = 'COP';
    public const string CZK = 'CZK';
    public const string EUR = 'EUR';
    public const string GBP = 'GBP';
    public const string HUF = 'HUF';
    public const string IDR = 'IDR';
    public const string INR = 'INR';
    public const string JPY = 'JPY';
    public const string MXN = 'MXN';
    public const string NOK = 'NOK';
    public const string PEN = 'PEN';
    public const string PHP = 'PHP';
    public const string PLN = 'PLN';
    public const string MYR = 'MYR';
    public const string RUB = 'RUB';
    public const string SEK = 'SEK';
    public const string SGD = 'SGD';
    public const string USD = 'USD';
    public const string VEF = 'VEF';
    public const string ZAR = 'ZAR';

    public const array ALLOWED_CURRENCIES = [
        self::ARS,
        self::AUD,
        self::BRL,
        self::CAD,
        self::CHF,
        self::CLP,
        self::COP,
        self::CZK,
        self::EUR,
        self::GBP,
        self::HUF,
        self::IDR,
        self::INR,
        self::JPY,
        self::MXN,
        self::NOK,
        self::PEN,
        self::PHP,
        self::PLN,
        self::MYR,
        self::RUB,
        self::SEK,
        self::SGD,
        self::USD,
        self::VEF,
        self::ZAR
    ];

    public const string DEFAULT_ISO_CODE = self::EUR;

    /**
     * @var string|null ISO 4217 3-letter currency code
     * @example EUR, USD
     */
    #[Choice(choices: [
        self::ARS,
        self::AUD,
        self::BRL,
        self::CAD,
        self::CHF,
        self::CLP,
        self::COP,
        self::CZK,
        self::EUR,
        self::GBP,
        self::HUF,
        self::IDR,
        self::INR,
        self::JPY,
        self::MXN,
        self::NOK,
        self::PEN,
        self::PHP,
        self::PLN,
        self::MYR,
        self::RUB,
        self::SEK,
        self::SGD,
        self::USD,
        self::VEF,
        self::ZAR
    ])]
    public ?string $isoCode = self::DEFAULT_ISO_CODE;
    /**
     * @var string currency symbol
     * @example $, €
     */
    public ?string $symbol;
    /**
     * @var bool determines if symbol is used before number, e.g. $ 1.0, or 1 €
     */
    public bool $displaySymbolBeforeAmount = false;

    public static function byIsoCode(string $isoCode):Currency {
        return new Currency($isoCode);
    }

    public function __construct(?string $isoCode = null)
    {
        parent::__construct();
        if (!$isoCode) {
            $isoCode = self::DEFAULT_ISO_CODE;
            return;
        }
        $isoCode = strtoupper($isoCode);
        if (in_array($isoCode, self::ALLOWED_CURRENCIES))
            $this->isoCode = $isoCode;
        else
            $this->isoCode = self::DEFAULT_ISO_CODE;
    }

    public function uniqueKey(): string
    {
        return self::uniqueKeyStatic($this->isoCode);
    }


}