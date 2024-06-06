@extends('layouts.admin')

@section('title', __(' Stok Product'))
@section('content-header', __('Riwayat Stok Product'))
@section('content-actions')
@endsection
@section('css')
<style>
body {
  overflow-x: hidden;
}
</style>
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="row">
  <div class="col-md-6">
    <a href="{{route('addstokproduk.create')}}" class="btn btn-primary mb-2">{{ __('+ Tambah Stok Produk') }}</a>
    <a href="{{route('laporan.addstok')}}" class="btn btn-success mb-2"><i class="fas fa-file-pdf"></i>
      {{ __(' Export Tambah Stok Produk ') }}</a>
    <div class="card product-list">
      <div class="card-body">
        <p>Riwayat Tambah Stok Produk</p>
        <table class="table">
          <thead>
            <tr>
              <th>{{ __('Produk ID') }}</th>
              <th>{{ __('Produk') }}</th>
              <th>{{ __('Stok Sebelum') }}</th>
              <th>{{ __('Stok Masuk') }}</th>
              <th>{{ __('Stok Terakhir') }}</th>
              <th>{{ __('Tanggal') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($addStokProduks as $asp)
            <tr>
              <td>PRD000{{$asp->product->id}}</td>
              <td>{{$asp->product->name}}</td>
              <td><span class="badge badge-sm badge-secondary">{{$asp->product->quantity - $asp->jumlah}}</span></td>
              <td> <span class="badge badge-sm badge-success">+{{$asp->jumlah}}</span></td>

              <td><span class="badge badge-sm badge-primary">{{$asp->product->quantity}}</span></td>
              <td>{{ \Carbon\Carbon::parse($asp->tanggal)->format('d-m-Y');}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <a href="{{route('laporan.kurangstok')}}" class="btn btn-success mb-2"><i class="fas fa-file-pdf"></i>
      {{ __(' Export Produk Terjual') }}</a>
    <div class="card product-list">
      <div class="card-body">
        <p>Riwayat Produk Terjual</p>
        <table class="table">
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
            @foreach ($orders as $order)
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
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="module">
$(document).ready(function() {
  $(document).on('click', '.btn-delete', function() {
    var $this = $(this);
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: {
        {
          __('sure')
        }
      },
      text: {
        {
          __('really_delete')
        }
      },
      icon: {
        {
          __('Create_Product')
        }
      }
      'warning',
      showCancelButton: true,
      confirmButtonText: {
        {
          __('yes_delete')
        }
      },
      cancelButtonText: {
        {
          __('No')
        }
      },
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        $.post($this.data('url'), {
          _method: 'DELETE',
          _token: '{{csrf_token()}}'
        }, function(res) {
          $this.closest('tr').fadeOut(500, function() {
            $(this).remove();
          })
        })
      }
    })
  })
})
</script>
@endsection