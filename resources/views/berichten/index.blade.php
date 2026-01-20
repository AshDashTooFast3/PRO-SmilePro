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
                            <meta http-equiv="refresh" content="8;url={{ route('berichten.index') }}">
                        </div>
                    @endif

                    <div class="mt-5 overflow-x-auto rounded-lg border border-gray-700">
                        <table class="min-w-full table-fixed border-collapse">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-48">Patient</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-56">Medewerker
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white">Bericht</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-44">Verzonden
                                        datum</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-32">Status</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-white w-32">Acties</th>
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

                                        <td class="px-4 py-3 text-sm text-gray-100">
                                            @if ($bericht->VerzondenDatum === null)
                                                <span class="text-yellow-400 font-semibold">Niet verzonden</span>
                                            @else
                                                {{ \Carbon\Carbon::parse($bericht->VerzondenDatum)->format('d-m-Y H:i') }}
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-100">
                                            {{ $bericht->Status }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('berichten.sturen', $bericht->Id) }}"
                                                    class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-xs">
                                                    Sturen
                                                </a>

                                                <a href="{{ route('berichten.edit', $bericht->Id) }}"
                                                    class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">
                                                    Wijzigen
                                                </a>

                                                <form method="POST" action="{{ route('berichten.destroy', $bericht->Id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-xs"
                                                        onclick="return confirm('Weet je zeker dat je dit bericht wilt annuleren?')">
                                                        Annuleren
                                                    </button>
                                                </form>
                                            </div>
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