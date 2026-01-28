<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Afspraken
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto min-h-screen py-10 px-4 bg-slate-900 text-white">

        @if(session('success'))
            <div class="mb-6 bg-green-600 text-white p-3 rounded">
                {{ session('success') }}
                <meta http-equiv="refresh" content="3">
            </div>
        @elseif(session('error'))
            <div class="mb-6 bg-red-600 text-white p-3 rounded">
                {{ session('error') }}
                <meta http-equiv="refresh" content="3">
            </div>
        @endif

        {{-- Alleen patiënten mogen afspraken maken --}}
        @if (Auth::user()->RolNaam === 'Patient')
            <div class="mb-6 text-right">
                <a href="{{ route('afspraken.create') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                    Afspraak maken
                </a>
            </div>
        @endif

        @forelse($afspraken as $afspraak)
            <div class="border border-gray-700 rounded-lg p-5 mb-6 bg-slate-800">

                <h3 class="text-lg font-semibold mb-2">Afspraak #{{ $afspraak->Id }}</h3>

                <p><span class="font-semibold">Datum:</span> {{ $afspraak->Datum }}</p>
                <p><span class="font-semibold">Tijd:</span> {{ $afspraak->Tijd }}</p>
                <p><span class="font-semibold">Status:</span> {{ $afspraak->Status }}</p>

                @if(Auth::user()->RolNaam !== 'Patient')
                    <p><span class="font-semibold">Patiënt ID:</span> {{ $afspraak->PatientId }}</p>
                    <p><span class="font-semibold">Medewerker ID:</span> {{ $afspraak->MedewerkerId }}</p>
                @endif

                <p><span class="font-semibold">Opmerking:</span> {{ $afspraak->Opmerking ?? '-' }}</p>

                <div class="mt-4 flex gap-3">

                    {{-- Bewerken --}}
                    <a href="{{ route('afspraken.edit', $afspraak) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded">
                        Bewerken
                    </a>

                    {{-- Verwijderen --}}
                    <form action="{{ route('afspraken.destroy', $afspraak) }}" method="POST"
                          onsubmit="return confirm('Weet je zeker dat je deze afspraak wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded">
                            Verwijderen
                        </button>
                    </form>

                    {{-- Status wijzigen (alleen medewerkers) --}}
                    @if(in_array(Auth::user()->RolNaam, ['Tandarts', 'Assistent', 'Mondhygiënist', 'Praktijkmanagement']))
                        <form action="{{ route('afspraken.updateStatus', $afspraak) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="Status"
                                    class="bg-slate-700 border border-gray-600 rounded p-1 text-white"
                                    onchange="this.form.submit()">
                                <option value="Bevestigd" {{ $afspraak->Status === 'Bevestigd' ? 'selected' : '' }}>
                                    Bevestigd
                                </option>
                                <option value="Geannuleerd" {{ $afspraak->Status === 'Geannuleerd' ? 'selected' : '' }}>
                                    Geannuleerd
                                </option>
                            </select>
                        </form>
                    @endif

                </div>

            </div>
        @empty
            <div class="text-center py-10 bg-slate-800 rounded-lg border border-gray-700">
                <p class="text-gray-300">Geen afspraken gevonden.</p>
            </div>
        @endforelse

    </div>
</x-app-layout>