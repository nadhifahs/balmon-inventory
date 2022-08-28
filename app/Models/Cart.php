<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'ref_code',
        'ref_file',
        'rent_code',
        'rent_time',
        'return_time',
        'status',
        'admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function cart_detail()
    {
        return $this->hasMany(CartDetail::class);
    }
}
