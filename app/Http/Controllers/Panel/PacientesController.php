<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class PacientesController extends Controller
{
	public function data($document, $numerodoc)
	{
		// $paciente = Pacientes::where('document_id', $document)->where('number_document', $numerodoc)->where('status', '1')->first();
		//return json_encode($paciente);
		// if ($paciente) {
		// 	return json_encode($paciente);
		// } else {
			//echo "1";
			if ($document == 1) {
				$documento = Helper::consultaDni($numerodoc);
				if (is_array($documento)) {
					return json_encode($documento);
				} else {
					echo 'null';
				}
			} else {
				echo 'null';
			}
		// }
	}
}
