<?php

namespace App\Http\Controllers;
use App\Models\Patient;

class patientenController extends Controller
{
    public function index()
    {
        $patienten = Patient::getVolledigeNaamPatienten();
        
        return view('patienten.overzicht-patienten', 
        [
        'patienten' => $patienten,
        'title' => 'Patienten Overzicht'  
    ]);
    }
}
