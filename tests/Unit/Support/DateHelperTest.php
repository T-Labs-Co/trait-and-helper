<?php

declare(strict_types=1);

use Carbon\Carbon;
use TLabsCo\TraitAndHelper\Support\DateHelper;

it('parses a date string to carbon', function () {
    $result = DateHelper::parseCarbon('2024-01-15');
    expect($result)->toBeInstanceOf(Carbon::class);
    expect($result->year)->toBe(2024);
    expect($result->month)->toBe(1);
    expect($result->day)->toBe(15);
});

it('returns carbon unchanged if already carbon', function () {
    $carbon = Carbon::parse('2024-06-01');
    $result = DateHelper::parseCarbon($carbon);
    expect($result)->toBe($carbon);
});

it('returns null for invalid date', function () {
    $result = DateHelper::parseCarbon('not-a-date');
    expect($result)->toBeNull();
});

it('returns null for null input', function () {
    $result = DateHelper::parseCarbon(null);
    expect($result)->toBeNull();
});
