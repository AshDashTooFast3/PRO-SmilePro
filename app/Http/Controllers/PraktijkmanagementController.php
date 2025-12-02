<?php

namespace App\Http\Controllers;
use App\Models\Communicatie;
use Illuminate\Http\Request;
use \App\Models\Afspraken;

class PraktijkmanagementController extends Controller
{
    private $communicatie;

    public function __construct() {
        $this->communicatie = new Communicatie();
    }

    public function index() {
        $aantalAfspraken = Afspraken::getAfsprakenCount();
        
        return view("praktijkmanagement.index", [
            "title"=> "Praktijkmanagement Dashboard",
            "aantalAfspraken" => $aantalAfspraken
        ]);
    }
    
    public function berichten() {

        $berichten = $this->communicatie->getAllCommunicatie();

        return view("praktijkmanagement.berichten", [
            "title"=> "Berichten Overzicht",
            "berichten" => $berichten
        ]);
    }
}
