<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use TLabsCo\TraitAndHelper\Tools\Config;

/**
 * Trait PropertyConfigurable
 *
 * @refer https://github.com/signifly/laravel-configurable
 *
 *  use PropertyConfigurable;
 *
 *    // Remember to make `settings` fillable
 *    protected $fillable = [
 *        'settings', 'extras',
 *    ];
 *
 *    // Remember to add `settings` to casts
 *    protected $casts = [
 *        'settings' => 'array',
 *        'extras' => 'array',
 *    ];
 *
 *    protected $propertyConfigKey = 'settings';
 *    // Or
 *    protected function getPropertyConfigKey()
 *    {
 *        return 'settings';
 *    }
 *
 *    // or add a custom config attribute like this:
 *    public function getExtrasAttribute()
 *    {
 *        return new Config($this, 'extras');
 *    }
 */
trait PropertyConfigurable
{
    /**
     * Cached config instances.
     *
     * @var array<string, Config>
     */
    protected array $cachedPropertyConfigs = [];

    protected string $propertyConfigKey = 'settings';

    /**
     * Get a Config value object.
     */
    public function config(bool $clearCache = false): Config
    {
        if ($clearCache) {
            $this->cachedPropertyConfigs = [];
        }

        return $this->makePropertyConfig($this, $this->getPropertyConfigKey());
    }

    /**
     * Clear config property cached.
     */
    public function clearConfigCached(): void
    {
        $this->cachedPropertyConfigs = [];
    }

    /**
     * Get the config database key.
     */
    public function getPropertyConfigKey(): string
    {
        return $this->propertyConfigKey;
    }

    /**
     * Create a new Config instance.
     */
    protected function makePropertyConfig(Model $model, string $key): Config
    {
        return Arr::get($this->cachedPropertyConfigs, $key, function () use ($key, $model) {
            return $this->cachedPropertyConfigs[$key] = new Config($model, $key);
        });
    }
}
