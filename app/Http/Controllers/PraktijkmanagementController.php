<?php

namespace App\Http\Controllers;
use App\Models\Communicatie;
use Illuminate\Http\Request;
use \App\Models\Afspraken;
use Illuminate\Support\Facades\Log;
use App\Models\Factuur;

class PraktijkmanagementController extends Controller
{
    private $communicatie;
    private $factuur;


    public function __construct() {
        $this->communicatie = new Communicatie();
        $this->factuur = new Factuur();
    }

    public function index() {

        // haalt het aantal afspraken op
        $aantalAfspraken = Afspraken::getAfsprakenCount();

        // haalt het geld bedrag op van de facuturen
        $omzet = $this->factuur->BerekenOmzet();


        //log voor het aantal afspraken
        if($aantalAfspraken > 0) {
            Log::info('Aantal afspraken opgehaald: ' . $aantalAfspraken);
        } else {
            Log::info('Geen afspraken gevonden');
        }

        //log voor het bedrag van de omzet
          if ($omzet > 0) {
            Log::info('Omzet opgehaald', ['Berekende omzet:' => count($omzet) . '€']);
        } else {
            Log::info('er is nog geen omzet gemaakt');
        }

        return view("praktijkmanagement.index", [
            "title"=> "Praktijkmanagement Dashboard",
            "aantalAfspraken" => $aantalAfspraken,
            "omzet" => $omzet
        ]);
    }
    
    public function praktijkmanagement() {

        //haalt alle berichten op
        $berichten = $this->communicatie->getAllCommunicatie();

        //log voor het aantal berichten
        if ($berichten > 0) {
            Log::info('Berichten opgehaald', ['Aantal berichten:' => count($berichten)]);
        } else {
            Log::info('Geen berichten opgehaald');
        }
        
        return view("praktijkmanagement.berichten", [
            "title"=> "Berichten Overzicht",
            "berichten" => $berichten,
        ]);
    }

}
