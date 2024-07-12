<?php

namespace App\Http\Controllers;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PersonaController extends Controller
{
    public function getPersonas() {
        $datos = DB::select("select p.persona_id,
        p.numero_identificacion,
        p.grado,
        p.nombres,
        p.apellidos,
        p.imagen,
        p.unidad,
        (select u.nombre_unidad from tb_unidades u where u.unidad_id = p.unidad) nombre_unidad,
        p.dependencia,
        (select u.nombre_unidad from tb_unidades u where u.unidad_id = p.dependencia) nombre_dependencia,
        p.cargo,
        p.usuario_creador,
        p.fecha_creacion,
        p.usuario_modificador,
        p.fecha_modificacion,
        p.tipo_persona 
    from tb_personas p;");

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function CrearPersonas(Request $request) {
        $m = new Persona();
        $persona = $m->crud_personas($request, 'C');
        if ($persona->persona_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => (int)$persona->persona_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    
    public function actualizarPersona(Request $request) {
        $m = new Persona();
        $persona = $m->crud_personas($request, 'U');
        if ($persona) {
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

    public function getUnidadesPadre() {
        $datos = DB::select("select * from tb_unidades u where u.activo = 1 and u.unidad_padre_id is null");

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    
    public function GetunidadesHijas(Request $request) {
        $model = new Persona();

        $datos = $model->GetUnidadesHijas($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function getUnidades() {
        $datos = DB::select("SELECT unidad_id
                            ,unidad_padre
                            ,nombre_unidad
                            ,unidad_padre_id
                            ,activo
                            ,usuario_creador
                            ,fecha_creacion
                            ,usuario_modificador
                            ,fecha_modificacion
                            ,dependencia
                            ,Unidad
                            , CASE 
                                WHEN CHARINDEX('/', Unidad) > 0 THEN SUBSTRING(Unidad, 1, CHARINDEX('/', Unidad) - 1)
                                ELSE Unidad
                            END AS unidad,
                            CASE 
                                WHEN CHARINDEX('/', Unidad) > 0 THEN SUBSTRING(Unidad, CHARINDEX('/', Unidad) + 1, LEN(Unidad))
                                ELSE NULL
                            END AS dependencia
                            FROM Tarjetas_fac.dbo.vw_unidades WHERE consultar = 1
                            ORDER BY 1, 2;");

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
}
