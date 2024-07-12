<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tb_usuarios';

    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'usuario,nombres,apellidos,email,tipo_usuario,estado,usuario_creador,fecha_creacion,usuario_modificador,fecha_modificacion'
    ];

    public $timestamps = false; // created_at y updated_ad

    protected $hidden = [ 'password' ];

    public function ObtenerUsuarios() {
        $db = DB::select("select * from tb_usuarios where usuario != 'admin'");
        return $db;
    }

    public function crud_usuarios(Request $request, $evento) {
        if ($evento == 'C') {
            $Usuario = new Usuario();
            $Usuario->usuario = $request->get('usuario');
            $Usuario->nombres = $request->get('nombres');
            $Usuario->apellidos = $request->get('apellidos');
            $Usuario->email = $request->get('email');
            $Usuario->password = password_hash($request->get('password'), PASSWORD_BCRYPT, ['cost' => 15]);
            $Usuario->tipo_usuario = $request->get('tipo_usuario');
            $Usuario->estado = "S";
            $Usuario->usuario_creador = $request->get('usuario');
            $Usuario->fecha_creacion = DB::raw('GETDATE()');
            $Usuario->save();            

            return $Usuario;
        }
        else if ($evento == 'U') {
            $Usuario = Usuario::find($request->get('usuario_id'));
            $Usuario->usuario = $request->get('usuario');
            $Usuario->nombres = $request->get('nombres');
            $Usuario->apellidos = $request->get('apellidos');
            $Usuario->email = $request->get('email');
            //$Usuario->password = password_hash($request->get('password'), PASSWORD_BCRYPT, ['cost' => 15]);
            $Usuario->tipo_usuario = $request->get('tipo_usuario');
            $Usuario->estado = $request->get('estado');
            $Usuario->usuario_modificador = $request->get('usuario');
            $Usuario->fecha_modificacion = DB::raw('GETDATE()');
            $Usuario->save(); 

            return $Usuario;
        }
    }

    public function Buscar(Request $request){
        $resultados = DB::select('exec buscarUsuarios ?', [ $request->get('busqueda')] );
        return $resultados;
    }

    public function cambioContraseña(Request $request) {
        $pass = $request->get('password');
        $password = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 15]);
        $usuario_id = $request->get('usuario_id');
    
        $db = DB::update('update tb_usuarios set password = ? where usuario_id = ?', [$password, $usuario_id]);
    
        return $db;
    }
}
