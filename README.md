# Trait & Helper

[![Tests](https://github.com/t-labs-co/trait-and-helper/actions/workflows/tests.yml/badge.svg)](https://github.com/t-labs-co/trait-and-helper/actions/workflows/tests.yml)
[![Static Analysis](https://github.com/t-labs-co/trait-and-helper/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/t-labs-co/trait-and-helper/actions/workflows/static-analysis.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/t-labs-co/trait-and-helper.svg)](https://packagist.org/packages/t-labs-co/trait-and-helper)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE.md)
[![PHP Version](https://img.shields.io/badge/php-%5E8.4-8892BF.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/laravel-%5E12.0%20%7C%20%5E13.0-FF2D20.svg)](https://laravel.com)

Collection of reusable traits and helper utilities for Laravel — model protection, bulk operations, enum helpers, array-access, dynamic property configuration, and more.

## Features

- **HasArrayAccessTrait**: Provides array-like access to object properties via magic methods and ArrayAccess interface.
- **ReadOnlyTrait**: Protects Eloquent models from being saved, updated, or deleted.
- **BulkDeleteTrait**: Simplifies bulk deletion of Eloquent models with transaction support and event control.
- **AutoFillableTrait**: Automatically populates mass-assignment fillable attributes from database table columns.
- **EnumHelperTrait**: Provides helper methods for working with PHP 8.1+ backed enums.
- **PropertyConfigurable**: Manage dynamic configurations stored in model attributes like `settings` or `extras`.
- **Helper Functions**: Global functions for string conversion, class introspection, date parsing, and trait detection.

## Requirements

- PHP: `^8.4`
- Laravel: `^12.0` | `^13.0`

## Installation

You can install the package via composer:

```bash
composer require t-labs-co/trait-and-helper
```

> **Upgrading from v1.x?** Read the [Migration Guide](https://github.com/T-Labs-Co/trait-and-helper/blob/main/MIGRATION_TO_V2.md) for a step-by-step upgrade path.

## Usage

### HasArrayAccessTrait

Provides array-like access to object properties via magic methods and the `ArrayAccess` interface.

```php
<?php

declare(strict_types=1);

namespace App\Models;

use TLabsCo\TraitAndHelper\Arrays\HasArrayAccessTrait;

class DataObject
{
    use HasArrayAccessTrait;

    protected array $options = [];

    public function __construct(array $initData = [])
    {
        $this->options = $initData;
    }

    protected function arrayDataKey(): string
    {
        return 'options';
    }
}

// Usage
$dataObject = new DataObject(['name' => 'John']);
$dataObject->get('name');       // 'John'
$dataObject->set('age', 30);
$dataObject->has('name');        // true
$dataObject['email'] = 'test@example.com';  // ArrayAccess
```

### ReadOnlyTrait

Protects Eloquent models from being saved, updated, or deleted.

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Model\ReadOnlyTrait;

class Category extends Model
{
    use ReadOnlyTrait;
}

// This will throw ReadOnlyException
$category->save();

// Disable read-only on the fly
$category->disableReadOnly()->save();
$category->enableReadOnly();
```

### BulkDeleteTrait

Simplifies bulk deletion of Eloquent models with transaction support.

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Model\BulkDeleteTrait;

class Category extends Model
{
    use BulkDeleteTrait;
}

// Delete by query builder
Category::deletes(Category::where('name', 'unknown'));

// Delete single model
Category::deletes($category);

// Delete collection
Category::deletes($categoryCollection);

// Force delete (for soft-deletable models)
Category::forceDeletes(Category::where('name', 'unknown'));

// Delete without firing events
Category::deletesQuietly(Category::where('name', 'unknown'));
```

### AutoFillableTrait

Automatically populates mass-assignment fillable attributes from database table columns.

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Model\AutoFillableTrait;

class Category extends Model
{
    use AutoFillableTrait;
    // No need to manually define $fillable — it's auto-populated from table columns
}

$category = new Category();
$category->fill($data)->save();
```

### PropertyConfigurable

Manage dynamic configurations stored in model attributes like `settings` or `extras`.

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Model\PropertyConfigurable;

class Product extends Model
{
    use PropertyConfigurable;

    protected $fillable = ['name', 'settings', 'extras'];
    protected $casts = ['settings' => 'array', 'extras' => 'array'];
    protected $propertyConfigKey = 'settings';
}

// Access configuration
$product = Product::find(1);
$config = $product->config();
$value = $config->get('key');

// Update configuration
$product->config()->set('key', 'new value');
$product->save();

// Clear cached configuration
$product->clearConfigCached();
```

### EnumHelperTrait

Provides helper methods for working with PHP 8.1+ backed enums.

```php
<?php

declare(strict_types=1);

namespace App\Enums;

use TLabsCo\TraitAndHelper\Enum\EnumHelperTrait;

enum Status: string
{
    use EnumHelperTrait;

    case Active = 'active';
    case Inactive = 'inactive';
}

Status::labels();   // ['Active', 'Inactive']
Status::values();   // ['active', 'inactive']
Status::names();    // ['Active', 'Inactive']
Status::toArray();  // ['active', 'inactive']
Status::toSelect(); // [['active' => 'Active'], ['inactive' => 'Inactive']]
Status::toList();   // 'active,inactive'

Status::Active->label();  // 'Active'
Status::Active->toUpper(); // 'ACTIVE'
Status::Active->toLower(); // 'active'
Status::Active->is('active'); // true
```

### Helper Functions

The package provides several global helper functions:

```php
camel2dashed('camelCase');           // 'camel-case'
camel2dashed('camelCase', '_');      // 'camel_case'
class2camel('App\Models\User');      // 'user'
class_name_only('App\Enums\Status'); // 'status'
has_use(SomeTrait::class, $obj);     // true/false
parse_date_carbon('2024-01-01');     // Carbon instance
```


## Quality & Development Practices

This package follows strict development standards:

- **PHPStan Level 8**: Static analysis with Larastan for type safety and bug prevention.
- **Pest PHP**: Modern testing framework with parallel execution support.
- **Laravel Pint**: Code style enforcement following Laravel conventions.
- **Full Type Coverage**: All parameters, properties, and return types are explicitly typed.
- **Strict Types**: Every file uses `declare(strict_types=1)`.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ty Huynh](https://github.com/ty-huynh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
