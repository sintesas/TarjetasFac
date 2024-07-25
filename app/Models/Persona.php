<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Persona extends Model
{
    protected $table = 'tb_personas';
    protected $primaryKey = 'persona_id';
    public $timestamps = false;

    public function crud_personas(Request $request, $evento) {
        if ($evento == 'C') {
            $persona = new Persona;
            $persona->numero_identificacion = $request->get('numero_identificacion');
            $persona->grado = $request->get('grado')== 0 ? null : $request->get('grado');
            $persona->nombres = $request->get('nombres');
            $persona->apellidos = $request->get('apellidos');
            $persona->tipo_persona = $request->get('tipo_persona');
            $persona->unidad = $request->get('unidad') == 0 ? null : $request->get('unidad');
            $persona->dependencia = $request->get('dependencia') == 0 ? null : $request->get('dependencia');
            $persona->cargo = $request->get('cargo');
            $persona->usuario_da = $request->get('usuario_da') == "" ? null : $request->get('usuario_da');
            $persona->usuario_creador = $request->get('usuario');
            $persona->fecha_creacion = DB::raw('GETDATE()');

            if ($request->get('imagen')) {
                $folderPath = public_path() . '/img/perfil';
                if (!File::exists($folderPath)) {
                   File::makeDirectory($folderPath, 0755, true);
                }
            
                $foto = $folderPath . '/' . $persona->numero_identificacion . $request->get('tipo_imagen');
                            
                 if (file_exists($foto)) {
                    File::delete($foto);
                 }
                    
                 $image_base64 = base64_decode($request->get('imagen'));
                 file_put_contents($foto, $image_base64);
            
                 $persona->imagen = $persona->numero_identificacion . $request->get('tipo_imagen');
            }

            $persona->save();

            return $persona;
        } else if ($evento == 'U') {
            $persona = Persona::find($request->persona_id);
            $persona->numero_identificacion = $request->get('numero_identificacion');
            $persona->grado = $request->get('grado')== 0 ? null : $request->get('grado');
            $persona->nombres = $request->get('nombres');
            $persona->apellidos = $request->get('apellidos');
            $persona->tipo_persona = $request->get('tipo_persona');
            $persona->unidad = $request->get('unidad') == 0 ? null : $request->get('unidad');
            $persona->dependencia = $request->get('dependencia') == 0 ? null : $request->get('dependencia');
            $persona->cargo = $request->get('cargo');
            $persona->usuario_modificador = $request->get('usuario');
            $persona->fecha_modificacion = DB::raw('GETDATE()');
            $folderPath = public_path() . '/img/perfil';
            $foto = $folderPath . '/' . $request->get('tmp_numero_identificacion') . $request->get('tipo_imagen');
            
            if ($request->get('imagen') != null) {
                if (!File::exists($folderPath)) {
                   File::makeDirectory($folderPath, 0755, true);
                }
            
                if ($request->get('tmp_imagen') != null) {
                    $foto = $folderPath . '/' . $request->get('tmp_imagen');

                    if (file_exists($foto)) {
                        File::delete($foto);
                    }
                }
                    
                $image_base64 = base64_decode($request->get('imagen'));
                file_put_contents($foto, $image_base64);
            
                $persona->imagen = $persona->numero_identificacion . $request->get('tipo_imagen');
            }

            $persona->save();

            return $persona;
        }
    }

    public function GetUnidadesHijas(Request $request) {
        $db = DB::select('select * from tb_unidades u where u.activo = 1 and u.unidad_padre_id = :id', array('id' => $request->get('id')));
        
        return $db;
    }
}
