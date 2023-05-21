<?php

namespace Thinkone\NovaPageSettings\Tests\Fixtures\Templates;

use Laravel\Nova\Http\Requests\NovaRequest;
use Thinkone\NovaPageSettings\Templates\BaseTemplate;

class HomePageTemplate extends BaseTemplate
{
    public function fields(NovaRequest $request): array
    {
        return [
            // Nothing need for test
        ];
    }
}
