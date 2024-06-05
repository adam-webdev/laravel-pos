@extends('layouts.admin')

@section('title', __('order.Orders_List'))
@section('content-header', __('order.Orders_List'))
@section('content-actions')
<a href="{{route('orders.laporan_penjualan')}}" class="btn btn-success"><i class="fas fa-file-pdf mr-2"></i>Export
  Laporan Penjualan</a>
<a href="{{route('cart.index')}}" class="btn btn-primary">{{ __('cart.title') }}</a>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-7"></div>
      <div class="col-md-5">
        <form action="{{route('orders.index')}}">
          <div class="row">
            <div class="col-md-5">
              <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
            </div>
            <div class="col-md-5">
              <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
            </div>
            <div class="col-md-2">
              <button class="btn btn-outline-primary" type="submit">{{ __('order.submit') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>{{ __('order.ID') }}</th>
          <th>Product</th>
          <th>Qty</th>
          <th>Harga</th>
          <th>{{ __('order.Customer_Name') }}</th>
          <th>{{ __('order.Total') }}</th>
          <th>{{ __('order.Received_Amount') }}</th>
          <th>{{ __('order.Status') }}</th>
          <th>{{ __('order.To_Pay') }}</th>
          <th>{{ __('order.Created_At') }}</th>
          <th>{{ __('Aksi') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
        @foreach ($order->items as $item)
        <tr>
          <td>{{$order->id}}</td>
          <td>{{$item->product->name}}</td>
          <td>{{$item->quantity}}</td>
          <td>{{$item->product->price}}</td>

          <td>{{$order->getCustomerName()}}</td>
          <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
          <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td>
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
          <td>
            <a href="{{ route('orders.cetak_nota', [$order->id]) }}" class="btn btn-sm btn-warning">
              <i class="fa-solid fa-print"></i> Cetak Nota
            </a>
          </td>

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
</div>
@endsection