<?php

/*
 * This file is a part of package t-co-labs/trait-and-helper
 *
 * (c) T.Labs & Co.
 * Contact for Work: T. <hongty.huynh@gmail.com>
 *
 * We're PHP and Laravel whizzes, and we'd love to work with you! We can:
 *  - Design the perfect fit solution for your app.
 *  - Make your code cleaner and faster.
 *  - Refactoring and Optimize performance.
 *  - Ensure Laravel best practices are followed.
 *  - Provide expert Laravel support.
 *  - Review code and Quality Assurance.
 *  - Offer team and project leadership.
 *  - Delivery Manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TLabsCo\TraitAndHelper\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Exceptions\ReadOnlyException;

trait ReadOnlyTrait
{
    private $readonly = true;

    public static function bootReadOnlyTrait() {
        static::saving(function(Model $model) {
            if ($model->isReadOnly()) {
                throw new ReadOnlyException('save', $model);
            }
        });

        static::updating(function(Model $model) {
            if ($model->isReadOnly()) {
                throw new ReadOnlyException('update', $model);
            }
        });

        static::deleting(function(Model $model) {
            if ($model->isReadOnly()) {
                throw new ReadOnlyException('delete', $model);
            }
        });
    }

    public function isReadOnly()
    {
        return $this->readonly;
    }

    public function enableReadOnly()
    {
        $this->readonly = true;
        return $this;
    }

    public function disableReadOnly()
    {
        $this->readonly = false;
        return $this;
    }
}
