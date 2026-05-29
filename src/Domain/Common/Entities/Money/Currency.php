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

    // ISO 4217 codes added 2026-05 (donated from RC's local Currency override).
    public const string BDT = 'BDT';
    public const string BGN = 'BGN';
    public const string DZD = 'DZD';
    public const string EGP = 'EGP';
    public const string GHS = 'GHS';
    public const string HKD = 'HKD';
    public const string ILS = 'ILS';
    public const string JMD = 'JMD';
    public const string KES = 'KES';
    public const string KHR = 'KHR';
    public const string KRW = 'KRW';
    public const string KWD = 'KWD';
    public const string MAD = 'MAD';
    public const string NGN = 'NGN';
    public const string NZD = 'NZD';
    public const string PKR = 'PKR';
    public const string RON = 'RON';
    public const string SAR = 'SAR';
    public const string THB = 'THB';
    public const string TRY = 'TRY';
    public const string TWD = 'TWD';
    public const string VND = 'VND';

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
        self::ZAR,
        self::BDT,
        self::BGN,
        self::DZD,
        self::EGP,
        self::GHS,
        self::HKD,
        self::ILS,
        self::JMD,
        self::KES,
        self::KHR,
        self::KRW,
        self::KWD,
        self::MAD,
        self::NGN,
        self::NZD,
        self::PKR,
        self::RON,
        self::SAR,
        self::THB,
        self::TRY,
        self::TWD,
        self::VND
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
    public ?string $symbol = null;
    /**
     * @var bool determines if symbol is used before number, e.g. $ 1.0, or 1 €
     */
    public bool $displaySymbolBeforeAmount = false;

    public static function byIsoCode(string $isoCode): Currency
    {
        return new Currency($isoCode);
    }

    public function __construct(?string $isoCode = null)
    {
        parent::__construct();
        if (!$isoCode) {
            return;
        }
        $isoCode = strtoupper($isoCode);
        if (in_array($isoCode, self::ALLOWED_CURRENCIES)) {
            $this->isoCode = $isoCode;
        } else {
            $this->isoCode = self::DEFAULT_ISO_CODE;
        }
    }

    public function uniqueKey(): string
    {
        return self::uniqueKeyStatic($this->isoCode);
    }
}