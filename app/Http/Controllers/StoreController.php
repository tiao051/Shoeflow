<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = [
            [
                'id' => 1,
                'name' => 'Converse Saigon Centre',
                'address' => '65 Le Loi, Ben Nghe, District 1, HCMC',
                'phone' => '028 3821 7575',
                'lat' => 10.774436, 
                'lng' => 106.702082
            ],
            [
                'id' => 2,
                'name' => 'Converse Van Hanh Mall',
                'address' => '11 Su Van Hanh, District 10, HCMC',
                'phone' => '028 3862 5555',
                'lat' => 10.776663, 
                'lng' => 106.669865
            ],
            [
                'id' => 3,
                'name' => 'Converse Vincom Ba Trieu',
                'address' => '191 Ba Trieu, Hai Ba Trung, Ha Noi',
                'phone' => '024 3974 8888',
                'lat' => 21.012224, 
                'lng' => 105.849184
            ],
        ];

        return view('stores.index', compact('stores'));
    }
}