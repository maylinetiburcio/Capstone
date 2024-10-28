<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class Check_Auth_Controller extends Controller
{

    public function setRole()
    {
    session(['role' => 'admin']); 
    return response()->json(['message' => 'Role set successfully']);
    }

    public function getSessionData()
    {
    return response()->json(session()->all());
    }

    public function checkAdminRole()
    {

        $role = Session::get('role');
        Log::info('Role from session: ', ['role' => $role]);
    
        $isAdmin = $role === 'admin';

        return response()->json(['isAdmin' => $isAdmin]);
    }

}
