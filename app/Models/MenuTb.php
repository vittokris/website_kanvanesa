<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuTb extends Model
{
    use SoftDeletes;

    protected $table = 'menu_tb';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'menu_name',
        'menu_description',
        'menu_price',
        'menu_image',
    ];

    protected $casts = [
        'menu_price' => 'integer',
    ];

    public function penilaians()
    {
        return $this->hasMany(PenilaianTb::class, 'id_menu', 'id_menu');
    }

    public function hasil()
    {
        return $this->hasOne(HasilTb::class, 'id_menu', 'id_menu');
    }

    /**
     * Get the full URL for the menu image.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->menu_image) {
            return route('menu.image', ['filename' => basename($this->menu_image)]);
        }

        return asset('images/no-image.png');
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->menu_price === null) {
            return 'Harga belum diisi';
        }

        return 'Rp ' . number_format($this->menu_price, 0, ',', '.');
    }
}
