<?php

namespace Api\Http\Controllers\Web\dashboard;

use Api\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Api\Events\Event;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest.redirect.back');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }
}
