<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2>Sales Invoice - {{ $month }}/{{ $year }}</h2>

    <table width="100%" border="1" cellspacing="0" cellpadding="6">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Buyer</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->source->name ?? '' }}</td>
                    <td>{{ $order->user->full_name ?? '' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ currency_exchange($order->total_amount) }}</td>
                    <td>{{ $order->status->label() }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
