<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\UsuarioRol;
use App\Models\UsuarioMenu;
use App\Models\RolPrivilegio;
use App\Models\Permiso;

class UsuarioController extends Controller
{
    //obtener usuarios
    public function getUsuarios() {
        $m = new Usuario();
        $datos = $m->ObtenerUsuarios();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function CrearUsuarios(Request $request) {
        $m = new Usuario();
        $usuario = $m->crud_usuarios($request, 'C');
        if ($usuario->usuario_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => $usuario->usuario_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    
    public function ActualizarUsuario(Request $request) {
        $m = new Usuario();
        $usuario = $m->crud_usuarios($request, 'U');
        if ($usuario) {
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

    public function buscando(Request $request) {
        $model = new Usuario();

        $datos = $model->Buscar($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function getRolesAsignados(Request $request){
        $m = new UsuarioRol;
        $datos = $m->get_usuarios_roles_by_usuario_id($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function CrearPrivilegios(Request $request) {
        $m = new UsuarioRol();
        $usuario = $m->crud_usuarios_roles($request, 'C');
        if ($usuario->usuario_id != 0) {
            $response = json_encode(array('mensaje' => 'Ha creado exitosamente.', 'tipo' => 0, 'id' => $usuario->usuario_rol_id), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
        else {
            $response = json_encode(array('mensaje' => 'Error al Crear el Registro.', 'tipo' => -1), JSON_NUMERIC_CHECK);
            $response = json_decode($response);

            return response()->json($response);
        }
    }

    public function ActualizarPrivilegios(Request $request) {
        $m = new UsuarioRol();
        $usuario = $m->crud_usuarios_roles($request, 'U');
        if ($usuario) {
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

    public function ChangePassword(Request $request) {
        $model = new Usuario();

        $datos = $model->cambioContraseña($request);

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function getRolPrivilegiosPantalla() {
        $m = new RolPrivilegio;
        $datos = $m->get_roles_privilegios_pantalla();

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }

    public function crearAsignarMenu(Request $request) {
        $m = new UsuarioMenu;
        $umenu = $m->crud_usuarios_menu($request);

        if ($umenu[0]->id != 0) {
            return response()->json(array('tipo' => 0, 'mensaje' => 'Fue creado exitosamente.', 'id' => $umenu[0]->id));
        }
        else {
            return response()->json(array('tipo' => -1, 'mensaje' => 'Error guardado'));
        }
    }

    public function getPermisos(Request $request) {
        $p = new Permiso;
        $permiso = $p->getPermisos($request);
        
        $datos = array();
        $datos['consultar'] = $permiso->consultar;
        $datos['crear'] = $permiso->crear;
        $datos['actualizar'] = $permiso->actualizar;
        $datos['eliminar'] = $permiso->eliminar;

        $response = json_encode(array('result' => $datos, 'tipo' => 0), JSON_NUMERIC_CHECK);
        $response = json_decode($response);

        return response()->json($response, 200);
    }
}
