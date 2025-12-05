<?php

namespace App\Http\Controllers;
use App\Models\Communicatie;
use Illuminate\Http\Request;
use \App\Models\Afspraken;
use Illuminate\Support\Facades\Log;

class PraktijkmanagementController extends Controller
{
    private $communicatie;

    public function __construct() {
        $this->communicatie = new Communicatie();
    }

    public function index() {

        $aantalAfspraken = Afspraken::getAfsprakenCount();

        if($aantalAfspraken > 0) {
            Log::info('Aantal afspraken opgehaald: ' . $aantalAfspraken);
        } else {
            Log::info('Geen afspraken gevonden');
        }

        return view("praktijkmanagement.index", [
            "title"=> "Praktijkmanagement Dashboard",
            "aantalAfspraken" => $aantalAfspraken
        ]);
    }
    
    public function berichten() {

        $berichten = $this->communicatie->getAllCommunicatie();

        if ($berichten > 0) {
            Log::info('Berichten opgehaald', ['Aantal berichten:' => count($berichten)]);
        } else {
            Log::info('Geen berichten opgehaald');
        }
        
        return view("praktijkmanagement.berichten", [
            "title"=> "Berichten Overzicht",
            "berichten" => $berichten
        ]);
    }
}
