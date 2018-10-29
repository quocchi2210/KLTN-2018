<?php

namespace App\Http\Controllers;

use App\Events\RedisEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RedisController extends Controller {
	public function index() {

		return view('message');
	}

	public function postSendMessage(Request $request) {
		$messages = $request->get('content');

		Log::debug('An informational message. hello ' . $messages);
		event(
			$e = new RedisEvent($messages)
		);
		return redirect()->back();
	}

}
