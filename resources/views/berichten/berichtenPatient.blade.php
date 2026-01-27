<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ _('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100">{{ $title }}</span>
                    <div class="mt-5 overflow-x-auto rounded-lg border border-gray-700">
                        <table class="min-w-full table-fixed border-collapse">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-48">Patient</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-56">Medewerker</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white">Bericht</th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse($berichten as $bericht)
                                    <tr class="hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 text-sm text-gray-100">
                                            {{ $bericht->PatientNummer }} – {{ $bericht->PatientVoornaam }}
                                            {{ $bericht->PatientTussenvoegsel }} {{ $bericht->PatientAchternaam }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-100">
                                            {{ $bericht->MedewerkerNummer }} – {{ $bericht->MedewerkerVoornaam }}
                                            {{ $bericht->MedewerkerTussenvoegsel }} {{ $bericht->MedewerkerAchternaam }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-100 break-words">
                                            {{ $bericht->Bericht }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                            Geen berichten gevonden.
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