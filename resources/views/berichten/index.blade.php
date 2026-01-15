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

                    {!! str_repeat('<br>', 2) !!}

                    <a href="{{ route('berichten.create') }}"
                        class="inline-block px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                        Nieuw Bericht aanmaken
                    </a>

                    @if(session('success'))
                        <div class="mt-4 p-4 bg-green-400 border border-green-400 text-green-900 rounded">
                            {{ session('success') }}
                            <meta http-equiv="refresh" content="3;url={{ route('berichten.index') }}">
                        </div>
                    @elseif(session('error'))
                        <div class="mt-4 p-4 bg-red-300 border border-red-400 text-red-900 rounded">
                            {{ session('error') }}
                            <meta http-equiv="refresh" content="3;url={{ route('berichten.index') }}">
                        </div>
                    @endif

                    <div class="mt-6">
                        <table class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="w-1/6 px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-white text-xs font-medium">
                                        Patient
                                    </th>
                                    <th class="w-1/6 px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-white text-xs font-medium">
                                        Medewerker
                                    </th>
                                    <th class="w-2/6 px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-white text-xs font-medium">
                                        Bericht
                                    </th>
                                    <th class="w-1/6 px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-white  text-xs font-medium">
                                        Verzonden datum
                                    </th>
                                    <th class="w-1/12 px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-white text-xs font-medium">
                                        Wijzigen
                                    </th>
                                    <th class="w-1/12 px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-white text-xs font-medium">
                                        Annuleren
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($berichten as $bericht)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $bericht->PatientNummer }} - {{ $bericht->PatientVoornaam }}
                                            {{ $bericht->PatientTussenvoegsel }}
                                            {{ $bericht->PatientAchternaam }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $bericht->MedewerkerNummer }} - {{ $bericht->MedewerkerVoornaam }}
                                            {{ $bericht->MedewerkerTussenvoegsel }}
                                            {{ $bericht->MedewerkerAchternaam }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 break-words whitespace-normal">
                                            {{ $bericht->Bericht }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            @if ($bericht->VerzondenDatum === null)
                                                <span class="text-yellow-600 font-semibold">Niet verzonden</span>
                                            @else
                                                {{ \Carbon\Carbon::parse($bericht->VerzondenDatum)->format('d-m-Y H:i') }}
                                            @endif
                                        </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('berichten.edit', $bericht->Id) }}"
                                            class="inline-block px-3 py-2 bg-blue-600 text-white rounded text-sm">
                                            Wijzigen
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('berichten.destroy', $bericht->Id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-2 bg-red-600 text-white rounded text-sm">
                                                Annuleren
                                            </button>
                                        </form>
                                    </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">Geen
                                            berichten gevonden.</td>
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