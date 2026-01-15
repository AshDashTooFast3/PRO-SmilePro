<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                        <div class="mt-4 p-4 bg-green-400 border border-green-400 text-green-900 rounded">
                            {{ session('success') }}
                            <meta http-equiv="refresh" content="5;url={{ route('berichten.index') }}">
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mt-4 p-4 bg-red-300 border border-red-400 text-red-900 rounded">
                            {{ session('error') }}
                            <meta http-equiv="refresh" content="5;url={{ route('berichten.create') }}">
                        </div>
                    @endif

                    <form method="POST" action="{{ route('berichten.update', $bericht->Id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="Patient"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Patient:</label>
                            <select name="Patient" id="Patient"
                                class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                required>
                                @foreach($patienten as $patient)
                                    <option value="{{ $patient->Id }}" {{ $patient->Id == $bericht->PatientId ? 'selected' : '' }}>
                                        {{ $patient->Id }} -
                                        {{ $patient->Persoon->Voornaam }}
                                        {{ $patient->Persoon->Tussenvoegsel }}
                                        {{ $patient->Persoon->Achternaam }}
                                        {{ $patient->Nummer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="Medewerker"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medewerker:</label>
                            <select name="Medewerker" id="Medewerker"
                                class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                required>
                                @foreach($medewerkers as $medewerker)
                                    <option value="{{ $medewerker->Id }}" {{ $medewerker->Id == $bericht->MedewerkerId ? 'selected' : '' }}>
                                        {{ $medewerker->Id }} -
                                        {{ $medewerker->Persoon->Voornaam }}
                                        {{ $medewerker->Persoon->Tussenvoegsel }}
                                        {{ $medewerker->Persoon->Achternaam }}
                                        {{ $medewerker->Nummer }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="Bericht"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bericht</label>
                            <textarea name="Bericht" id="Bericht" rows="4"
                                class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100"
                                required>{{ old('Bericht', $bericht->Bericht) }}</textarea>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">Aanmaken</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>