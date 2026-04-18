# mgamadeus/ddd-common-money -- Money Module

Currency and MoneyAmount value objects for the `mgamadeus/ddd` framework.

**Package:** `mgamadeus/ddd-common-money` (v1.0.0)
**Namespace:** `DDD\`
**Depends on:** `mgamadeus/ddd` (^2.10)

> **This module follows all DDD Core conventions.** For base patterns, see the skills in `vendor/mgamadeus/ddd`.

## Architecture

```
src/
+-- Domain/Common/Entities/Money/
|   +-- Currency.php          [ValueObject -- ISO 4217 currency with symbol]
|   +-- MoneyAmount.php       [ValueObject -- amount + currency composition]
+-- Modules/Money/
    +-- MoneyModule.php       [DDDModule entry point]
```

## Entities

### Currency (ValueObject)

27 supported currencies with ISO 4217 codes. Default: EUR.

**Key properties:** `isoCode` (validated via `#[Choice]`), `symbol`, `displaySymbolBeforeAmount`

**Factory:** `Currency::byIsoCode('USD')`

**Supported:** ARS, AUD, BRL, CAD, CHF, CLP, COP, CZK, EUR, GBP, HUF, IDR, INR, JPY, MXN, MYR, NOK, PEN, PHP, PLN, RUB, SEK, SGD, USD, VEF, ZAR

### MoneyAmount (ValueObject)

Monetary amount with currency. Supports equality comparison on both amount and currency.

**Constructor:** `new MoneyAmount(amount: 19.99, currency: 'USD')` or `new MoneyAmount(19.99, Currency::byIsoCode('USD'))`

**Method:** `setCurrencyByIsoCode(string)`, `isEqualTo(?DefaultObject)` (compares amount + currency)

## Usage

```php
use DDD\Domain\Common\Entities\Money\Currency;
use DDD\Domain\Common\Entities\Money\MoneyAmount;

// As entity property
public ?MoneyAmount $price = null;

// Create
$price = new MoneyAmount(29.99, 'EUR');
$price = new MoneyAmount(0.0, Currency::byIsoCode('USD'));

// Compare
$price1->isEqualTo($price2);  // true if same amount AND currency
```

## Coding Conventions

All DDD Core conventions apply. See `vendor/mgamadeus/ddd/AGENTS.md`.
