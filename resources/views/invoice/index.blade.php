@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            {{ __('Invoice list') }}
                        </div>
                        <div>
                            <a href="{{ route('invoice.create') }}" class="btn btn-outline-primary float-end"> Add Invoice</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Date</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->date }}</td>
                                    <td>{{ $invoice->customer->name}}</td>
                                    <td>{{ $invoice->subtotal }}</td>
                                    <td>
                                        <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-outline-info m-1">Show</a>
                                            <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-outline-primary m-1">Edit</a>
                                            <button type="submit" class="btn btn-outline-danger m-1">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection