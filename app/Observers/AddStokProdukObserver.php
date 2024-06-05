<?php

namespace App\Observers;

use App\Models\AddStokProduk;
use App\Models\Product;

class AddStokProdukObserver
{
    /**
     * Handle the AddStokProduk "created" event.
     */
    public function created(AddStokProduk $addStokProduk): void
    {
        $produk = Product::find($addStokProduk->product_id);
        if ($produk) {
            $produk->quantity += $addStokProduk->jumlah;
            $produk->save();
        }
    }

    /**
     * Handle the AddStokProduk "updated" event.
     */
    public function updated(AddStokProduk $addStokProduk): void
    {
        $qtyOriginal = $addStokProduk->getOriginal('jumlah');
        $produk = Product::find($addStokProduk->product_id);
        if ($produk) {
            $produk->quantity += $addStokProduk->jumlah - $qtyOriginal;
            $produk->save();
        }
    }

    /**
     * Handle the AddStokProduk "deleted" event.
     */
    public function deleted(AddStokProduk $addStokProduk): void
    {
        $produk = Product::find($addStokProduk->product_id);
        if ($produk) {
            $produk->quantity -= $addStokProduk->jumlah;
            $produk->save();
        }
    }

    /**
     * Handle the AddStokProduk "restored" event.
     */
    public function restored(AddStokProduk $addStokProduk): void
    {
        //
    }

    /**
     * Handle the AddStokProduk "force deleted" event.
     */
    public function forceDeleted(AddStokProduk $addStokProduk): void
    {
        //
    }
}
