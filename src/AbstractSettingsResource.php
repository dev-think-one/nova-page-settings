<?php

namespace Thinkone\NovaPageSettings;

use Laravel\Nova\Resource;

/**
 * @deprecated
 * @extends Resource<\Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel>
 */
abstract class AbstractSettingsResource extends Resource
{
    use \Thinkone\NovaPageSettings\Nova\Resources\Traits\AsPageSetting;

    public static $model = \Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::class;

    public static $searchable         = false;
    public static $globallySearchable = false;

    public static $title = \Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel::ATTR_NAME;

    public static $perPageOptions = [ 1000 ];
}
