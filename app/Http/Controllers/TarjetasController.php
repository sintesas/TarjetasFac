<?php

namespace App\Http\Controllers;
use App\Models\Tarjetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarjetasController extends Controller
{
    public function GetTarjetas() {
        $model = new Tarjetas();

        $datos = $model->GetTarjetas();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function GetPesonasData(Request $request) {
        $model = new Tarjetas();

        $datos = $model->GetPesonasData($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
    
    public function CrearTarjetas(Request $request) {
        $m = new Tarjetas();
        $tarjeta = $m->crud_tarjetas($request, 'C');
        if ($tarjeta->tarjeta_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => (int)$tarjeta->tarjeta_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    public function actualizarTarjeta(Request $request) {
        $m = new Tarjetas();
        $tarjeta = $m->crud_tarjetas($request, 'U');
        if ($tarjeta) {
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

    public function GetTarjetasByPersonaID(Request $request) {
        $model = new Tarjetas();

        $datos = $model->GetTarjetasByPersonaID($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function buscarImagen(Request $request) {
        // $datos = DB::table('tbl_vw_siath_full')->where('identificacion', $request->get('identificacion'))->first();
        // $path = env('FOTOS_DIR');

        // if ($datos == null) {
        //     $filename = public_path() . '\\img\\avatar.jpg';
        //     $file = \File::get($filename);
        //     $mime = \File::mimeType($filename);
            
        //     $response = \Response::make($file, 200);
        //     $response->header("Content-Type", $mime);
            
        //     return $response;
        // }
        // else {
        //     $filename = $path . $datos->nombrefoto;
        //     if (!\File::exists($filename)) {
        //         $filename = public_path() . '\\img\\avatar.jpg';
        //         $file = \File::get($filename);
        //         $mime = \File::mimeType($filename);
                
        //         $response = \Response::make($file, 200);
        //         $response->header("Content-Type", $mime);

        //         return $response;
        //     }
        //     else {
        //         $file = \File::get($filename);
        //         $mime = \File::mimeType($filename);
                
        //         $response = \Response::make($file, 200);
        //         $response->header("Content-Type", $mime);

        //         return $response;
        //     }
        // }
        $datos = DB::table('tbl_vw_siath_full')->where('identificacion', $request->get('identificacion'))->first();
        $path = "http://localhost:3000/fotos/";

        if ($datos == null) {
            $filename = public_path() . '\\img\\noimage.jpg';
            $file = \File::get($filename);
            $mime = \File::mimeType($filename);
            
            $response = \Response::make($file, 200);
            $response->header("Content-Type", $mime);
            
            return $response;
        }
        else {
            $image_url = $path . $datos->nombrefoto;
            $ch = curl_init();
            
            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $image_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            
            // Execute cURL session
            $image_data = curl_exec($ch);
            
            // Check for errors
            if (curl_errno($ch)) {
                curl_close($ch);
                // return response()->json(['error' => 'Failed to fetch image: ' . curl_error($ch)], 500);
                $filename = public_path() . '\\img\\noimage.jpg';
                $file = \File::get($filename);
                $mime = \File::mimeType($filename);
            
                $response = \Response::make($file, 200);
                $response->header("Content-Type", $mime);
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == 404) {
                curl_close($ch);
                $filename = public_path() . '\\img\\noimage.jpg';
                $file = \File::get($filename);
                $mime = \File::mimeType($filename);
            
                $response = \Response::make($file, 200);
                $response->header("Content-Type", $mime);

                return $response;
            }
            
            // Get content type of the image
            $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            
            // Close cURL session
            curl_close($ch);

            return \Response::make($image_data, 200, ['Content-Type' => $content_type,]);
        }
    }
}
