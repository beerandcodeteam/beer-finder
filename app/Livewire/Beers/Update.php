<?php

namespace App\Livewire\Beers;

use App\Livewire\Forms\BeerForm;
use App\Models\Beer;
use Livewire\Component;

class Update extends Component
{
    public BeerForm $form;
    public Beer $beer;

    public function mount(Beer $beer)
    {
        $this->beer = $beer;
        $this->form->setBeer($beer);
    }

    public function save()
    {
        $this->form->update();
        return redirect(route('beers.index'))
            ->success("{$this->form->name} atualizada com sucesso!");
    }

    public function render()
    {
        return view('livewire.beers.update');
    }
}
