<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingExtraCharge extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'booking_extra_charges';
    protected $fillable = [
        'booking_id', 'title', 'price', 'qty'
    ];
    protected $casts = [
        'price'    => 'double',
        'qty'   => 'integer',
        'booking_id'   => 'integer',
    ];
}
