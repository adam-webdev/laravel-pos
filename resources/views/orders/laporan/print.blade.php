<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <title>Document</title>
  <style>
  .header {
    display: flex;
    position: relative;
    justify-content: space-between;
    width: 100%;
    align-items: center;
  }


  .text {
    display: flex;
    align-items: center;
    justify-content: center;

  }

  hr {
    margin-bottom: 30px;
  }
  </style>
</head>

<body>
  <div class="header">
    <div class=" text">
      <h2>Toko Abigail</h2>
      <p> Bekasi </p>
      <p>Email : tokoabigail@gmail.com Fax :99999</p>
    </div>
  </div>
  <hr>
  <div class="row">
    <h5 class="text-center">
      {{ $periode == 'all'? 'Laporan  Penjualan all ': 'Laporan Penjualan Per-periode ' . $tgl_awal . ' sampai dengan ' . $tgl_akhir }}
    </h5>
  </div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <table class="table table-striped table-bordered align-items-center" width="100%" cellspacing="0">
      <thead>
        <tr align="center">
          <th>Order ID</th>
          <th>Product</th>
          <th>Qty</th>
          <th>Harga</th>
          <th>Customer</th>
          <th>Total</th>
          <th>Yang Diterima</th>
          <th>Status</th>
          <th>Kembalian</th>
          <th>Tanggal Order</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $order)
        @foreach ($order->items as $item)
        <tr>
          <td>{{$order->id}}</td>
          <td>{{$item->product->name}}</td>
          <td>{{$item->quantity}}</td>
          <td>{{ config('settings.currency_symbol') }} {{$item->product->price}}</td>

          <td>{{$order->getCustomerName()}}</td>
          <!-- <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td> -->
          <td>{{ config('settings.currency_symbol') }} {{$item->product->price * $item->quantity }}</td>

          <td>{{ config('settings.currency_symbol') }} {{$item->product->price * $item->quantity }}</td>
          <td>
            @if($order->receivedAmount() == 0)
            <span class="badge badge-danger">{{ __('order.Not_Paid') }}</span>
            @elseif($order->receivedAmount() < $order->total())
              <span class="badge badge-warning">{{ __('order.Partial') }}</span>
              @elseif($order->receivedAmount() == $order->total())
              <span class="badge badge-success">{{ __('order.Paid') }}</span>
              @elseif($order->receivedAmount() > $order->total())
              <span class="badge badge-info">{{ __('order.Change') }}</span>
              @endif
          </td>
          <td>{{config('settings.currency_symbol')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}
          </td>
          <td>{{$order->created_at->format('d-m-Y')}}</td>


        </tr>
        @endforeach
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
          <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</body>

</html>
{{-- @endsection --}}