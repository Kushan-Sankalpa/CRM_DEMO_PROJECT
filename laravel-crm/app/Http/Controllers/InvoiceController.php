<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $request->customer_id,
            'invoice_number' => 'INV-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT),
            'amount' => $request->amount,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $invoice->update($request->all());
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function updateStatus(Invoice $invoice, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        $invoice->status = $request->status;
        $invoice->save();
        return redirect()->route('invoices.index')->with('success', 'Invoice status updated.');
    }

    public function send(Invoice $invoice)
    {
        Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));
        return redirect()->route('invoices.index')->with('success', 'Invoice sent successfully.');
    }

    public function pay(Invoice $invoice)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Invoice #' . $invoice->invoice_number,
                    ],
                    'unit_amount' => $invoice->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('invoices.payment.success', $invoice),
            'cancel_url' => route('invoices.payment.cancel', $invoice),
        ]);

        $invoice->update(['stripe_payment_id' => $session->id]);

        return redirect()->to($session->url);
    }

    public function paymentSuccess(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        return redirect()->route('invoices.index')->with('success', 'Payment successful.');
    }

    public function paymentCancel(Invoice $invoice)
    {
        $invoice->update(['status' => 'failed']);
        return redirect()->route('invoices.index')->with('error', 'Payment cancelled.');
    }
}