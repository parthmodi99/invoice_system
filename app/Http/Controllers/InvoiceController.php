<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InvoiceEmail;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('invoice.index', [
            'invoices' => Invoice::all(),
            'customers' => Customer::all(),
            'materials' => Material::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoice.create', [
            'customers' => Customer::all(),
            'materials' => Material::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'invoice_number' => 'required|string|max:255',
                'date' => 'required|date',
                'customer_id' => 'required|integer',
                'material.*' => 'required|integer',
                'quantity.*' => 'required|numeric',

            ],
            [
                'material.*.required' => 'Material field is required for item :index.',
                'material.*.integer' => 'Material field must be an integer for item :index.',
                'quantity.*.required' => 'Quantity field is required for item :index.',
                'quantity.*.numeric' => 'Quantity field must be numeric for item :index.',
            ]
        );

        // Create a invoice instance
        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'subtotal' => $request->subtotal
        ]);

        // Create a invoice details instance
        foreach ($request->index as $index => $value) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'material_id' => $request->material[$index],
                'qty' => $request->quantity[$index],
                'price' => $request->price[$index],
                'total_price' => $request->total_price[$index],
            ]);
        }

        $invoice = Invoice::find($invoice->id);

        if ($request->submit_action === 'save-print') {

            return $this->print($invoice);
        } elseif ($request->submit_action === 'save-send') {

            return $this->send($invoice);
        }

        return redirect()->route('invoice.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoice.show', [
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice.edit', [
            'invoice' => $invoice,
            'customers' => Customer::all(),
            'materials' => Material::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate(
            [
                'material.*' => 'required|integer',
                'quantity.*' => 'required|numeric',

            ],
            [
                'material.*.required' => 'Material field is required for item :index.',
                'material.*.integer' => 'Material field must be an integer for item :index.',
                'quantity.*.required' => 'Quantity field is required for item :index.',
                'quantity.*.numeric' => 'Quantity field must be numeric for item :index.',
            ]
        );

        // update a invoice instance
        $invoice->update([
            'subtotal' => $request->subtotal
        ]);

        // Delete old invoice details instance
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();

        // Create a invoice details instance
        foreach ($request->index as $index => $value) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'material_id' => $request->material[$index],
                'qty' => $request->quantity[$index],
                'price' => $request->price[$index],
                'total_price' => $request->total_price[$index],
            ]);
        }

        $invoice = Invoice::find($invoice->id);

        if ($request->submit_action === 'save-print') {

            return $this->print($invoice);
        } elseif ($request->submit_action === 'save-send') {

            return $this->send($invoice);
        }

        return redirect()->route('invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Print the specified resource from storage.
     */
    public function print(Invoice $invoice)
    {
        $pdf = PDF::loadView('invoice.invoice', ['invoice' => $invoice]);

        $pdfFilename = 'invoice-' . $invoice->invoice_number . '.pdf';
        return $pdf->download($pdfFilename);
    }

    /**
     * Send the specified resource from storage.
     */
    public function send(Invoice $invoice)
    {
        Mail::to($invoice->customer->email)->send(new InvoiceEmail($invoice));
        return redirect()->route('invoice.index')->with('success', 'Invoice saved and sent successfully.');
    }
}
