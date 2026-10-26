<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Exceptions\ReadOnlyException;
use TLabsCo\TraitAndHelper\Model\ReadOnlyTrait;

class TestReadOnlyModel extends Model
{
    use ReadOnlyTrait;

    protected $table = 'test_readonly';

    public $timestamps = false;
}

it('is read only by default', function () {
    $model = new TestReadOnlyModel;
    expect($model->isReadOnly())->toBeTrue();
});

it('allows disabling read only', function () {
    $model = new TestReadOnlyModel;
    $result = $model->disableReadOnly();
    expect($model->isReadOnly())->toBeFalse();
    expect($result)->toBeInstanceOf(TestReadOnlyModel::class);
});

it('allows re-enabling read only', function () {
    $model = new TestReadOnlyModel;
    $model->disableReadOnly();
    $result = $model->enableReadOnly();
    expect($model->isReadOnly())->toBeTrue();
    expect($result)->toBeInstanceOf(TestReadOnlyModel::class);
});

it('throws exception when saving read only model', function () {
    $model = new TestReadOnlyModel;

    expect(fn () => $model->save())->toThrow(ReadOnlyException::class);
});
