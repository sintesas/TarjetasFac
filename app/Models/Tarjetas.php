<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Tarjetas extends Model
{
    use HasFactory;
    protected $table = 'tb_tarjetas';
    protected $primaryKey = 'tarjeta_id';
    public $timestamps = false;

    public function GetTarjetas() {
        $db = DB::select('select p.persona_id,
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
        p.tipo_persona,
        p.restringe_da
    from tb_personas p where tarjeta = 1');
        
        return $db;
    }

    public function GetPesonasData(Request $request) {
        $db = DB::select('select p.persona_id,
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
        p.tipo_persona,
        p.restringe_da from tb_personas p where numero_identificacion = :id', array('id' => $request->get('id')));
        
        return $db;
    }

    public function crud_tarjetas(Request $request, $evento) {
        $datos = json_decode($request->modelo, true);
        if ($evento == 'C') {
            $id = $datos['persona_id'];
            $restringe_da = $datos['restringe_da'] == true ? 1 : 0;
            DB::table('tb_personas')
                ->where('persona_id', $id)
                ->update(['tarjeta' => 1]);
            DB::table('tb_personas')
                ->where('persona_id', $id)
                ->update(['restringe_da' => $restringe_da]);
            $tarjeta = new Tarjetas;
            $tarjeta->persona_id = $datos['persona_id'];
            $tarjeta->tipo_id = $datos['tipo_id'] == 0 ? null : $datos['tipo_id'];
            $tarjeta->clasificacion_id = $datos['clasificacion_id'];
            $tarjeta->fecha_inicio = $datos['fecha_inicio'];
            $tarjeta->fecha_fin = $datos['fecha_fin'];
            $tarjeta->nombre_firma = $datos['nombre_firma'];
            $tarjeta->cargo_firma = $datos['cargo_firma'];
            $tarjeta->activo = $datos['activo'] == true ? 1 : 0;
            $tarjeta->usuario_creador = $datos['usuario'];
            $tarjeta->fecha_creacion = DB::raw('GETDATE()');
            $tarjeta->unidad = $datos['unidad'];
            $tarjeta->dependencia = $datos['dependencia'];
            $tarjeta->cargo = $datos['cargo'];
            $tarjeta->vigencia = $datos['vigencia'];

            if ($request->file('acta')) {
                $acta_nombre = $datos['acta_nombre'];
                $file = $request->file('acta');
                $folderPath = public_path('actas');
                if (!File::exists($folderPath)) {
                   File::makeDirectory($folderPath, 0755, true);
                }
                $archivo = $acta_nombre .'.'. $file->getClientOriginalExtension();
                $file->move($folderPath, $archivo);
                 $tarjeta->ruta_acta = $archivo;
            }

            if ($request->file('reserva')) {
                $reserva_nombre = $datos['reserva_nombre'];
                $file = $request->file('reserva');
                $folderPath = public_path('reservas');
                if (!File::exists($folderPath)) {
                   File::makeDirectory($folderPath, 0755, true);
                }
            
                $archivo = $reserva_nombre .'.'. $file->getClientOriginalExtension();
                $file->move($folderPath, $archivo);
            
                 $tarjeta->ruta_reserva = $archivo;
            }

            $tarjeta->save();

            return $tarjeta;
        } else if ($evento == 'U') {
            $id = $datos['persona_id'];
            $restringe_da = $datos['restringe_da'] == true ? 1 : 0;
            DB::table('tb_personas')
                ->where('persona_id', $id)
                ->update(['restringe_da' => $restringe_da]);
            $tarjeta = Tarjetas::find($datos['tarjeta_id']);
            $tarjeta->persona_id = $datos['persona_id'];
            $tarjeta->tipo_id = $datos['tipo_id'] == 0 ? null : $datos['tipo_id'];
            $tarjeta->clasificacion_id = $datos['clasificacion_id'];
            $tarjeta->fecha_inicio = $datos['fecha_inicio'];
            $tarjeta->fecha_fin = $datos['fecha_fin'];
            $tarjeta->nombre_firma = $datos['nombre_firma'];
            $tarjeta->cargo_firma = $datos['cargo_firma'];
            $tarjeta->activo = $datos['activo'] == true ? 1 : 0;
            $tarjeta->usuario_creador = $datos['usuario'];
            $tarjeta->fecha_creacion = DB::raw('GETDATE()');
            $tarjeta->unidad = $datos['unidad'];
            $tarjeta->dependencia = $datos['dependencia'];
            $tarjeta->cargo = $datos['cargo'];
            $tarjeta->vigencia = $datos['vigencia'];

            if ($request->file('acta')) {
                $acta_nombre = $datos['acta_nombre'];
                $file = $request->file('acta');
                $folderPath = public_path('actas');
                if (!File::exists($folderPath)) {
                   File::makeDirectory($folderPath, 0755, true);
                }
                $archivo = $acta_nombre .'.'. $file->getClientOriginalExtension();
                $file->move($folderPath, $archivo);
            
                $tarjeta->ruta_acta = $archivo;
            }

            if ($request->file('reserva')) {
                $reserva_nombre = $datos['reserva_nombre'];
                $file = $request->file('reserva');
                $folderPath = public_path('reservas');
                if (!File::exists($folderPath)) {
                   File::makeDirectory($folderPath, 0755, true);
                }
            
                $archivo = $reserva_nombre .'.'. $file->getClientOriginalExtension();
                $file->move($folderPath, $archivo);
                $tarjeta->ruta_reserva = $archivo;
            }

            $tarjeta->save();

            return $tarjeta;
        }
    }

    public function GetTarjetasByPersonaID(Request $request) {
        $db = DB::select('select * from tb_tarjetas where persona_id = :id', array('id' => $request->get('id')));
        
        return $db;
    }

    public function getTarjetaData($id){
        $db = DB::select('select * from vw_tarjeta where tarjeta_id = :id', array('id' => $id));
        return $db;
    }
}
 