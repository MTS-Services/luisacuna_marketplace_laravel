<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
</head>

<body>

    <p><strong>Invoice ID:</strong> {{ $invoiceId }}</p>
    <p>Date: {{ now()->format('Y-m-d') }}</p>

    @php
        $totalAmount = 0;
    @endphp

    <table width="100%" cellspacing="0" cellpadding="8" style="border-collapse: collapse; border: 1px solid #000;">
        <thead>
            <tr>
                <th style="border: 1px solid #000;">Game</th>
                <th style="border: 1px solid #000;">Quantity</th>
                <th style="border: 1px solid #000;">Price</th>
                <th style="border: 1px solid #000;">Status</th>
                <th style="border: 1px solid #000;">Delivery Time</th>
                <th style="border: 1px solid #000;">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                @php $totalAmount += $offer->price; @endphp
                <tr>
                    <td style="border: 1px solid #000;">{{ $offer->game->name }}</td>
                    <td style="border: 1px solid #000;">{{ $offer->quantity }}</td>
                    <td style="border: 1px solid #000;">
                        {{ currency_symbol() }}{{ number_format(currency_exchange($offer->price), 2) }}
                    </td>
                    <td style="border: 1px solid #000;">{{ $offer->status->label() }}</td>
                    <td style="border: 1px solid #000;">{{ $offer->delivery_timeline }}</td>
                    <td style="border: 1px solid #000;">{{ $offer->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" align="right" style="border: 1px solid #000;"><strong>Total Amount</strong></td>
                <td style="border: 1px solid #000;">
                    <strong>{{ currency_symbol() }}{{ number_format(currency_exchange($totalAmount), 2) }}</strong>
                </td>
                <td colspan="3" style="border: 1px solid #000;"></td>
            </tr>
        </tfoot>
    </table>

    <p style="text-align: center;">Generated automatically</p>

</body>

</html>
