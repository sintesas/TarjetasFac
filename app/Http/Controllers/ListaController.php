<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lista;
use App\Models\ListaDetalle;

class ListaController extends Controller
{
    public function getListas() {
        $datos = Lista::orderBy('nombre_lista_id', 'asc')->get();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function get_listas_padres() {
        $model = new Lista;

        $datos = $model->Get_listas_padres();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function crearLista(Request $request) {
        $m = new Lista;
        $lista = $m->crud_listas($request, 'C');
        if ($lista->nombre_lista_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => $lista->nombre_lista_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }
    
    public function actualizarLista(Request $request) {
        $m = new Lista;
        $lista = $m->crud_listas($request, 'U');
        if ($lista) {
            $response = json_encode(array('mensaje' => 'Ha actualizado exitosamente.', 'tipo' => 0, 'id' => $lista->nombre_lista_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Actualizar el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    public function getListasId(Request $request) {
        $model = new ListaDetalle;

        $datos = $model->get_lista_by_id($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function getListaDetalleFull() {
        $datos = ListaDetalle::orderBy('lista_dinamica_id', 'asc')->get();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function crearListaDetalle(Request $request) {
        $m = new ListaDetalle;
        $lista = $m->crud_listas_detalles($request, 'C');
        if ($lista->lista_dinamica_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => $lista->lista_dinamica_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }
    
    public function actualizarListaDetalle(Request $request) {
        $m = new ListaDetalle;
        $lista = $m->crud_listas_detalles($request, 'U');
        if ($lista) {
            $response = json_encode(array('mensaje' => 'Ha actualizado exitosamente.', 'tipo' => 0, 'id' => $lista->lista_dinamica_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Actualizar el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    public function getListasName(Request $request) {
        $model = new ListaDetalle;

        $datos = $model->get_lista_by_name($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function getListaByIdyValor(Request $request){
        $model = new ListaDetalle;

        $datos = $model->GetLista($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
}