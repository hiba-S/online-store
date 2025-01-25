<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'details', 'total_price', 'user_id',
    ];

    // details : {
    // cart items set
    // }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
