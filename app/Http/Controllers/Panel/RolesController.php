<?php



namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
	// home
	public function show()
	{
		$breadcrumbs = [
			['link' => "roles", 'name' => "Roles"], ['name' => "show"]
		];
		return view('/content/panel/roles', ['breadcrumbs' => $breadcrumbs]);
	}
}
