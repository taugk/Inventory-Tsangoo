<!DOCTYPE html>
<html>
<head>
    <title>Report Inventory</title>
</head>
<body>

    <h1>Report Inventory {{ $type }}</h1>
    <p>From: {{ $startDate }} To: {{ $endDate }}</p>

    <p><strong>Total Barang Masuk: </strong>{{ $totalQuantity }}</p>

    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Entry Date</th>
            </tr>
        </thead>
        <tbody>
            @if(count($data) > 0)
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->entry_date ? $item->entry_date->format('Y-m-d') : 'Tidak Ada Tanggal Masuk' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" align="center">Tidak ada data barang masuk</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>
