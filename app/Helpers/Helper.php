<?php

use Carbon\Carbon;
use App\User;
use App\Models\Marketing;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Invoice;

function return_date($date)
{
    return Carbon::parse($date)->format('j F, Y. h:i a');
}

function return_date_wo_time($date){
    return Carbon::parse($date)->format('j F, Y.');
}

function return_date_pdf($date)
{
    return Carbon::parse($date)->format('j F, Y');
}

function return_todays_date()
{
    return Carbon::now();
}

function return_user_name($id)
{
    $user = User::find($id);
    return optional($user)->name;
}

function return_decimal_number($foo)
{
    return number_format((float)$foo, 2, '.', '');
}