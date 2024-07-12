<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'tb_roles';

    protected $primaryKey = 'rol_id';

    protected $fillable = [ 'rol', 'descripcion', 'activo' ];

    public $timestamps = false;

    public function crud_roles(Request $request, $evento) {
        if ($evento == 'C') {
            $rol = new Rol;
            $rol->rol = $request->get('rol');
            $rol->descripcion = $request->get('descripcion');
            $rol->activo = 'S';
            $rol->fecha_creacion = DB::raw('GETDATE()');
            $rol->usuario_creador = DB::raw('user');
            $rol->save();            

            return $rol;
        }
        else if ($evento == 'U') {
            $rol = Rol::find($request->get('rol_id'));
            $rol->rol = $request->get('rol');
            $rol->descripcion = $request->get('descripcion');
            $rol->activo = $request->get('activo') == true ? 'S' : 'N';
            $rol->fecha_modificacion = DB::raw('GETDATE()');
            $rol->save();

            return $rol;
        }
    }

    public function get_roles_by_user(Request $request) {
        $db = DB::select('select rol from vw_roles_users where user_id = :id', array('id' => $request->get('user_id')));

        return $db;
    }
}
