<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddStokProduk extends Model
{
    use HasFactory;

    protected $fillable = ['jumlah', 'tanggal', 'product_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
