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
        'minus',
        'ok',
        'raja3t',
        'rest',
        'previousRaja3t',

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

 // Accessor for el_mostafid
    // Accessor for el_mostafid
    public function getElMostafidAttribute()
    {
        $li_seleft_upper = strtoupper($this->li_seleft);

        // Check if el_mostafid is null
        if (is_null($this->attributes['el_mostafid'])) {
            if ($li_seleft_upper === 'AM') {
                return 'DZ';
            } elseif ($li_seleft_upper === 'DZ') {
                return 'AM';
            } else {
                // Return null if li_seleft is neither 'AM' nor 'DZ'
                return null;
            }
        }

        // Return the value from the database in uppercase if it's not null
        return strtoupper($this->attributes['el_mostafid']);
    }

    // Accessor for li_seleft
    public function getLiSeleftAttribute($value)
    {
        return strtoupper($value);
    }

    // Mutator for li_seleft
    public function setLiSeleftAttribute($value)
    {
        $this->attributes['li_seleft'] = strtoupper($value);
    }


     public function getRestAttribute()
     {
         return $this->qte - $this->raja3t;

     }

     protected static function booted()
     {
         static::saving(function ($model) {
             // Ensure 'previousRaja3t' is set correctly before saving
             if (isset($model->attributes['raja3t']) && $model->isDirty('raja3t')) {
                 $model->previousRaja3t = $model->raja3t;
                 $model->ok = false; // Set 'ok' to false if 'raja3t' is modified
             }

             if ($model->ok == true) {
                 $model->raja3t = $model->qte; // Then update 'raja3t' to the value of 'qte'
             }

             $model->rest = $model->getRestAttribute();
             if ($model->rest === 0) {
                 $model->ok = true; // Ensure 'ok' is true if 'rest' is 0
             }
         });
     }

    public static function boot()
    {
        parent::boot();
    }

}
