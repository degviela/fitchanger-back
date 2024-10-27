<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function clothingItems()
    {
        return $this->belongsToMany(ClothingItem::class, 'clothingitem_outfit');
    }
}
