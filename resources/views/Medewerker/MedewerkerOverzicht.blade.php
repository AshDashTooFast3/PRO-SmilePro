<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-white dark:text-gray-100 text-lg font-medium">Overzicht van medewerkers</span>
                </div>

                <div class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="container">
                        <h1 class="mb-6 text-center text-3xl font-bold text-white dark:text-gray-100">Medewerker Overzicht</h1>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700 text-white">
                                <thead class="bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Medewerkernummer</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Naam</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Type</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Specialisatie</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Beschikbaarheid</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Actief</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold uppercase tracking-wider">Opmerking</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    @forelse($medewerkers as $m)
                                    <tr class="hover:bg-gray-700">
                                        <td class="px-4 py-3">{{ $m->Nummer }}</td>
                                        <td class="px-4 py-3">
                                            @if($m->persoon)
                                                {{ $m->persoon->Voornaam }}
                                                @if($m->persoon->Tussenvoegsel)
                                                    {{ $m->persoon->Tussenvoegsel }}
                                                @endif
                                                {{ $m->persoon->Achternaam }}
                                            @else
                                                <em>Onbekend</em>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $m->Medewerkertype }}</td>
                                        <td class="px-4 py-3">{{ $m->Specialisatie ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $m->Beschikbaarheid ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $m->Isactief ? 'Ja' : 'Nee' }}</td>
                                        <td class="px-4 py-3">{{ $m->Opmerking ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center">
                                            <div class="bg-blue-600 text-white py-4 px-6 rounded-md shadow-md inline-block">
                                                <span class="font-semibold">Er zijn geen medewerkers aanwezig</span>
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
    </div>
</x-app-layout>