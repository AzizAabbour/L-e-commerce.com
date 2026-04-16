<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeSouhait extends Model
{
    protected $table = 'liste_souhaits';
    protected $fillable = ['user_id', 'produit_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
