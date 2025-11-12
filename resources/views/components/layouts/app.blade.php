<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    <x-toaster-hub />
</x-layouts.app.sidebar>
