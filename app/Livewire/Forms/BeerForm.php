<?php

namespace App\Livewire\Forms;

use App\Models\Beer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BeerForm extends Form
{

    public ?Beer $beer = null;

    public string $name = '';

    public string $tagline = '';

    public string $description = '';

    public string $first_brewed_at = '';

    public string $abv = '';

    public string $ibu = '';

    public string $ebc = '';

    public string $ph = '';

    public string $volume = '';

    public string $ingredients = '';

    public string $brewer_tips = '';

    public function setBeer(Beer $beer): void
    {
        $this->beer = $beer;
        $this->name = $beer->name;
        $this->tagline = $beer->tagline;
        $this->description = $beer->description;
        $this->first_brewed_at = $beer->first_brewed_at->format('Y-m-d');
        $this->abv = (string) $beer->abv;
        $this->ibu = (string) $beer->ibu;
        $this->ebc = (string) $beer->ebc;
        $this->ph = (string) $beer->ph;
        $this->volume = (string) $beer->volume;
        $this->ingredients = $beer->ingredients;
        $this->brewer_tips = $beer->brewer_tips;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'tagline' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:1000',
            'first_brewed_at' => 'required|date',
            'abv' => 'required|numeric|min:0|max:100',
            'ibu' => 'required|numeric|min:0|max:200',
            'ebc' => 'required|numeric|min:0|max:100',
            'ph' => 'required|numeric|min:0|max:14',
            'volume' => 'required|numeric|min:0|max:100',
            'ingredients' => 'required|string|min:3|max:1000',
            'brewer_tips' => 'required|string|min:3|max:1000',
        ];
    }

    public function store(): Beer
    {
        return Beer::create($this->validate());
    }

    public function update(): Beer
    {
        $this->beer->update($this->validate());
        return $this->beer->fresh();
    }
}
