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

    protected function runSelect(): array
    {
        if (empty($this->_templatesCompiled)) {
            $this->_templatesCompiled = collect($this->getTemplates())
                /** @var SettingsTemplate $template */
                ->map(function ($template, $id) {
                    return [
                        InternalSettingsModel::ATTR_CLASS => $template,
                        InternalSettingsModel::ATTR_ID    => method_exists($template, 'getID')?$template::getID():$id,
                        InternalSettingsModel::ATTR_NAME  => $template::getName(),
                    ];
                })->toArray();
        }

        return $this->_templatesCompiled;
    }

    public function getCountForPagination($columns = [ '*' ]): int
    {
        $templates = $this->getTemplates();

        return count($templates);
    }

    public function getTemplates()
    {
        if (empty($this->_templates)) {
            $namespace = app()->getNamespace();
            $templates = [];
            if(Str::startsWith($this->from, DIRECTORY_SEPARATOR)) {
                $from = $this->from;
            } else {
                $from = base_path($this->from);
            }
            foreach (( new Finder )->in($from)->files() as $template) {
                preg_match('/\s*namespace\s?([A-Za-z\\\]*)\s*;\s*/is', file_get_contents($template->getPathname()), $matches);
                if(isset($matches[1])) {
                    $namespace = '\\'.$matches[1];
                }

                $template = $namespace . '\\' . Str::before($template->getBasename(), '.'.$template->getExtension());

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
