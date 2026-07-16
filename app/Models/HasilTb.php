<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HasilTb extends Model
{
    use SoftDeletes;

    protected $table = 'hasil_tb';
    protected $primaryKey = 'id_hasil';

    protected $fillable = [
        'id_menu',
        'skor',
    ];

    protected $casts = [
        'skor' => 'decimal:6',
    ];

    public function menu()
    {
        return $this->belongsTo(MenuTb::class, 'id_menu', 'id_menu');
    }
}
