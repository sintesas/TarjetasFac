<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Home;

class HomeController extends Controller
{
    public function getBanner() {
        $m = new Home;
        $datos = $m->getBanners();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
}
