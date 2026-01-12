<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">
                        Nieuwe factuur aanmaken
                    </h3>

                    <form action="{{ route('factuur.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="patient_id" value="{{ $patient_id }}">
                        
                        {{-- Behandeling --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">
                                Behandeling
                            </label>

                            <select name="behandeling_id"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white"
                                required>
                                @foreach($behandelingen as $behandeling)
                                    <option value="{{ $behandeling->Id }}">
                                        {{ $behandeling->Behandelingtype }} - €{{ number_format($prijzen[$behandeling->Behandelingtype], 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="behandeling" id="behandelingInput" value="{{ $behandelingen->first()->Behandelingtype }}">

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const select = document.querySelector('select[name="behandeling_id"]');
                                const input = document.getElementById('behandelingInput');
                                select.addEventListener('change', function () {
                                    const selectedOption = select.options[select.selectedIndex];
                                    // Get the behandeling type from the option text before the dash
                                    const behandelingType = selectedOption.text.split(' - ')[0].trim();
                                    input.value = behandelingType;
                                });
                            });
                        </script>

                        {{-- Omschrijving --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">
                                Omschrijving
                            </label>
                            <input type="text"
                                   name="omschrijving"
                                   class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white"
                                   required>
                        </div>

                        {{-- Datum --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">
                                Datum
                            </label>
                            <input type="date"
                                   name="datum"
                                   class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white"
                                   required>
                        </div>

                        {{-- Tijd --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">
                                Tijd
                            </label>
                            <input type="text"
                                   name="tijd"
                                   placeholder="HH:MM"
                                   pattern="^([01]?[0-9]|2[0-3]):[0-5][0-9]$"
                                   class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white"
                                   required>
                        </div>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">
                            Factuur opslaan
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
