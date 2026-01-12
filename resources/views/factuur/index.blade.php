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
                                        Patient naam
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Behandelingtype
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Factuurnummer
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Omschrijving
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Datum
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tijd
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Bedrag
                                    </th>

                                    @forelse($facturen as $factuur)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ $factuur->PatientVoornaam }} {{ $factuur->PatientTussenvoegsel }}
                                                {{ $factuur->PatientAchternaam }}
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ $factuur->BehandelingType }}
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ $factuur->Nummer }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ $factuur->Omschrijving }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ $factuur->Datum }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($factuur->Tijd)->format('H:i') }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                {{ $factuur->Status }}
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-normal break-words text-sm text-gray-900 dark:text-gray-100">
                                                €{{ number_format($factuur->Bedrag, 2) }}
                                            </td>
                                        </tr>

                                    @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                            <div class="flex justify-center items-center">
                                                Geen facturen gevonden.
                                            </div>
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