<div class="h-full flex flex-col" x-data="{
    scrollToBottom() {
        setTimeout(() => {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }, 100);
    }
}" x-init="$watch('$wire.messages', () => scrollToBottom())">
    <flux:main container="">
        <div class="flex flex-col h-full max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="mb-6">
                <flux:heading size="xl">Beer Finder Chat</flux:heading>
                <flux:text class="mt-2">Pergunte sobre cervejas e receba recomendações!</flux:text>
            </div>

            {{-- Messages Container --}}
            <div x-ref="messagesContainer" class="flex-1 overflow-y-auto mb-6 space-y-4 max-h-[calc(100vh-280px)] border border-neutral-200 dark:border-neutral-700 rounded-lg p-4 bg-neutral-50 dark:bg-neutral-900">
                @if(empty($messages))
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <flux:icon.chat-bubble-bottom-center-text class="w-16 h-16 text-neutral-400 dark:text-neutral-600 mb-4"/>
                        <flux:text class="text-neutral-500 dark:text-neutral-400">
                            Comece uma conversa! Pergunte sobre cervejas para churrascos, harmonizações ou qualquer dúvida.
                        </flux:text>
                    </div>
                @else
                    @foreach($messages as $msg)
                        @if($msg['type'] === 'user')
                            {{-- User Message --}}
                            <div class="flex justify-end">
                                <div class="max-w-[80%] bg-zinc-600 text-white rounded-lg p-4">
                                    <p class="text-sm">{{ $msg['content'] }}</p>
                                    <span class="text-xs opacity-75 mt-2 block">{{ $msg['timestamp']->format('H:i') }}</span>
                                </div>
                            </div>
                        @else
                            {{-- Bot Message --}}
                            <div class="flex justify-start">
                                <div class="max-w-[85%] space-y-4">
                                    <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 shadow-sm border border-neutral-200 dark:border-neutral-700">
                                        <p class="text-sm text-neutral-900 dark:text-neutral-100">{{ $msg['content'] }}</p>
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 block">{{ $msg['timestamp']->format('H:i') }}</span>
                                    </div>

                                    {{-- Beer Cards --}}
                                    @if(!empty($msg['beers']))
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            @foreach($msg['beers'] as $beer)
                                                <a href="{{ $beer['url'] }}" target="_blank" class="block">
                                                    <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 shadow-sm border border-neutral-200 dark:border-neutral-700 hover:shadow-md transition-shadow">
                                                        <div class="aspect-square overflow-hidden rounded-md mb-3 bg-neutral-100 dark:bg-neutral-900 flex items-center justify-center">
                                                            <img src="{{ $beer['imagem'] }}" alt="{{ $beer['nome'] }}" class="w-full h-full object-cover"/>
                                                        </div>
                                                        <h3 class="font-semibold text-sm text-neutral-900 dark:text-neutral-100 mb-2">{{ $beer['nome'] }}</h3>
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-lg font-bold text-green-600 dark:text-green-500">{{ $beer['preco'] }}</span>
                                                            <flux:icon.arrow-top-right-on-square class="w-4 h-4 text-neutral-400"/>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{-- Loading Indicator --}}
                    @if($isLoading)
                        <div class="flex justify-start">
                            <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 shadow-sm border border-neutral-200 dark:border-neutral-700">
                                <div class="flex space-x-2">
                                    <div class="w-2 h-2 bg-neutral-400 dark:bg-neutral-500 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-neutral-400 dark:bg-neutral-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                    <div class="w-2 h-2 bg-neutral-400 dark:bg-neutral-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Input Form --}}
            <div class="mt-auto">
                <form wire:submit="sendMessage" class="flex gap-3">
                    <div class="flex-1">
                        <flux:input
                            wire:model="message"
                            placeholder="Digite sua pergunta sobre cervejas..."
                            class="w-full"
                        />
                        @error('message')
                        <flux:text class="text-red-600 text-sm mt-1">{{ $message }}</flux:text>
                        @enderror
                    </div>
                    <flux:button
                        type="submit"
                        icon="paper-airplane"
                        variant="primary"
                        :disabled="$isLoading"
                    >
                        Enviar
                    </flux:button>
                </form>
            </div>
        </div>
    </flux:main>
</div>
