<?php

use Carbon\Carbon;
use App\Models\Marketing;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\User;

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

function count_by_type($type){
    if($type == "All"){
        $count = count(User::all());
    }
    else{
        $count = count(User::where('type', $type)->get());
    }
    
    return $count;
}

function getIp(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return server ip when no client ip found
}