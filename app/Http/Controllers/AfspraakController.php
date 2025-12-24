<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Afspraken; // Zorg dat dit je juiste model is

class AfspraakController extends Controller
{
    public function index()
    {
        // Haal alle afspraken op (pas aan naar wat je nodig hebt)
        $afspraken = Afspraken::all();

        return view('afspraken.index', [
            'title' => 'Mijn afspraken',
            'afspraken' => $afspraken,
        ]);
    }
}