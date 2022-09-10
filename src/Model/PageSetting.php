<?php

namespace Thinkone\NovaPageSettings\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thinkone\NovaPageSettings\Factories\PageSettingFactory;

class PageSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getTable()
    {
        return config('nova-page-settings.default.settings_table');
    }

    protected static function newFactory(): PageSettingFactory
    {
        return PageSettingFactory::new();
    }

    public function newCollection(array $models = [])
    {
        return new PageSettingsCollection($models);
    }

    public function scopePage(Builder $query, $slug)
    {
        return $query->where('page', '=', $slug);
    }

    public function valueArray(): array
    {
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
