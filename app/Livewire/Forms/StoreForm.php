<?php

namespace App\Livewire\Forms;

use App\Models\Store;
use Illuminate\Support\Str;
use Livewire\Form;

class StoreForm extends Form
{
    public ?Store $store = null;

    public string $name = '';

    public string $slug = '';

    public string $website = '';

    public string $phone = '';

    public array $opening_hours_json = [];

    /**
     * Set the store to edit.
     */
    public function setStore(Store $store): void
    {
        $this->store = $store;
        $this->name = $store->name;
        $this->slug = $store->slug;
        $this->website = $store->website;
        $this->phone = $store->phone;
        $this->opening_hours_json = $store->opening_hours_json ?? [];
    }

    /**
     * Convert opening hours array to JSON format for storage.
     */
    private function convertToJson(array $openingHours): array
    {
        $result = [];
        foreach ($openingHours as $hour) {
            if (! empty($hour['day']) && ! empty($hour['start']) && ! empty($hour['end'])) {
                $result[] = [
                    'day' => $hour['day'],
                    'start' => $hour['start'],
                    'end' => $hour['end'],
                ];
            }
        }

        return $result;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $unique_rule = 'unique:stores,slug';
        if ($this->store) {
            $unique_rule .= ','.$this->store->id;
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $unique_rule],
            'website' => ['required', 'string', 'url', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'opening_hours_json.*.day' => ['nullable', 'string'],
            'opening_hours_json.*.start' => ['required_with:opening_hours_json.*.day', 'date_format:H:i'],
            'opening_hours_json.*.end' => ['required_with:opening_hours_json.*.day', 'date_format:H:i'],
        ];
    }

    /**
     * Generate slug from name.
     */
    public function generateSlug(): void
    {
        $this->slug = Str::slug($this->name);
    }

    /**
     * Create a new store.
     */
    public function store(): Store
    {
        $validated = $this->validate();
        $validated['user_id'] = auth()->id();
        $validated['opening_hours_json'] = ! empty($this->opening_hours_json)
            ? $this->convertToJson($this->opening_hours_json)
            : null;

        return Store::create($validated);
    }

    /**
     * Update the store.
     */
    public function update(): void
    {
        $validated = $this->validate();
        $validated['opening_hours_json'] = ! empty($this->opening_hours_json)
            ? $this->convertToJson($this->opening_hours_json)
            : null;

        $this->store->update($validated);
    }
}
