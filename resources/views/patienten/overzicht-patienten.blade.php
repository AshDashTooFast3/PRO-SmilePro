<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100">{{ $title }}</span>
                    <a href="/Patient-toevoegen"
                        class="float-right inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Patiënt toevoegen
                    </a>

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

                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nummer</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Naam</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Medischdossier</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Factuur toesturen</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        wijzigen</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        annuleren</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($patienten as $patient)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->Nummer }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->Naam }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->MedischDossier }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            <form action="{{ route('factuur.create') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="patient_id" value="{{ $patient->PatientId }}">
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-sm text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Factuur maken
                                                </button>
                                            </form>
                                        </td>

                                        <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            <form action="{{ route('patient.edit', $patient->PatientId) }}" method="GET">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-md bg-green-600 px-3 py-1.5 text-sm text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    wijzigen
                                                </button>
                                            </form>
                                        </td>

                                        <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            <form action="{{ route('patient.delete') }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze patient wilt verwijderen?');">
                                            @csrf
                                                <input type="hidden" name="patient_id" value="{{ $patient->PatientId }}">
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    verwijderen
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                            Geen patienten gevonden.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
