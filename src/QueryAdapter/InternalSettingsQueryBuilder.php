<?php


namespace Thinkone\NovaPageSettings\QueryAdapter;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Thinkone\NovaPageSettings\Templates\SettingsTemplate;

class InternalSettingsQueryBuilder extends QueryBuilder
{
    protected array $_templates         = [];
    protected array $_templatesCompiled = [];

    protected function runSelect()
    {
        if (empty($this->_templatesCompiled)) {
            $this->_templatesCompiled = collect($this->getTemplates())
                /** @var SettingsTemplate $template */
                ->map(function ($template, $id) {
                    return [
                        InternalSettingsModel::ATTR_CLASS => $template,
                        InternalSettingsModel::ATTR_ID    => $id,
                        InternalSettingsModel::ATTR_NAME  => $template::getName(),
                    ];
                })->toArray();
        }

        return $this->_templatesCompiled;
    }

    public function getCountForPagination($columns = [ '*' ])
    {
        $templates = $this->getTemplates();

        return count($templates);
    }

    public function getTemplates()
    {
        if (empty($this->_templates)) {
            $namespace = app()->getNamespace();
            $templates = [];
            foreach (( new Finder )->in(base_path($this->from))->files() as $template) {
                $template = $namespace . str_replace(
                    [ '/', '.php' ],
                    [ '\\', '' ],
                    Str::after($template->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

                if (class_implements($template, SettingsTemplate::class) &&
                     !( new ReflectionClass($template) )->isAbstract()) {
                    $templates[] = $template;
                }
            }

            $this->_templates = $templates;
        }

        return $this->_templates;
    }
}
