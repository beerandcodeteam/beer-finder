<?php

namespace App\Livewire\Store;

use App\Models\Store;
use App\Services\StoreService;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    use WithPagination;

    public string $sortBy = '';

    public string $sortDirection = '';

    public array $filters = [];

    protected StoreService $storeService;

    public function boot(StoreService $storeService): void
    {
        $this->storeService = $storeService;
    }

    public function sort(string $sortBy): void
    {
        $this->sortBy = $sortBy;
        $this->sortDirection = ! empty($this->sortDirection) && $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->resetPage();
    }

    public function filter(): void
    {
        $this->validate([
            'filters.name' => 'nullable|string|min:3|max:255',
            'filters.phone' => 'nullable|string|max:15',
            'filters.website' => 'nullable|string|max:255',
        ]);

        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Toaster::error("Erro ao aplicar o filtro {$e->getMessage()}");
        }
    }

    public function remove(Store $store): void
    {
        $store->delete();
        Toaster::info("{$store->name} removida com sucesso!");
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.store.index', [
            'stores' => $this->storeService->getStores($this->filters, $this->sortBy, $this->sortDirection),
        ]);
    }
}
