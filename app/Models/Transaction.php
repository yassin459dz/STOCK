<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'li_seleft',
        'el_mostafid',
        'note',
        'qte',
        'validate',
        'rest',
    ];
    public function setQteAttribute($value)
    {
        $this->attributes['qte'] = $value;
        $this->attributes['rest'] = $value; // Set 'rest' attribute with the same value as 'qte'
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getElMostafidAttribute()
    {
        if ($this->li_seleft === 'AM') {
            return 'DZ';
        } elseif ($this->li_seleft === 'DZ') {
            return 'AM';
        }

        // Default or fallback value if needed
    }

}
