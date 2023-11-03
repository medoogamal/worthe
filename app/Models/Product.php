<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','purchase_price','sale_price','category_id','image','stock'] ;
    protected $appended = ['image_path','profit_percent'];


    public function category (){
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute(){
        return asset('/uploads/product_images/'. $this->image);
    }
    public function getProfitPercentAttribute(){
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit*100 / $this->purchase_price;
        return $profit_percent;
    }


    public function orders (){
        return $this->belongsToMany(Order::class,'product_order');
    }

}