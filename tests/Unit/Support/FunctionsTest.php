<?php

declare(strict_types=1);
use Carbon\Carbon;

it('camel2dashed converts camelCase to dashed', function () {
    expect(camel2dashed('camelCase'))->toBe('camel-case');
    expect(camel2dashed('firstName'))->toBe('first-name');
});

it('camel2dashed uses custom separator', function () {
    expect(camel2dashed('camelCase', '_'))->toBe('camel_case');
});

it('class2camel converts class name to camelCase', function () {
    expect(class2camel('App\Models\UserProfile'))->toBe('userProfile');
});

it('class_name_only returns snake case class name', function () {
    expect(class_name_only('App\Enums\StatusEnum'))->toBe('status_enum');
});

it('has_use checks trait usage', function () {
    trait TestTraitForFunctionHelper {}
    $obj = new class
    {
        use TestTraitForFunctionHelper;
    };
    expect(has_use('TestTraitForFunctionHelper', $obj))->toBeTrue();
});

it('parse_date_carbon parses string to carbon', function () {
    $result = parse_date_carbon('2024-01-01');
    expect($result)->toBeInstanceOf(Carbon::class);
});

it('parse_date_carbon returns null for invalid', function () {
    expect(parse_date_carbon('invalid'))->toBeNull();
});
