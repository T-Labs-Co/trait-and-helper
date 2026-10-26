# AI Assistant Guide — Trait & Helper

This document provides essential context and guidelines for AI assistants working on the `t-labs-co/trait-and-helper` Laravel package.

## Project Overview

**Trait & Helper** is a collection of reusable traits and helper utilities for Laravel (`^12.0` | `^13.0`) and PHP `^8.4`. It provides model protection traits, bulk operations, enum helpers, array-access patterns, dynamic property configuration, and global helper functions.

### Key Features
- **HasArrayAccessTrait**: Array-like access to object properties via magic methods and ArrayAccess interface
- **ReadOnlyTrait**: Protects Eloquent models from being saved, updated, or deleted
- **BulkDeleteTrait**: Bulk deletion with transaction support and event control
- **AutoFillableTrait**: Auto-populates fillable attributes from database table columns
- **EnumHelperTrait**: Helper methods for PHP 8.1+ backed enums
- **PropertyConfigurable**: Dynamic configuration management via model attributes
- **Helper Functions**: Global functions for string conversion, class introspection, date parsing, and trait detection

## Architecture

### Directory Structure
```
src/
├── Arrays/
│   └── HasArrayAccessTrait.php        # Array-like property access trait
├── Enum/
│   └── EnumHelperTrait.php            # PHP enum helper methods
├── Exceptions/
│   └── ReadOnlyException.php          # Thrown when modifying read-only models
├── Model/
│   ├── AutoFillableTrait.php          # Auto-fillable from table columns
│   ├── BulkDeleteTrait.php            # Transactional bulk deletion
│   ├── PropertyConfigurable.php       # Dynamic config via model attributes
│   └── ReadOnlyTrait.php              # Model write-protection
├── Providers/
│   └── TraitAndHelperServiceProvider.php # Native service provider (no Spatie)
├── Support/
│   ├── ClassHelper.php                # Class name introspection utilities
│   ├── DateHelper.php                 # Carbon date parsing helper
│   └── functions.php                  # Global helper functions
└── Tools/
    └── Config.php                     # Config value object for PropertyConfigurable
```

### Core Concepts

1. **Trait-Driven Design**: This package is primarily trait-based — no runtime bootstrapping is needed. The service provider is minimal.
2. **Helper Functions**: Global functions are auto-loaded via Composer `files` autoloading from `src/Support/functions.php`.
3. **No Database Migrations**: The package does not require any migrations or views.
4. **Namespace Convention**: `TLabsCo\TraitAndHelper\` with sub-namespaces matching directory structure.

## Coding Standards

### PHP Standards
- **PHP Version**: `^8.4` with strict types (`declare(strict_types=1)`)
- **Code Style**: Laravel Pint configuration (see `pint.json`)
- **Static Analysis**: PHPStan Level 8 via Larastan (`composer analyse`)
- **Type Safety**: Full type coverage required — all parameters, properties, and return types must be explicitly typed

### Naming Conventions
- **Classes**: PascalCase (e.g., `ClassHelper`, `ReadOnlyException`)
- **Traits**: PascalCase with `Trait` suffix (e.g., `BulkDeleteTrait`)
- **Methods/Functions**: camelCase (e.g., `classNameOnly`, `parseCarbon`)
- **Properties**: camelCase with visibility modifiers
- **Files**: PascalCase.php matching class/trait name

### Type Annotations
Use PHPDoc `@param`, `@return`, and `@var` annotations for:
- Complex array types: `@param array<string, mixed> $data`
- Collection generics: `@return Collection<int, string>`
- Nullable types: `@param string|null $key`

## Testing Guidelines

### Test Framework
- **Pest PHP** with Laravel plugin for unit tests
- Run tests with: `composer test` (includes parallel execution)

### Test Organization
```
tests/
├── Unit/
│   ├── Arrays/
│   │   └── HasArrayAccessTraitTest.php
│   ├── Enum/
│   │   └── EnumHelperTraitTest.php
│   ├── Model/
│   │   ├── BulkDeleteTraitTest.php
│   │   ├── ReadOnlyTraitTest.php
│   ├── Support/
│   │   ├── ClassHelperTest.php
│   │   ├── DateHelperTest.php
│   │   └── FunctionsTest.php
│   └── Tools/
│       └── ConfigTest.php
├── Feature/
├── ArchTest.php
├── Pest.php
└── TestCase.php
```

### Test Writing Guidelines
- Use descriptive test names: `it_can_delete_a_single_model()`
- Test both success and failure paths
- Use Orchestra Testbench for Laravel package testing
- Cover edge cases: null values, empty arrays, boundary conditions

## Development Workflow

### Quality Gates
Before submitting changes, ensure:
1. **Static Analysis Passes**: `composer analyse` (PHPStan Level 8, 0 errors)
2. **Tests Pass**: `composer test` (all tests passing)
3. **Code Style**: `composer format` (Laravel Pint auto-fixes applied)

### Common Commands
```bash
# Run tests
composer test

# Run static analysis
composer analyse

# Format code
composer format

# Full quality check
composer analyse && composer test
```

## Change Guidelines

### Adding New Traits
1. Place in the appropriate sub-namespace (`Model/`, `Enum/`, `Arrays/`, `Support/`)
2. Add `declare(strict_types=1)` and full type coverage
3. Add corresponding unit tests
4. Ensure PHPStan Level 8 passes

### Adding New Helper Functions
1. Add to `src/Support/functions.php` with `if (!function_exists(...))` guard
2. Add full type declarations
3. Add corresponding unit tests in `tests/Unit/Support/FunctionsTest.php`

### Modifying Existing Code
1. Preserve backward compatibility where possible
2. Update tests to reflect new behavior
3. Maintain type safety — no untyped parameters or returns

## Important Notes

- **Package Namespace**: `TLabsCo\TraitAndHelper\`
- **No Runtime Bootstrap**: The service provider is minimal; traits work without registration
- **Helper Functions**: Auto-loaded via Composer — no service provider needed
- **No Config File**: The package does not publish any configuration
- **No Views or Migrations**: Pure utility package

## Documentation

- **README.md**: User-facing documentation and usage examples
- **CHANGELOG.md**: Release history
- **composer.json**: Dependencies and scripts
- **phpstan.neon.dist**: Static analysis configuration
- **pint.json**: Code style configuration
