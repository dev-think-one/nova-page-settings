<?php

namespace Thinkone\NovaPageSettings\Nova\Resources\Traits;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel;
use Thinkone\NovaPageSettings\Templates\SettingsTemplate;

trait AsPageSetting
{
    public function fields(Request $request): array
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
