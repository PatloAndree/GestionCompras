<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigController extends Controller
{
	public function clearRoute()
	{
		Artisan::call('cache:clear');
		Artisan::call('optimize');
		Artisan::call('route:cache');
		Artisan::call('route:clear');
		Artisan::call('view:clear');
		Artisan::call('config:cache');
	}
}
