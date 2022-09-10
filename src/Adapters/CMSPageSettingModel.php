<?php

namespace Thinkone\NovaPageSettings\Adapters;

use Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel;

class CMSPageSettingModel extends InternalSettingsModel
{
    /**
     * @inheritDoc
     */
    public function getDBModel(): string
    {
        return config('nova-page-settings.default.settings_model');
    }
}
