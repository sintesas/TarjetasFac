<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolPrivilegio extends Model
{
    use HasFactory;

    protected $table = 'tb_roles_privilegios';

    protected $primaryKey = 'rol_privilegio_id';

    protected $fillable = [
        'rol_privilegio_id,rol_id,num_pantalla,modulo,nombre_pantalla,consultar,crear,actualizar,eliminar,activo,usuario_creador,fecha_creacion,usuario_modificador,fecha_modificacion'
    ];

    public $timestamps = false;

    public function crud_roles_privilegios(Request $request, $evento) {
        if ($evento == 'C') {
            $m = new RolPrivilegio;
            $m->rol_id = $request->get('rol_id');
            $m->num_pantalla = $request->get('num_pantalla');
            $m->modulo = $request->get('modulo');
            $m->nombre_pantalla = $request->get('nombre_pantalla');
            $m->consultar = $request->get('consultar') == true ? 1 : 0;
            $m->crear = $request->get('crear') == true ? 1 : 0;
            $m->actualizar = $request->get('actualizar') == true ? 1 : 0;
            $m->eliminar = $request->get('eliminar') == true ? 1 : 0;
            $m->activo = $request->get('activo') == true ? 1 : 0;
            $m->usuario_creador = $request->get('usuario');
            $m->fecha_creacion = DB::raw('GETDATE()');
            $m->save();

            return $m;
        }
        else if ($evento == 'U') {
            $m = RolPrivilegio::find($request->get('rol_privilegio_id'));
            $m->rol_id = $request->get('rol_id');
            $m->num_pantalla = $request->get('num_pantalla');
            $m->nombre_pantalla = $request->get('nombre_pantalla');
            $m->consultar = $request->get('consultar') == true ? 1 : 0;
            $m->crear = $request->get('crear') == true ? 1 : 0;
            $m->actualizar = $request->get('actualizar') == true ? 1 : 0;
            $m->eliminar = $request->get('eliminar') == true ? 1 : 0;
            $m->activo = $request->get('activo') == true ? 1 : 0;
            $m->usuario_modificador = $request->get('usuario');
            $m->fecha_modificacion = DB::raw('GETDATE()');
            $m->save();

            return $m;
        }
    }

    public function get_roles_privilegios_by_rol_id(Request $request) {
        $db = DB::select('select * from tb_roles_privilegios where rol_id = :id order by rol_privilegio_id', array('id' => $request->get('rol_id')));
        
        return $db;
    }

    public function eliminar_roles_privilegios_by_id(Request $request) {
        $db = RolPrivilegio::find($request->get('rol_privilegio_id'));
        $db->delete();
        
        return $db;
    }

    public function get_modulos() {
        $db = DB::select("exec pr_get_modulos");
        
        return $db;
    }

    public function get_roles_privilegios_pantalla() {
        $db = DB::select('exec pr_rol_privilegios_pantalla');

        return $db;
    }
}
