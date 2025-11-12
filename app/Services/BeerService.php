<?php

namespace App\Services;

use App\Models\Beer;

class BeerService
{
    public function getBeers(string $sortBy, string $sortDirection, array $filters)
    {
        $query = Beer::query();

        if (isset($filters['name']))
        {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['prop_filter'])
            && !empty($filters['prop_filter_rule'])
            && !empty($filters['prop_filter_value'])

        )
        {
            $query->where($filters['prop_filter'], $filters['prop_filter_rule'], $filters['prop_filter_value']);
        }

        if ($sortBy && $sortDirection)
        {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query->paginate(15);
    }
}
