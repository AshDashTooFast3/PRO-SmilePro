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
                    <form method="POST" action="{{ route('praktijkmanagement.storeBericht') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="PatientNummer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Patientnummer</label>
                            <select name="PatientNummer" id="PatientNummer" class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
                                <option value="">Selecteer een patiënt</option>
                                @foreach($patienten as $patient)
                                    <option value="{{ $patient->PatientNummer }}">{{ $patient->naam }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="MedewerkerNummer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medewerkernummer</label>
                            <select name="MedewerkerNummer" id="MedewerkerNummer" class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required>
                                <option value="">Selecteer een medewerker</option>
                                @foreach($medewerkers as $medewerker)
                                    <option value="{{ $medewerker->MedewerkerNummer }}">{{ $medewerker->naam }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="Bericht" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bericht</label>
                            <textarea name="Bericht" id="Bericht" rows="4" class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100" required></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">Verzenden</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>