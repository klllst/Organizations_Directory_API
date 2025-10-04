<?php

namespace App\ModelFilters;

use Illuminate\Database\Eloquent\Builder;

abstract class ModelFilter
{
    protected $fields;

    protected $builder;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->fields as $field => $value) {
            if (method_exists($this, $field)) {
                call_user_func([$this, $field], $value);
            }
        }
    }
}
