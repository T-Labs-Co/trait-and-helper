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

namespace TLabsCo\TraitAndHelper\Tools;

use ArrayAccess;
use Countable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Config
 *
 * @refer https://github.com/signifly/laravel-configurable
 */
class Config implements ArrayAccess, Countable
{
    /**
     * The config db key.
     *
     * @var string|null
     */
    protected $configKey;

    /**
     * The config data.
     *
     * @var array
     */
    protected $data;

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new Config instance.
     *
     * @param  string  $configKey
     */
    public function __construct(Model $model, $configKey = null)
    {
        $this->model = $model;

        $this->configKey = $configKey;

        $this->data = $this->getRawData();
    }

    /**
     * Get an attribute from config.
     *
     * @param  mixed  $default
     */
    public function get(string $key, $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Determine if an attribute exists in config.
     */
    public function has(string $key): bool
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Set an attribute in config.
     *
     * @param  mixed  $value
     */
    public function set(string $key, $value): void
    {
        Arr::set($this->data, $key, $value);

        $this->model->{$this->getConfigKey()} = $this->data;
    }

    /**
     * Remove an attribute from config.
     */
    public function remove(string $key): Config
    {
        $this->model->{$this->getConfigKey()} = Arr::except($this->data, $key);

        return $this;
    }

    /**
     * Get all attributes from config.
     */
    public function all(): array
    {
        return $this->getRawData();
    }

    /**
     * Count attributes in config.
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Get a specific attribute as a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collect(string $key)
    {
        return new Collection($this->get($key));
    }

    /**
     * Get the config key.
     */
    protected function getConfigKey(): string
    {
        return $this->configKey ??
            (method_exists($this->model, 'getPropertyConfigKey') ? $this->model->getPropertyConfigKey() : '_');
    }

    /**
     * Get the raw data from the model.
     *
     * @return array
     */
    protected function getRawData()
    {
        return json_decode($this->model->getAttributes()[$this->getConfigKey()] ?? '{}', true);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    /**
     * Get an attribute from config.
     *
     * @param  string  $key
     */
    public function __get($key): mixed
    {
        return $this->get($key);
    }

    /**
     * Determine if an attribute exists in config.
     *
     * @param  string  $key
     */
    public function __isset($key): bool
    {
        return $this->has($key);
    }

    /**
     * Set an attribute in config.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function __set($key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Remove an attribute from config.
     *
     * @param  string  $key
     */
    public function __unset($key): void
    {
        $this->remove($key);
    }
}
