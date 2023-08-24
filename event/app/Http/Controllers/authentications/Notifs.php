<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Notifs extends Controller
{
  public function index(Request $request)
  {
	if(isset($request->msg)){
		$massage = $request->msg;
	}else{
		$massage = '';
	}
	
	if(isset($request->type)){
		$type = $request->type;
		//success
	}else{
		$type = 'question';
	}
	
	if(isset($request->redir)){
		$redir = $request->redir;
	}else{
		$redir = route('pages-home');
	}
	  
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-notifs', ['pageConfigs' => $pageConfigs, 'massage' => $massage, 'type' => $type, 'redir' => $redir]);
  }
}