<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <title>Pengurangan Stok</title>
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
      {{ $periode == 'all'? 'Laporan  Pengurangan Stok All ': 'Laporan Pengurangan Stok Per-periode ' . $tgl_awal . ' sampai dengan ' . $tgl_akhir }}
    </h5>
  </div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <table class="table table-striped table-bordered align-items-center" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>{{ __('Produk ID') }}</th>
          <th>{{ __('Produk') }}</th>
          <th>{{ __('Stok Sebelum') }}</th>
          <th>{{ __('Stok Keluar') }}</th>
          <th>{{ __('Stok Terakhir') }}</th>
          <th>{{ __('Tanggal') }}</th>
          <!-- <th>{{ __('Aksi') }}</th> -->
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $order)
        @foreach ($order->items as $item)
        <tr>
          <td>PRD000{{$item->product->id}}</td>
          <td>{{$item->product->name}}</td>
          <!-- <td>{{$item->quantity}}</td> -->


          <td><span class="badge badge-sm badge-secondary">{{$item->product->quantity + $item->quantity}}</span>
          </td>
          <td> <span class="badge badge-sm badge-danger">-{{$item->quantity}}</span></td>

          <td><span class="badge badge-sm badge-primary">{{$item->product->quantity}}</span></td>
          <td>{{$item->created_at->format('d-m-Y')}}</td>


        </tr>
        @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
</body>

</html>
{{-- @endsection --}}