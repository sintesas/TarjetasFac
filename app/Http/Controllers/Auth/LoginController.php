<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Menu;
use App\Models\Usuario;
use App\Models\UsuarioMenu;

class LoginController extends Controller
{
    public function login(Request $request) {
        $p_usuario = $request->get('usuario');
        $p_password = $request->get('password');
        
        if (Auth::attempt(['usuario' => $p_usuario, 'password' => $p_password])) {
            //$usuario = Usuario::where('usuario',$p_usuario)->first();
            $usuario = Auth::user();

            $m_menu = new Menu;
            $m_usuariomenu = new UsuarioMenu;

            $data = array();
            $data['usuario_id'] = $usuario->usuario_id;
            $data['usuario'] = $usuario->usuario;
            $data['nombre_completo'] = $usuario->nombres . ' ' . $usuario->apellidos;
            $data['email'] = $usuario->email;
            $data['menus'] = $m_menu->get_menu_id($m_usuariomenu->getUsuarioMenu($usuario->usuario_id));

            $response = json_encode(array('result' => $data), JSON_NUMERIC_CHECK);
            $response = json_decode($response);
            return response()->json(array('user' => $response, 'tipo' => 0));
        }
        else {
            return response()->json(array('mensaje' => 'Usuario y/o contraseña no es correcto o puede que su usuario no este activo en este caso valide con el administrador', 'tipo' => -2));
        }
    }

    public function logout(){
        Auth::logout();
    }
}
