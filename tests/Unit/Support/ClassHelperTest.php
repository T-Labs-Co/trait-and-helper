<?php

declare(strict_types=1);

use TLabsCo\TraitAndHelper\Support\ClassHelper;

it('returns class name only from string', function () {
    $result = ClassHelper::classNameOnly('App\Enums\StatusEnum');
    expect($result)->toBe('status_enum');
});

it('returns class name only from object', function () {
    $obj = new class {};
    $result = ClassHelper::classNameOnly($obj);
    expect($result)->toBeString();
});

it('detects trait usage', function () {
    trait TestTraitForClassHelper {}
    $class = new class
    {
        use TestTraitForClassHelper;
    };
    expect(ClassHelper::hasUseTrait('TestTraitForClassHelper', $class))->toBeTrue();
});
