<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function viewSettings(Request $request)
    {

        $member = DB::table('member')
        ->where('member.kode_member',Auth::user()->kode_member)
        ->first();
        return view('settings.viewSettings', compact('member'));
    }

}
