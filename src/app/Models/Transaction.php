<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{

    /**
     * @var array
    */
    protected $fillable = [
        'transactionId',
        'productId',
        'userId',
        'price',
        'date'
    ];


    /**
     * @param mixed[] $attributes
    */
    public function saveSale(array $attributes)
    {
        return DB::insert('insert into transactions (transactionId, productId, userId, price, date) values (?, ?, ?, ?, ?)', [$attributes['transactionId'], $attributes['productId'], $attributes['userId'], $attributes['price'], $attributes['date']]);
    }
}
