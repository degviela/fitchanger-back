<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothingItem extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'image_path'];

    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'clothingitem_outfit');
    }
}
