<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ultimos Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Formulario para nuevo chirp --}}
                    <form method="POST" action="{{ route('chirps.store') }}">
                        @csrf
                        <div>
                            <textarea name="message" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Escribe tu chirp..."></textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>
                        <div class="mt-3 text-right">
                            <x-primary-button>
                                {{ __('Chirpear') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Lista de chirps --}}
            <div class="mt-6 space-y-4">
                @forelse ($chirps as $chirp)
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <img src="https://avatars.laravel.cloud/{{ $chirp->user->email }}?size=40" alt="Avatar" class="rounded-full w-10 h-10">
                                <div>
                                    <strong>{{ $chirp->user->name }}</strong>
                                    <small class="text-gray-500">· {{ $chirp->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @can('update', $chirp)
                                <div class="flex gap-2">
                                    <a href="{{ route('chirps.edit', $chirp) }}" class="text-blue-600 hover:underline">Editar</a>
                                    <form method="POST" action="{{ route('chirps.destroy', $chirp) }}" onsubmit="return confirm('¿Eliminar este chirp?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                        <p class="mt-2 text-gray-700">{{ $chirp->message }}</p>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                        No hay chirps todavia
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
