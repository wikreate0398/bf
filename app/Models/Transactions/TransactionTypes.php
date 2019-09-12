<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.05.2019
 * Time: 22:16
 */

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    public $timestamps = false;

    protected $table = 'transaction_types';

    protected $fillable = [
        'var',
        'name_ru',
        'name_ro',
        'name_en'
    ];
}