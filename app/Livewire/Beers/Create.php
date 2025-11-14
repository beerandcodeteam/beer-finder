<?php

namespace App\Livewire\Beers;

use App\Jobs\ProcessBeerJob;
use App\Livewire\Forms\BeerForm;
use App\Models\Beer;
use Livewire\Component;

class Create extends Component
{
    public BeerForm $form;

    public function save()
    {
        $this->authorize('create', Beer::class);
        $beer = $this->form->store();

        dispatch(new ProcessBeerJob($beer));

        return redirect(route('beers.index'))
            ->success("{$this->form->name} Criada com sucesso!");

    }

    public function render()
    {
        return view('livewire.beers.create');
    }
}
