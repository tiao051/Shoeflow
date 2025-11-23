<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FitsController extends Controller
{
    /**
     * Display the "Fits with Converse" lookbook page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {      
     return view('fits.index');
    }
}