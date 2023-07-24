<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Asistencias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:6');
	}

	public function index()
	{
	
	

			return view('/content/panel/calendario');
	}


}
