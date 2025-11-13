<div>
    <flux:main container="">
        <div class="flex flex-row items-center w-full justify-between mb-6">
            <div>
                <flux:heading size="xl">Editar Loja</flux:heading>
                <flux:text class="mt-2 text-base">Atualize os dados da loja</flux:text>
            </div>

            <flux:button variant="ghost" icon="arrow-left" :href="route('stores.index')" wire:navigate>
                Voltar
            </flux:button>
        </div>

        <x-section>
            <form wire:submit="save" class="space-y-6">
                <div class="grid lg:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:input
                            label="Nome"
                            placeholder="Nome da loja"
                            wire:model.blur="form.name"
                            wire:change="form.generateSlug"
                            required
                        />
                    </flux:field>

                    <flux:field>
                        <flux:input
                            label="Slug"
                            placeholder="slug-da-loja"
                            wire:model="form.slug"
                            required
                        />
                    </flux:field>
                </div>

                <div class="grid lg:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:input
                            label="Website"
                            placeholder="https://example.com"
                            type="url"
                            wire:model="form.website"
                            required
                        />
                    </flux:field>

                    <flux:field>
                        <flux:input
                            label="Telefone"
                            placeholder="(00) 00000-0000"
                            type="tel"
                            wire:model="form.phone"
                            required
                        />
                    </flux:field>
                </div>

                <div>
                    <flux:label>Horário de Funcionamento</flux:label>
                    <flux:text class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        Adicione os horários de funcionamento da loja. Opcional.
                    </flux:text>

                    @foreach($form->opening_hours_json as $index => $hour)
                        <div class="grid lg:grid-cols-8 gap-4 mb-4" wire:key="hour-{{ $index }}">
                            <flux:field class="col-span-3">
                                <flux:select wire:model="form.opening_hours_json.{{ $index }}.day">
                                    <flux:select.option value="">Selecione o dia</flux:select.option>
                                    <flux:select.option value="monday">Segunda-feira</flux:select.option>
                                    <flux:select.option value="tuesday">Terça-feira</flux:select.option>
                                    <flux:select.option value="wednesday">Quarta-feira</flux:select.option>
                                    <flux:select.option value="thursday">Quinta-feira</flux:select.option>
                                    <flux:select.option value="friday">Sexta-feira</flux:select.option>
                                    <flux:select.option value="saturday">Sábado</flux:select.option>
                                    <flux:select.option value="sunday">Domingo</flux:select.option>
                                </flux:select>
                            </flux:field>

                            <flux:field class="col-span-2">
                                <flux:input
                                    type="time"
                                    wire:model="form.opening_hours_json.{{ $index }}.start"
                                    placeholder="Início"
                                />
                            </flux:field>

                            <flux:field class="col-span-2">
                                <flux:input
                                    type="time"
                                    wire:model="form.opening_hours_json.{{ $index }}.end"
                                    placeholder="Fim"
                                />
                            </flux:field>

                            <div class="flex items-end">
                                <flux:button
                                    type="button"
                                    variant="danger"
                                    icon="trash"
                                    wire:click="removeOpeningHour({{ $index }})"
                                />
                            </div>
                        </div>
                    @endforeach

                    <flux:button
                        type="button"
                        variant="ghost"
                        icon="plus"
                        wire:click="addOpeningHour"
                    >
                        Adicionar Horário
                    </flux:button>
                </div>

                <flux:separator/>

                <livewire:components.image-uploader :model="$store" storage-path="stores" />

                <flux:separator/>

                <livewire:components.beer-selector :store="$store" />

                <flux:separator/>

                <livewire:components.catalog-item-manager :store="$store" />

                <div class="flex items-center justify-end gap-4">
                    <flux:button variant="ghost" :href="route('stores.index')" wire:navigate>
                        Cancelar
                    </flux:button>
                    <flux:button variant="primary" type="submit" icon="check">
                        Atualizar Loja
                    </flux:button>
                </div>
            </form>
        </x-section>
    </flux:main>
</div>
