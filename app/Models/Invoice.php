<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\InvoiceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'date',
        'customer_id',
        'subtotal',
    ];

    /**
     * Get the details for the invoice.
     */
    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    /**
     * Get the customer for the the invoice.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
