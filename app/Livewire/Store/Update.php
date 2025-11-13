<?php

namespace App\Livewire\Store;

use App\Livewire\Forms\StoreForm;
use App\Models\Store;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Update extends Component
{
    public StoreForm $form;

    public Store $store;

    public function mount(Store $store): void
    {
        $this->store = $store;
        $this->form->setStore($store);
    }

    public function addOpeningHour(): void
    {
        $this->form->opening_hours_json[] = [
            'day' => '',
            'start' => '',
            'end' => '',
        ];
    }

    public function removeOpeningHour(int $index): void
    {
        unset($this->form->opening_hours_json[$index]);
        $this->form->opening_hours = array_values($this->form->opening_hours);
    }

    public function save(): void
    {
        $this->form->update();

        Toaster::success('Loja atualizada com sucesso!');

        $this->redirect(route('stores.index'), navigate: true);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.store.update');
    }
}
