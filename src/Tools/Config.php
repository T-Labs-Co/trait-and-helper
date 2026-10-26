<?php

declare(strict_types=1);

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
 *
 * @template TKey of array-key
 * @template TValue
 * @implements ArrayAccess<TKey, TValue>
 */
class Config implements ArrayAccess, Countable
{
    /**
     * The config db key.
     */
    protected ?string $configKey;

    /**
     * The config data.
     *
     * @var array<string, mixed>
     */
    protected array $data;

    /**
     * The Model instance.
     */
    protected Model $model;

    /**
     * Create a new Config instance.
     */
    public function __construct(Model $model, ?string $configKey = null)
    {
        $this->model = $model;
        $this->configKey = $configKey;
        $this->data = $this->getRawData();
    }

    /**
     * Get an attribute from config.
     */
    public function get(string $key, mixed $default = null): mixed
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
     */
    public function set(string $key, mixed $value): void
    {
        Arr::set($this->data, $key, $value);

        $this->model->{$this->getConfigKey()} = $this->data;
    }

    /**
     * Remove an attribute from config.
     */
    public function remove(string $key): static
    {
        $this->data = Arr::except($this->data, $key);

        $this->model->{$this->getConfigKey()} = $this->data;

        return $this;
    }

    /**
     * Get all attributes from config.
     *
     * @return array<string, mixed>
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
     * @return Collection<array-key, mixed>
     */
    public function collect(string $key): Collection
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
     * @return array<string, mixed>
     */
    protected function getRawData(): array
    {
        $raw = $this->model->getAttributes()[$this->getConfigKey()] ?? '{}';
        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset): mixed
    {
        return $this->$offset;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->{$offset} = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    /**
     * Get an attribute from config.
     */
    public function __get(string $key): mixed
    {
        return $this->get($key);
    }

    /**
     * Determine if an attribute exists in config.
     */
    public function __isset(string $key): bool
    {
        return $this->has($key);
    }

    /**
     * Set an attribute in config.
     */
    public function __set(string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Remove an attribute from config.
     */
    public function __unset(string $key): void
    {
        $this->remove($key);
    }
}
