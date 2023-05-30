<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'apartment_category_id', 'title', 'slug', 'description', 'visible', 'mq', 'address', 'free_form_address', 'latitude', 'longitude', 'beds', 'total_rooms', 'baths', 'media', 'guests', 'check_in', 'check_out', 'price',];

    public static function slugGenerator($title)
    {
        $apartmentSlug = Str::slug($title);
        return $apartmentSlug;
    }
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }


    /**
     * Get the user associated with the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The services that belong to the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }


    /**
     * Get all of the messages for the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }


    /**
     * Get all of the views for the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }


    /**
     * Get the apartment_category that owns the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function apartment_category(): BelongsTo
    {
        return $this->belongsTo(ApartmentCategory::class);
    }
}
