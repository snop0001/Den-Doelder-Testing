<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMaterial extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $attributes = [
        'test' => null,
    ];
    /**
     * Gets the material related to the orderMaterial
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id','product_id');
    }

    /**
     * Gets the order related to the orderMaterial
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
