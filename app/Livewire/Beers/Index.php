<?php

namespace App\Livewire\Beers;

use App\Models\Beer;
use App\Services\BeerService;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Index extends Component
{

    use WithPagination;

    protected BeerService $beerService;

    public string $sortBy = '';
    public string $sortDirection = '';

    public array $filters = [];


    public function boot(BeerService $beerService)
    {
        $this->beerService = $beerService;
    }

    public function sort($sortBy)
    {
        $this->sortBy = $sortBy;
        $this->sortDirection = !empty($this->sortDirection)
                        && $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->resetPage();
    }

    public function filter()
    {
        $this->validate([
            'filters.name' => 'nullable|string|min:3|max:255',
            'filters.prop_filter' => 'nullable',
            'filters.prop_filter_rule' => 'required_with:filters.prop_filter',
            'filters.prop_filter_value' => 'required_with:filters.prop_filter_rule',
        ]);

        $this->resetPage();
    }

    public function remove(Beer $beer)
    {
        $this->authorize('delete', $beer);
        $beer->delete();
        Toaster::success("{$beer->name} foi removida com sucesso.");
    }

    public function render()
    {
        return view('livewire.beers.index', [
            'beers' => $this->beerService->getBeers($this->sortBy, $this->sortDirection, $this->filters),
        ]);
    }
}
