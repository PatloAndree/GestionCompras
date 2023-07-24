<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Sedes;
use App\Models\User;
use App\Models\Fechas_list;
use App\Models\Userscronograma;
use App\Models\Usersedes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PdfController extends Controller
{
	
	public function index()
	{
	
		return view('/content/panel/myPDF');
	}
}