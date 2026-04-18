---
name: money-module-specialist
description: Work with Currency and MoneyAmount value objects from the ddd-common-money module. Use when handling monetary values, currency codes, or price properties in entities.
metadata:
  author: mgamadeus
  version: "1.0.0"
  module: mgamadeus/ddd-common-money
---

# Money Module Specialist

Currency and MoneyAmount value objects within the `mgamadeus/ddd-common-money` module.

> **Base patterns:** See core skills in `vendor/mgamadeus/ddd` for entity/service conventions.

## When to Use

- Adding price/cost/amount properties to entities
- Working with multi-currency monetary values
- Comparing monetary amounts

## Currency (ValueObject)

27 ISO 4217 currencies. Default: `EUR`. Invalid codes fall back to EUR.

```php
use DDD\Domain\Common\Entities\Money\Currency;

$eur = Currency::byIsoCode('EUR');
$usd = Currency::byIsoCode('USD');
$invalid = Currency::byIsoCode('XYZ');  // Falls back to EUR

// Properties
$eur->isoCode;                    // 'EUR'
$eur->symbol;                     // null (set by consuming app)
$eur->displaySymbolBeforeAmount;  // false
```

**Supported codes:** ARS, AUD, BRL, CAD, CHF, CLP, COP, CZK, EUR, GBP, HUF, IDR, INR, JPY, MXN, MYR, NOK, PEN, PHP, PLN, RUB, SEK, SGD, USD, VEF, ZAR

**Constants:** `Currency::EUR`, `Currency::USD`, etc. + `Currency::DEFAULT_ISO_CODE` (EUR) + `Currency::ALLOWED_CURRENCIES` (array)

## MoneyAmount (ValueObject)

Amount + currency composition with value equality.

```php
use DDD\Domain\Common\Entities\Money\MoneyAmount;

// Construction
$price = new MoneyAmount(29.99, 'EUR');
$price = new MoneyAmount(0.0, Currency::byIsoCode('USD'));
$price = new MoneyAmount();  // 0.0 EUR

// Properties
$price->amount;     // float
$price->currency;   // Currency object

// Update currency
$price->setCurrencyByIsoCode('USD');

// Equality (checks BOTH amount and currency)
$a = new MoneyAmount(10.0, 'EUR');
$b = new MoneyAmount(10.0, 'USD');
$a->isEqualTo($b);  // false (different currency)
```

## Entity Property Pattern

```php
use DDD\Domain\Common\Entities\Money\MoneyAmount;

class Product extends Entity
{
    public ?MoneyAmount $price = null;
    public ?MoneyAmount $costPerUnit = null;
}
```

MoneyAmount is a ValueObject -- stored as JSON in the database automatically.

## Used By

- `ddd-ai` module: `AILanguageModelSetting` stores token costs as MoneyAmount
- `ddd-common-translations`: `AppTranslationsResult` stores estimated AI costs
