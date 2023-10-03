@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create Invoice') }}</div>

                <div class="card-body">
                    <form action="{{ route('invoice.store') }}" method="post" id="invoiceForm">
                        @csrf
                        <ul class="alert alert-danger mt-3" style="display: @if ($errors->any()) block @else none @endif">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <label for="invoice_number" class="col-md-4 col-form-label text-md-end">{{ __('Invoice Number') }}</label>

                                    <div class="col-md-6">
                                        <input id="invoice_number" type="text" class="form-control" name="invoice_number" value="{{ __('IN00') . App\Models\Invoice::count() + 1 }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Date') }}</label>

                                    <div class="col-md-6">
                                        <input id="date" type="date" class="form-control" name="date" value="{{ old('date') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <label for="customer_id" class="col-md-4 col-form-label text-md-end">{{ __('Customer') }}</label>

                                    <div class="col-md-6">
                                        <select id="customer_id" class="form-control" name="customer_id" required>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                                <th>No</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>
                                    <a href="javascript:void(0)" class="btn btn-outline-success" id="add-field">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                            <path
                                                d="M14.513 6a.75.75 0 0 1 .75.75v2h1.987a.75.75 0 0 1 0 1.5h-1.987v2a.75.75 0 1 1-1.5 0v-2H11.75a.75.75 0 0 1 0-1.5h2.013v-2a.75.75 0 0 1 .75-.75Z">
                                            </path>
                                            <path
                                                d="M7.024 3.75c0-.966.784-1.75 1.75-1.75H20.25c.966 0 1.75.784 1.75 1.75v11.498a1.75 1.75 0 0 1-1.75 1.75H8.774a1.75 1.75 0 0 1-1.75-1.75Zm1.75-.25a.25.25 0 0 0-.25.25v11.498c0 .139.112.25.25.25H20.25a.25.25 0 0 0 .25-.25V3.75a.25.25 0 0 0-.25-.25Z">
                                            </path>
                                            <path
                                                d="M1.995 10.749a1.75 1.75 0 0 1 1.75-1.751H5.25a.75.75 0 1 1 0 1.5H3.745a.25.25 0 0 0-.25.25L3.5 20.25c0 .138.111.25.25.25h9.5a.25.25 0 0 0 .25-.25v-1.51a.75.75 0 1 1 1.5 0v1.51A1.75 1.75 0 0 1 13.25 22h-9.5A1.75 1.75 0 0 1 2 20.25l-.005-9.501Z">
                                            </path>
                                        </svg>
                                    </a>
                                </th>
                            </thead>
                            <tbody id="tbody">
                                <tr class="item">
                                    <td>
                                        <div class="form-group">
                                            <input type="number" name="index[]" class="form-control index" readonly value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="material[]" class="form-select material" required>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" name="quantity[]" class="form-control quantity" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" name="price[]" class="form-control price" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" name="total_price[]" class="form-control total_price" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-outline-danger remove-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                <path
                                                    d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z">
                                                </path>
                                                <path
                                                    d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td colspan="3">Grand Total</td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <input id="grand-total" type="number" name="subtotal" class="form-control subtotal" readonly>
                                    </div>
                                </td>
                                <td></td>
                            </tfoot>
                        </table>

                        <div class="d-flex justify-content-center">
                            <input type="hidden" id="submitButton" name="submit_action" value="">
                            <button type="button" class="m-2 btn btn-outline-success" data-action="save">Save</button>
                            <button type="button" class="m-2 btn btn-outline-success" data-action="save-print">Save & Print</button>
                            <button type="button" class="m-2 btn btn-outline-success" data-action="save-send">Save & Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // Define a mapping of material names to their corresponding prices
        const materialPrices = {!! json_encode($materials->pluck('price', 'id')) !!};

        // Function to update the price based on the selected material
        function updatePrice(selector) {
            const selectedMaterial = $(selector).val();
            const selectedPrice = materialPrices[selectedMaterial];
            const priceInput = $(selector).closest('tr').find('.price');

            if (selectedPrice !== undefined) {
                priceInput.val(selectedPrice);
            } else {
                priceInput.val(''); // Clear the price if material not found
            }
        }

        // Initial price update on page load for each material selector
        $('.material').each(function() {
            updatePrice(this);
        });

        // Update the price when any of the material selectors changes
        $(document).on('change', '.material', function () {
            updatePrice(this);
        });



        let currentIndex = 1; // Initialize the current index

        // Function to calculate total price
        function calculateTotalPrice(index) {
            const quantity = parseFloat($('.quantity').eq(index).val());
            const price = parseFloat($('.price').eq(index).val());

            if (!isNaN(quantity) && !isNaN(price)) {
                const totalPrice = quantity * price;
                $('.total_price').eq(index).val(totalPrice.toFixed(2));
            }
        }

        // Function to calculate and update Grand Total
        function updateGrandTotal() {
            let grandTotal = 0;

            $('.total_price').each(function () {
                const totalPrice = parseFloat($(this).val());
                if (!isNaN(totalPrice)) {
                    grandTotal += totalPrice;
                }
            });

            $('#grand-total').val(grandTotal.toFixed(2));
        }

        // Calculate total price on page load
        $('.quantity').each(function (index) {
            calculateTotalPrice(index);
        });

        // Calculate total price for existing and dynamically added fields
        $(document).on('input', '.quantity, .price', function () {
            const index = $(this).closest('tr').index(); // Find the index of the current row
            calculateTotalPrice(index);
            updateGrandTotal();
        });

        // Add more item fields when the "Add Item" button is clicked
        $('#add-field').click(function () {
            currentIndex++; // Increment the current index
            const newItem = `
                <tr class="item">
                    <td>
                        <div class="form-group">
                            <input type="number" name="index[]" class="form-control index" readonly value="${currentIndex}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select name="material[]" class="form-select material" required>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" name="quantity[]" class="form-control quantity" required>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" name="price[]" class="form-control price" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" name="total_price[]" class="form-control total_price" readonly>
                        </div>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-outline-danger remove-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path
                                    d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z">
                                </path>
                                <path
                                    d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z">
                                </path>
                            </svg>
                        </a>
                    </td>
                </tr>
            `;

            $('#tbody').append(newItem);
        });

        // Remove item when "Remove Item" button is clicked
        $(document).on('click', '.remove-item', function () {
            // Get the index of the row to be removed
            const indexToRemove = $(this).closest('tr').index();

            // Remove the row
            $(this).closest('tr').remove();

            // Update the index numbers of the remaining rows
            $('.index').each(function (index) {
                $(this).val(index + 1);
            });

            updateGrandTotal(); // Recalculate Grand Total
        });


        // Handle button clicks
        $('button[data-action]').click(function() {
            const action = $(this).data('action');

            $('#submitButton').val(action);
            $('#invoiceForm').submit();
        });
    });

</script>

@endsection