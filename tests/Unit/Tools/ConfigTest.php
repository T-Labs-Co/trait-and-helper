<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TLabsCo\TraitAndHelper\Tools\Config;

class TestConfigModel extends Model
{
    protected $table = 'test_config';

    public $timestamps = false;

    protected $fillable = ['settings'];

    protected $casts = ['settings' => 'array'];
}

it('can get a config value', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['name' => 'John', 'age' => 30])]);
    $config = new Config($model, 'settings');
    expect($config->get('name'))->toBe('John');
    expect($config->get('age'))->toBe(30);
});

it('can set a config value', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['name' => 'John'])]);
    $config = new Config($model, 'settings');
    $config->set('email', 'test@example.com');
    expect($config->get('email'))->toBe('test@example.com');
});

it('can remove a key', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['name' => 'John', 'age' => 30])]);
    $config = new Config($model, 'settings');
    $config->remove('age');
    expect($config->has('age'))->toBeFalse();
});

it('can count keys', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['name' => 'John', 'age' => 30])]);
    $config = new Config($model, 'settings');
    expect($config->count())->toBe(2);
});

it('can collect a key as collection', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['tags' => ['a', 'b', 'c']])]);
    $config = new Config($model, 'settings');
    $collection = $config->collect('tags');
    expect($collection)->toBeInstanceOf(Collection::class);
    expect($collection->count())->toBe(3);
});

it('supports array access', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['name' => 'John'])]);
    $config = new Config($model, 'settings');
    expect(isset($config['name']))->toBeTrue();
    expect($config['name'])->toBe('John');
});

it('supports magic accessors', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode(['name' => 'John'])]);
    $config = new Config($model, 'settings');
    expect($config->name)->toBe('John');
});

it('returns default when key missing', function () {
    $model = new TestConfigModel;
    $model->setRawAttributes(['settings' => json_encode([])]);
    $config = new Config($model, 'settings');
    expect($config->get('missing', 'default'))->toBe('default');
});
