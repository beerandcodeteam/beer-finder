<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\Store\BeerSelectorForm;
use App\Models\Beer;
use App\Models\Store;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class BeerSelector extends Component
{
    public ?Store $store = null;

    public BeerSelectorForm $form;

    public array $selectedBeers = [];

    public array $availableBeers = [];

    /**
     * Mount the component.
     */
    public function mount(?Store $store = null): void
    {
        $this->store = $store;
        $this->form->setStore($store);

        $this->loadBeers();
    }

    /**
     * Load beers data.
     */
    public function loadBeers(): void
    {
        if (! $this->store) {
            return;
        }

        $this->selectedBeers = $this->store->beers()
            ->withPivot(['id', 'price', 'url', 'promo_label'])
            ->get()
            ->map(fn (Beer $beer) => [
                'pivot_id' => $beer->pivot->id,
                'beer_id' => $beer->id,
                'name' => $beer->name,
                'price' => $beer->pivot->price,
                'url' => $beer->pivot->url,
                'promo_label' => $beer->pivot->promo_label,
            ])
            ->toArray();

        $selectedBeerIds = collect($this->selectedBeers)->pluck('beer_id')->toArray();

        $this->availableBeers = Beer::query()
            ->whereNotIn('id', $selectedBeerIds)
            ->orderBy('name')
            ->get()
            ->map(fn (Beer $beer) => [
                'id' => $beer->id,
                'name' => $beer->name,
            ])
            ->toArray();
    }

    /**
     * Add beer to store.
     */
    public function addBeer(): void
    {
        if (! $this->store || ! $this->form->selectedBeerId) {
            return;
        }

        $this->validate();

        $this->form->attach();

        $this->form->reset(['selectedBeerId', 'price', 'url', 'promo_label']);
        $this->loadBeers();

        Toaster::success('Cerveja adicionada com sucesso!');
    }

    /**
     * Remove beer from store.
     */
    public function removeBeer(int $beerId): void
    {
        if (! $this->store) {
            return;
        }

        $this->store->beers()->detach($beerId);
        $this->loadBeers();

        Toaster::success('Cerveja removida com sucesso!');
    }

    /**
     * Render the component.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.components.beer-selector');
    }
}
