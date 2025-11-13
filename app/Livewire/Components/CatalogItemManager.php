<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\Store\CatalogItemForm;
use App\Models\CatalogItem;
use App\Models\Store;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CatalogItemManager extends Component
{
    public ?Store $store = null;
    public CatalogItemForm $form;

    public array $catalogItems = [];

    public bool $showForm = false;

    public ?int $editingItemId = null;

    /**
     * Mount the component.
     */
    public function mount(?Store $store = null): void
    {
        $this->store = $store;
        $this->loadCatalogItems();
    }

    /**
     * Load catalog items data.
     */
    public function loadCatalogItems(): void
    {
        if (! $this->store) {
            return;
        }

        $this->catalogItems = $this->store->catalogItems()
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Show form to add new item.
     */
    public function showAddForm(): void
    {
        $this->form->reset();
        $this->showForm = true;
    }

    /**
     * Show form to edit item.
     */
    public function editItem(int $itemId): void
    {
        $item = collect($this->catalogItems)->firstWhere('id', $itemId);
        $this->editingItemId = $itemId;
        $this->form->setEditItem($item);
        $this->showForm = true;
    }

    /**
     * Cancel form.
     */
    public function cancelForm(): void
    {
        $this->form->reset();
        $this->showForm = false;

    }

    /**
     * Save catalog item.
     */
    public function saveItem(): void
    {
        if (! $this->store) {
            return;
        }

        $this->form->setStore($this->store);

        $this->validate();

        if ($this->editingItemId) {
            $this->form->update();
        } else {
            $this->form->store();
        }

        $actionType = $this->editingItemId ? 'atualizado' : 'adicionado';
        Toaster::success("Item do catálogo {$actionType} com sucesso!");

        $this->form->reset();
        $this->loadCatalogItems();
    }

    /**
     * Remove catalog item.
     */
    public function removeItem(int $itemId): void
    {
        if (! $this->store) {
            return;
        }

        $item = CatalogItem::find($itemId);

        if ($item && $item->store_id === $this->store->id) {
            $item->delete();
            $this->loadCatalogItems();

            Toaster::success('Item do catálogo removido com sucesso!');
        }
    }

    /**
     * Render the component.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.components.catalog-item-manager');
    }
}
