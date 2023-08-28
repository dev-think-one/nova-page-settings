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

    /**
     * @return class-string \Thinkone\NovaPageSettings\Model
     */
    abstract public function getDBModel(): string;

    public function getTemplatesPath(): string
    {
        return config('nova-page-settings.default.templates_path');
    }

    public function keyPrefix(): string
    {
        return config('nova-page-settings.key_prefix');
    }

    public function getTable(): string
    {
        return $this->getTemplatesPath();
    }

    protected function newBaseQueryBuilder(): InternalSettingsQueryBuilder
    {
        return new InternalSettingsQueryBuilder(
            new InternalSettingsConnection(),
            new InternalSettingsGrammar(),
            new InternalSettingsProcessor()
        );
    }

    public function newEloquentBuilder($query): SettingsQueryBuilder
    {
        return (new SettingsQueryBuilder($query))->setModel($this);
    }

    public function template(): ?SettingsTemplate
    {
        if ($class = $this->attributes[self::ATTR_CLASS]) {
            return new $class();
        }

        return null;
    }

    protected function predefinedKeys(): array
    {
        return [
            self::ATTR_CLASS,
            self::ATTR_ID,
            self::ATTR_NAME,
        ];
    }

    public function getAttribute($key)
    {
        if (!in_array($key, $this->predefinedKeys()) && Str::startsWith($key, static::keyPrefix())) {
            $newKey = Str::after($key, static::keyPrefix());
            if (!array_key_exists($newKey, $this->_buffer)) {
                $template = $this->template();
                /** @psalm-suppress UndefinedClass */
                $model    = $this->getDBModel()::query()
                    ->page($template::getSlug())
                    ->key($newKey)->first();
                if ($model) {
                    $this->_buffer[$newKey] = $template->mutateAttribute($newKey, $model->value);
                } else {
                    $this->_buffer[$newKey] = null;
                }
            }

            return $this->_buffer[$newKey];
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (!in_array($key, $this->predefinedKeys()) && Str::startsWith($key, static::keyPrefix())) {
            $newKey = Str::after($key, static::keyPrefix());

            $this->_buffer[$newKey] = $value;

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function save(array $options = []): bool
    {
        /** @var SettingsTemplate $template */
        $template = $this->template();
        if ($template) {
            $page = $template::getSlug();
            foreach ($this->_buffer as $key => $value) {
                $this->getDBModel()::updateOrCreate(
                    ['page' => $page, 'key' => $key],
                    ['value' => $value]
                );
            }
        }

        return true;
    }
}
