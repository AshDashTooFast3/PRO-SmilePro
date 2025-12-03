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
        Log::info('Aantal afspraken opgehaald', ['Aantal afspraken:' => $aantalAfspraken]);
        
        return view("praktijkmanagement.index", [
            "title"=> "Praktijkmanagement Dashboard",
            "aantalAfspraken" => $aantalAfspraken
        ]);
    }
    
    public function berichten() {
        $berichten = $this->communicatie->getAllCommunicatie();
        Log::info('Berichten opgehaald', ['Aantal berichten:' => count($berichten)]);
        
        return view("praktijkmanagement.berichten", [
            "title"=> "Berichten Overzicht",
            "berichten" => $berichten
        ]);
    }
}
