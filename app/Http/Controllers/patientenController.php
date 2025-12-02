<?php

namespace App\Http\Controllers;
use App\Models\PatientModel;

use Illuminate\Http\Request;

class patientenController extends Controller
{
    public function index()
    {
        $patienten = PatientModel::all();

        return view(['patienten.overzicht-patienten', ]);
    }
}
