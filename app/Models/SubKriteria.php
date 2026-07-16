<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKriteria extends Model
{
    use SoftDeletes;

    protected $table = 'sub_kriteria';
    protected $primaryKey = 'id_sub_kriteria';

    protected $fillable = [
        'id_kriteria',
        'sub_kriteria_name',
        'bobot_subkriteria',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function penilaians()
    {
        return $this->hasMany(PenilaianTb::class, 'id_subkriteria', 'id_sub_kriteria');
    }
}
