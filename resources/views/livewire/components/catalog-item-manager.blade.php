<div>
    <flux:field>
        <flux:label>Itens do Catálogo</flux:label>
        <flux:text class="mb-4 text-sm">
            Gerencie os itens do catálogo da loja com nome, descrição, ingredientes, preço e URL.
        </flux:text>

        <!-- Items já cadastrados -->
        @if (!empty($catalogItems))
            <div class="mb-6">
                <flux:text class="mb-2 font-medium">Itens Cadastrados:</flux:text>
                <div class="space-y-3">
                    @foreach ($catalogItems as $item)
                        <div class="flex items-start justify-between p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                            <div class="flex-1">
                                <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $item['name'] }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    <span class="font-semibold">Preço:</span> R$ {{ number_format($item['price'] / 100, 2, ',', '.') }}
                                </div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    <span class="font-semibold">Descrição:</span> {{ Str::limit($item['description'], 80) }}
                                </div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    <span class="font-semibold">Ingredientes:</span> {{ Str::limit($item['ingredients'], 80) }}
                                </div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    <span class="font-semibold">URL:</span>
                                    <a href="{{ $item['url'] }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                        {{ Str::limit($item['url'], 50) }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex gap-2 ml-4">
                                <flux:button
                                    type="button"
                                    variant="ghost"
                                    size="sm"
                                    icon="pencil"
                                    wire:click="editItem({{ $item['id'] }})"
                                />
                                <flux:button
                                    type="button"
                                    variant="danger"
                                    size="sm"
                                    icon="trash"
                                    wire:click="removeItem({{ $item['id'] }})"
                                    wire:confirm="Tem certeza que deseja remover este item?"
                                />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Formulário para adicionar/editar item -->
        @if ($store)
            @if (!$showForm)
                <flux:button
                    type="button"
                    variant="primary"
                    icon="plus"
                    wire:click="showAddForm"
                >
                    Adicionar Novo Item
                </flux:button>
            @else
                <div class="p-4 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg">
                    <flux:text class="mb-4 font-medium">
                        {{ $editingItemId ? 'Editar Item:' : 'Adicionar Novo Item:' }}
                    </flux:text>

                    <div class="space-y-4">
                        <flux:field>
                            <flux:input
                                wire:model="form.name"
                                label="Nome do Item"
                                type="text"
                                placeholder="Ex: IPA Clássica"
                                required
                            />
                        </flux:field>

                        <flux:field>
                            <flux:input
                                wire:model="form.url"
                                label="URL do Produto"
                                type="url"
                                placeholder="https://loja.com/produto/ipa-classica"
                                required
                            />
                        </flux:field>

                        <flux:field>
                            <flux:input
                                wire:model="form.price"
                                label="Preço (em centavos)"
                                type="number"
                                min="0"
                                placeholder="2990 = R$ 29,90"
                                required
                            />
                        </flux:field>

                        <flux:field>
                            <flux:textarea
                                wire:model="form.description"
                                label="Descrição"
                                placeholder="Descreva o produto..."
                                rows="3"
                                required
                            />
                        </flux:field>

                        <flux:field>
                            <flux:textarea
                                wire:model="form.ingredients"
                                label="Ingredientes"
                                placeholder="Liste os ingredientes..."
                                rows="3"
                                required
                            />
                        </flux:field>

                        <div class="flex gap-3">
                            <flux:button
                                type="button"
                                variant="primary"
                                icon="{{ $editingItemId ? 'check' : 'plus' }}"
                                wire:click="saveItem"
                            >
                                {{ $editingItemId ? 'Atualizar Item' : 'Adicionar Item' }}
                            </flux:button>

                            <flux:button
                                type="button"
                                variant="ghost"
                                wire:click="cancelForm"
                            >
                                Cancelar
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if (empty($catalogItems) && !$store)
            <div class="py-8 text-center border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg">
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Nenhum item cadastrado ainda. Adicione itens ao catálogo da loja.
                </flux:text>
            </div>
        @endif
    </flux:field>
</div>
