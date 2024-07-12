<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Lista extends Model
{
    use HasFactory;

    protected $table = 'tb_nombres_listas';

    protected $primaryKey = 'nombre_lista_id';

    public $timestamps = false;

    public function Get_listas_padres() {
        $db = DB::select('	select * from tb_nombres_listas nld inner join 
                        tb_listas_dinamicas ld on ld.nombre_lista_id = nld.nombre_lista_id');
        
        return $db;
    }

    public function crud_listas(Request $request, $evento) {
        if ($evento == 'C') {
            $Listas = new Lista;
            $Listas->nombre_lista = $request->get('nombre_lista');
            $Listas->descripcion = $request->get('descripcion');
            $Listas->nombre_lista_padre_id = $request->get('nombre_lista_padre_id') == 0 ? null : $request->get('nombre_lista_padre_id');
            $Listas->lista_padre_id = $request->get('lista_padre_id') == 0 ? null : $request->get('lista_padre_id');
            $Listas->activo = 1;
            $Listas->usuario_creador = $request->get('usuario');
            $Listas->fecha_creacion = DB::raw('GETDATE()');
            $Listas->save();            

            return $Listas;
        }
        else if ($evento == 'U') {
            $Listas = Lista::find($request->get('nombre_lista_id'));
            $Listas->nombre_lista = $request->get('nombre_lista');
            $Listas->descripcion = $request->get('descripcion');
            $Listas->nombre_lista_padre_id = $request->get('nombre_lista_padre_id') == 0 ? null : $request->get('nombre_lista_padre_id');
            $Listas->lista_padre_id = $request->get('lista_padre_id') == 0 ? null : $request->get('lista_padre_id');
            $Listas->activo = $request->get('activo') == true ? 1 : 0;
            $Listas->usuario_modificador = $request->get('usuario');
            $Listas->fecha_modificacion = DB::raw('GETDATE()');
            $Listas->save(); 

            return $Listas;
        }
    }
}
