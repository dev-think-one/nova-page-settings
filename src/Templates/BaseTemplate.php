<?php

namespace Thinkone\NovaPageSettings\Templates;

use Illuminate\Support\Str;

abstract class BaseTemplate implements SettingsTemplate
{
    public static function getSlug(): string
    {
        return Str::slug(static::getName());
    }

    public static function retreive(?string $modelClass = null)
    {
        $modelClass = $modelClass ?? config('nova-page-settings.default.settings_model');

        return $modelClass::page(static::getSlug())->get();
    }

    public static function getName(): string
    {
        return Str::title(Str::snake(array_reverse(explode('\\', static::class))[0], ' '));
    }

    public function templateKey(string $key): string
    {
        return 'opt_'.$key;
    }

    protected function hasAttrMutator($key): bool
    {
        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }


    public function mutateAttribute($key, $value)
    {
        if ($this->hasAttrMutator($key)) {
            return $this->{'get'.Str::studly($key).'Attribute'}($value);
        }

        return $value;
    }
}
