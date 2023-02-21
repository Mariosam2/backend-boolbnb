<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'name', 'stripe_id', 'stripe_status', 'stripe_price', 'quantity', 'trial_ends_at', 'ends_at'];
    /**
     * Get the apartment that owns the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    /**
     * Get the product that owns the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
