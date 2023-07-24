<?php



namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asistencias;
use App\Models\Fichas;
use App\Models\Sedes;
use App\Models\User;
use App\Models\Userscronograma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesController extends Controller
{
	// home


	public function __construct()
	{
		$this->middleware('role:1,6');
	}

	public function index()
	{
		$data['sedes'] = Sedes::where('status', 1)->get();
		return view('/content/panel/reportes', $data);
	}

	public function reporte_atenciones_topico($sedes, $range)
	{

		$fecha = explode('|', $range);
		$fechaInicio = $fecha[0];
		$fechaFin = $fecha[1];
		if ($sedes > 0) {
			$fichas = Fichas::where('sede_id', $sedes)->where('status', 1)->whereBetween('date_of_attention', [$fechaInicio, $fechaFin])->get();
			$sede = Sedes::where('id', $sedes)->first();
			$textSede = 'REGISTRO DE ATENCIONES TÓPICO ' . strtoupper($sede->name . ' - ' . $sede->departamento->nombre_ubigeo . ', ' . $sede->provincia->nombre_ubigeo . ', ' . $sede->distrito->nombre_ubigeo);
		} else {
			$fichas = Fichas::where('status', 1)->whereBetween('date_of_attention', [$fechaInicio, $fechaFin])->get();
			$textSede = 'REGISTRO DE ATENCIONES EN TODOS LOS TÓPICOS';
		}
		//$fichas = Fichas::where('sede_id', $sedes)->where('status', 1)->whereBetween('date_of_attention', [$fechaInicio, $fechaFin])->get();
		$sede = Sedes::where('id', $sedes)->first();


		$fechaInicioCarbon = Carbon::createFromFormat('Y-m-d', $fechaInicio);
		$fechaInicioCarbon->locale();
		$fechaFinCarbon = Carbon::createFromFormat('Y-m-d', $fechaFin);
		$fechaFinCarbon->locale();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(8);
		$sheet->getColumnDimension('C')->setWidth(45);
		$sheet->getColumnDimension('D')->setWidth(6);
		$sheet->getColumnDimension('E')->setWidth(6);
		$sheet->getColumnDimension('F')->setWidth(10);
		$sheet->getColumnDimension('G')->setWidth(80);
		$sheet->getColumnDimension('H')->setWidth(80);
		$sheet->getColumnDimension('I')->setWidth(80);
		$sheet->getColumnDimension('J')->setWidth(30);
		$sheet->getColumnDimension('K')->setWidth(50);
		$sheet->getColumnDimension('L')->setWidth(80);
		$sheet->getColumnDimension('M')->setWidth(80);
		$sheet->getColumnDimension('N')->setWidth(15);

		$spreadsheet->getActiveSheet()->mergeCells('C2:H2');
		$spreadsheet->getActiveSheet()->setCellValue('C2', $textSede);
		//$sheet->getStyle('C2')->getAlignment()->setHorizontal('center');



		$spreadsheet->getActiveSheet()->mergeCells('C3:H3');
		$month_inicio = Helper::getMonthSpanish($fechaInicioCarbon->format('n'));
		$month_fin = Helper::getMonthSpanish($fechaFinCarbon->format('n'));
		$spreadsheet->getActiveSheet()->setCellValue('C3', strtoupper('Del ' . $fechaInicioCarbon->format('d') . ' ' . $month_inicio . ' del ' . $fechaInicioCarbon->format('Y') . ' al ' . $fechaFinCarbon->format('d') . ' ' . $month_fin . ' del ' . $fechaInicioCarbon->format('Y')));
		$sheet->getStyle('C2:C3')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('C2:C3')->getFont()->setBold(true);


		$spreadsheet->getActiveSheet()->setCellValue('A6', 'FECHA');
		$spreadsheet->getActiveSheet()->setCellValue('B6', 'HORA');
		$spreadsheet->getActiveSheet()->setCellValue('C6', 'APELLIDOS Y NOMBRES');
		$spreadsheet->getActiveSheet()->setCellValue('D6', 'SEXO');
		$spreadsheet->getActiveSheet()->setCellValue('E6', 'EDAD');
		$spreadsheet->getActiveSheet()->setCellValue('F6', 'DNI');
		$spreadsheet->getActiveSheet()->setCellValue('G6', 'DIAGNÓSTICO');
		$spreadsheet->getActiveSheet()->setCellValue('H6', 'TRATAMIENTO');
		$spreadsheet->getActiveSheet()->setCellValue('I6', 'ATENCIÒN');
		$spreadsheet->getActiveSheet()->setCellValue('J6', 'CATEGORIA');
		$spreadsheet->getActiveSheet()->setCellValue('K6', 'LICENCIADA(O)');
		$spreadsheet->getActiveSheet()->setCellValue('L6', 'OBSERVACIONES');
		$spreadsheet->getActiveSheet()->setCellValue('M6', 'RECEPCIÓN DE FICHA');
		$spreadsheet->getActiveSheet()->getStyle('A6:M6')->getFont()->setBold(true);;
		$fila = 7;
		$consultas = 0;
		$urgencias = 0;
		$emergencias = 0;
		$accidentes = 0;
		foreach ($fichas as $ficha) {
			$atencion = Carbon::createFromFormat('Y-m-d', $ficha->date_of_attention);
			$hour_of_attention_start = Carbon::createFromFormat('H:i:s', $ficha->hour_of_attention_start);
			$recepcion = Carbon::createFromFormat('Y-m-d H:i:s', $ficha->created_at);
			$spreadsheet->getActiveSheet()->setCellValue('A' . $fila, $atencion->format('d-M'));
			$spreadsheet->getActiveSheet()->setCellValue('B' . $fila, $hour_of_attention_start->format('h:i'));

			$spreadsheet->getActiveSheet()->setCellValue('C' . $fila, $ficha->paciente->name . ' ' . $ficha->paciente->last_name);
			$sex = 'F';
			if ($ficha->paciente->sex == 1) {
				$sex = 'M';
			}
			$spreadsheet->getActiveSheet()->setCellValue('D' . $fila, $sex);
			$spreadsheet->getActiveSheet()->setCellValue('E' . $fila, $ficha->paciente->age);
			$spreadsheet->getActiveSheet()->setCellValue('F' . $fila, $ficha->paciente->number_document);
			$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, $ficha->diagnosis);
			$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, $ficha->treatment);
			$atencion = '';
			if ($ficha->type_of_attention == 1) {
				$atencion = 'Consulta';
				$consultas++;
			} else if ($ficha->type_of_attention == 2) {
				$atencion = 'Urgencia';
				$urgencias++;
			} else if ($ficha->type_of_attention == 3) {
				$atencion = 'Emergencia';
				$emergencias++;
			} else if ($ficha->type_of_attention == 4) {
				$atencion = 'Accidente';
				$accidentes++;
			}
			$spreadsheet->getActiveSheet()->setCellValue('I' . $fila, $atencion);
			$spreadsheet->getActiveSheet()->setCellValue('J' . $fila, '');
			$spreadsheet->getActiveSheet()->setCellValue('K' . $fila, $ficha->usuario->name . ' ' . $ficha->usuario->last_name);
			$spreadsheet->getActiveSheet()->setCellValue('L' . $fila, $ficha->treatment);
			$spreadsheet->getActiveSheet()->setCellValue('M' . $fila, $recepcion->format('d-m-Y h:i'));
			$fila++;
		}
		$fila = $fila + 2;
		//$spreadsheet->getActiveSheet()->setCellValue('I' . $fila, $atencion);
		// add some text
		$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, 'TOTAL DE ATENCIONES');
		$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, count($fichas));
		$fila++;
		$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, 'CONSULTAS');
		$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, $consultas);
		$fila++;
		$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, 'ACCIDENTES');
		$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, $accidentes);
		$fila++;
		$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, 'URGENCIAS');
		$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, $urgencias);
		$fila++;
		$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, 'EMERGENCIAS');
		$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, $emergencias);
		$fila++;
		$fila++;
		$spreadsheet->getActiveSheet()->setCellValue('G' . $fila, 'TOTAL DE TRASLADOS');
		$spreadsheet->getActiveSheet()->setCellValue('H' . $fila, '0');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $textSede . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}

	public function reporte_horastrabajadas_topico($sedes, $range)
	{

		$fecha = explode('|', $range);
		$fechaInicio = $fecha[0];
		$fechaFin = $fecha[1];
		$dias = array("D", "L", "M", "M", "J", "V", "S");

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(35);
		$sheet->mergeCells('C6:D7');
		$sheet->mergeCells('E6:E7');

		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal('center');
		$spreadsheet->getDefaultStyle()->getAlignment()->setVertical('center');
		$sheet->getStyle('C6:D8')->getAlignment()->setHorizontal('center');

		$usuarios = User::where('status', 1)->get();

		//$sheet = $sheet->getStyle('D2:G8')->applyFromArray($styleArray);

		$spreadsheet->getActiveSheet()->setCellValue('C6', "HORAS TRABAJADAS POR EL PERSONAL \n " . date("d-m-Y", strtotime($fechaInicio)) . ' AL ' .  date("d-m-Y", strtotime($fechaFin)));
		$spreadsheet->getActiveSheet()->setCellValue('C8', "Nombre");
		$spreadsheet->getActiveSheet()->setCellValue('D8', "Tipo usuario");
		$spreadsheet->getActiveSheet()->setCellValue('E8', "Sede");
		$spreadsheet->getActiveSheet()->getStyle('C6')->getAlignment()->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle('C6:E8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
		$spreadsheet->getActiveSheet()->getStyle('C6:E8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

		$initialColum = 6;
		#
		for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
			$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
			$spreadsheet->getActiveSheet()->mergeCells($columnaLetra . '6:' . $columnaLetra . '7');
			$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '6', $dias[date('w', $i)]);
			$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '8', date("d", $i));

			$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
			if (date('w', $i) == 0) {
				$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF');
				$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
			}

			$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
			$sheet->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getAlignment()->setHorizontal('center');


			$initialColum++;
		}

		$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
		$spreadsheet->getActiveSheet()->mergeCells($columnaLetra . '6:' . $columnaLetra . '8');
		$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '6', 'Horas');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		$sheet->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getAlignment()->setHorizontal('center');

		$initialColum++;

		$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
		$spreadsheet->getActiveSheet()->mergeCells($columnaLetra . '6:' . $columnaLetra . '8');
		$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '6', 'Soles');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		$sheet->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getAlignment()->setHorizontal('center');


		$initialColumY = 9;

		foreach ($usuarios as $usuario) {

			if ($usuario->type == 1) {
				$tipousuario = 'Administrador';
			} else if ($usuario->type == 2) {
				$tipousuario = 'Enfermero';
			} else if ($usuario->type == 3) {
				$tipousuario = 'Doctor';
			} else if ($usuario->type == 4) {
				$tipousuario = 'Conductor';
			} else if ($usuario->type == 5) {
				$tipousuario = 'Call center';
			} elseif ($usuario->type == 6) {
				$tipousuario = 'Supervisor';
			} else {
				$tipousuario = 'no definido';
			}

			if ($sedes > 0) {
				$asistenciasede = Asistencias::where('usuario_registrado_id', $usuario->id)->whereHas('asignacion', function ($q, $sedes) {
					$q->where('sede_id', $sedes);
				})->get();
			} else {
				$asistenciasede = Asistencias::where('usuario_registrado_id', $usuario->id)->get();
			}

			$spreadsheet->getActiveSheet()->setCellValue('C' . $initialColumY, $usuario->name . ' ' . $usuario->last_name);
			$spreadsheet->getActiveSheet()->setCellValue('D' . $initialColumY, $tipousuario);
			$columnaLetra = 6;
			$initialColumLetra = 6;
			if (count($asistenciasede) > 0) {
				$spreadsheet->getActiveSheet()->setCellValue('E' . $initialColumY, '-');
				$initialColum = 6;
				$totalHoras = "00:00";
				$totalSoles = 0.00;
				for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
					$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
					$fechaSearch = date("Y-m-d", $i);
					$fechaAsistencia = Asistencias::where('usuario_registrado_id', $usuario->id)->whereNotNull('horasalida')->where('fechaingreso', $fechaSearch)->where('status', 1)->first();
					$horas = '00:00';
					if ($fechaAsistencia) {
						$fechaIngreso = Carbon::createFromFormat('Y-m-d H:i:s', $fechaAsistencia->fechaingreso . ' ' . $fechaAsistencia->horaingreso);
						$fechaSalida = Carbon::createFromFormat('Y-m-d H:i:s', $fechaAsistencia->fechasalida . ' ' . $fechaAsistencia->horasalida);
						$diferenciaenhoras = $fechaIngreso->diffInHours($fechaSalida) . ':' . $fechaIngreso->diff($fechaSalida)->format('%I');
						//CALCULOS HORAS MINUTOS
						$horas = $diferenciaenhoras;
						$horasN = explode(":", $horas);
						$hN = $horasN[0];
						$mN = $horasN[1];
						$horaInit = explode(":", $totalHoras);
						$hInit = $horaInit[0];
						$mInit = $horaInit[1];
						$sumaHoras = (int)$hN + (int)$hInit;

						$sumaMinutos = (int)$mN + (int)$mInit;
						$sumaHoras += (int)($sumaMinutos / 60);
						$sumaMinutos = $sumaMinutos % 60;
						if ($sumaMinutos < 10) $sumaMinutos = "0" . $sumaMinutos;
						$totalHoras = $sumaHoras . ":" . $sumaMinutos;
						//CALCULO MONTO TOTAL
						$total = (float)60; // Obtener total de la base de datos
						$porcentaje = ((float)$sumaMinutos * 100) / $total; // Regla de tres
						$porcentaje = round($porcentaje, 0);  // Quitar los decimales
						$totalSoles += round($fechaAsistencia->factor * ((float)($sumaHoras . "." . $porcentaje)), 2);
					}
					$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $horas);
					$initialColum++;
				}
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalHoras);
				$initialColum++;
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalSoles);
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('E' . $initialColumY, '-');
				$initialColum = 6;
				$totalHoras = "00:00";
				$totalSoles = 0.00;
				for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
					$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);

					$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalHoras);
					$initialColum++;
				}
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalHoras);
				$initialColum++;
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalSoles);
			}
			$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
			$spreadsheet->getActiveSheet()->getStyle('C' . $initialColumY . ':' . $columnaLetra . $initialColumY)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
			$initialColumY++;
		}



		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
	}

	public function reporte_disponibilidad($range)
	{
		$fecha = explode('|', $range);
		$fechaInicio = $fecha[0];
		$fechaFin = $fecha[1];
		$dias = array("D", "L", "M", "M", "J", "V", "S");

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(45);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(35);
		$sheet->getColumnDimension('F')->setWidth(35);

		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal('center');
		$spreadsheet->getDefaultStyle()->getAlignment()->setVertical('center');
		$sheet->getStyle('B2:F2')->getAlignment()->setHorizontal('center');

		//$spreadsheet->getActiveSheet()->setCellValue('C2', 'Fecha');
		$spreadsheet->getActiveSheet()->setCellValue('B2', 'Rol');
		$spreadsheet->getActiveSheet()->setCellValue('C2', 'Usuario');

		$initialColum = 4;
		for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
			$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
			$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '2',  date("d/m/Y", $i));
			$spreadsheet->getActiveSheet()->getColumnDimension($columnaLetra)->setWidth(25);
			$initialColum++;
		}
		/*
		
		$spreadsheet->getActiveSheet()->setCellValue('F2', 'Jornada');
		$spreadsheet->getActiveSheet()->getStyle('C2:F2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$spreadsheet->getActiveSheet()->getStyle('C2:F2')->getFont()->setBold(true);
		
		#*/
		$initialColum = 3;
		$firstColumn = 3;
		$usuarios = User::where('status', 1)->get();
		ini_set('max_execution_time', 180);
		foreach ($usuarios as $usuario) {
			if ($usuario->type == 1) {
				$tipousuario = 'Administrador';
			} else if ($usuario->type == 2) {
				$tipousuario = 'Enfermero';
			} else if ($usuario->type == 3) {
				$tipousuario = 'Doctor';
			} else if ($usuario->type == 4) {
				$tipousuario = 'Conductor';
			} else if ($usuario->type == 5) {
				$tipousuario = 'Call center';
			} elseif ($usuario->type == 6) {
				$tipousuario = 'Supervisor';
			} else {
				$tipousuario = 'no definido';
			}

			$spreadsheet->getActiveSheet()->setCellValue('B' . $initialColum, $tipousuario);
			$spreadsheet->getActiveSheet()->setCellValue('C' . $initialColum, $usuario->name . ' ' . $usuario->last_name);
			$initialColumFecha = 4;
			//$cronograma = collect($usuario->cronograma)Userscronograma::whereBetween('fecha', [$fechaInicio, $fechaFin])->where('status', 1)->get();
			for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColumFecha);
				$cronograma = collect($usuario->cronograma)->where('fecha', date("Y-m-d", $i))->where('status', 1)->where('user_id', $usuario->id)->first();
				if ($cronograma) {
					if ($cronograma->jornada == 1) {
						$tipoJornada = 'Tiempo completo';
					} else if ($cronograma->jornada == 2) {
						$tipoJornada = 'Día';
					} else if ($cronograma->jornada == 3) {
						$tipoJornada = 'Noche';
					} else {
						$tipoJornada = 'no definido';
					}
					$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColum,  $tipoJornada);
				} else {
					$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColum,  '');
				}

				$initialColumFecha++;
			}
			$initialColum++;
		}

		if ($initialColum > 3) {
			$initialColum = $initialColum - 1;
			$initialColumFecha = $initialColumFecha - 1;
		}

		$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColumFecha);

		$spreadsheet->getActiveSheet()->getStyle('B2:' . $columnaLetra . $initialColum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$spreadsheet->getActiveSheet()->getStyle('B2:' . $columnaLetra . '2')->getFont()->setBold(true);;
		$sheet->getStyle('C3:C' . $initialColum)->getAlignment()->setHorizontal('left');
		$sheet->getStyle('B3:B' . $initialColum)->getAlignment()->setHorizontal('left');
		//$sheet->getStyle('C2:F2')->getAlignment()->setHorizontal('center');
		/*
		for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
			//echo date("d/m/Y", $i) . '<br>';

			$usuarios = DB::table('users')->join('userscronograma', 'users.id', '=', 'userscronograma.user_id')->where('userscronograma.status', 1)->where('users.status', 1)->where('userscronograma.fecha', date("Y-m-d", $i))->get();
			foreach ($usuarios as $usuario) {
				if ($usuario->type == 1) {
					$tipousuario = 'Administrador';
				} else if ($usuario->type == 2) {
					$tipousuario = 'Enfermero';
				} else if ($usuario->type == 3) {
					$tipousuario = 'Doctor';
				} else if ($usuario->type == 4) {
					$tipousuario = 'Conductor';
				} else if ($usuario->type == 5) {
					$tipousuario = 'Call center';
				} else {
					$tipousuario = 'no definido';
				}

				if ($usuario->jornada == 1) {
					$tipoJornada = 'Tiempo completo';
				} else if ($usuario->jornada == 2) {
					$tipoJornada = 'Día';
				} else if ($usuario->jornada == 3) {
					$tipoJornada = 'Noche';
				} else {
					$tipoJornada = 'no definido';
				}

				$spreadsheet->getActiveSheet()->setCellValue('D' . $initialColum, $usuario->name . ' ' . $usuario->last_name);
				$spreadsheet->getActiveSheet()->setCellValue('E' . $initialColum, $tipousuario);
				$spreadsheet->getActiveSheet()->setCellValue('F' . $initialColum, $tipoJornada);
				$spreadsheet->getActiveSheet()->getStyle('C' . $initialColum . ':F' . $initialColum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				$initialColum++;
			}
			if (count($usuarios) > 0) {
				$spreadsheet->getActiveSheet()->mergeCells('C' . $firstColumn . ':C' . ($initialColum - 1));

				$spreadsheet->getActiveSheet()->getStyle('C' . $firstColumn . ':C' . ($initialColum - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				$sheet->getStyle('C' . $firstColumn . ':C' . ($initialColum - 1))->getAlignment()->setHorizontal('center');
				$spreadsheet->getActiveSheet()->setCellValue('C' . $firstColumn, date("d/m/Y", $i));
				$spreadsheet->getActiveSheet()->getStyle('C' . $firstColumn . ':C' . ($initialColum - 1))->getFont()->setBold(true);
				$initialColum = $initialColum;
				$firstColumn = $initialColum;
			} else {
				$spreadsheet->getActiveSheet()->mergeCells('C' . $firstColumn . ':C' . $initialColum);
				$sheet->getStyle('C' . $firstColumn . ':C' . $initialColum)->getAlignment()->setHorizontal('center');
				$spreadsheet->getActiveSheet()->getStyle('C' . $firstColumn . ':F' . $initialColum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				$spreadsheet->getActiveSheet()->setCellValue('C' . $firstColumn, date("d/m/Y", $i));

				$spreadsheet->getActiveSheet()->getStyle('C' . $firstColumn . ':F' . $initialColum)->getFont()->setBold(true);
				$initialColum++;
				$initialColum = $initialColum;
				$firstColumn = $initialColum;
			}
		}*/
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Reporte de disponibilidad.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;






		//$sheet = $sheet->getStyle('D2:G8')->applyFromArray($styleArray);

		$spreadsheet->getActiveSheet()->setCellValue('C6', "HORAS TRABAJADAS POR EL PERSONAL \n " . date("d-m-Y", strtotime($fechaInicio)) . ' AL ' .  date("d-m-Y", strtotime($fechaFin)));
		$spreadsheet->getActiveSheet()->setCellValue('C8', "Nombre");
		$spreadsheet->getActiveSheet()->setCellValue('D8', "Tipo usuario");
		$spreadsheet->getActiveSheet()->setCellValue('E8', "Sede");
		$spreadsheet->getActiveSheet()->getStyle('C6')->getAlignment()->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle('C6:E8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
		$spreadsheet->getActiveSheet()->getStyle('C6:E8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

		$initialColum = 6;
		#
		for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
			$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
			$spreadsheet->getActiveSheet()->mergeCells($columnaLetra . '6:' . $columnaLetra . '7');
			$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '6', $dias[date('w', $i)]);
			$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '8', date("d", $i));

			$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
			if (date('w', $i) == 0) {
				$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF');
				$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
			}

			$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
			$sheet->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getAlignment()->setHorizontal('center');


			$initialColum++;
		}

		$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
		$spreadsheet->getActiveSheet()->mergeCells($columnaLetra . '6:' . $columnaLetra . '8');
		$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '6', 'Horas');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		$sheet->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getAlignment()->setHorizontal('center');

		$initialColum++;

		$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
		$spreadsheet->getActiveSheet()->mergeCells($columnaLetra . '6:' . $columnaLetra . '8');
		$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . '6', 'Soles');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
		$spreadsheet->getActiveSheet()->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
		$sheet->getStyle($columnaLetra . '6:' . $columnaLetra . '8')->getAlignment()->setHorizontal('center');


		$initialColumY = 9;

		foreach ($usuarios as $usuario) {

			if ($usuario->type == 1) {
				$tipousuario = 'Administrador';
			} else if ($usuario->type == 2) {
				$tipousuario = 'Enfermero';
			} else if ($usuario->type == 3) {
				$tipousuario = 'Doctor';
			} else if ($usuario->type == 4) {
				$tipousuario = 'Conductor';
			} else if ($usuario->type == 5) {
				$tipousuario = 'Call center';
			} elseif ($usuario->type == 6) {
				$tipousuario = 'Supervisor';
			} else {
				$tipousuario = 'no definido';
			}

			/*if ($sedes > 0) {
				$asistenciasede = Asistencias::where('usuario_registrado_id', $usuario->id)->whereHas('asignacion', function ($q, $sedes) {
					$q->where('sede_id', $sedes);
				})->get();
			} else {
				$asistenciasede = Asistencias::where('usuario_registrado_id', $usuario->id)->get();
			}*/

			/*$spreadsheet->getActiveSheet()->setCellValue('C' . $initialColumY, $usuario->name . ' ' . $usuario->last_name);
			$spreadsheet->getActiveSheet()->setCellValue('D' . $initialColumY, $tipousuario);
			$columnaLetra = 6;
			$initialColumLetra = 6;
			if (count($asistenciasede) > 0) {
				$spreadsheet->getActiveSheet()->setCellValue('E' . $initialColumY, '-');
				$initialColum = 6;
				$totalHoras = "00:00";
				$totalSoles = 0.00;
				for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
					$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
					$fechaSearch = date("Y-m-d", $i);
					$fechaAsistencia = Asistencias::where('usuario_registrado_id', $usuario->id)->whereNotNull('horasalida')->where('fechaingreso', $fechaSearch)->where('status', 1)->first();
					$horas = '00:00';
					if ($fechaAsistencia) {
						$fechaIngreso = Carbon::createFromFormat('Y-m-d H:i:s', $fechaAsistencia->fechaingreso . ' ' . $fechaAsistencia->horaingreso);
						$fechaSalida = Carbon::createFromFormat('Y-m-d H:i:s', $fechaAsistencia->fechasalida . ' ' . $fechaAsistencia->horasalida);
						$diferenciaenhoras = $fechaIngreso->diffInHours($fechaSalida) . ':' . $fechaIngreso->diff($fechaSalida)->format('%I');
						//CALCULOS HORAS MINUTOS
						$horas = $diferenciaenhoras;
						$horasN = explode(":", $horas);
						$hN = $horasN[0];
						$mN = $horasN[1];
						$horaInit = explode(":", $totalHoras);
						$hInit = $horaInit[0];
						$mInit = $horaInit[1];
						$sumaHoras = (int)$hN + (int)$hInit;

						$sumaMinutos = (int)$mN + (int)$mInit;
						$sumaHoras += (int)($sumaMinutos / 60);
						$sumaMinutos = $sumaMinutos % 60;
						if ($sumaMinutos < 10) $sumaMinutos = "0" . $sumaMinutos;
						$totalHoras = $sumaHoras . ":" . $sumaMinutos;
						//CALCULO MONTO TOTAL
						$total = (float)60; // Obtener total de la base de datos
						$porcentaje = ((float)$sumaMinutos * 100) / $total; // Regla de tres
						$porcentaje = round($porcentaje, 0);  // Quitar los decimales
						$totalSoles += round($fechaAsistencia->factor * ((float)($sumaHoras . "." . $porcentaje)), 2);
					}
					$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $horas);
					$initialColum++;
				}
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalHoras);
				$initialColum++;
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalSoles);
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('E' . $initialColumY, '-');
				$initialColum = 6;
				$totalHoras = "00:00";
				$totalSoles = 0.00;
				for ($i = strtotime($fechaInicio); $i <= strtotime($fechaFin); $i += 86400) {
					$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);

					$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalHoras);
					$initialColum++;
				}
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalHoras);
				$initialColum++;
				$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
				$spreadsheet->getActiveSheet()->setCellValue($columnaLetra . $initialColumY, $totalSoles);
			}
			$columnaLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($initialColum);
			$spreadsheet->getActiveSheet()->getStyle('C' . $initialColumY . ':' . $columnaLetra . $initialColumY)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
			$initialColumY++;*/
		}



		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
	}
}
