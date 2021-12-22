<?php

namespace Thinkone\NovaPageSettings\QueryAdapter;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class SettingsQueryBuilder extends EloquentBuilder
{
    public function find($id, $columns = [ '*' ])
    {
        return $this->get()->firstWhere(InternalSettingsModel::ATTR_ID, $id);
    }

    public function first($columns = [ '*' ])
    {
        $wheres = $this->query->wheres;
        $key    = InternalSettingsModel::ATTR_ID;
        $val    = collect($wheres)->firstWhere('column', "{$this->query->from}.{$key}");

        if ($val) {
            return $this->find($val['value']);
        }

        return parent::first($columns);
    }
}
