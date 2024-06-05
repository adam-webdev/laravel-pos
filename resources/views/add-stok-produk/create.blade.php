@extends('layouts.admin')

@section('title', __(' Add Stok Product'))
@section('content-header', __(' Add Stok Product'))

@section('content')

<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">

        <form action="{{ route('addstokproduk.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label for="produk">{{ __('Produk') }}</label>
            <select name="product_id" class="form-control @error('product_id') is-invalid @enderror" id="produk">
              <option selected disabled value="">-- Pilih Produk --</option>
              @foreach ($products as $product)
              <option value="{{$product->id}}">{{ $product->name }}</option>
              @endforeach
            </select>
            @error('product_id')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="jumlah">{{ __('Jumlah') }}</label>
            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" placeholder="{{ __('Jumlah') }}" value="{{ old('jumlah') }}">
            @error('jumlah')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="tanggal">{{ __('Tanggal') }}</label>
            <input type="date" tanggal="tanggal" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="{{ __('tanggal') }}" value="{{ old('tanggal') }}">
            @error('tanggal')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>


          <button class="btn btn-primary" type="submit">{{ __('Create') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init();
  });
</script>
@endsection