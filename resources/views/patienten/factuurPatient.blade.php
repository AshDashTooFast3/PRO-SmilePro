<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div style="max-width: 700px; margin: 0 auto; font-family: Arial, sans-serif; color: #fff; background-color: #0f172a; min-height: 100vh; padding-bottom: 40px;">

        @forelse($facturen as $factuur)
            <div style="border: 1px solid #ccc; padding: 20px; margin: 25px; border-radius: 6px;">

                <!-- Header -->
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0; font-size: 20px;">Factuur #{{ $factuur->Nummer }}</h3>
                        <p style="margin: 3px 0;">Datum: {{ $factuur->Datum }}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="margin: 0; font-weight: bold;">
                            € {{ number_format($factuur->Bedrag, 2, ',', '.') }}
                        </p>
                        <p style="margin: 3px 0;">Status: {{ $factuur->Status }}</p>
                    </div>
                </div>

                <hr style="margin: 15px 0; border-color: #fff;">

                <!-- Patient -->
                <div style="margin-bottom: 10px;">
                    <strong>Patiënt:</strong>
                    <span>{{ $factuur->PatientNaam }}</span>
                </div>

                <!-- Behandeling -->
                <div style="margin-bottom: 10px;">
                    <strong>Behandeling:</strong>
                    <span>{{ $factuur->BehandelingNaam }}</span>
                </div>

                <!-- Betaling -->
                <div style="margin-top: 20px; padding: 10px; background-color: #1e293b; border-radius: 4px;">
                    <strong>Let op:</strong> Gelieve het bedrag over te maken naar IBAN <span style="font-weight: bold;">NL91BANK0123456789</span>.
                </div>

            </div>

            @empty
                <div style="margin: 50px; border: 1px solid #ccc; padding: 20px; border-radius: 6px; text-align: center; background-color: #1e293b;">
                    <p style="margin: 0; color: #fff;">Geen facturen gevonden.</p>
                </div>
        @endforelse

    </div>
</x-app-layout>
