<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_number }}</h1>
    <p>Dear {{ $invoice->customer->name }},</p>
    <p>Amount: ${{ number_format($invoice->amount, 2) }}</p>
    <p>Status: {{ $invoice->status }}</p>
    <a href="{{ url('/invoices/' . $invoice->id . '/pay') }}" style="background-color: #6777ef; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Pay Now</a>
</body>
</html>