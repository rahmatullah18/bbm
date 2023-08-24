<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePage extends Controller
{
	public function index()
	{
		//$users = DB::table('tuser')->get();

		//var_dump($users);

		//if(session()->has('username')){
		session()->pull('menu_active');
		session(['menu_active' => 'marketing']);
		return view('content.pages.pages-home');

		/*}else{
		
		$err_msg = 'Anda belum login.';
		redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
	}*/
	}

	public function portalBBM()
	{
		return view('content.pages.pages-portal');
	}

	public function finance()
	{
		session()->pull('menu_active');
		session(['menu_active' => 'finance']);
		return view('content.pages.pages-finance');
	}


	public function update(Request $request)
	{
		$usr = $request->user();
		var_dump($usr);
	}
}
