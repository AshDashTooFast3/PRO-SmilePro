<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">
                        Factuur wijzigen
                    </h3>

                    <form action="{{ route('factuur.update', $factuur->Id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @if (session('success'))
                            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                                <meta http-equiv="refresh" content="3">
                            </div>
                        @elseif (session('error'))
                            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                                <meta http-equiv="refresh" content="3">
                            </div>
                        @endif

                        {{-- Nummer --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Nummer</label>
                            <input type="text" name="Nummer" value="{{ old('Nummer', $factuur->Nummer) }}"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        {{-- Omschrijving --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Omschrijving</label>
                            <input type="text" name="Omschrijving"
                                value="{{ old('Omschrijving', $factuur->Omschrijving) }}"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        {{-- Datum --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Datum</label>
                            <input type="date" name="Datum" value="{{ old('Datum', $factuur->Datum) }}"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        {{-- Tijd --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Tijd</label>
                            <input type="text" name="Tijd"
                                value="{{ old('Tijd', \Carbon\Carbon::parse($factuur->Tijd)->format('H:i')) }}"
                                placeholder="HH:MM" pattern="^([01]?[0-9]|2[0-3]):[0-5][0-9]$"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <input type="text" name="Status" value="{{ old('Status', $factuur->Status) }}"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        {{-- Bedrag --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Bedrag</label>
                            <input type="number" step="0.01" name="Bedrag"
                                value="{{ old('Bedrag', $factuur->Bedrag) }}"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">
                            Factuur opslaan
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
