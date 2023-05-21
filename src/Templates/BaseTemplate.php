<?php

namespace Thinkone\NovaPageSettings\Templates;

use Illuminate\Support\Str;
use Thinkone\NovaPageSettings\Model\PageSettingsCollection;

abstract class BaseTemplate implements SettingsTemplate
{
    /**
     * @deprecated
     */
    public static function retreive(?string $modelClass = null): PageSettingsCollection
    {
        return static::retrieve($modelClass);
    }

    public static function retrieve(?string $modelClass = null): PageSettingsCollection
    {
        $modelClass = $modelClass ?? config('nova-page-settings.default.settings_model');

        return $modelClass::page(static::getSlug())->get();
    }

    public static function viewData(array $options = []): array
    {
        $pageSettingsCollection = static::retrieve($options['modelClass'] ?? null);

        return  $pageSettingsCollection->pluck('value', 'key')->all();
    }

    public static function getSlug(): string
    {
        return Str::slug(static::getName());
    }

    public static function getName(): string
    {
        return Str::title(Str::snake(array_reverse(explode('\\', static::class))[0], ' '));
    }

    public function mutateAttribute($key, $value)
    {
        if ($this->hasAttrMutator($key)) {
            return $this->{'get' . Str::studly($key) . 'Attribute'}($value);
        }

        return $value;
    }

    public function templateKey(string $key): string
    {
        return config('nova-page-settings.key_prefix') . $key;
    }

    protected function hasAttrMutator($key): bool
    {
        return method_exists($this, 'get' . Str::studly($key) . 'Attribute');
    }
}
