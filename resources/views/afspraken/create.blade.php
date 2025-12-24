<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div style="max-width: 700px; margin: 0 auto; font-family: Arial, sans-serif; color: #fff; background-color: #0f172a; min-height: 100vh; padding-bottom: 40px;">

        <form action="{{ route('afspraak.store') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; margin: 25px; border-radius: 6px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="datum" style="display: block; margin-bottom: 5px;">Datum:</label>
                <input type="date" id="datum" name="datum" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="tijd" style="display: block; margin-bottom: 5px;">Tijd:</label>
                <input type="time" id="tijd" name="tijd" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="behandeling" style="display: block; margin-bottom: 5px;">Behandeling:</label>
                <select id="behandeling" name="behandeling" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    @foreach($behandelingen as $behandeling)
                        <option value="{{ $behandeling->id }}">{{ $behandeling->naam }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" style="background-color: #2563eb; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Maak Afspraak</button>
        </form>

    </div>
</x-app-layout>