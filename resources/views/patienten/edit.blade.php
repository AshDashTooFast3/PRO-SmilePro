<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100">{{ $title }}</span>
                    <a href="/overzicht-patienten"
                        class="float-right inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Terug
                    </a>

                    <form action="{{ route('patient.update') }}" method="POST" class="mt-10">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $patient->Id }}">

                        

                        <div class="mb-4">
                            <label for="Nummer" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nummer</label>
                            <input type="text" name="Nummer" id="Nummer" value="{{ old('naam', $patient->Nummer) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100">
                            @error('naam')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="MedischDossier" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Medisch Dossier</label>
                            <input type="text" name="MedischDossier" id="MedischDossier" value="{{ old('email', $patient->MedischDossier) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100">
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="Opmerking" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Opmerking</label>
                            <input type="text" name="Opmerking" id="Opmerking" value="{{ old('medischdossier', $patient->Opmerking) }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100">
                            @error('medischdossier')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
