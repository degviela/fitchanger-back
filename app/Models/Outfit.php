<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'head_id',
        'top_id',
        'bottom_id',
        'footwear_id',
    ];

    public function head()
    {
        return $this->belongsTo(ClothingItem::class, 'head_id');
    }

    public function top()
    {
        return $this->belongsTo(ClothingItem::class, 'top_id');
    }

    public function bottom()
    {
        return $this->belongsTo(ClothingItem::class, 'bottom_id');
    }

    public function footwear()
    {
        return $this->belongsTo(ClothingItem::class, 'footwear_id');
    }
}
