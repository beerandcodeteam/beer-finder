<?php

namespace App\Livewire\Store;

use App\Livewire\Forms\StoreForm;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    public StoreForm $form;

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
        $this->form->opening_hours_json = array_values($this->form->opening_hours);
    }

    public function save(): void
    {
        $store = $this->form->store();

        Toaster::success('Loja criada com sucesso!');

        $this->redirect(route('stores.index'), navigate: true);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.store.create');
    }
}
