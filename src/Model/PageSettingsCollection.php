<?php

namespace Thinkone\NovaPageSettings\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PageSettingsCollection extends Collection
{
    public function getSettingValue(string $key, string $type = 'string', $default = null, ...$parameters)
    {
        /** @var PageSetting $setting */
        if ($setting = $this->firstWhere('key', $key)) {
            if (is_object($setting) && method_exists($setting, ($method = 'value'.Str::ucfirst($type)))) {
                return $setting->$method(...$parameters);
            }

            return Arr::get($setting, 'value');
        }

        return $default;
    }

    public function __call($method, $parameters)
    {
        $suffix = 'SettingValue';
        if (Str::endsWith($method, $suffix)) {
            return $this->getSettingValue(array_shift($parameters), Str::beforeLast($method, $suffix), array_shift($parameters), ...$parameters);
        }

        return parent::__call($method, $parameters);
    }
}
