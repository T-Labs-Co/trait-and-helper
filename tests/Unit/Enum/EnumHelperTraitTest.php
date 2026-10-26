<?php

declare(strict_types=1);
use TLabsCo\TraitAndHelper\Enum\EnumHelperTrait;

enum TestStatus: string
{
    use EnumHelperTrait;

    case Active = 'active';
    case Inactive = 'inactive';
    case Pending = 'pending';
}

it('returns labels array', function () {
    $labels = TestStatus::labels();
    expect($labels)->toBeArray()->toHaveCount(3);
    expect($labels)->toContain('Active', 'Inactive', 'Pending');
});

it('returns names array', function () {
    $names = TestStatus::names();
    expect($names)->toBeArray()->toHaveCount(3);
    expect($names)->toContain('Active', 'Inactive', 'Pending');
});

it('returns values array', function () {
    $values = TestStatus::values();
    expect($values)->toBeArray()->toHaveCount(3);
    expect($values)->toContain('active', 'inactive', 'pending');
});

it('converts to array', function () {
    $array = TestStatus::toArray();
    expect($array)->toBeArray()->toHaveCount(3);
    expect($array)->toContain('active', 'inactive', 'pending');
});

it('converts to select', function () {
    $select = TestStatus::toSelect();
    expect($select)->toBeArray()->toHaveCount(3);
});

it('returns label for single case', function () {
    expect(TestStatus::Active->label())->toBe('Active');
});

it('checks is correctly', function () {
    expect(TestStatus::Active->is('active'))->toBeTrue();
    expect(TestStatus::Active->is('inactive'))->toBeFalse();
    expect(TestStatus::Active->is('nonexistent'))->toBeFalse();
});

it('converts to upper', function () {
    expect(TestStatus::Active->toUpper())->toBe('ACTIVE');
});

it('converts to lower', function () {
    expect(TestStatus::Active->toLower())->toBe('active');
});

it('returns list string', function () {
    $list = TestStatus::toList();
    expect($list)->toBeString();
    expect($list)->toContain('active');
});
