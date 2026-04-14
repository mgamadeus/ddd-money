# mgamadeus/ddd-common-money

Currency and MoneyAmount value objects for the [mgamadeus/ddd](https://github.com/mgamadeus/ddd) framework.

## Installation

```bash
composer require mgamadeus/ddd-common-money
```

## What it does

Provides lightweight value objects for monetary amounts and currencies:

- **MoneyAmount** — amount + currency code (e.g. `new MoneyAmount(9.99, 'USD')`)
- **Currency** — ISO 4217 currency with symbol, placement, and validation for 27+ supported currencies (EUR, USD, GBP, CHF, etc.)

## Usage

```php
use DDD\Domain\Common\Entities\Money\MoneyAmount;
use DDD\Domain\Common\Entities\Money\Currency;

$price = new MoneyAmount(29.99, 'EUR');
$currency = new Currency('USD');
```

## Overriding

Extend in your project to add currencies or customize behavior:

```php
namespace App\Domain\Common\Entities\Money;

use DDD\Domain\Common\Entities\Money\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    // Add project-specific currencies
}
```
