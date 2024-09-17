<x-filament-panels::page>
    <h1 class="text-xl dark:text-primary-500">
        Mi contador
    </h1>

    <div>
        <h1>{{ $count }}</h1>

        <x-filament::button wire:click="increment">
            increment
        </x-filament::button>
        <x-filament::button wire:click="decrement">
            decrement
        </x-filament::button>
    </div>

    <x-filament::avatar
    src="https://filamentphp.com/dan.jpg"
    alt="Dan Harrin"
    />
</x-filament-panels::page>
