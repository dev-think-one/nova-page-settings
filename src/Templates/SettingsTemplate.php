<?php

namespace Thinkone\NovaPageSettings\Templates;

use Laravel\Nova\Http\Requests\NovaRequest;

interface SettingsTemplate
{
    public static function getSlug(): string;

    public static function getName(): string;

    public function fields(NovaRequest $request);

    public function mutateAttribute($key, $value);
}
