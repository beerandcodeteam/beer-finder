<div>
    <flux:field>

        <flux:label>Imagens</flux:label>
        <flux:text class="mb-4 text-sm">
            Faça upload de uma ou mais imagens. A primeira imagem será definida como capa automaticamente.
        </flux:text>

        <div class="mb-4">
            <input
                type="file"
                wire:model="images"
                multiple
                accept="image/*"
                class="p-4 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-zinc-800 dark:border-gray-600 dark:placeholder-gray-400"
            />

            @error('images.*')
                <flux:text class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</flux:text>
            @enderror

            <div wire:loading wire:target="images" class="mt-2">
                <flux:text class="text-sm">Carregando imagens....</flux:text>
            </div>
        </div>

        @if(!empty($images))
            <div class="mb-4">
                <flux:text class="mb-2 font-medium">Imagens para Upload:</flux:text>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($images as $index => $image)
                        <div class="relative group">
                            <img
                                src="{{ $image->temporaryUrl() }}"
                                alt="Preview"
                                class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700"
                            />
                            <button
                                type="button"
                                wire:click="removePendingImage({{ $index }})"
                                class="absolute top-2 right-2 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            @if ($index === 0 && empty($existingImages))
                                <div class="absolute bottom-2 left-2 px-2 py-1 bg-blue-600 text-white text-xs rounded">
                                    Capa
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if ($model)
                    <div class="mt-4">
                        <flux:button
                            wire:click="saveImages"
                            variant="primary"
                            size="sm"
                            icon="arrow-up-tray"
                        >
                            Salvar Imagens
                        </flux:button>
                    </div>
                @endif
            </div>
        @endif

        @if (!empty($existingImages))
            <div>
                <flux:text class="mb-2 font-medium">Imagens Salvas:</flux:text>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($existingImages as $existingImage)
                        <div class="relative group">
                            <img
                                src="{{ $existingImage['url'] }}"
                                alt="Image"
                                class="w-full h-32 object-cover rounded-lg border-2 {{ $existingImage['is_cover'] ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700' }}"
                            />

                            <!-- Botões de ação -->
                            <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if (!$existingImage['is_cover'])
                                    <button
                                        type="button"
                                        wire:click="setCover({{ $existingImage['id'] }})"
                                        class="p-1 bg-blue-600 text-white rounded-full"
                                        title="Definir como capa"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                @endif

                                <button
                                    type="button"
                                    wire:click="removeExistingImage({{ $existingImage['id'] }})"
                                    wire:confirm="Tem certeza que deseja remover esta imagem?"
                                    class="p-1 bg-red-600 text-white rounded-full"
                                    title="Remover imagem"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Badge de capa -->
                            @if ($existingImage['is_cover'])
                                <div class="absolute bottom-2 left-2 px-2 py-1 bg-blue-600 text-white text-xs rounded">
                                    Capa
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </flux:field>
</div>
