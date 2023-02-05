<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'apartment_category_id', 'title', 'description', 'visible', 'square_meters', 'address', 'latitude', 'longitude', 'beds', 'total_rooms', 'baths', 'media', 'guests', 'check_in', 'check_out', 'price'];
}
