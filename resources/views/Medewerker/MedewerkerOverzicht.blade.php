@extends('layouts.medewerker')

@section('content')
<div class="container">

    <h1 class="mb-4 text-center">Medewerker Overzicht</h1>

    @if($medewerkers->isEmpty())
        <p class="text-center">Geen medewerkers gevonden.</p>
    @else
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Medewerkernummer</th>
                    <th>Naam</th>
                    <th>Type</th>
                    <th>Specialisatie</th>
                    <th>Beschikbaarheid</th>
                    <th>Actief</th>
                    <th>Opmerking</th>
                </tr>
            </thead>

            <tbody>
                @foreach($medewerkers as $m)
                <tr>
                    <td>{{ $m->Nummer }}</td>

                    <td>
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

                    <td>{{ $m->Medewerkertype }}</td>

                    <td>{{ $m->Specialisatie ?? '-' }}</td>

                    <td>{{ $m->Beschikbaarheid ?? '-' }}</td>

                    <td>{{ $m->Isactief ? 'Ja' : 'Nee' }}</td>

                    <td>{{ $m->Opmerking ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
