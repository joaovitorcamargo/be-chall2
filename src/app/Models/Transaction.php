<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->create($attributes);
    }
}
