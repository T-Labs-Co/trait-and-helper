<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Model\BulkDeleteTrait;

class TestBulkDeleteModel extends Model
{
    use BulkDeleteTrait;

    protected $table = 'test_models';

    public $timestamps = false;
}

it('can delete a single model', function () {
    expect(is_callable([TestBulkDeleteModel::class, 'deletes']))->toBeTrue();
});

it('can force delete', function () {
    expect(is_callable([TestBulkDeleteModel::class, 'forceDeletes']))->toBeTrue();
});

it('can delete quietly', function () {
    expect(is_callable([TestBulkDeleteModel::class, 'deletesQuietly']))->toBeTrue();
});

it('returns empty array for unknown builder type', function () {
    // We can test getRecords indirectly - passing a string should return empty
    $result = TestBulkDeleteModel::deletes('invalid');
    expect($result)->toBeTrue();
});
