<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pallet extends Model
{
    use HasFactory;
    protected $attributes = [
        'valid'=>1,
        'specifications' => '',
        'extra_instructions' => '',
        'details_components_bovendek' => 'Stijl, Type, Nummer: 7, Dikte: 22, Breedte: 95, Lengte: 1200',
        'details_components_onderdek' => 'Stijl, Type, Nummer: 7, Dikte: 22, Breedte: 95, Lengte: 1200',
        'details_components_boventussendek' => 'Stijl, Type, Nummer: 7, Dikte: 22, Breedte: 95, Lengte: 1200',
        'details_components_klossen' => 'Stijl, Type, Nummer: 7, Dikte: 22, Breedte: 95, Lengte: 1200',
        'details_materialen' => 'nagels, lengte, draad, ...',
        'details_nieuw_hout' => 'merk, ...',
        'details_specifieke_bladnotities' => 'Rechterblok: .., Middenblok: .., Linkerblok: ..',
    ];
    /**
     * This function creates a new product and returns that product
     */
    public static function addProduct()
    {
        Product::create(([
            'type'=>'pallet']));
        return DB::table('products')->orderBy('id','desc')->first();
    }

    /**
     * Gets the product related to the pallet
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     *Gets the orders related to the pallet
     */
    public function orders()
    {
        return $this->hasMany(Order::class,'pallet_id','product_id');
    }

    /**
     *Gets the orderMaterials related to the order
     */
    public function palletMaterials()
    {
        return $this->hasMany(PalletMaterial::class, 'pallet_id');
    }
}
