<?php

namespace App\Services;

use App\Repositories\LogoRepository;
use App\Models\Logo;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
// use Hash;

class LogoService extends LogoRepository
{
    public function toggle_logo_status($id)
    {
        if(!$logo = Logo::find($id)){
            return '';
        }

        $logo->status = (($logo->status == "Inactive") ? ("Active") : "Inactive");
        $logo->save();
        return '';
    }
}