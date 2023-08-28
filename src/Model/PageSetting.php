<?php

namespace Thinkone\NovaPageSettings\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thinkone\NovaPageSettings\Factories\PageSettingFactory;

class PageSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getTable(): string
    {
        return config('nova-page-settings.default.settings_table');
    }

    protected static function newFactory(): Factory
    {
        return PageSettingFactory::new();
    }

    public function newCollection(array $models = []): PageSettingsCollection
    {
        return new PageSettingsCollection($models);
    }

    public function scopePage(Builder $query, string $slug)
    {
        return $query->where('page', '=', $slug);
    }

    public function scopeKey(Builder $query, string $key)
    {
        return $query->where('key', '=', $key);
    }

    public function valueArray(): array
    {
        if(is_array($this->value)) {
            return $this->value;
        }

        $data = json_decode($this->value, true);

        return is_array($data) ? $data : [];
    }

    public function valueBool(): bool
    {
        return (bool) ($this->value);
    }

    public function valueString(): string
    {
        try {
            return (string) ($this->value);
        } catch (\Exception $e) {
            return '';
        }
    }
}
