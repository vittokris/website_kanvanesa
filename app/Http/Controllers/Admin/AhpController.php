<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AhpController extends Controller
{
    /**
     * Display the static AHP page.
     * All data is hardcoded directly in the Blade view.
     */
    public function index()
    {
        return view('admin.ahp.index');
    }
}
