<div>
    <flux:main container="">
        <div class="flex flex-row items-center justify-between w-full">
            <div>
                <flux:heading size="xl">Cervejas</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Listagem de cervejas</flux:text>
            </div>

            @can('create', \App\Models\Beer::class)
                <flux:button href="{{ route('beers.create') }}" icon="plus-circle">Criar nova cerveja</flux:button>
            @endcan
        </div>

        <div class="grid lg:grid-cols-13 gap-4 mb-6 items-end">

            <flux:field class="col-span-3">
                <flux:input label="Nome" placeholder="Busque pelo nome da cerveja" wire:model="filters.name" />
            </flux:field>

            <flux:field class="col-span-3">
                <flux:select label="Propriedade" wire:model.live="filters.prop_filter">
                    <flux:select.option value="">Selecione</flux:select.option>
                    <flux:select.option value="first_brewed_date">Data da primeira fabricação</flux:select.option>
                    <flux:select.option value="abv">Abv</flux:select.option>
                    <flux:select.option value="ibu">Ibu</flux:select.option>
                    <flux:select.option value="ebc">Ebc</flux:select.option>
                    <flux:select.option value="ph">Ph</flux:select.option>
                    <flux:select.option value="volume">Volume</flux:select.option>
                </flux:select>
            </flux:field>

            <flux:field class="col-span-3">
                <flux:select label="Regra" :disabled="empty($filters['prop_filter'])" wire:model.live="filters.prop_filter_rule">
                    <flux:select.option value="">Selecione</flux:select.option>
                    <flux:select.option value=">">Maior que</flux:select.option>
                    <flux:select.option value="<">Menor que</flux:select.option>
                    <flux:select.option value=">=">Maior ou igual</flux:select.option>
                    <flux:select.option value="<=">Menor ou igual</flux:select.option>
                    <flux:select.option value="=">Igual</flux:select.option>
                </flux:select>
            </flux:field>

            <flux:field class="col-span-3">
                <flux:input label="Valor"
                            placeholder="Valor desejado"
                            wire:model.live="filters.prop_filter_value"
                            :disabled="empty($filters['prop_filter_rule'])"
                            :type="isset($filters['prop_filter']) && $filters['prop_filter'] == 'first_brewed_date' ? 'date' : 'number'"
                />
            </flux:field>
            <flux:field class="col-span-1">
                <flux:button wire:click="filter" icon="magnifying-glass" class="w-full"></flux:button>
            </flux:field>

        </div>

        <x-section>

            <x-table>

                <x-table.columns>

                    <x-table.column>Nome</x-table.column>
                    <x-table.column
                        wire:click="sort('first_brewed_at')"
                        sortable
                        :sorted="$sortBy === 'first_brewed_at'"
                        :direction="$sortDirection"
                    >
                        Data da primeira receita
                    </x-table.column>
                    <x-table.column
                        wire:click="sort('abv')"
                        sortable
                        :sorted="$sortBy === 'abv'"
                        :direction="$sortDirection"
                    >
                        Abv
                    </x-table.column>
                    <x-table.column
                        wire:click="sort('ibu')"
                        sortable
                        :sorted="$sortBy === 'ibu'"
                        :direction="$sortDirection"
                    >
                        Ibu
                    </x-table.column>
                    <x-table.column
                        wire:click="sort('ebc')"
                        sortable
                        :sorted="$sortBy === 'ebc'"
                        :direction="$sortDirection"
                    >
                        Ebc
                    </x-table.column>
                    <x-table.column
                        wire:click="sort('ph')"
                        sortable
                        :sorted="$sortBy === 'ph'"
                        :direction="$sortDirection"
                    >
                        Ph
                    </x-table.column>
                    <x-table.column
                        wire:click="sort('volume')"
                        sortable
                        :sorted="$sortBy === 'volume'"
                        :direction="$sortDirection"
                    >
                        Volume
                    </x-table.column>
                    <x-table.column></x-table.column>

                    <x-table.rows>
                        @foreach ($beers as $beer)
                            <x-table.row wire:key="beer-{{ $beer['id'] }}">
                                <x-table.cell>
                                    {{ $beer['name'] }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $beer['first_brewed_at']->format('d/m/Y') }}
                                </x-table.cell>
                                <x-table.cell>{{ $beer['abv'] }}</x-table.cell>
                                <x-table.cell>{{ $beer['ibu'] }}</x-table.cell>
                                <x-table.cell>{{ $beer['ebc'] }}</x-table.cell>
                                <x-table.cell>{{ $beer['ph'] }}</x-table.cell>
                                <x-table.cell>{{ $beer['volume'] }}</x-table.cell>
                                <x-table.cell>

                                    @can('update', $beer)
                                        <flux:button
                                            href="{{ route('beers.update', $beer['id']) }}"
                                            variant="ghost" size="sm" icon="pencil" class="cursor-pointer"
                                            inset="top bottom"></flux:button>
                                    @endcan
                                    @can('delete', $beer)
                                    <flux:button
                                        wire:click="remove({{ $beer['id'] }})"
                                        variant="ghost" size="sm" icon="trash" class="cursor-pointer"
                                        inset="top bottom"></flux:button>
                                    @endcan
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-table.rows>

                </x-table.columns>

            </x-table>

            <div class="mt-6">
                {{ $beers->links() }}
            </div>

        </x-section>
    </flux:main>
</div>
