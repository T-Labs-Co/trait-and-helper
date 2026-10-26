# Changelog

All notable changes to `trait-and-helper` will be documented in this file.

Contact [T.Labs & Co.](https://github.com/ty-huynh)


---

## [2.0.0] - 2026-10-26

### Breaking Changes

- **PHP version requirement** — Minimum PHP version bumped from 8.1 to **8.4**.
- **Laravel version requirement** — Now requires **Laravel 12 or 13** (`illuminate/* ^12|^13`).
- **Namespace renames** — `Models/` renamed to `Model/`, and `Misc/` split into `Enum/` and `Support/`.
  - `TLabsCo\TraitAndHelper\Models\*` → `TLabsCo\TraitAndHelper\Model\*`
  - `TLabsCo\TraitAndHelper\Misc\EnumHelperTrait` → `TLabsCo\TraitAndHelper\Enum\EnumHelperTrait`
  - `TLabsCo\TraitAndHelper\Misc\ClassHelper` → `TLabsCo\TraitAndHelper\Support\ClassHelper`
  - `TLabsCo\TraitAndHelper\Misc\DateHelper` → `TLabsCo\TraitAndHelper\Support\DateHelper`
- **Service provider rewrite** — Dropped `spatie/laravel-package-tools` dependency; provider is now natively implemented at `TLabsCo\TraitAndHelper\Providers\TraitAndHelperServiceProvider`.
- **Helpers moved** — Standalone helper functions moved from `src/helpers.php` to `src/Support/functions.php`.
- **Removed unused components** — Deleted stub command, facade, config file, database factories, migrations, and resource views.

### Bug Fixes

- **BulkDeleteTrait `match()` error** — Replaced invalid `match()` expression with proper `if/elseif` chain for type checking builder instances.
- **BulkDeleteTrait `$this` in static context** — Replaced `$this` calls with `static::` to fix fatal errors in static methods.
- **HasArrayAccessTrait `offsetUnset()`** — Keys are now properly removed using `Arr::forget()` instead of being set to `null`.
- **Config `remove()`** — Internal data is now updated before syncing to the model, so `has()` reflects the removal immediately.

### New Features

- **Strict types** — Added `declare(strict_types=1)` to all source files for stricter type safety.
- **Full type declarations** — Added type hints to all properties, parameters, and return types across all 11 source files.
- **PHPStan Level 8** — Upgraded static analysis to PHPStan Level 8 with Larastan extension; removed baseline file for a clean slate.
- **Pest test suites** — Split tests into Unit and Feature suites with proper database environment configuration.
- **GitHub Actions upgrade** — Replaced old workflows with modern `tests.yml` and `static-analysis.yml` with proper caching and matrix builds.
- **Migration guide** — Added `MIGRATION_TO_V2.md` with step-by-step upgrade instructions from v1.x to v2.0.

### Changed

- **Dev tools upgrade** — Updated `larastan/larastan` to `^3`, `orchestra/testbench` to `^10|^11`, `pestphp/pest` to `^4|^5`, and related plugins.
- **README updated** — Documentation now reflects new namespaces, added badges, and quality section.

## v1.1.4 - 2026-08-05

**Full Changelog**: https://github.com/T-Labs-Co/trait-and-helper/compare/v1.1.3...v1.1.4

## v1.1.3 - 2026-08-05

**Full Changelog**: https://github.com/T-Labs-Co/trait-and-helper/compare/v1.1.2...v1.1.3

## v1.1.2 - 2026-08-05

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/T-Labs-Co/trait-and-helper/pull/3
* Bump dependabot/fetch-metadata from 2.4.0 to 2.5.0 by @dependabot[bot] in https://github.com/T-Labs-Co/trait-and-helper/pull/7

**Full Changelog**: https://github.com/T-Labs-Co/trait-and-helper/compare/v1.1.1...v1.1.2

## v1.1.1 - 2025-06-10

### What's Changed

* Bump dependabot/fetch-metadata from 2.3.0 to 2.4.0 by @dependabot in https://github.com/T-Labs-Co/trait-and-helper/pull/1

### New Contributors

* @dependabot made their first contribution in https://github.com/T-Labs-Co/trait-and-helper/pull/1

**Full Changelog**: https://github.com/T-Labs-Co/trait-and-helper/compare/v1.1.0...v1.1.1

## v1.1.0 - 2025-04-12

**Full Changelog**: https://github.com/T-Labs-Co/trait-and-helper/compare/v1.0.1...v1.1.0

## [1.1.0] - 2025-04-12

### Added

- Added `PropertyConfigurable` trait for managing dynamic configurations in models.

### Changed

- Updated documentation for `EnumHelperTrait` with additional examples.

## [1.0.1] - 2025-03-24

### Fixed

- Fixed load helpers from composer

### Added

- Added `AutoFillableTrait` for automatically filling model attributes from request data.

## [1.0.0] - 2025-03-22

**Full Changelog**: https://github.com/T-Labs-Co/trait-and-helper/commits/v1.0.0

### Added

- Initial release of the `trait-and-helper` package.
- Added `HasArrayAccessTrait` for array-like access to object properties.
- Added `ReadOnlyTrait` for protects models from being modified
- Added `BulkDeleteTrait` for simplifying bulk deletion of Eloquent models with transaction support.
- Added `EnumHelperTrait` for providing helper methods for working with PHP enums.
- Added additional helper functions to streamline common tasks.
