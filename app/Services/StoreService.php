<?php

namespace App\Services;

use App\Models\Store;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StoreService
{
    public function getStores(array $filters, string $sortBy, string $sortDirection): LengthAwarePaginator
    {
        $query = Store::query()->with(['user']);

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (isset($filters['phone'])) {
            $query->where('phone', 'like', '%'.$filters['phone'].'%');
        }

        if (isset($filters['website'])) {
            $query->where('website', 'like', '%'.$filters['website'].'%');
        }

        if ($sortBy && $sortDirection) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query->paginate(15);
    }

    public function store(array $data): Store
    {
        return Store::create($data);
    }

    public function update(Store $store, array $data): Store
    {
        $store->update($data);

        return $store;
    }
}
