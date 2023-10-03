<?php

namespace App\Http\Controllers\APIs;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Store a newly created material in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMaterial(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:materials',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }


        // Create a new material using the validated data
        $material = Material::create($validator->safe()->only([
            'code', 'name', 'price'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Material created successfully',
        ], 201);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeCustomer(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:customers',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }


        // Create a new customer using the validated data
        $customer = Customer::create($validator->safe()->only([
            'code', 'name', 'email', 'address'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
        ], 201);
    }

    /**
     * Get a list of invoices.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoice()
    {
        return response()->json([
            'status' => true,
            'message' => 'customer created successfully',
            'data' => Invoice::with('details')->get()
        ], 200);
    }
}
