<?php

namespace Api\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    function action(){
    	return view('welcome');
    }
}
