<!DOCTYPE html>
<html>

<head>
  <title>Nota</title>
  <style>
  body {
    font-family: 'Courier New', Courier, monospace;
    font-size: 14px;
  }

  .nota {
    width: 300px;
    margin: auto;
    border: 1px solid black;
    padding: 10px;
  }

  .nota-header,
  .nota-footer {
    text-align: center;
  }

  .nota-content {
    margin-top: 10px;
  }

  .nota-content table {
    width: 100%;
    border-collapse: collapse;
  }

  .nota-content table td {
    padding: 5px;
  }

  .nota-content table td:nth-child(2) {
    text-align: right;
  }

  .nota-content table td:nth-child(3) {
    text-align: right;
  }

  .nota-footer {
    margin-top: 20px;
    border-top: 1px dashed black;
    padding-top: 10px;
  }

  .print-button {
    margin-top: 20px;
    padding: 10px;
    width: 100%;
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
  }

  @media print {
    .print-button {
      display: none;
    }
  }
  </style>
</head>

<body>

  <div class="nota">
    <div class="nota-header">
      <h2>{{ $data['store_name'] }}</h2>
      <p>{{ $data['store_address'] }}</p>
    </div>

    <div class="nota-content">
      <p>Tanggal: {{ $data['transaction_date'] }}</p>
      <p>No: {{ $data['transaction_number'] }}</p>
      <hr>
      <table>
        <tr>
          <td>Produk</td>
          <td>Qty X Harga</td>
          <td>Total</td>
        </tr>
        @foreach($data['items'] as $item)
        <tr>
          <td>{{ $item['name'] }}</td>
          <td>{{ $item['quantity'] }} x {{ number_format($item['price'], 0, ',', '.') }}</td>
          <td>{{ number_format($item['total'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
      </table>
      <hr>
      <table>
        <tr>
          <td>Total Harga:</td>
          <td></td>
          <td>{{ number_format($data['total_price'], 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>Total Item:</td>
          <td></td>
          <td>{{ $data['total_item'] }}</td>
        </tr>
        <tr>
          <td>Diskon:</td>
          <td></td>
          <td>{{ number_format($data['discount'], 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>Total Bayar:</td>
          <td></td>
          <td>{{ number_format($data['total_payment'], 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>Diterima:</td>
          <td></td>
          <td>{{ number_format($data['received'], 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>Kembali:</td>
          <td></td>
          <td>{{ number_format($data['change'], 0, ',', '.') }}</td>
        </tr>
      </table>
    </div>

    <div class=" nota-footer">
      <p>-- TERIMA KASIH --</p>
    </div>
  </div>

  <button onclick="window.print()" class="print-button">Cetak</button>

</body>

</html>