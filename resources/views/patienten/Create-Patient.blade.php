<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100">{{ $title }}</span>
                    <a href="/overzicht-patienten"
                        class="float-right inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        terug
                    </a>
                    <div class="mt-10 mb-10">
                        <input type="text" id="searchInput" placeholder="Zoeken op gebruikersnaam of email..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    <script>
                        document.getElementById('searchInput').addEventListener('keyup', function() {
                            const searchTerm = this.value.toLowerCase();
                            const rows = document.querySelectorAll('tbody tr');

                            rows.forEach(row => {

                                const username = row.cells[0].textContent.toLowerCase();
                                const email = row.cells[1].textContent.toLowerCase();

                                if (username.includes(searchTerm) || email.includes(searchTerm)) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        });
                    </script>

                    <div class="mt-6">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Rolnaam</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Medischdossier</th>
                                    <th
                                        class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Patient maken</th>


                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($gebruikers as $gebruiker)
                                    <tr>
                                        <form action="{{ route('patienten.toevoegen-update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="gebruiker_id" value="{{ $gebruiker->Id }}">

                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $gebruiker->RolNaam }}
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $gebruiker->Email }}
                                            </td>

                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                <input type="text" name="medischdossier"
                                                    class="border border-gray-300 dark:border-gray-600 rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100" />
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    Patient maken
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Geen gebruikers gevonden
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
