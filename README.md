# mgamadeus/ddd-common-money

Currency and MoneyAmount value objects for the [mgamadeus/ddd](https://github.com/mgamadeus/ddd) framework.

## Installation

```bash
composer require mgamadeus/ddd-common-money
```

## What It Does

Lightweight value objects for handling monetary amounts with currency awareness:

- **Currency** -- ISO 4217 currency codes (27 supported) with symbol and display formatting
- **MoneyAmount** -- Amount + Currency composition with value equality comparison

Both are ValueObjects -- stored as JSON when used as entity properties.

## Usage

```php
use DDD\Domain\Common\Entities\Money\Currency;
use DDD\Domain\Common\Entities\Money\MoneyAmount;

// Create a monetary amount
$price = new MoneyAmount(29.99, 'EUR');
$price = new MoneyAmount(0.0, Currency::byIsoCode('USD'));

// Use as entity property (stored as JSON)
class Product extends Entity
{
    public ?MoneyAmount $price = null;
}

// Compare (checks both amount AND currency)
$a = new MoneyAmount(10.0, 'EUR');
$b = new MoneyAmount(10.0, 'USD');
$a->isEqualTo($b);  // false -- different currency
```

## Supported Currencies

ARS, AUD, BRL, CAD, CHF, CLP, COP, CZK, **EUR** (default), GBP, HUF, IDR, INR, JPY, MXN, MYR, NOK, PEN, PHP, PLN, RUB, SEK, SGD, USD, VEF, ZAR

Invalid ISO codes fall back to EUR.

## Overriding

```php
namespace App\Domain\Common\Entities\Money;

use DDD\Domain\Common\Entities\Money\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    // Add custom currencies or symbols
}
```

## License

MIT
