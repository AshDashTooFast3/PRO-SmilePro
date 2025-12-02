<?php

namespace App\Http\Controllers;
use App\Models\Communicatie;
use Illuminate\Http\Request;
use App\Models\Bericht;

class PraktijkmanagementController extends Controller
{
    private $communicatie;

    public function __construct() {
        $this->communicatie = new Communicatie();
    }

    public function index() {
        $aantalAfspraken = \App\Models\Afspraken::query()->getModel()->getAfsprakenCount();
        
        return view("praktijkmanagement.index", [
            "title"=> "Praktijkmanagement Dashboard",
            "aantalAfspraken" => $aantalAfspraken
        ]);
    }
    
    public function berichten() {

        return view("praktijkmanagement.berichten", [
            "title"=> "Berichten Overzicht",
            "berichten" => ""
        ]);
    }
}
