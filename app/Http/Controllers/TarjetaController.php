<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Tarjetas;
use Illuminate\Support\Facades\Log;

class TarjetaController extends Controller
{
    private function getImagenURL($identificacion) {
        $datos = \DB::table('tbl_vw_siath_full')->where('identificacion', $identificacion)->first();
        $path = "http://localhost:3000/fotos/";

        $url = 'img/foto.png';

        if ($datos == null) {
            $url = 'img/foto.png';
        }
        else {
            $image_url = $path . $datos->nombrefoto;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $image_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);

            if (curl_errno($ch)) {
                curl_close($ch);

                $url = 'img/foto.png';
            }

            curl_close($ch);

            $url = $image_url;
        }

        return $url;
    }
    public function index($id) {
        $model = new Tarjetas();

        $dat = $model->getTarjetaData($id);
        $datos = $dat[0];
        if($datos->imagen != null) {
            $url = 'img/perfil/' . $datos->imagen;
        }
        else{
            $url = $this->getImagenURL($datos->numero_identificacion);
        }
        $clasificacion = $datos->clasificacion;
        $fondo="";
        if($clasificacion == 'naranja'){
            $fondo = "img/img_restringido.png";
        }
        else{
            if($clasificacion == 'amarillo'){
                $fondo = "img/img_secreto.png";
            }
            else{
                if($clasificacion == 'verde'){
                    $fondo = "img/img_ultrasecreto.png";
                }
                else{
                    if($clasificacion == 'rojo'){
                        $fondo = "img/img_confidencial.png";
                    }
                }
            }
        }
        $data = [
            'num_autorizacion' => $datos->tarjeta_id,
            'fecha_autorizacion' => $datos->fecha_inicio,
            'grado' => $datos->grado,
            'apellido_nombre' => $datos->apellido_nombre,
            'num_documento' => $datos->numero_identificacion,
            'cargo' => $datos->cargo,
            'dependencia' => $datos->dependencia == null ?  $datos->unidad: $datos->dependencia,
            'grado_sigla' => $datos->nombre_firma,
            'sigla_completo' => $datos->cargo_firma,
            'fecha_vigencia' => $datos->fecha_fin,
            'perfil' => $url,
            'fondo' => $fondo
        ];

        $pdf = Pdf::loadView('tarjeta', $data);

        return $pdf->stream();
    }

    public function Download($id) {
        $model = new Tarjetas();

        $dat = $model->getTarjetaData($id);
        $datos = $dat[0];
        if($datos->imagen != null) {
            $url = 'img/perfil/' . $datos->imagen;
        }
        else{
            $url = $this->getImagenURL($datos->numero_identificacion);
        }
        $clasificacion = $datos->clasificacion;
        $fondo="";
        if($clasificacion == 'naranja'){
            $fondo = "img/img_restringido.png";
        }
        else{
            if($clasificacion == 'amarillo'){
                $fondo = "img/img_secreto.png";
            }
            else{
                if($clasificacion == 'verde'){
                    $fondo = "img/img_ultrasecreto.png";
                }
                else{
                    if($clasificacion == 'rojo'){
                        $fondo = "img/img_confidencial.png";
                    }
                }
            }
        }
        $CC = $datos->numero_identificacion;
        $data = [
            'num_autorizacion' => $datos->tarjeta_id,
            'fecha_autorizacion' => $datos->fecha_inicio,
            'grado' => $datos->grado,
            'apellido_nombre' => $datos->apellido_nombre,
            'num_documento' => $datos->numero_identificacion,
            'cargo' => $datos->cargo,
            'dependencia' => $datos->dependencia == null ?  $datos->unidad: $datos->dependencia,
            'grado_sigla' => $datos->nombre_firma,
            'sigla_completo' => $datos->cargo_firma,
            'fecha_vigencia' => $datos->fecha_fin,
            'perfil' => $url,
            'fondo' => $fondo
        ];

        $pdf = Pdf::loadView('tarjeta', $data);

        return $pdf->download($CC . '.pdf');
    }
}
