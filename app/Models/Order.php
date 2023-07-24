<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'product', 'public', 'secret_key'];

    public function scopeActive(Builder $query) :void
    {
        $query->where('public', 1);
    }
}
