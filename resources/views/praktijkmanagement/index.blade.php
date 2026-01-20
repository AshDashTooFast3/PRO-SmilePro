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
                </div>

                <div class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-gray-100 text-2xl">
                    <strong>
                        <p class="text-white p-4">
                            Aantal afspraken gemaakt:
                            @if (!empty($aantalAfspraken) && $aantalAfspraken > 0)
                            <span style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #4F46E5; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                {{ $aantalAfspraken }}
                            </span>
                            @else
                                <span style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #ffa600ff; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    0
                                </span>
                                <span style="margin-left: 10px; color: #ffa600ff;">
                                    er zijn nog geen afspraken gemaakt
                                </span>
                            @endif
                        </p>
                    </strong>
                    <br>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-gray-100 text-2xl">
                    <strong>
                        <p class="text-white p-4">
                            Omzet tot nu toe:
                            @if (!empty($omzet) && $omzet[0]->TotaleOmzet > 0)
                                €{{ $omzet[0]->TotaleOmzet }}
                            @else
                                <span
                                    style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #ffa600ff; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    0
                                </span>
                                <span style="margin-left: 10px; color: #ffa600ff;">
                                    er is nog geen omzet gegenereerd
                                </span>
                            @endif
                        </p>
                    </strong>
                    <br>
                </div>
            <div class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <strong>
                    <p class="text-white p-4 text-2xl">
                        Meest voorkomende behandelingen:
                    </p>
                </strong>
                @if (!empty($meestVoorkomendeBehhandelingen) && count($meestVoorkomendeBehhandelingen) > 0)
                    <div class="p-4">
                        <table class="w-full text-gray-100">
                            <thead class="border-b border-gray-700">
                                <tr>
                                    <th class="text-left py-2">Behandeling</th>
                                    <th class="text-right py-2">Aantal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($meestVoorkomendeBehhandelingen as $behandeling)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700">
                                        <td class="py-3 px-2">{{ $behandeling->naam }}</td>
                                        <td class="text-right py-3 px-2">
                                            <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm">
                                                {{ $behandeling->aantal }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4">
                        <span style="color: #ffa600ff;">
                            Er zijn nog geen behandelingen uitgevoerd
                        </span>
                    </div>
                @endif
                <br>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>