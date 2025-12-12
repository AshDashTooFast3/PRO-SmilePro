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
                                        opmerking</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($patienten as $patient)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->Nummer }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->Naam }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->MedischDossier }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                            {{ $patient->Opmerking }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">Geen
                                            patienten gevonden.</td>
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
