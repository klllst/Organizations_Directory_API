<?php

namespace App\Traits;

use App\ModelFilters\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $builder, array $fields, $filter = null)
    {
        $filterClass = $this->provideFilterClass($filter);
        $filter = new $filterClass($fields);
        $filter->apply($builder);
    }

    public function provideFilterClass($filter = null): string
    {
        if ($filter === null) {
            $filter = config('model-filter.namespace', 'App\\ModelFilters\\').class_basename($this).'Filter';
        }

        return $filter;
    }
}
