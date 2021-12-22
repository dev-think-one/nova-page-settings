<?php

namespace Thinkone\NovaPageSettings;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class PageSetting extends Model
{
    protected $guarded = [];

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

    /**
     * @param  Collection|PageSetting[]  $collection
     * @param  string  $key
     * @param  string  $type
     * @param  null  $default
     *
     * @return mixed|null
     */
    public static function getValueFromCollection(Collection $collection, string $key, string $type = 'string', $default = null)
    {
        /** @var PageSetting $setting */
        if ($setting = $collection->firstWhere('key', $key)) {
            if (is_object($setting) && method_exists($setting, ($method = 'value'.Str::ucfirst($type)))) {
                return $setting->$method();
            }

            return Arr::get($setting, 'value');
        }

        return $default;
    }
}
