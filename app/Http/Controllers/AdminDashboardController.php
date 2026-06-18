<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Membuka file resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }
}