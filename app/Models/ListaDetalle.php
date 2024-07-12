<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListaDetalle extends Model
{
    use HasFactory;

    protected $table = 'tb_listas_dinamicas';

    protected $primaryKey = 'lista_dinamica_id';

    public $timestamps = false;

    // public function get_lista_by_id(Request $request) {
    //     $db = \DB::select('select t.*, (select lista_dinamica from tb_listas_dinamicas where lista_dinamica_id = t.lista_padre_id) as lista_padre from sg_adm_listas_dinamicas t where t.nombre_lista_id = :id order by t.lista_dinamica_id', array('id' => $request->get('nombre_lista_id')));
        
    //     return $db;
    // }

     public function get_lista_by_id(Request $request) {
        $db = DB::select('select * from tb_listas_dinamicas ld where ld.nombre_lista_id = :id order by ld.lista_dinamica_id', array('id' => $request->get('id')));
        
        return $db;
     }

    public function crud_listas_detalles(Request $request, $evento) {
        if ($evento == 'C') {
            $Listas = new ListaDetalle;
            $Listas->nombre_lista_id = $request->get('nombre_lista_id');
            $Listas->lista_dinamica = $request->get('lista_dinamica');
            $Listas->descripcion = $request->get('descripcion');
            $Listas->codigo = $request->get('codigo');
            $Listas->atributo1 = $request->get('atributo1');
            $Listas->atributo2 = $request->get('atributo2');
            $Listas->activo = $request->get('activo') == true ? 1 : 0;
            $Listas->usuario_creador = $request->get('usuario');
            $Listas->fecha_creacion = DB::raw('GETDATE()');
            $Listas->save();            

            return $Listas;
        }
        else if ($evento == 'U') {
            $Listas = ListaDetalle::find($request->get('lista_dinamica_id'));
            $Listas->nombre_lista_id = $request->get('nombre_lista_id');
            $Listas->lista_dinamica = $request->get('lista_dinamica');
            $Listas->descripcion = $request->get('descripcion');
            $Listas->codigo = $request->get('codigo');
            $Listas->atributo1 = $request->get('atributo1');
            $Listas->atributo2 = $request->get('atributo2');
            $Listas->activo = $request->get('activo') == true ? 1 : 0;
            $Listas->usuario_modificador = $request->get('usuario');
            $Listas->fecha_modificacion = DB::raw('GETDATE()');
            $Listas->save();

            return $Listas;
        }
    }

    public function get_lista_by_name(Request $request) {
        $db = DB::select('select * from tb_listas_dinamicas where nombre_lista_id = (select nombre_lista_id from tb_nombres_listas where nombre_lista = :nombre)', array('nombre' => $request->get('nombre')));
        
        return $db;
    }
}
