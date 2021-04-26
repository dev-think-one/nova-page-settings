<?php

function page_setting_value(\Illuminate\Support\Collection $collection, string $key, $type = 'string', $default = null)
{
    return \Thinkone\NovaPageSettings\PageSetting::getValueFromCollection(
        $collection,
        $key,
        $type,
        $default
    );
}
