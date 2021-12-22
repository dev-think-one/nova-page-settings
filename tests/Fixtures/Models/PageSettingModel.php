<?php

namespace Thinkone\NovaPageSettings\Tests\Fixtures\Models;

use Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel;

class PageSettingModel extends InternalSettingsModel
{
    /**
     * @inheritDoc
     */
    public function getDBModel(): string
    {
        return PageSetting::class;
    }
}
