<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
  public function index()
  {
    Log::info('Página Dashboard.', ['action_user_id' => Auth::id()]);

    return view('dashboard.index');
  }
}
