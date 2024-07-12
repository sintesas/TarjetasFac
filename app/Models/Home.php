<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $table = 'tb_banner';

    protected $primaryKey = 'banner_id';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'imagen'
    ];

    public function getBanners() {
        $db = Home::all()->sortBy('banner_id');

        return $db;
    }
}
