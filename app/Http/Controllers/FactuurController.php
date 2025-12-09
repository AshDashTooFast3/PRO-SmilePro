<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factuur;

class FactuurController extends Controller
{
    private $factuur;

    public function __construct() {
        $this->factuur = new Factuur();
    }
    
}
