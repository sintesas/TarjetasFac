<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsuarioRol extends Model
{
    use HasFactory;

    protected $table = 'tb_usuarios_roles';

    protected $primaryKey = 'usuario_rol_id';

    protected $fillable = [
        "usuario_rol_id,user_id,rol_id,rol_privilegio_id,activo,usuario_creador,fecha_creacion,usuario_modificador,fecha_modificacion"
    ];

    public $timestamps = false;

    public function getUsuarioRolById(Request $request) {
        $db = DB::select('exec pr_get_sg_adm_usuarios_roles_by_user_id ?', [ $request->get('user_id') ]);

        return $db;
    }
    
    public function crud_usuarios_roles(Request $request, $evento) {
        if ($evento == 'C') {
            $m = new UsuarioRol;
            $m->usuario_id = $request->get('usuario_id');
            $m->rol_id = $request->get('rol_id');
            $m->rol_privilegio_id = $request->get('rol_privilegio_id');
            $m->activo = $request->get('activo') == true ? 'S' : 'N';
            $m->usuario_creador = $request->get('usuario');
            $m->fecha_creacion = DB::raw('GETDATE()');
            $m->save();

            return $m;
        }
        else if ($evento == 'U') {
            $m = UsuarioRol::find($request->get('usuario_rol_id'));
            $m->usuario_id = $request->get('usuario_id');
            $m->rol_id = $request->get('rol_id');
            $m->activo = $request->get('activo') == true ? 'S' : 'N';
            $m->usuario_modificador = $request->get('usuario');
            $m->fecha_modificacion = DB::raw('GETDATE()');
            $m->save();

            return $m;
        }
    }

    public function get_usuarios_roles_by_usuario_id(Request $request) {
        $db = DB::select("exec get_usuarios_roles_by_usuario_id ?", array($request->input('usuario_id')));

        return $db;
    }

    public function eliminar_usuarios_roles_by_id(Request $request) {
        $db = UsuarioRol::find($request->get('usuario_rol_id'));
        $db->delete();

        return $db;
    }
}
