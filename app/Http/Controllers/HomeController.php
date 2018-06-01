<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        //Nėra ka pridurti, sukam ciklą ir traukiam visus klausimus iš DB
        return view('home', [
            'tests' => Test::all(),
        ]);
    }
}
