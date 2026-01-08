<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>



    <p><strong>Invoice ID:</strong> {{ $invoiceId }}</p>


    <p>Date: {{ now()->format('Y-m-d') }}</p>



    @php
        $totalAmount = 0;
    @endphp

    <table width="100%" cellspacing="0" cellpadding="7" style="border-collapse: collapse; border: 1px solid #000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000;">Order ID</th>
                <th style="border: 1px solid #000;">Product</th>
                <th style="border: 1px solid #000;">Buyer</th>
                <th style="border: 1px solid #000;">Qty</th>
                <th style="border: 1px solid #000;">Currency</th>
                <th style="border: 1px solid #000;">Amount</th>
                <th style="border: 1px solid #000;">Status</th>
                <th style="border: 1px solid #000;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                @php $totalAmount += $order->total_amount; @endphp
                <tr>
                    <td style="border: 1px solid #000;">{{ $order->order_id }}</td>
                    <td style="border: 1px solid #000;">{{ $order->source->name ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $order->user->full_name ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $order->quantity }}</td>
                    <td style="border: 1px solid #000;">{{ $order->currency }}</td>
                    <td style="border: 1px solid #000;">{{ $order->total_amount }}</td>
                    <td style="border: 1px solid #000;">{{ $order->status->label() }}</td>
                    <td style="border: 1px solid #000;">{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" align="right" style="border: 1px solid #000;"><strong>Total Amount</strong></td>
                <td style="border: 1px solid #000;"><strong>{{ $totalAmount }}</strong></td>
                <td colspan="2" style="border: 1px solid #000;"></td>
            </tr>
        </tfoot>

    </table>


    <p style="text-align: center">Generate by automatically</p>

</body>

</html>
