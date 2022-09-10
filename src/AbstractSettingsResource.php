<?php

namespace Thinkone\NovaPageSettings;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Laravel\Nova\Resource;
use Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel;
use Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel;
use Thinkone\NovaPageSettings\Templates\SettingsTemplate;

abstract class AbstractSettingsResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CMSPageSettingModel::class;

    public static $searchable         = false;
    public static $globallySearchable = false;

    public static $title = InternalSettingsModel::ATTR_NAME;

    public static $perPageOptions = [ 1000 ];

    public function fields(Request $request)
    {
        if ($request instanceof ResourceIndexRequest) {
            return $this->fieldsOnIndex($request);
        }


        if ($request instanceof ResourceDetailRequest || $request instanceof NovaRequest) {
            /** @var SettingsTemplate $template */
            $templateModel = $request->model()->find($request->route('resourceId'));
            if ($templateModel && ($template = $templateModel->template())) {
                return $template->fields($request);
            }
        }

        return [];
    }

    public function fieldsOnIndex(ResourceIndexRequest $request)
    {
        return [
            ID::make('Id', InternalSettingsModel::ATTR_ID),
            Text::make('Name', InternalSettingsModel::ATTR_NAME),
        ];
    }

    public static function newModel()
    {
        return parent::newModel();
    }
}
