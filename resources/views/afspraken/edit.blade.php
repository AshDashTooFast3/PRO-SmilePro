<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Afspraak bewerken
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10 px-4 bg-slate-900 text-white">

        @if($errors->any())
            <div class="mb-6 bg-red-600 text-white p-3 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('afspraken.update', $afspraak) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Datum</label>
                <input type="date" name="Datum" value="{{ old('Datum', $afspraak->Datum) }}"
                       class="w-full bg-slate-800 border border-gray-600 rounded p-2 text-white">
            </div>

            <div>
                <label class="block font-medium mb-1">Tijd</label>
                <input type="time" name="Tijd" value="{{ old('Tijd', $afspraak->Tijd) }}"
                       class="w-full bg-slate-800 border border-gray-600 rounded p-2 text-white">
            </div>

            <div>
                <label class="block font-medium mb-1">Opmerking</label>
                <textarea name="Opmerking" rows="3"
                          class="w-full bg-slate-800 border border-gray-600 rounded p-2 text-white">{{ old('Opmerking', $afspraak->Opmerking) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('afspraken.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded">
                    Annuleren
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Bijwerken
                </button>
            </div>
        </form>

    </div>
</x-app-layout>