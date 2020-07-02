<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferMoney extends Model
{
    protected $fillable = ['reference_no', 'from_account_id', 'to_account_id', 'amount'];
}
