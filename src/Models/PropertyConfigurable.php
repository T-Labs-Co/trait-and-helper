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
use Illuminate\Support\Arr;
use TLabsCo\TraitAndHelper\Tools\Config;

/**
 * Trait PropertyConfigurable
 *
 * @refer https://github.com/signifly/laravel-configurable
 *
 *  use PropertyConfigurable;


    // Remember to make `settings` fillable
    protected $fillable = [
        'settings', 'extras',
    ];

    // Remember to add `settings` to casts
    protected $casts = [
        'settings' => 'array',
        'extras' => 'array',
    ];

    protected $propertyConfigKey = 'settings';
    // Or
    protected function getPropertyConfigKey()
    {
        return 'settings';
    }

    // or add a custom config attribute like this:
    public function getExtrasAttribute()
    {
        return new Config($this, 'extras');
    }
 */
trait PropertyConfigurable
{
    /**
     * Cached config instances.
     *
     * @var array
     */
    protected $cachedPropertyConfigs = [];

    protected $propertyConfigKey = 'settings';

    /**
     * Get a Config value object.
     *
     * @return Config
     */
    public function config($clearCache = false)
    {
        if ($clearCache) {
            $this->cachedPropertyConfigs = [];
        }

        return $this->makePropertyConfig($this, $this->getPropertyConfigKey());
    }

    /**
     * Clear config property cached
     */
    public function clearConfigCached()
    {
        $this->cachedPropertyConfigs = [];
    }

    /**
     * Get the config database key.
     *
     * @return string
     */
    public function getPropertyConfigKey()
    {
        return $this->propertyConfigKey; // default is settings property
    }

    /**
     * Create a new Config instance.
     *
     * @return Config
     */
    protected function makePropertyConfig(Model $model, string $key)
    {
        return Arr::get($this->cachedPropertyConfigs, $key, function () use ($key, $model) {
            return $this->cachedPropertyConfigs[$key] = new Config($model, $key);
        });
    }
}
