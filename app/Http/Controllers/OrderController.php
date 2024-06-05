<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = new Order();
        if ($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $orders = $orders->with(['items.product', 'payments', 'customer'])->get();
        // ddd($orders);



        $total = $orders->map(function ($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function ($i) {
            return $i->receivedAmount();
        })->sum();
        // ddd($orders);
        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'price' => $item->price * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }

    public function cetak_nota($id)
    {
        // Dummy data for example, you should retrieve this from your database
        $orderItems = OrderItem::with('product')->where('order_id', $id)->get();

        $items = [];
        $totalPrice = 0;

        foreach ($orderItems as $orderItem) {
            $items[] = [
                'name' => $orderItem->product->name,
                'quantity' => $orderItem->quantity,
                'price' => $orderItem->price,
                'total' => $orderItem->quantity * $orderItem->price
            ];
            $totalPrice += $orderItem->quantity * $orderItem->price;
        }

        $data = [
            'store_name' => 'ABIGAIL',
            'store_address' => 'JL. Kenangan',
            'transaction_date' => now()->format('d-m-Y'), // Assuming the current date
            'transaction_number' => str_pad($id, 11, '0', STR_PAD_LEFT),
            'items' => $items,
            'total_price' => $totalPrice,
            'total_item' => count($items),
            'discount' => 0, // Example: Replace with actual discount logic if needed
            'total_payment' => $totalPrice, // Example: Replace with actual payment logic if needed
            'received' => $totalPrice, // Example: Replace with actual received amount if needed
            'change' => 0 // Example: Replace with actual change amount if needed
        ];

        return view('orders.nota', compact('data'));

        // return view('orders.show', compact('order'));
    }

    public function view_penjualan()
    {
        return view('orders.laporan.laporan');
    }

    public function penjualan(Request $request)
    {
        // $this->middleware('role:Admin|Direktur');
        $periode = $request->periode;

        if ($periode == "all") {
            $data = Order::with(['items.product', 'payments', 'customer'])->get();

            $total = $data->map(function ($i) {
                return $i->total();
            })->sum();
            $receivedAmount = $data->map(function ($i) {
                return $i->receivedAmount();
            })->sum();

            $pdf = PDF::loadView('orders.laporan.print', compact('data', 'periode', 'total', 'receivedAmount'))->setPaper('A4', 'landscape');
            return $pdf->stream('laporan-penjualan-all.pdf');
        } else if ($periode == "periode") {
            $tgl_awal = $request->awal;
            $tgl_akhir = $request->akhir;
            $data = Order::with(['items.product', 'payments', 'customer'])->whereBetween('created_at', [$tgl_awal, $tgl_akhir])
                ->orderBy('created_at', 'ASC')->get();

            $total = $data->map(function ($i) {
                return $i->total();
            })->sum();
            $receivedAmount = $data->map(function ($i) {
                return $i->receivedAmount();
            })->sum();

            $pdf = PDF::loadView('orders.laporan.print', compact('data', 'periode', 'tgl_awal', 'tgl_akhir', 'total', 'receivedAmount'))->setPaper('A4', 'landscape');
            $namaFile = 'laporan-penjualan-periode-' . $tgl_awal . '-' . $tgl_akhir . '.pdf';
            return $pdf->stream($namaFile);
        }
    }
}