<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kriteria extends Model
{
    use SoftDeletes;

    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = ['kriteria_name'];

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function penilaians()
    {
        return $this->hasMany(PenilaianTb::class, 'id_kriteria', 'id_kriteria');
    }
}
