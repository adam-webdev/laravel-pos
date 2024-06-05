<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <title>Add Stok</title>
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
      {{ $periode == 'all'? 'Laporan  Add Stok all ': 'Laporan Add Stok Per-periode ' . $tgl_awal . ' sampai dengan ' . $tgl_akhir }}
    </h5>
  </div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <table class="table table-striped table-bordered align-items-center" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>{{ __('No') }}</th>
          <th>{{ __('Produk') }}</th>
          <th>{{ __('Jumlah') }}</th>
          <th>{{ __('Tanggal') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $asp)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$asp->product->name}}</td>
          <td>{{$asp->jumlah}}</td>
          <td>{{ \Carbon\Carbon::parse($asp->tanggal)->format('d-m-Y');}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>

</html>
{{-- @endsection --}}