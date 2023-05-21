<?php

namespace Thinkone\NovaPageSettings\Templates;

use Laravel\Nova\Http\Requests\NovaRequest;
use Thinkone\NovaPageSettings\Model\PageSettingsCollection;

interface SettingsTemplate
{
    public static function retrieve(?string $modelClass = null): PageSettingsCollection;

    public static function viewData(array $options = []): array;

    /**
     * Template unique identificator.
     */
    public static function getSlug(): string;

    /**
     * Template display name.
     */
    public static function getName(): string;

    /**
     * Set of laravel nova fields displayed in template.
     */
    public function fields(NovaRequest $request): array;

    public function mutateAttribute($key, $value);
}
