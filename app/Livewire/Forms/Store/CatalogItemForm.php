<?php

namespace App\Livewire\Forms\Store;

use App\Models\CatalogItem;
use App\Models\Store;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Masmerise\Toaster\Toaster;

class CatalogItemForm extends Form
{
    public ?Store $store = null;

    public string $name = '';

    public string $url = '';

    public string $description = '';

    public string $ingredients = '';

    public string $price = '';
    public ?int $editingItemId = null;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function setStore(Store $store)
    {
        $this->store = $store;
    }

    public function setEditItem($item)
    {
        if (! $item) {
            return;
        }

        $this->editingItemId = $item['id'];
        $this->name = $item['name'];
        $this->url = $item['url'];
        $this->description = $item['description'];
        $this->ingredients = $item['ingredients'];
        $this->price = (string) $item['price'];
    }

    public function store()
    {
        $this->store->catalogItems()->create($this->validate());
    }

    public function update()
    {
        $item = CatalogItem::find($this->editingItemId);

        if ($item && $item->store_id === $this->store->id) {
            $item->update($this->validate());
        }
    }

}
