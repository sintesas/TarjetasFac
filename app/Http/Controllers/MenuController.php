<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;

class MenuController extends Controller
{
    // obtiene el menu
    public function getMenu() {
        $m = new Menu;
        $datos = $m->getMenu();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
}
