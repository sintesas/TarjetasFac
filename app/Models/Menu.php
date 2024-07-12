<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'tb_menu';// cambiar a vista?

    protected $primaryKey = 'menu_id';

    public $timestamps = false;

    protected $fillable = [
        'nombre_menu',
        'descripcion',
        'menu_padre_id',
        'tipo_menu',
        'icono',
        'url',
        'estado',
        'usuario_creador',
        'fecha_creacion',
        'usuario_modificador',
        'fecha_modificacion'
    ];
    
    public function getMenu() {
        $db = Menu::all()->sortBy('menu_id');

        return $db;
    }

    public function get_menu_id($menus) {
        $data = array();
        foreach($menus as $row) {
            $tmp = array();
            $tmp['menu_id'] = intval($row->menu_id);
            $tmp['titulo'] = $row->titulo;
            $tmp['tipo_menu_id'] = intval($row->tipo_menu_id);
            $tmp['tipo'] = $row->tipo;
            $tmp['menu_padre_id'] = $row->menu_padre_id == null ? null : intval($row->menu_padre_id);
            $tmp['icono'] = $row->icono;
            $tmp['url'] = $row->url;
            $tmp['submenus'] = array();

            array_push($data, $tmp);
        }

        $result = $this->menu_recursivo($data);

        return $result;
    }

    public function menu_recursivo($data, $padre_id = 0) {
        $tree = array();
        foreach ($data as $d) {
            if ($d['menu_padre_id'] == $padre_id) {
                $submenus = $this->menu_recursivo($data, $d['menu_id']);
                if (!empty($submenus)) {
                    $d['submenus'] = $submenus;
                }
                $tree[] = $d;
            }
        }
        return $tree;
    }
}
