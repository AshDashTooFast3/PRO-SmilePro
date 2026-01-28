<?php

namespace App\Http\Controllers;

use App\Models\Afspraak;
use App\Models\Communicatie;
use App\Models\Factuur;
use App\Models\Behandeling;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;

class PraktijkmanagementController extends Controller
{
    private $communicatie;
    private $factuur;
    private $behandeling;

    public function __construct()
    {
        $this->communicatie = new Communicatie;
        $this->factuur = new Factuur;
        $this->behandeling = new Behandeling;
    }

    public function index()
    {

        // haalt het aantal afspraken op
        $aantalAfspraken = Afspraak::getAfsprakenCount();
    

        // haalt het geld bedrag op van de facuturen
        $omzet = $this->factuur->BerekenOmzet();

        // haalt het aantal voorkomende behandelingen op
        $voorkomendeBehandelingen = $this->behandeling->VoorkomendeBehandelingen();

        // log voor het aantal afspraken
        if ($aantalAfspraken > 0) {
            Log::info('Aantal afspraken opgehaald: '.$aantalAfspraken);
        } else {
            Log::info('Geen afspraken gevonden');
        }

        // log voor het bedrag van de omzet
        if ($omzet > 0) {
            Log::info('Omzet opgehaald', ['Totaal omzet bedrag opgehaald:', $omzet]);
        } else {
            Log::info('er is nog geen omzet gemaakt');
        }

        if (count($voorkomendeBehandelingen) > 0) {
            Log::info('Voorkomende behandelingen opgehaald', ['Aantal voorkomende behandelingen:', count($voorkomendeBehandelingen)]);
        } else {
            Log::info('Geen voorkomende behandelingen gevonden');
        }

        return view('praktijkmanagement.index', [
            'title' => 'Praktijkmanagement Dashboard',
            'aantalAfspraken' => $aantalAfspraken,
            'omzet' => $omzet,
            'voorkomendeBehandelingen' => $voorkomendeBehandelingen,
        ]);
    }
}
