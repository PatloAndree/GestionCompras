<?php



namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
	// home
	public function show()
	{
		$breadcrumbs = [
			['link' => "permissions", 'name' => "Permissions"], ['name' => "Permissions"]
		];
		return view('/content/panel/permissions', ['breadcrumbs' => $breadcrumbs]);
	}
}
