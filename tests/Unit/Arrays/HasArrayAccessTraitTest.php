<?php

declare(strict_types=1);

use TLabsCo\TraitAndHelper\Arrays\HasArrayAccessTrait;

class TestArrayAccessModel implements \ArrayAccess
{
    use HasArrayAccessTrait;

    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
}

it('can get a value by key', function () {
    $model = new TestArrayAccessModel(['name' => 'John', 'age' => 30]);
    expect($model->get('name'))->toBe('John');
    expect($model->get('age'))->toBe(30);
});

it('can set a value', function () {
    $model = new TestArrayAccessModel;
    $model->set('name', 'Jane');
    expect($model->get('name'))->toBe('Jane');
});

it('can check key existence', function () {
    $model = new TestArrayAccessModel(['name' => 'John']);
    expect($model->has('name'))->toBeTrue();
    expect($model->has('email'))->toBeFalse();
});

it('can get all values', function () {
    $model = new TestArrayAccessModel(['name' => 'John', 'age' => 30]);
    expect($model->all())->toBe(['name' => 'John', 'age' => 30]);
});

it('supports array access interface', function () {
    $model = new TestArrayAccessModel(['name' => 'John']);
    expect($model['name'])->toBe('John');
    expect(isset($model['name']))->toBeTrue();
    $model['email'] = 'test@example.com';
    expect($model['email'])->toBe('test@example.com');
    unset($model['email']);
    expect($model->has('email'))->toBeFalse();
});

it('supports magic get set unset', function () {
    $model = new TestArrayAccessModel(['name' => 'John']);
    expect($model->name)->toBe('John');
    $model->email = 'test@example.com';
    expect($model->email)->toBe('test@example.com');
});

it('can get many keys at once', function () {
    $model = new TestArrayAccessModel(['name' => 'John', 'age' => 30, 'city' => 'NYC']);
    $result = $model->getMany(['name', 'age']);
    expect($result)->toBe(['name' => 'John', 'age' => 30]);
});
