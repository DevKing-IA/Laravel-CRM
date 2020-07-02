<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable =[

        "site_title", "site_logo", "currency", "currency_position", "sale_invoice_initial_number", "pos_invoice_initial_number" ,"staff_access", "date_format", "theme",
    ];
}
