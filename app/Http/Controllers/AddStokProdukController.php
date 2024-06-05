<?php

namespace App\Http\Controllers;

use App\Models\AddStokProduk;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class AddStokProdukController extends Controller
{
    public function index()
    {
        $addStokProduks = AddStokProduk::with('product')->get();
        $orders = Order::with('items.product')->get();
        return view('add-stok-produk.index', compact('addStokProduks', 'orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('add-stok-produk.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'product_id' => 'required|exists:products,id'
        ]);

        AddStokProduk::create($request->all());
        return redirect()->route('addstokproduk.index');
    }

    public function edit($id)
    {
        $products = Product::all();
        $addStokProduk = AddStokProduk::find($id);
        return view('add-stok-produk.edit', compact('addStokProduk', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'product_id' => 'required|exists:products,id'
        ]);

        $addStokProduk = AddStokProduk::find($id);
        $addStokProduk->update($request->all());
        return redirect()->route('addstokproduk.index');
    }

    public function destroy($id)
    {
        AddStokProduk::destroy($id);
        return redirect()->route('addstokproduk.index');
    }

    public function view_tambah_stok()
    {
        return view('add-stok-produk.laporan-tambah-stok.laporan');
    }

    public function tambah_stok(Request $request)
    {
        // $this->middleware('role:Admin|Direktur');
        $periode = $request->periode;

        if ($periode == "all") {
            $data = AddStokProduk::with('product')->get();
            $pdf = PDF::loadView('add-stok-produk.laporan-tambah-stok.print', compact('data', 'periode'))->setPaper('A4', 'portrait');
            return $pdf->stream('laporan-penambahan-stok-all.pdf');
        } else if ($periode == "periode") {
            $tgl_awal = $request->awal;
            $tgl_akhir = $request->akhir;
            $data = AddStokProduk::with('product')->whereBetween('created_at', [$tgl_awal, $tgl_akhir])
                ->orderBy('created_at', 'ASC')->get();

            $pdf = PDF::loadView('add-stok-produk.laporan-tambah-stok.print', compact('data', 'periode', 'tgl_awal', 'tgl_akhir'))->setPaper('A4', 'portrait');
            $namaFile = 'laporan-penambahan-stok-periode-' . $tgl_awal . '-' . $tgl_akhir . '.pdf';
            return $pdf->stream($namaFile);
        }
    }

    public function view_kurang_stok()
    {
        return view('add-stok-produk.laporan-kurang-stok.laporan');
    }

    public function kurang_stok(Request $request)
    {
        // $this->middleware('role:Admin|Direktur');
        $periode = $request->periode;

        if ($periode == "all") {
            $data = Order::with('items.product')->get();
            $pdf = PDF::loadView('add-stok-produk.laporan-kurang-stok.print', compact('data', 'periode'))->setPaper('A4', 'portrait');
            return $pdf->stream('laporan-pengurangan-stok-all.pdf');
        } else if ($periode == "periode") {
            $tgl_awal = $request->awal;
            $tgl_akhir = $request->akhir;
            $data = Order::with('items.product')->whereBetween('created_at', [$tgl_awal, $tgl_akhir])
                ->orderBy('created_at', 'ASC')->get();
            $pdf = PDF::loadView('add-stok-produk.laporan-kurang-stok.print', compact('data', 'periode', 'tgl_awal', 'tgl_akhir'))->setPaper('A4', 'portrait');
            $namaFile = 'laporan-pengurangan-stok-periode-' . $tgl_awal . '-' . $tgl_akhir . '.pdf';
            return $pdf->stream($namaFile);
        }
    }
}