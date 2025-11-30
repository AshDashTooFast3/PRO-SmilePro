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
                        <p>
                            Aantal afspraken:
                            <span style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #4F46E5; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                {{ $aantalAfspraken }}
                            </span>
                        </p>
                    </strong>
                    <br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>