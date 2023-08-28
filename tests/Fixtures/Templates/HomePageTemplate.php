<?php

namespace Thinkone\NovaPageSettings\Tests\Fixtures\Templates;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Thinkone\NovaPageSettings\Templates\BaseTemplate;

class HomePageTemplate extends BaseTemplate
{
    public function fields(NovaRequest $request): array
    {
        return [
            Text::make('Title', $this->templateKey('title')),
            Text::make('Image', $this->templateKey('image')),
        ];
    }

    public function getImageAttribute($value): string
    {
        return "http://{$value}";
    }
}
