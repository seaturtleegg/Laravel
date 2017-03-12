<?php

namespace App\Http\Controllers\Welcome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class WelcomeController extends Controller
{
	public function index(){
		$cards = \DB::table('client_WorkOrder')->get();
		
		return view('welcome', compact('cards'));
	}
	
	public function login(){
		return view('login');
	}
}
