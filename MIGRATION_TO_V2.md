# Migration Guide: v1.x → v2.0

This guide helps you upgrade `t-labs-co/trait-and-helper` from version 1.x to version 2.0.

## Summary of Breaking Changes

| Change | v1.x | v2.0 |
|--------|------|------|
| PHP version | `^8.1` | `^8.4` |
| Laravel version | `^9\|^10\|^11` | `^12\|^13` |
| Model traits namespace | `TLabsCo\TraitAndHelper\Models\` | `TLabsCo\TraitAndHelper\Model\` |
| Enum helper namespace | `TLabsCo\TraitAndHelper\Misc\EnumHelperTrait` | `TLabsCo\TraitAndHelper\Enum\EnumHelperTrait` |
| Class helper namespace | `TLabsCo\TraitAndHelper\Misc\ClassHelper` | `TLabsCo\TraitAndHelper\Support\ClassHelper` |
| Date helper namespace | `TLabsCo\TraitAndHelper\Misc\DateHelper` | `TLabsCo\TraitAndHelper\Support\DateHelper` |
| Helper functions file | `src/helpers.php` | `src/Support/functions.php` |
| Service provider | `TLabsCo\TraitAndHelper\TraitAndHelperServiceProvider` | `TLabsCo\TraitAndHelper\Providers\TraitAndHelperServiceProvider` |
| spatie/laravel-package-tools | Dependency used | Removed, native provider |

---

## Step 1: Upgrade PHP and Laravel

Before upgrading the package, ensure your project meets the new requirements:

- **PHP 8.4 or higher**
- **Laravel 12 or 13**

```bash
php -v  # Check PHP version
php artisan --version  # Check Laravel version
```

---

## Step 2: Update Composer

```bash
composer require t-labs-co/trait-and-helper:^2.0
```

---

## Step 3: Update Namespace Imports

### Model Traits: `Models\` → `Model\`

The `Models` namespace (plural) has been renamed to `Model` (singular).

#### ReadOnlyTrait

```diff
- use TLabsCo\TraitAndHelper\Models\ReadOnlyTrait;
+ use TLabsCo\TraitAndHelper\Model\ReadOnlyTrait;
```

#### BulkDeleteTrait

```diff
- use TLabsCo\TraitAndHelper\Models\BulkDeleteTrait;
+ use TLabsCo\TraitAndHelper\Model\BulkDeleteTrait;
```

#### AutoFillableTrait

```diff
- use TLabsCo\TraitAndHelper\Models\AutoFillableTrait;
+ use TLabsCo\TraitAndHelper\Model\AutoFillableTrait;
```

#### PropertyConfigurable

```diff
- use TLabsCo\TraitAndHelper\Models\PropertyConfigurable;
+ use TLabsCo\TraitAndHelper\Model\PropertyConfigurable;
```

### Misc Classes: `Misc\` → `Enum\` + `Support\`

The `Misc` namespace has been split into two dedicated namespaces.

#### EnumHelperTrait

```diff
- use TLabsCo\TraitAndHelper\Misc\EnumHelperTrait;
+ use TLabsCo\TraitAndHelper\Enum\EnumHelperTrait;
```

#### ClassHelper

```diff
- use TLabsCo\TraitAndHelper\Misc\ClassHelper;
+ use TLabsCo\TraitAndHelper\Support\ClassHelper;
```

#### DateHelper

```diff
- use TLabsCo\TraitAndHelper\Misc\DateHelper;
+ use TLabsCo\TraitAndHelper\Support\DateHelper;
```

### Other Unchanged Namespaces

These namespaces remain the same:

- `TLabsCo\TraitAndHelper\Arrays\HasArrayAccessTrait`
- `TLabsCo\TraitAndHelper\Tools\Config`
- `TLabsCo\TraitAndHelper\Exceptions\ReadOnlyException`

---

## Step 4: Update Service Provider

If you manually registered the service provider (e.g., in a non-Laravel auto-discovery setup), update the class name:

```diff
- TLabsCo\TraitAndHelper\TraitAndHelperServiceProvider::class
+ TLabsCo\TraitAndHelper\Providers\TraitAndHelperServiceProvider::class
```

If you rely on Laravel's auto-discovery (the `"extra.laravel.providers"` key in `composer.json`), no action is needed — the provider will be discovered automatically.

---

## Step 5: Helper Functions

Helper functions are still auto-loaded via Composer, but the source file has moved from `src/helpers.php` to `src/Support/functions.php`.

**No code changes are needed** — the functions are loaded through the `autoload.files` configuration in `composer.json`. The available functions remain the same:

- `camel2dashed(string $str, string $character = '-')` — Convert camelCase to kebab-case
- `has_use(string $trait, object $obj)` — Check if an object uses a trait
- `parse_date_carbon(mixed $date)` — Parse a date string to Carbon instance

---

## Step 6: Removed Components

The following components have been removed in v2.0. If you were using them, you'll need to find alternatives:

| Removed | Reason | Alternative |
|---------|--------|-------------|
| `TraitAndHelper` facade | Unused facade | Direct class usage |
| `TraitAndHelperCommand` Artisan command | Stub command with no functionality | N/A |
| `config/trait-and-helper.php` | No config needed | N/A |
| `database/factories/` | Not part of library scope | Create your own factories |
| `database/migrations/` | Not part of library scope | Create your own migrations |
| `resources/views/` | No views needed | N/A |

---

## Full Before/After Example

### Before (v1.x)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Models\ReadOnlyTrait;
use TLabsCo\TraitAndHelper\Models\BulkDeleteTrait;
use TLabsCo\TraitAndHelper\Misc\EnumHelperTrait;
use TLabsCo\TraitAndHelper\Misc\ClassHelper;

class Product extends Model
{
    use ReadOnlyTrait, BulkDeleteTrait;

    protected function helper(): string
    {
        return ClassHelper::classNameOnly($this);
    }
}
```

### After (v2.0)

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Model\ReadOnlyTrait;
use TLabsCo\TraitAndHelper\Model\BulkDeleteTrait;
use TLabsCo\TraitAndHelper\Support\ClassHelper;

class Product extends Model
{
    use ReadOnlyTrait, BulkDeleteTrait;

    protected function helper(): string
    {
        return ClassHelper::classNameOnly($this);
    }
}
```

---

## Bug Fixes That Affect Behavior

### BulkDeleteTrait

Two critical bugs were fixed in `BulkDeleteTrait`:

1. **Broken `match()` expression** — The type-checking logic for builder instances was using an invalid `match()` expression. It has been replaced with a proper `if/elseif` chain. If you relied on the internal behavior, the trait now correctly handles `Builder`, `EloquentBuilder`, and `SoftDeletes`.

2. **`$this` in static context** — Static methods incorrectly used `$this`, causing fatal errors. All static method calls now use `static::` instead.

### HasArrayAccessTrait

- `offsetUnset()` now properly removes keys using `Arr::forget()` instead of setting them to `null`.

### Config

- `remove()` now correctly updates internal data before syncing to the model, so `has()` reflects the removal immediately.

---

## Quick Search & Replace Reference

Use these search patterns to find all occurrences in your codebase:

```bash
# Model namespace (plural → singular)
grep -r "TLabsCo\\\\TraitAndHelper\\\\Models\\\\" app/

# EnumHelperTrait
grep -r "TLabsCo\\\\TraitAndHelper\\\\Misc\\\\EnumHelperTrait" app/

# ClassHelper
grep -r "TLabsCo\\\\TraitAndHelper\\\\Misc\\\\ClassHelper" app/

# DateHelper
grep -r "TLabsCo\\\\TraitAndHelper\\\\Misc\\\\DateHelper" app/

# Old service provider
grep -r "TLabsCo\\\\TraitAndHelper\\\\TraitAndHelperServiceProvider" app/ config/
```
