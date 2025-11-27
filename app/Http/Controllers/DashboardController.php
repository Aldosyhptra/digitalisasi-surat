<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function penduduk()
    {
        return view('welcome');
    }

    public function admin()
    {
        return view('admin.dashboard');
    }
}
