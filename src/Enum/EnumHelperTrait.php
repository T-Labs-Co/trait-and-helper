<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Enum;

use Illuminate\Support\Str;

trait EnumHelperTrait
{
    /**
     * @return array<string>
     */
    public static function labels(): array
    {
        return array_map(fn ($case) => $case->label(), self::cases());
    }

    /**
     * @return array<string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array<int|string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<int|string>
     */
    public static function toArray(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public static function toList(): string
    {
        return implode(',', self::toArray());
    }

    /**
     * @return array<array<int|string, string>>
     */
    public static function toSelect(): array
    {
        return array_map(fn ($case) => [$case->value => $case->label()], self::cases());
    }

    public function label(): string
    {
        return ucwords(str_replace('_', ' ', $this->name));
    }

    public function is(mixed $input, bool $safe = true): bool
    {
        try {
            $case = self::from($input);

            return $case && $case->value === $this->value;
        } catch (\ValueError $e) {
            if (! $safe) {
                throw $e;
            }

            return false;
        }
    }

    public function toUpper(): string
    {
        return Str::upper($this->value);
    }

    public function toLower(): string
    {
        return Str::lower($this->value);
    }
}
