<div>
    <flux:field>
        <flux:label>Cervejas da Loja</flux:label>
        <flux:text class="mb-4 text-sm">
            Vincule cervejas à loja informando preço, URL e etiqueta promocional.
        </flux:text>

        <!-- Cervejas já vinculadas -->
        @if (!empty($selectedBeers))
            <div class="mb-6">
                <flux:text class="mb-2 font-medium">Cervejas Vinculadas:</flux:text>
                <div class="space-y-3">
                    @foreach ($selectedBeers as $beer)
                        <div class="flex items-center justify-between p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                            <div class="flex-1">
                                <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $beer['name'] }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    <span class="font-semibold">Preço:</span> R$ {{ number_format($beer['price'] / 100, 2, ',', '.') }}
                                    <span class="mx-2">•</span>
                                    <span class="font-semibold">Promoção:</span> {{ $beer['promo_label'] }}
                                </div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    <span class="font-semibold">URL:</span>
                                    <a href="{{ $beer['url'] }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                        {{ Str::limit($beer['url'], 50) }}
                                    </a>
                                </div>
                            </div>

                            <flux:button
                                type="button"
                                variant="danger"
                                size="sm"
                                icon="trash"
                                wire:click="removeBeer({{ $beer['beer_id'] }})"
                                wire:confirm="Tem certeza que deseja remover esta cerveja?"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Adicionar nova cerveja -->
        @if ($store && !empty($availableBeers))
            <div class="p-4 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg">
                <flux:text class="mb-4 font-medium">Adicionar Nova Cerveja:</flux:text>

                <div class="space-y-4">
                    <flux:field>
                        <flux:select wire:model.live="form.selectedBeerId" label="Selecione a Cerveja">
                            <flux:select.option value="">Escolha uma cerveja</flux:select.option>
                            @foreach($availableBeers as $beer)
                                <flux:select.option value="{{ $beer['id'] }}">{{ $beer['name'] }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <div class="grid lg:grid-cols-2 gap-4">
                        <flux:field>
                            <flux:input
                                wire:model="form.price"
                                label="Preço (em centavos)"
                                type="number"
                                min="0"
                                placeholder="2990 = R$ 29,90"
                            />
                        </flux:field>

                        <flux:field>
                            <flux:input
                                wire:model="form.promo_label"
                                label="Etiqueta Promocional"
                                type="text"
                                placeholder="Ex: Promoção de Verão"
                            />
                        </flux:field>
                    </div>

                    <flux:field>
                        <flux:input
                            wire:model="form.url"
                            label="URL do Produto"
                            type="url"
                            placeholder="https://loja.com/produto/cerveja"
                        />
                    </flux:field>

                    <flux:button
                        type="button"
                        variant="primary"
                        icon="plus"
                        wire:click="addBeer()"
                        :disabled="!$form->selectedBeerId"
                    >
                        Adicionar Cerveja
                    </flux:button>
                </div>
            </div>
        @elseif ($store && empty($availableBeers))
            <div class="p-4 text-center border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg">
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Todas as cervejas já foram adicionadas a esta loja.
                </flux:text>
            </div>
        @endif

        @if (empty($selectedBeers) && (!$store || empty($availableBeers)))
            <div class="py-8 text-center border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg">
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Nenhuma cerveja vinculada ainda. Adicione cervejas à loja.
                </flux:text>
            </div>
        @endif
    </flux:field>
</div>
