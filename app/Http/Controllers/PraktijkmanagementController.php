<?php

namespace App\Http\Controllers;
use App\Models\Praktijkmanagement;
use Illuminate\Http\Request;
use App\Models\Bericht;

class PraktijkmanagementController extends Controller
{
    private $bericht;

    public function __construct() {
        $this->bericht = new Bericht();
    }

    public function index() {
        return view("praktijkmanagement.index", [
            "title"=> "Praktijkmanagement Dashboard",
        ]);
    }
    
    public function berichten() {
        
        return view("praktijkmanagement.berichten", [
            "title"=> "Berichten Overzicht",
        ]);
    }
}
