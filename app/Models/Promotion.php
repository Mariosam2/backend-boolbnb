<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'price', 'duration'];

    /**
     * The apartments that belong to the Promotion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apartments(): BelongsToMany
    {
        return $this->belongsToMany(Apartment::class);
    }
}
