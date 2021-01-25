<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Http;

class HomeController extends Controller
{
    public function index()
    {
        $rpt = Http::get('https://mindicador.cl/api');

        if (!$rpt->serverError()) {
            SendEmail::dispatch();
            echo 'a la cola';
            return false;
        }

        $dolar = $rpt->json();
        return view('test', compact('dolar'));
    }
}
