<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Contract\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    private function getCurrentUserData()
    {
        $user = Session::get('firebase_user');
        $userRole = Session::get('user_role');
        
        if (!$user || !$userRole) {
            Log::warning('Missing user data in session', [
                'user' => $user ? 'exists' : 'missing',
                'role' => $userRole
            ]);
            return null;
        }

        return [
            'uid' => $user->uid,
            'email' => $user->email,
            'role' => $userRole
        ];
    }
    public function index(){

        $userData = $this->getCurrentUserData();
        if (!$userData) {
            return redirect()->route('login')
                        ->with('error', 'Your session has expired. Please login again.');
        }

        return view('dashboard.index');
    }
}
