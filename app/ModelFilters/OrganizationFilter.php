<?php

namespace App\ModelFilters;

class OrganizationFilter extends ModelFilter
{
    public function search($value): void
    {
        if (isset($value)) {
            $this->builder
                ->where('name', 'like', "%{$value}%");
        }
    }

    public function building($value): void
    {
        if (is_numeric($value)) {
            $this->builder
                ->where('building_id', $value);
        }
    }

    public function activity($value): void
    {
        if (is_numeric($value)) {
            $this->builder
                ->whereHas('activities', function ($query) use ($value) {
                    $query->where('activities.id', $value);
                });
        }
    }
}
