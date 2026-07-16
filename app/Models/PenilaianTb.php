<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianTb extends Model
{
    use SoftDeletes;

    protected $table = 'penilaian_tb';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_user',
        'id_menu',
        'id_kriteria',
        'id_subkriteria',
    ];

    public function user()
    {
        return $this->belongsTo(UserTb::class, 'id_user', 'id_user');
    }

    public function menu()
    {
        return $this->belongsTo(MenuTb::class, 'id_menu', 'id_menu');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'id_subkriteria', 'id_sub_kriteria');
    }
}
