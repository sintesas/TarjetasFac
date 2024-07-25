<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unidades;
use Illuminate\Http\Request;

class UnidadesController extends Controller
{
    public function getUnidades() {
        $model = new Unidades();
        $datos = $model->GetUnidades();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function get_unidad_by_id(Request $request) {
        $model = new Unidades();

        $datos = $model->get_unidad_by_id($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function CrearUnidades(Request $request) {
        $m = new Unidades();
        $unidad = $m->crud_unidades($request, 'C');
        if ($unidad->unidad_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => $unidad->unidad_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    
    public function actualizarUnidad(Request $request) {
        $m = new Unidades();
        $unidad = $m->crud_unidades($request, 'U');
        if ($unidad) {
            $response = json_encode(array('mensaje' => 'Ha actualizado exitosamente.', 'tipo' => 0), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Actualizar el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    public function GetUnidad(Request $request) {
        $model = new Unidades();

        $datos = $model->GetUnidad($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function GetDependencia(Request $request) {
        $model = new Unidades();

        $datos = $model->GetDependencia($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
}