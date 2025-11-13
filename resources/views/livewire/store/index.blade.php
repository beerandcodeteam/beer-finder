<div>
    <flux:main container="">

        <div class="flex flex-row items-center w-full justify-between">
            <div>
                <flux:heading size="xl">Lojas</flux:heading>
                <flux:text class="mt-2 mb-6 text-base">Listagem de lojas</flux:text>
            </div>

            <flux:button icon="plus-circle" :href="route('stores.create')" wire:navigate>Criar nova loja</flux:button>
        </div>

        <div class="grid lg:grid-cols-4 gap-4 mb-6 items-end">
            <flux:field class="col-span-1">
                <flux:input label="Nome" placeholder="Busque pelo nome" wire:model="filters.name"/>
            </flux:field>
            <flux:field class="col-span-1">
                <flux:input label="Telefone" placeholder="Busque pelo telefone" wire:model="filters.phone"/>
            </flux:field>
            <flux:field class="col-span-1">
                <flux:input label="Website" placeholder="Busque pelo website" wire:model="filters.website"/>
            </flux:field>
            <flux:field class="col-span-1">
                <flux:button wire:click="filter" icon="magnifying-glass" class="w-full">Filtrar</flux:button>
            </flux:field>
        </div>

        <x-section>
            <x-table>
                <x-table.columns>
                    <x-table.column
                        wire:click="sort('name')"
                        sortable
                        :sorted="$sortBy === 'name'"
                        :direction="$sortDirection"
                    >
                        Nome
                    </x-table.column>
                    <x-table.column>Slug</x-table.column>
                    <x-table.column>Website</x-table.column>
                    <x-table.column>Telefone</x-table.column>
                    <x-table.column>Proprietário</x-table.column>
                    <x-table.column></x-table.column>
                </x-table.columns>

                <x-table.rows>
                    @foreach($stores as $store)
                        <x-table.row wire:key="{{ $store->id }}">
                            <x-table.cell>{{ $store->name }}</x-table.cell>
                            <x-table.cell>{{ $store->slug }}</x-table.cell>
                            <x-table.cell>
                                <a href="{{ $store->website }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                    {{ Str::limit($store->website, 30) }}
                                </a>
                            </x-table.cell>
                            <x-table.cell>{{ $store->phone }}</x-table.cell>
                            <x-table.cell>{{ $store->user?->name ?? 'N/A' }}</x-table.cell>
                            <x-table.cell>
                                <flux:button
                                    :href="route('stores.update', $store->id)"
                                    variant="ghost" size="sm" icon="pencil" class="cursor-pointer"
                                    inset="top bottom"
                                    wire:navigate
                                ></flux:button>
                                <flux:button
                                    wire:click="remove({{ $store->id }})"
                                    wire:confirm="Tem certeza que deseja remover esta loja?"
                                    variant="ghost" size="sm" icon="trash" class="cursor-pointer"
                                    inset="top bottom"
                                ></flux:button>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table.rows>

            </x-table>

            <div class="mt-6">
                {{ $stores->links() }}
            </div>
        </x-section>
    </flux:main>


</div>
