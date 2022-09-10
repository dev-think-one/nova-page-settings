<?php


namespace Thinkone\NovaPageSettings\QueryAdapter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Thinkone\NovaPageSettings\Templates\SettingsTemplate;

abstract class InternalSettingsModel extends Model
{
    const ATTR_CLASS = '__nps_class';
    const ATTR_ID    = 'id';
    const ATTR_NAME  = '__nps_name';

    protected $_buffer = [];

    abstract public function getDBModel(): string;

    public function getTemplatesPath(): string
    {
        return config('nova-page-settings.default.templates_path');
    }

    public function getTable()
    {
        return $this->getTemplatesPath();
    }

    protected function newBaseQueryBuilder()
    {
        return new InternalSettingsQueryBuilder(
            new InternalSettingsConnection(),
            new InternalSettingsGrammar(),
            new InternalSettingsProcessor()
        );
    }

    public function newEloquentBuilder($query)
    {
        return ( new SettingsQueryBuilder($query) )->setModel($this);
    }

    public function template()
    {
        if ($class = $this->attributes[ self::ATTR_CLASS ]) {
            return new $class();
        }

        return null;
    }

    protected function predefinedKeys()
    {
        return [
            self::ATTR_CLASS,
            self::ATTR_ID,
            self::ATTR_NAME,
        ];
    }

    public function getAttribute($key)
    {
        if (!in_array($key, $this->predefinedKeys()) && Str::startsWith($key, 'opt_')) {
            $newKey = Str::after($key, 'opt_');
            if (!array_key_exists($newKey, $this->_buffer)) {
                $template = $this->template();
                $model    = $this->getDBModel()::where('page', '=', $template::getSlug())
                                 ->where('key', '=', $newKey)->first();
                if ($model) {
                    $this->_buffer[ $newKey ] = $template->mutateAttribute($newKey, $model->value);
                } else {
                    $this->_buffer[ $newKey ] = null;
                }
            }

            return $this->_buffer[ $newKey ];
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (!in_array($key, $this->predefinedKeys()) && Str::startsWith($key, 'opt_')) {
            $newKey = Str::after($key, 'opt_');

            $this->_buffer[ $newKey ] = $value;

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function save(array $options = [])
    {
        /** @var SettingsTemplate $template */
        $template = $this->template();
        if ($template) {
            $page = $template::getSlug();
            foreach ($this->_buffer as $key => $value) {
                $this->getDBModel()::updateOrCreate(
                    [ 'page' => $page, 'key' => $key ],
                    [ 'value' => $value ]
                );
            }
        }

        return true;
    }
}
