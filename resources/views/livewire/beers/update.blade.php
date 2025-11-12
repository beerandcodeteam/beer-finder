<div>
    <div class="flex flex-row items-center justify-between w-full">
        <div>
            <flux:heading size="xl">Cervejas</flux:heading>
            <flux:text class="mt-2 mb-6 text-base">Atualizar cerveja</flux:text>
        </div>

        <flux:button href="{{ route('beers.index') }}" icon="plus-circle">Voltar</flux:button>
    </div>

    <x-section>

        <form wire:submit="save" class="space-y-6">
            <div class="grid lg:grid-cols-2 gap-6">
                <flux:field>
                    <flux:input
                        label="Nome"
                        placeholder="Nome da cerveja"
                        wire:model="form.name"
                        required
                    />
                </flux:field>

                <flux:field>
                    <flux:input
                        label="Tagline"
                        placeholder="Slogan ou frase de efeito"
                        wire:model="form.tagline"
                        required
                    />
                </flux:field>
            </div>

            <flux:field>
                <flux:textarea
                    label="Descrição"
                    placeholder="Descrição detalhada da cerveja"
                    wire:model="form.description"
                    rows="4"
                    required
                />
            </flux:field>

            <div class="grid lg:grid-cols-4 gap-6">
                <flux:field>
                    <flux:input
                        label="Data da Primeira Receita"
                        type="date"
                        wire:model="form.first_brewed_at"
                        required
                    />
                </flux:field>

                <flux:field>
                    <flux:input
                        label="ABV (%)"
                        type="number"
                        step="0.1"
                        min="0"
                        max="100"
                        placeholder="0.0"
                        wire:model="form.abv"
                        required
                    />
                </flux:field>

                <flux:field>
                    <flux:input
                        label="IBU"
                        type="number"
                        min="0"
                        max="200"
                        placeholder="0"
                        wire:model="form.ibu"
                        required
                    />
                </flux:field>

                <flux:field>
                    <flux:input
                        label="EBC"
                        type="number"
                        min="0"
                        max="100"
                        placeholder="0"
                        wire:model="form.ebc"
                        required
                    />
                </flux:field>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <flux:field>
                    <flux:input
                        label="pH"
                        type="number"
                        step="0.1"
                        min="0"
                        max="14"
                        placeholder="0.0"
                        wire:model="form.ph"
                        required
                    />
                </flux:field>

                <flux:field>
                    <flux:input
                        label="Volume (ml)"
                        type="number"
                        min="1"
                        placeholder="355"
                        wire:model="form.volume"
                        required
                    />
                </flux:field>
            </div>

            <flux:field>
                <flux:textarea
                    label="Ingredientes"
                    placeholder="Liste os ingredientes da cerveja"
                    wire:model="form.ingredients"
                    rows="4"
                    required
                />
            </flux:field>

            <flux:field>
                <flux:textarea
                    label="Dicas do Cervejeiro"
                    placeholder="Dicas e recomendações para apreciar esta cerveja"
                    wire:model="form.brewer_tips"
                    rows="4"
                />
            </flux:field>

            <flux:separator />

            <livewire:components.image-uploader :model="$beer ?? null" storage-path="beers" />

            <div class="flex items-center justify-end gap-4">
                <flux:button variant="ghost" :href="route('beers.index')" wire:navigate>
                    Cancelar
                </flux:button>
                <flux:button variant="primary" type="submit" icon="check">
                    Atualizar Cerveja
                </flux:button>
            </div>
        </form>

    </x-section>
</div>
