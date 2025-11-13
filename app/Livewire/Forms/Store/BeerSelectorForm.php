<?php

namespace App\Livewire\Forms\Store;

use App\Models\Store;
use Livewire\Form;

class BeerSelectorForm extends Form
{
    public ?Store $store = null;

    public int $selectedBeerId = 0;

    public string $price = '';

    public string $url = '';

    public string $promo_label = '';

    public function rules(): array
    {
        return [
            'selectedBeerId' => ['required', 'exists:beers,id'],
            'price' => ['required', 'integer', 'min:0'],
            'url' => ['required', 'url', 'max:255'],
            'promo_label' => ['required', 'string', 'max:255'],
        ];
    }

    public function setStore(Store $store): void
    {
        $this->store = $store;
    }

    public function attach(): void
    {
        $this->store->beers()->attach($this->selectedBeerId, [
            'price' => $this->price,
            'url' => $this->url,
            'promo_label' => $this->promo_label,
        ]);
    }
}
