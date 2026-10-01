<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    public function users()
{
    $customers = User::where('role', 'customer')
        ->latest()
        ->get();

    $totalCustomers = $customers->count();

    return view('admin.users', compact(
        'customers',
        'totalCustomers'
    ));
}
}
