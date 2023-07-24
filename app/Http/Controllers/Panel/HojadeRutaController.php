<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Asistencias;
use App\Models\Hojaderuta;
use App\Models\Fechas_list;
use App\Models\DetallesCheck;
use App\Models\Hojaderutadetalle;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sedes;
use App\Models\Ubigeo;
use App\Models\Usersedes;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HojadeRutaController extends Controller
{

	public function index()
	{
		$userAuth = Auth::user();
		$data['tipo_user'] = $userAuth->type;
        return view('/content/panel/hojasderuta', $data);
	}

	public function show($hoja_id){

		ini_set('memory_limit','2048M');
		$userAuth = Auth::user();
		$fechaHoy = Carbon::now();
		// $date = $fechaHoy->format('Y-m-d');

		$conductorAsignacion = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada',date('Y-m-d'))->where('status', 1)->first();
		// $base = Sedes::where('id',$hojaderuta->sede_ambulancia)->first();
		$edit_Hoja = Hojaderuta::where('id',$hoja_id)->first();
		$data['sedesGeneral']=Sedes::where('status',1)->where('sw_ambulancia',0)->get();
	
		$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
		$data['fecha'] = date("Y-m-d");
		// $data['idCheckRuta'] = $checkList ? $checkList['id'] : "";
		// $data['nombre_piloto'] = $conductorAsignacion->usuario->name." ".$conductorAsignacion->usuario->last_name;
		if ($conductorAsignacion || $edit_Hoja ) {
			if($hoja_id==0){ //CUANDO VA A CREAR.
				$data=array();
				$conductorAsignacion = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada',date('Y-m-d'))->where('status', 1)->first();
			
				$enfermeros = Asignacionesdiarias::with('usuario')->whereHas('usuario', function ($query) {$query->where('type', 2);})->where('sede_id', $conductorAsignacion->sede_id)->where('fecha_asignada',date('Y-m-d'))->where('status', 1)->get();

				$data['sedesGeneral']=Sedes::where('status',1)->where('sw_ambulancia',0)->get();
				$base = Sedes::where('id',$conductorAsignacion->sede_id)->first();
				$data['enfermeros'] = $enfermeros;
				// $data['hojasdetalles'] = json_encode($dataDetalles);
				$data['tipo_usuario'] = $userAuth->type;
				$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
				$data['sede'] = $base->name;
				$data['sede_ambulancia'] = $base->id;

				$data['datos_ambulancia'] = $base;
				$data['distritos'] = Ubigeo::where('id_padre_ubigeo', $base->provincia_id)->get();
				$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $base->departamento_id)->get();
				$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
				$data['nombre_piloto'] = $conductorAsignacion->usuario->name." ".$conductorAsignacion->usuario->last_name;
				$data['fecha'] = date("Y-m-d");

				$horario = Fechas_list::where('id',$conductorAsignacion->horario_id)->first();

				$data['horarios']= $horario;

				$horario = Fechas_list::where('id',$conductorAsignacion->horario_id)->first();

				$checkList = DetallesCheck::where('ruta_id',$hoja_id)->first();
				$data['idCheckRuta'] = $checkList ? $checkList['id'] : "";
	
				return view('/content/panel/hojaderuta', $data );
	
	
			}else{ //CUANDO VA A MOSTAR LOS DATOS.

				$hojaderuta = Hojaderuta::with('detalles')->where('id', $hoja_id)->where('status',1 )->first();

				$conductorAsignacion = Asignacionesdiarias::where('usuario_id', $hojaderuta->piloto_id)->where('fecha_asignada',$hojaderuta->fecha_reporte )->where('status', 1)->first();
	
				$enfermeros = Asignacionesdiarias::with(['usuario'=>function($query) use($hojaderuta){
					$query->where('id',$hojaderuta->paramedico_id);
					$query->where('type', 2);
				}])

				->where('sede_id', $hojaderuta->sede_ambulancia)
				->where('fecha_asignada', $hojaderuta->fecha_reporte)
				->where('status', 1)
				->get();
				$hojaderuta = Hojaderuta::with('detalles')->where('id', $hoja_id)->where('status',1 )->first();

				$data['sedesGeneral']=Sedes::where('status',1)->where('sw_ambulancia',0)->get();
				$base = Sedes::where('id',$hojaderuta->sede_ambulancia)->first();
				// print_r($enfermeros);
				// exit;
				// print_r($enfermeros);
				// exit;
				// $data['hojasdetalles'] = json_encode($dataDetalles);
				$data['tipo_usuario'] = $userAuth->type;
				$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
				$data['sede'] = $base->name;
				$data['datos_ambulancia'] = $base;
				$data['distritos'] = Ubigeo::where('id_padre_ubigeo', $base->provincia_id)->get();
				$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $base->departamento_id)->get();
				$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
				$data['nombre_piloto'] = $conductorAsignacion->usuario->name." ".$conductorAsignacion->usuario->last_name;
				$data['fecha'] = date("Y-m-d");

				
				$horario = Fechas_list::where('id',$hojaderuta->turno_horas)->first();
				$data['horarios']= $horario;
				$checkList = DetallesCheck::where('ruta_id',$hoja_id)->first();
			
				$data['idCheckRuta'] = $checkList != "" ? $checkList['id'] : "";
				$get_km_final = Hojaderutadetalle::where('id_hoja',$hoja_id)->max('kilometraje');
				
				if($hojaderuta){
					$dataDetalles = [] ;
					foreach ($hojaderuta->detalles as $hojaD) {
					
						$distrito= Ubigeo::where('id_padre_ubigeo', $hojaD->provincia)->get();
						$provincia = Ubigeo::where('id_padre_ubigeo', $hojaD->departamento)->get();
						$departamentos= Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
		
						$arrayHojaDetalles = array(
								'id' 			 	=> $hojaD->id,
								'id_hoja'		 	=> $hojaD->id_hoja,
								'departamento'   	=> $hojaD->departamento,
								'selectDepartamento'=> $departamentos ,
								'selectProvincia' 	=> $provincia ,
								'selectDistrito' 	=> $distrito ,
								'provincia'      	=> $hojaD->provincia,
								'distrito'   	 	=> $hojaD->distrito,
								'direccion'      	=> $hojaD->direccion,
								'hora_llegada'   	=> $hojaD->hora_llegada,
								'kilometraje'    	=> $hojaD->kilometraje,
								'hora_salida'    	=> $hojaD->hora_salida
						);
						array_push($dataDetalles, $arrayHojaDetalles);
						// $dataDetalles[] .= $arrayHojaDetalles;
					}
				}

				$data=array();
				$data['sedesGeneral']=Sedes::where('status',1)->where('sw_ambulancia',0)->get();
				$data['datos_ambulancia'] = $base;
				$data['distritos'] = Ubigeo::where('id_padre_ubigeo', $base->provincia_id)->get();
				$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $base->departamento_id)->get();
				$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
				$data['horarios']=$horario;
				$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
				$data['fecha'] = date("Y-m-d");
				$data['sede'] = $base->name;
				$data['idCheckRuta'] = $checkList ? $checkList['id'] : "";
				$data['nombre_piloto'] = $conductorAsignacion->usuario->name." ".$conductorAsignacion->usuario->last_name;
				if($get_km_final != ""){
					$data['km_final'] = $get_km_final;
				}else{
					$data['km_final'] = "";
				}
				$data['hojasdetalles'] = json_encode($dataDetalles);
				$data['tipo_usuario'] = $userAuth->type;
				$data['enfermeros'] = $enfermeros[0];


				if($hojaderuta){

					$detallesCheck = DetallesCheck::where('ruta_id', $hoja_id)->where('status', 1)->first();
					if ($detallesCheck) {
						
						$rutasCheck = array(
							'ruta_id' => $detallesCheck->ruta_id,
							'obser_entrante' => $detallesCheck->obser_entrante,
							'obser_saliente' => $detallesCheck->obser_saliente,
							'ruta_incidencia' => $detallesCheck->ruta_incidencia,
							'incidencia' => $detallesCheck->incidencia,
							'pedal_embriague' => $detallesCheck->pedal_embriague,
							'pedal_freno' => $detallesCheck->pedal_freno,
							'pedal_acelera' => $detallesCheck->pedal_acelera,
							'asientos_cabezal' => $detallesCheck->asientos_cabezal,
							'espejo_retrovisor' => $detallesCheck->espejo_retrovisor,
							'freno_mano' => $detallesCheck->freno_mano,
							'cenicero' => $detallesCheck->cenicero,
							'manijas' => $detallesCheck->manijas,
							'palanca_cambios' => $detallesCheck->palanca_cambios,
							'parabrisas' => $detallesCheck->parabrisas,
							'planilla_luces' => $detallesCheck->planilla_luces,
							'radio' => $detallesCheck->radio,
							'tapasol' => $detallesCheck->tapasol,
							'tapis' => $detallesCheck->tapis,
							'extintor' => $detallesCheck->extintor,
							'estribos' => $detallesCheck->estribos,
							'mivel_aceite' => $detallesCheck->mivel_aceite,
							'freno' => $detallesCheck->freno,
							'nivel_bateria' => $detallesCheck->nivel_bateria,
							'kilometraje' => $detallesCheck->kilometraje,
							'nivel_temperatura' => $detallesCheck->nivel_temperatura,
							'reloj' => $detallesCheck->reloj,
							'nivel_combustible' => $detallesCheck->nivel_combustible,
							'mica' => $detallesCheck->mica,
							'direccionales' => $detallesCheck->direccionales,
							'pisos'  => $detallesCheck->pisos	,
							'timon_claxon' => $detallesCheck->timon_claxon,
							'ventanas' => $detallesCheck->ventanas,
							'guantera' => $detallesCheck->guantera,
							'cinturon_seguridad' => $detallesCheck->cinturon_seguridad,
							'cajonera' => $detallesCheck->cajonera,
							'tapa_combustible' => $detallesCheck->tapa_combustible,
							'agua' => $detallesCheck->agua,
							'aceite'	 => $detallesCheck->aceite,
							'liquido_freno' => $detallesCheck->liquido_freno,
							'hidrolima' => $detallesCheck->hidrolima,
							'luces_delanteras' => $detallesCheck->luces_delanteras,
							'luces_posteriores' => $detallesCheck->luces_posteriores,
							'direccion_derecho' => $detallesCheck->direccion_derecho,
							'direccion_izquierda' => $detallesCheck->direccion_izquierda,
							'luces_freno' => $detallesCheck->luces_freno,
							'luces_cabina_delantera' => $detallesCheck->luces_cabina_delantera,
							'luces_cabecera_posterior' => $detallesCheck->luces_cabecera_posterior,
							'circulina' => $detallesCheck->circulina,
							'modulo_parlantes' => $detallesCheck->modulo_parlantes,
							'tapa_com_exterior' => $detallesCheck->tapa_com_exterior,
							'espejos_laterales' => $detallesCheck->espejos_laterales,
							'mascara' => $detallesCheck->mascara,
							'plumillas' => $detallesCheck->plumillas,
							'parachoque_delantero' => $detallesCheck->parachoque_delantero,
							'parachoque_trasero' => $detallesCheck->parachoque_trasero,
							'carroceria' => $detallesCheck->carroceria,
							'neumaticos' => $detallesCheck->neumaticos,
							'tubo_escape' => $detallesCheck->tubo_escape,
							'cierre_puertas' => $detallesCheck->cierre_puertas,
							'documentos' => $detallesCheck->documentos,
							'tarjeta_propiedad' => $detallesCheck->tarjeta_propiedad,
							'soat' => $detallesCheck->soat,
							'revision_tecnica' => $detallesCheck->revision_tecnica,
							'radiador_tapa' => $detallesCheck->radiador_tapa,
							'deposito_refri' => $detallesCheck->deposito_refri,
							'baterias' => $detallesCheck->baterias,
							'arrancador' => $detallesCheck->arrancador	,
							'tapa_liquido' => $detallesCheck->tapa_liquido,
							'paletas_ventilador' => $detallesCheck->paletas_ventilador,
							'varilla_medicion' => $detallesCheck->varilla_medicion,
							'tapa_ace_motor' => $detallesCheck->tapa_ace_motor,
							'llave_ruedas'	 => $detallesCheck->llave_ruedas,
							'gato_dado_pala'	 => $detallesCheck->gato_dado_pala,
							'cono_seguridad' => $detallesCheck->cono_seguridad,
							'triangulo_segu' => $detallesCheck->triangulo_segu,
							'herramienta'	 => $detallesCheck->herramienta,
							'neumatico' => $detallesCheck->neumatico,
							'tablero' => $detallesCheck->tablero,
							'guia_calles'	 => $detallesCheck->guia_calles,
							'linterna' => $detallesCheck->linterna,
							'cable_corriente' => $detallesCheck->cable_corriente,
						);
						$data['checklist'] = $rutasCheck ;

					}

				}
				$data['data'] = $hojaderuta;
				return view('/content/panel/hojaderuta', $data );
			}

		}
		else{	
			$userAuth = Auth::user();
			$data['tipo_user'] = $userAuth->type;
			return view('/content/panel/aviso',$data);
		}
		
	
		
	}

	public function show_eye($hoja_id){
		
		$hojaderuta = Hojaderuta::with('detalles')->where('id', $hoja_id)->where('status',1 )->first();
		$rangoFecha="";
		
		$conductor=Asignacionesdiarias::where('usuario_id', $hojaderuta->piloto_id)->where('fecha_asignada',$hojaderuta->fecha_reporte )->where('status', 1)->first();

		$hoja = Hojaderuta::where('id', $hoja_id)->first();
		$sedes = Sedes::where('id',$hojaderuta->sede_id)->first(); // SEDE DE BASE
		$base = Sedes::where('id',$hojaderuta->sede_ambulancia)->first(); // SEDE AMBULANCIA
		$user = User::where('id',$hoja->paramedico_id)->first();
		$piloto = User::where('id',$hoja->piloto_id)->first();
	
		$data['datos_ambulancia'] = $base;

		$data['nombre_piloto'] = $piloto->name.' '. $piloto->last_name;
		$data['distritos'] = Ubigeo::where('id_padre_ubigeo', $base->provincia_id)->get();
		$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $base->departamento_id)->get();
		$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
		$fechaHoy = Carbon::now();
		$date = $fechaHoy->format('Y-m-d');
		$data['fecha'] = $date;
		$hojas = Hojaderuta::where('id', $hoja_id)->where('status', 1)->first();
		$detallesCheck = DetallesCheck::where('ruta_id', $hoja_id)->where('status', 1)->first();
		$hojasDetalles = Hojaderutadetalle::where('id_hoja',$hojas->id)->get();
		$get_km_final = Hojaderutadetalle::where('id_hoja',$hojas->id)->max('kilometraje');
		// where('status', 1)->max('id');
		$arrayHoja = array(
					"id" 			=> $hojas->id,
					"fecha_reporte" => $hojas->fecha_reporte,
					"paramedico_id" => $user,
					'piloto_id'   	=> $hojas->medico,
					"turno_horas"   => $hojas->turno_horas ,
					"sede_id"   	=> $hojas->sede_id ,
					"numero_vales"  => $hojas->numero_vales ,
					"valorizado"    => $hojas->valorizado ,
					"galones"   	=> $hojas->galones ,
					"km_inicial"    => $hojas->km_inicial,
					"km_final"      => $get_km_final,
					"sub_base"      => $base->name,
					"gaso1"      	=> $hojas->gaso1,
					"gaso2"      	=> $hojas->gaso2,
					"observacion"   => $hojas->observacion
				);
		$rutasCheck = array(
					'ruta_id' => $detallesCheck->ruta_id,
					'obser_entrante' => $detallesCheck->obser_entrante,
					'obser_saliente' => $detallesCheck->obser_saliente,
					'ruta_incidencia' => $detallesCheck->ruta_incidencia,
					'incidencia' => $detallesCheck->incidencia,
					'pedal_embriague' => $detallesCheck->pedal_embriague,
					'pedal_freno' => $detallesCheck->pedal_freno,
					'pedal_acelera' => $detallesCheck->pedal_acelera,
					'asientos_cabezal' => $detallesCheck->asientos_cabezal,
					'espejo_retrovisor' => $detallesCheck->espejo_retrovisor,
					'freno_mano' => $detallesCheck->freno_mano,
					'cenicero' => $detallesCheck->cenicero,
					'manijas' => $detallesCheck->manijas,
					'palanca_cambios' => $detallesCheck->palanca_cambios,
					'parabrisas' => $detallesCheck->parabrisas,
					'planilla_luces' => $detallesCheck->planilla_luces,
					'radio' => $detallesCheck->radio,
					'tapasol' => $detallesCheck->tapasol,
					'tapis' => $detallesCheck->tapis,
					'extintor' => $detallesCheck->extintor,
					'estribos' => $detallesCheck->estribos,
					'mivel_aceite' => $detallesCheck->mivel_aceite,
					'freno' => $detallesCheck->freno,
					'nivel_bateria' => $detallesCheck->nivel_bateria,
					'kilometraje' => $detallesCheck->kilometraje,
					'nivel_temperatura' => $detallesCheck->nivel_temperatura,
					'reloj' => $detallesCheck->reloj,
					'nivel_combustible' => $detallesCheck->nivel_combustible,
					'mica' => $detallesCheck->mica,
					'direccionales' => $detallesCheck->direccionales,
					'pisos'  => $detallesCheck->pisos	,
					'timon_claxon' => $detallesCheck->timon_claxon,
					'ventanas' => $detallesCheck->ventanas,
					'guantera' => $detallesCheck->guantera,
					'cinturon_seguridad' => $detallesCheck->cinturon_seguridad,
					'cajonera' => $detallesCheck->cajonera,
					'tapa_combustible' => $detallesCheck->tapa_combustible,
					'agua' => $detallesCheck->agua,
					'aceite'	 => $detallesCheck->aceite,
					'liquido_freno' => $detallesCheck->liquido_freno,
					'hidrolima' => $detallesCheck->hidrolima,
					'luces_delanteras' => $detallesCheck->luces_delanteras,
					'luces_posteriores' => $detallesCheck->luces_posteriores,
					'direccion_derecho' => $detallesCheck->direccion_derecho,
					'direccion_izquierda' => $detallesCheck->direccion_izquierda,
					'luces_freno' => $detallesCheck->luces_freno,
					'luces_cabina_delantera' => $detallesCheck->luces_cabina_delantera,
					'luces_cabecera_posterior' => $detallesCheck->luces_cabecera_posterior,
					'circulina' => $detallesCheck->circulina,
					'modulo_parlantes' => $detallesCheck->modulo_parlantes,
					'tapa_com_exterior' => $detallesCheck->tapa_com_exterior,
					'espejos_laterales' => $detallesCheck->espejos_laterales,
					'mascara' => $detallesCheck->mascara,
					'plumillas' => $detallesCheck->plumillas,
					'parachoque_delantero' => $detallesCheck->parachoque_delantero,
					'parachoque_trasero' => $detallesCheck->parachoque_trasero,
					'carroceria' => $detallesCheck->carroceria,
					'neumaticos' => $detallesCheck->neumaticos,
					'tubo_escape' => $detallesCheck->tubo_escape,
					'cierre_puertas' => $detallesCheck->cierre_puertas,
					'documentos' => $detallesCheck->documentos,
					'tarjeta_propiedad' => $detallesCheck->tarjeta_propiedad,
					'soat' => $detallesCheck->soat,
					'revision_tecnica' => $detallesCheck->revision_tecnica,
					'radiador_tapa' => $detallesCheck->radiador_tapa,
					'deposito_refri' => $detallesCheck->deposito_refri,
					'baterias' => $detallesCheck->baterias,
					'arrancador' => $detallesCheck->arrancador	,
					'tapa_liquido' => $detallesCheck->tapa_liquido,
					'paletas_ventilador' => $detallesCheck->paletas_ventilador,
					'varilla_medicion' => $detallesCheck->varilla_medicion,
					'tapa_ace_motor' => $detallesCheck->tapa_ace_motor,
					'llave_ruedas'	 => $detallesCheck->llave_ruedas,
					'gato_dado_pala'	 => $detallesCheck->gato_dado_pala,
					'cono_seguridad' => $detallesCheck->cono_seguridad,
					'triangulo_segu' => $detallesCheck->triangulo_segu,
					'herramienta'	 => $detallesCheck->herramienta,
					'neumatico' => $detallesCheck->neumatico,
					'tablero' => $detallesCheck->tablero,
					'guia_calles'	 => $detallesCheck->guia_calles,
					'linterna' => $detallesCheck->linterna,
					'cable_corriente' => $detallesCheck->cable_corriente,
		);
		$dataDetalles = [] ;
		foreach ($hojasDetalles as $hojaD) {
			
			$distrito= Ubigeo::where('id_padre_ubigeo', $hojaD->provincia)->get();
			$provincia = Ubigeo::where('id_padre_ubigeo', $hojaD->departamento)->get();
			$departamentos= Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();

			$arrayHojaDetalles = array(
					'id' 			 	=> $hojaD->id,
					'id_hoja'		 	=> $hojaD->id_hoja,
					'departamento'   	=> $hojaD->departamento,
					'selectDepartamento'=>$departamentos ,
					'selectProvincia' 	=>$provincia ,
					'selectDistrito' 	=>$distrito ,
					'provincia'      	=> $hojaD->provincia,
					'distrito'   	 	=> $hojaD->distrito,
					'direccion'      	=> $hojaD->direccion,
					'hora_llegada'   	=> $hojaD->hora_llegada,
					'kilometraje'    	=> $hojaD->kilometraje,
					'hora_salida'    	=> $hojaD->hora_salida
			);
			array_push($dataDetalles, $arrayHojaDetalles);
			// $dataDetalles[] .= $arrayHojaDetalles;
		}
		$data['hojasdetalles'] = json_encode($dataDetalles);
		$data['data'] = $arrayHoja;
		$data['checklist'] = $rutasCheck;
		$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
		$data['enfermero'] = $user->name.''.$user->last_name;
		$data['sedes'] = $sedes->name;

			return view('/content/panel/hojaderuta_show', $data );
		
	}

	public function list()
	{
		$userAuth = Auth::user();
		
		if($userAuth->type==1){
			$hojas = Hojaderuta::where('status', 1)->get();
		}else{
			$hojas = Hojaderuta::where('status', 1)->where('piloto_id',$userAuth->id)->get();
		}
		$now = Carbon::now();

		$dataHojas = [];
		foreach ($hojas as $hoja) {
			$paramedico = 	User::where('id',$hoja->paramedico_id)->where('status',1)->first();
			$piloto = 	User::where('id',$hoja->piloto_id)->where('status',1)->first();	
			$horario = 	fechas_list::where('id',$hoja->turno_horas)->where('status',1)->first();	
			$sede = 	Sedes::where('id',$hoja->sede_id)->where('status',1)->first();	
			$km_final = Hojaderutadetalle::where('id_hoja',$hoja->id)->max('kilometraje');
			$arrayHoja = array(
				"fecha_reporte" => $hoja->fecha_reporte,
				'medico'   		=> $paramedico->name,
				'piloto'  	    => $piloto->name,
				'turno_horas'   => $horario->entrada.'-'.$horario->salida ,
				'sub_base'   	=> $sede->name ,
				'km_inicial'    => $hoja->km_inicial,
				'km_final'      => $km_final,
				"actions"       => '
										'. $userAuth->type == 1 ? 
											$now->diffInSeconds($hoja->created_at) <= 172800 && $hoja->estado_hr == 2?
												'
													<div class="d-inline-flex">
														<a href="hojaderuta/show/' . $hoja->id . '" class="hoja-show" target="_blank" ><i data-feather="edit"></i></a>
													</div> 
													<div class="d-inline-flex">
														<a href="javascript:;" class="hoja-delete" data-sedeid="'. $hoja->id .'"><i data-feather="trash-2" color="red"></i></a>
													</div>
												' : 
												'
												<div class="d-inline-flex">
													<a href="hojaderuta_show/show_eye/' . $hoja->id . '" class="hoja-show" target="_blank" ><i data-feather="eye"></i></a>
												</div>
												<div class="d-inline-flex">
													<a href="javascript:;" class="hoja-delete" data-sedeid="'. $hoja->id .'"><i data-feather="trash-2" color="red"></i></a>
												</div>
												'
											: ($now->diffInSeconds($hoja->created_at) <= 172800  && $hoja->estado_hr == 2 ?  '
												<div class="d-inline-flex">
														<a href="hojaderuta/show/' . $hoja->id . '" class="hoja-show" target="_blank" ><i data-feather="edit"></i></a>
													</div> 
												' :
												'<div class="d-inline-flex">
														<a href="hojaderuta_show/show_eye/' . $hoja->id . '" class="hoja-show"  ><i data-feather="eye"></i></a>
													</div>
												'
												)
										.'
								    ' 
			
			);
			array_push($dataHojas, (object)$arrayHoja);
			
		}
		$dataReturn['data'] = $dataHojas;
		return json_encode($dataReturn);
	}

	public function create(Request $request)
	{
		$userAuth = Auth::user();
		$fechaHoy = Carbon::now();
		$date = $fechaHoy->format('Y-m-d');
		$conductor = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada',$date  )->where('status', 1)->first();
	
		// para sacar sede
		$validator = Validator::make($request->all(), [
			'hoja_fecha' => 'required|date',
			'hoja_paramedico' => 'required|int',
			'select_horario' => 'required|int',
			'select_base' => 'required|int',
			'observacion_hoja' => 'required|string',
			'hoja_km_inicial' => 'required|integer'
			// 'hoja_gaso1' => 'required|integer',
		]);
	
		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		if($userAuth->type == 4 || $userAuth->type == 2 ){
			if($conductor)
			{
				$dataHoja = array();
				$dataHoja['fecha_reporte'] = trim($request->hoja_fecha);
				$dataHoja['paramedico_id'] = trim($request->hoja_paramedico);
				$dataHoja['piloto_id'] = trim($userAuth->id);
				$dataHoja['turno_horas'] = trim($request->select_horario);
				$dataHoja['sede_id'] = trim($request->select_base);
				$dataHoja['sede_ambulancia'] = trim($request->sede_ambulancia);
				$dataHoja['km_inicial'] = trim($request->hoja_km_inicial);
				$dataHoja['gaso1'] = trim($request->hoja_gaso1);
				$dataHoja['gaso2'] = trim($request->hoja_gaso2);
				$dataHoja['numero_vales'] = trim($request->n_vales);
				$dataHoja['valorizado'] = trim($request->valorizado);
				$dataHoja['galones'] = trim($request->galones);
				$dataHoja['observacion'] = trim($request->observacion_hoja);
				$dataHoja['observacion_admin'] = trim($request->observacion_admin);

				if($dataHoja){
					$Hojas = Hojaderuta::create($dataHoja);
					$hojasrutas = json_decode($request->hojadetalle);
					if (isset($hojasrutas)) {
						foreach ($hojasrutas as $hoja) {
							$InsertHojaDetalle = array();
							$InsertHojaDetalle['id_hoja'] = $Hojas->id;
							$InsertHojaDetalle['direccion'] = $hoja->direccion;
							$InsertHojaDetalle['departamento'] = $hoja->departamento;
							$InsertHojaDetalle['provincia'] = $hoja->provincia;
							$InsertHojaDetalle['distrito'] = $hoja->distrito;
							$InsertHojaDetalle['hora_llegada'] = $hoja->llegada;
							$InsertHojaDetalle['kilometraje'] = $hoja->kilometraje;
							$InsertHojaDetalle['hora_salida'] = $hoja->salida;
							Hojaderutadetalle::create($InsertHojaDetalle);
						}

					}
				}
			}
			
		}

	
		if(isset($dataHoja)){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la sede"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "da"));
		}
		
	}	

	public function saveCheck(Request $request)
	{
		$value = $request['nuevoArreglo'];
		$checks = json_decode($value, true);
		// print_r($for[0]['value'].'-'.$for[1]['value']);
		// die();
		$userAuth = Auth::user();
		$fechaHoy = Carbon::now();
		$date = $fechaHoy->format('Y-m-d');
		$conductor = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada',$date  )->where('status', 1)->first();

		if($userAuth->type == 4 || $userAuth->type == 2 ){
			if($conductor)
			{
					$arrayCheck = array();
					$arrayCheck['ruta_id'] = $request['idruta'];
					$arrayCheck['obser_entrante'] = $request['obser_entrada'];	
					$arrayCheck['obser_saliente'] = $request['obser_salida'];	
					$imagen = $request['file']->store('public/incidencias');
					$url = Storage::url($imagen);
					$arrayCheck['ruta_incidencia'] = $url;	
					$arrayCheck['incidencia'] =  $request['observacion_incidencia'];	
					$arrayCheck['pedal_embriague'] = $checks[0]['value'];	
					$arrayCheck['pedal_freno'] = $checks[1]['value'];	
					$arrayCheck['pedal_acelera'] = $checks[2]['value'];	
					$arrayCheck['asientos_cabezal'] = $checks[3]['value'];	
					$arrayCheck['espejo_retrovisor'] = $checks[4]['value'];	
					$arrayCheck['freno_mano'] = $checks[5]['value'];	
					$arrayCheck['cenicero'] = $checks[6]['value'];	
					$arrayCheck['manijas'] = $checks[7]['value'];	
					$arrayCheck['palanca_cambios'] = $checks[8]['value'];	
					$arrayCheck['parabrisas'] = $checks[9]['value'];	
					$arrayCheck['planilla_luces'] = $checks[10]['value'];	
					$arrayCheck['radio'] = $checks[11]['value'];	
					$arrayCheck['tapasol'] = $checks[12]['value'];	
					$arrayCheck['tapis'] = $checks[13]['value'];	
					$arrayCheck['extintor'] = $checks[14]['value'];	
					$arrayCheck['estribos'] = $checks[15]['value'];	
					$arrayCheck['mivel_aceite'] = $checks[16]['value'];	
					$arrayCheck['freno'] = $checks[17]['value'];	
					$arrayCheck['nivel_bateria'] = $checks[18]['value'];	
					$arrayCheck['kilometraje'] = $checks[19]['value'];	
					$arrayCheck['nivel_temperatura'] = $checks[20]['value'];	
					$arrayCheck['reloj'] = $checks[21]['value'];	
					$arrayCheck['nivel_combustible'] = $checks[22]['value'];	
					$arrayCheck['mica'] = $checks[23]['value'];	
					$arrayCheck['direccionales'] = $checks[24]['value'];	
					$arrayCheck['pisos' ] = $checks[25]['value'];
					$arrayCheck['timon_claxon'] = $checks[26]['value'];	
					$arrayCheck['ventanas'] = $checks[27]['value'];	
					$arrayCheck['guantera'] = $checks[28]['value'];	
					$arrayCheck['cinturon_seguridad'] = $checks[29]['value'];	
					$arrayCheck['cajonera'] = $checks[30]['value'];	
					$arrayCheck['tapa_combustible'] = $checks[31]['value'];	
					$arrayCheck['agua'] = $checks[32]['value'];	
					$arrayCheck['aceite'] = $checks[33]['value'];
					$arrayCheck['liquido_freno'] = $checks[34]['value'];	
					$arrayCheck['hidrolima'] = $checks[35]['value'];	
					$arrayCheck['luces_delanteras'] = $checks[36]['value'];	
					$arrayCheck['luces_posteriores'] = $checks[37]['value'];	
					$arrayCheck['direccion_derecho'] = $checks[38]['value'];	
					$arrayCheck['direccion_izquierda'] = $checks[39]['value'];	
					$arrayCheck['luces_freno'] = $checks[40]['value'];	
					$arrayCheck['luces_cabina_delantera'] = $checks[41]['value'];	
					$arrayCheck['luces_cabecera_posterior'] = $checks[42]['value'];	
					$arrayCheck['circulina'] = $checks[43]['value'];	
					$arrayCheck['modulo_parlantes'] = $checks[44]['value'];	
					$arrayCheck['tapa_com_exterior'] = $checks[45]['value'];	
					$arrayCheck['espejos_laterales'] = $checks[46]['value'];	
					$arrayCheck['mascara'] = $checks[47]['value'];	
					$arrayCheck['plumillas'] = $checks[48]['value'];	
					$arrayCheck['parachoque_delantero'] = $checks[49]['value'];	
					$arrayCheck['parachoque_trasero'] = $checks[50]['value'];	
					$arrayCheck['carroceria'] = $checks[51]['value'];	
					$arrayCheck['neumaticos'] = $checks[52]['value'];	
					$arrayCheck['tubo_escape'] = $checks[53]['value'];	
					$arrayCheck['cierre_puertas'] = $checks[54]['value'];	
					$arrayCheck['documentos'] = $checks[55]['value'];	
					$arrayCheck['tarjeta_propiedad'] = $checks[56]['value'];	
					$arrayCheck['soat'] = $checks[57]['value'];	
					$arrayCheck['revision_tecnica'] = $checks[58]['value'];	
					$arrayCheck['radiador_tapa'] = $checks[59]['value'];	
					$arrayCheck['deposito_refri'] = $checks[60]['value'];	
					$arrayCheck['baterias'] = $checks[61]['value'];	
					$arrayCheck['arrancador'] = $checks[62]['value'];
					$arrayCheck['tapa_liquido'] = $checks[63]['value'];	
					$arrayCheck['paletas_ventilador'] = $checks[64]['value'];	
					$arrayCheck['varilla_medicion'] = $checks[65]['value'];	
					$arrayCheck['tapa_ace_motor'] = $checks[66]['value'];	
					$arrayCheck['llave_ruedas'] = $checks[67]['value'];
					$arrayCheck['gato_dado_pala'	] = $checks[68]['value'];
					$arrayCheck['cono_seguridad'] = $checks[69]['value'];	
					$arrayCheck['triangulo_segu'] = $checks[70]['value'];	
					$arrayCheck['herramienta'] = $checks[71]['value'];
					$arrayCheck['neumatico'] = $checks[72]['value'];	
					$arrayCheck['tablero'] = $checks[73]['value'];	
					$arrayCheck['guia_calles'] = $checks[74]['value'];
					$arrayCheck['linterna'] = $checks[75]['value'];	
					$arrayCheck['cable_corriente'] = $checks[76]['value'];
					DetallesCheck::create($arrayCheck);
				}
			}
			
	
		if($conductor){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la sede"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "2"));
		}
		
	}

	public function updateCheck(Request $request, $checkId )
	{
		$value = $request['nuevoArreglo'];
		$checks = json_decode($value, true);
		$userAuth = Auth::user();
		$fechaHoy = Carbon::now();
		$date = $fechaHoy->format('Y-m-d');
		$conductor = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada',$date  )->where('status', 1)->first();

		if($userAuth->type == 4 || $userAuth->type == 2 ){
			if($conductor)
			{
					$arrayCheck = array();
					$arrayCheck['ruta_id'] = $request['idruta'];
					$arrayCheck['obser_entrante'] = $request['obser_entrada'];	
					$arrayCheck['obser_saliente'] = $request['obser_salida'];	
					$imagen = $request['file']->store('public/incidencias');
					$url = Storage::url($imagen);
					$arrayCheck['ruta_incidencia'] = $url;	
					$arrayCheck['incidencia'] =  $request['observacion_incidencia'];	
					$arrayCheck['pedal_embriague'] = $checks[0]['value'];	
					$arrayCheck['pedal_freno'] = $checks[1]['value'];	
					$arrayCheck['pedal_acelera'] = $checks[2]['value'];	
					$arrayCheck['asientos_cabezal'] = $checks[3]['value'];	
					$arrayCheck['espejo_retrovisor'] = $checks[4]['value'];	
					$arrayCheck['freno_mano'] = $checks[5]['value'];	
					$arrayCheck['cenicero'] = $checks[6]['value'];	
					$arrayCheck['manijas'] = $checks[7]['value'];	
					$arrayCheck['palanca_cambios'] = $checks[8]['value'];	
					$arrayCheck['parabrisas'] = $checks[9]['value'];	
					$arrayCheck['planilla_luces'] = $checks[10]['value'];	
					$arrayCheck['radio'] = $checks[11]['value'];	
					$arrayCheck['tapasol'] = $checks[12]['value'];	
					$arrayCheck['tapis'] = $checks[13]['value'];	
					$arrayCheck['extintor'] = $checks[14]['value'];	
					$arrayCheck['estribos'] = $checks[15]['value'];	
					$arrayCheck['mivel_aceite'] = $checks[16]['value'];	
					$arrayCheck['freno'] = $checks[17]['value'];	
					$arrayCheck['nivel_bateria'] = $checks[18]['value'];	
					$arrayCheck['kilometraje'] = $checks[19]['value'];	
					$arrayCheck['nivel_temperatura'] = $checks[20]['value'];	
					$arrayCheck['reloj'] = $checks[21]['value'];	
					$arrayCheck['nivel_combustible'] = $checks[22]['value'];	
					$arrayCheck['mica'] = $checks[23]['value'];	
					$arrayCheck['direccionales'] = $checks[24]['value'];	
					$arrayCheck['pisos' ] = $checks[25]['value'];
					$arrayCheck['timon_claxon'] = $checks[26]['value'];	
					$arrayCheck['ventanas'] = $checks[27]['value'];	
					$arrayCheck['guantera'] = $checks[28]['value'];	
					$arrayCheck['cinturon_seguridad'] = $checks[29]['value'];	
					$arrayCheck['cajonera'] = $checks[30]['value'];	
					$arrayCheck['tapa_combustible'] = $checks[31]['value'];	
					$arrayCheck['agua'] = $checks[32]['value'];	
					$arrayCheck['aceite'] = $checks[33]['value'];
					$arrayCheck['liquido_freno'] = $checks[34]['value'];	
					$arrayCheck['hidrolima'] = $checks[35]['value'];	
					$arrayCheck['luces_delanteras'] = $checks[36]['value'];	
					$arrayCheck['luces_posteriores'] = $checks[37]['value'];	
					$arrayCheck['direccion_derecho'] = $checks[38]['value'];	
					$arrayCheck['direccion_izquierda'] = $checks[39]['value'];	
					$arrayCheck['luces_freno'] = $checks[40]['value'];	
					$arrayCheck['luces_cabina_delantera'] = $checks[41]['value'];	
					$arrayCheck['luces_cabecera_posterior'] = $checks[42]['value'];	
					$arrayCheck['circulina'] = $checks[43]['value'];	
					$arrayCheck['modulo_parlantes'] = $checks[44]['value'];	
					$arrayCheck['tapa_com_exterior'] = $checks[45]['value'];	
					$arrayCheck['espejos_laterales'] = $checks[46]['value'];	
					$arrayCheck['mascara'] = $checks[47]['value'];	
					$arrayCheck['plumillas'] = $checks[48]['value'];	
					$arrayCheck['parachoque_delantero'] = $checks[49]['value'];	
					$arrayCheck['parachoque_trasero'] = $checks[50]['value'];	
					$arrayCheck['carroceria'] = $checks[51]['value'];	
					$arrayCheck['neumaticos'] = $checks[52]['value'];	
					$arrayCheck['tubo_escape'] = $checks[53]['value'];	
					$arrayCheck['cierre_puertas'] = $checks[54]['value'];	
					$arrayCheck['documentos'] = $checks[55]['value'];	
					$arrayCheck['tarjeta_propiedad'] = $checks[56]['value'];	
					$arrayCheck['soat'] = $checks[57]['value'];	
					$arrayCheck['revision_tecnica'] = $checks[58]['value'];	
					$arrayCheck['radiador_tapa'] = $checks[59]['value'];	
					$arrayCheck['deposito_refri'] = $checks[60]['value'];	
					$arrayCheck['baterias'] = $checks[61]['value'];	
					$arrayCheck['arrancador'] = $checks[62]['value'];
					$arrayCheck['tapa_liquido'] = $checks[63]['value'];	
					$arrayCheck['paletas_ventilador'] = $checks[64]['value'];	
					$arrayCheck['varilla_medicion'] = $checks[65]['value'];	
					$arrayCheck['tapa_ace_motor'] = $checks[66]['value'];	
					$arrayCheck['llave_ruedas'] = $checks[67]['value'];
					$arrayCheck['gato_dado_pala'	] = $checks[68]['value'];
					$arrayCheck['cono_seguridad'] = $checks[69]['value'];	
					$arrayCheck['triangulo_segu'] = $checks[70]['value'];	
					$arrayCheck['herramienta'] = $checks[71]['value'];
					$arrayCheck['neumatico'] = $checks[72]['value'];	
					$arrayCheck['tablero'] = $checks[73]['value'];	
					$arrayCheck['guia_calles'] = $checks[74]['value'];
					$arrayCheck['linterna'] = $checks[75]['value'];	
					$arrayCheck['cable_corriente'] = $checks[76]['value'];
					DetallesCheck::where('id', $checkId)->update($arrayCheck);
				}
			}
			
	
		if($conductor){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la sede"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "s"));
		}
		
	}

	public function update(Request $request , $hoja)
	{
		$userAuth = Auth::user();
		$fechaHoy = Carbon::now();
		$date = $fechaHoy->format('Y-m-d');
		// $conductor = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada',$date  )->where('status', 1)->first();

		if($userAuth->type == 4 || $userAuth->type == 2 || $userAuth->type == 1){
			// if($conductor)
			// {
				$dataHoja = array();
				$dataHoja['sede_id'] = trim($request->select_base);
				$dataHoja['km_inicial'] = trim($request->hoja_km_inicial);
				$dataHoja['gaso1'] = trim($request->hoja_gaso1);
				$dataHoja['gaso2'] = trim($request->hoja_gaso2);
				$dataHoja['numero_vales'] = trim($request->n_vales);
				$dataHoja['valorizado'] = trim($request->valorizado);
				$dataHoja['galones'] = trim($request->galones);
				$dataHoja['observacion_admin'] = trim($request->observacion_admin);
				$dataHoja['observacion'] = trim($request->observacion_hoja);
				$dataHoja['estado_hr'] = trim($request->estado_hr);

				if($dataHoja){
					$Hojas = Hojaderuta::where('id', $hoja)->update($dataHoja);
					Hojaderutadetalle::where('id_hoja', $hoja)->delete();
					$hojasrutas = json_decode($request->hojadetalle);
					
					if ($Hojas) {
						foreach ($hojasrutas as $hojita) {
							// echo($hoja->)
							$InsertHojaDetalle = array();
							$InsertHojaDetalle['id_hoja'] = $hoja;
							$InsertHojaDetalle['direccion'] = $hojita->direccion;
							$InsertHojaDetalle['departamento'] = $hojita->departamento;
							$InsertHojaDetalle['provincia'] = $hojita->provincia;
							$InsertHojaDetalle['distrito'] = $hojita->distrito;
							$InsertHojaDetalle['hora_llegada'] = $hojita->llegada;
							$InsertHojaDetalle['kilometraje'] = $hojita->kilometraje;
							$InsertHojaDetalle['hora_salida'] = $hojita->salida;
							Hojaderutadetalle::create($InsertHojaDetalle);
						}
					}
				// }
			}
		}
		if($dataHoja){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo correctamente la hoja de ruta"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "intentelo de nuevo" ));
		}
		
	}	
	
	// public function generatePDF(Request $request, $hoja)
	public function generatePDF($hoja_id)
    {
				
		$userAuth = Auth::user();
		$fechaHoy = Carbon::now();
		$date = $fechaHoy->format('Y-m-d');
		$hojaderuta = Hojaderuta::with('detalles')->where('id', $hoja_id)->where('status',1 )->first();

				$conductorAsignacion = Asignacionesdiarias::where('usuario_id', $hojaderuta->piloto_id)->where('fecha_asignada',$hojaderuta->fecha_reporte )->where('status', 1)->first();
	
				$enfermeros = Asignacionesdiarias::with(['usuario'=>function($query) use($hojaderuta){
					$query->where('id',$hojaderuta->paramedico_id);
					$query->where('type', 2);
				}])

				->where('sede_id', $hojaderuta->sede_ambulancia)
				->where('fecha_asignada', $hojaderuta->fecha_reporte)
				->where('status', 1)
				->get();
				$hojaderuta = Hojaderuta::with('detalles')->where('id', $hoja_id)->where('status',1 )->first();

				$data['sedesGeneral']=Sedes::where('status',1)->where('sw_ambulancia',0)->get();
				$base = Sedes::where('id',$hojaderuta->sede_ambulancia)->first();
				$data['enfermeros'] = $enfermeros;
				// $data['hojasdetalles'] = json_encode($dataDetalles);
				$data['tipo_usuario'] = $userAuth->type;
				$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
				$data['sede'] = $base->name;
				$data['datos_ambulancia'] = $base;
				$data['distritos'] = Ubigeo::where('id_padre_ubigeo', $base->provincia_id)->get();
				$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $base->departamento_id)->get();
				$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
				$data['nombre_piloto'] = $conductorAsignacion->usuario->name." ".$conductorAsignacion->usuario->last_name;
				$data['fecha'] = date("Y-m-d");

				
				$horario = Fechas_list::where('id',$hojaderuta->turno_horas)->first();
				$data['horarios']= $horario;
				$checkList = DetallesCheck::where('ruta_id',$hoja_id)->first();
				$data['idCheckRuta'] = $checkList ? $checkList['id'] : "";
				
				if($hojaderuta){
					$dataDetalles = [] ;
					foreach ($hojaderuta->detalles as $hojaD) {
					
						$distrito= Ubigeo::where('id', $hojaD->distrito)->first();
		
						$arrayHojaDetalles = array(
								'id' 			 	=> $hojaD->id,
								'id_hoja'		 	=> $hojaD->id_hoja,
								'departamento'   	=> $hojaD->departamento,
								'provincia'      	=> $hojaD->provincia,
								'distrito'   	 	=> $distrito->nombre_ubigeo,
								'direccion'      	=> $hojaD->direccion,
								'hora_llegada'   	=> $hojaD->hora_llegada,
								'kilometraje'    	=> $hojaD->kilometraje,
								'hora_salida'    	=> $hojaD->hora_salida
						);
						array_push($dataDetalles, $arrayHojaDetalles);
						// $dataDetalles[] .= $arrayHojaDetalles;
					
					}
				}
			

				$data=array();
				$data['sedesGeneral']=Sedes::where('status',1)->where('sw_ambulancia',0)->get();
				$data['datos_ambulancia'] = $base;
				$data['distritos'] = Ubigeo::where('id_padre_ubigeo', $base->provincia_id)->get();
				$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $base->departamento_id)->get();
				$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', $base->pais_id)->get();
				$data['horarios']=$horario;
				$data['hoja'] = $hoja_id != "" ? $hoja_id : 0;
				$data['fecha'] = date("Y-m-d");
				$data['sede'] = $base->name;
				$data['idCheckRuta'] = $checkList ? $checkList['id'] : "";
				$data['nombre_piloto'] = $conductorAsignacion->usuario->name." ".$conductorAsignacion->usuario->last_name;
				$data['enfermeros'] = $enfermeros[1];
				$data['hojasdetalles'] = $dataDetalles != "" ? $dataDetalles : "" ;
				$data['tipo_usuario'] = $userAuth->type;

		$detallesCheck = DetallesCheck::where('ruta_id', $hoja_id)->where('status', 1)->first();
		$rutasCheck = array(
			'ruta_id' => $detallesCheck->ruta_id,
			'obser_entrante' => $detallesCheck->obser_entrante,
			'obser_saliente' => $detallesCheck->obser_saliente,
			'ruta_incidencia' => $detallesCheck->ruta_incidencia,
			'incidencia' => $detallesCheck->incidencia,
			'pedal_embriague' => $detallesCheck->pedal_embriague,
			'pedal_freno' => $detallesCheck->pedal_freno,
			'pedal_acelera' => $detallesCheck->pedal_acelera,
			'asientos_cabezal' => $detallesCheck->asientos_cabezal,
			'espejo_retrovisor' => $detallesCheck->espejo_retrovisor,
			'freno_mano' => $detallesCheck->freno_mano,
			'cenicero' => $detallesCheck->cenicero,
			'manijas' => $detallesCheck->manijas,
			'palanca_cambios' => $detallesCheck->palanca_cambios,
			'parabrisas' => $detallesCheck->parabrisas,
			'planilla_luces' => $detallesCheck->planilla_luces,
			'radio' => $detallesCheck->radio,
			'tapasol' => $detallesCheck->tapasol,
			'tapis' => $detallesCheck->tapis,
			'extintor' => $detallesCheck->extintor,
			'estribos' => $detallesCheck->estribos,
			'mivel_aceite' => $detallesCheck->mivel_aceite,
			'freno' => $detallesCheck->freno,
			'nivel_bateria' => $detallesCheck->nivel_bateria,
			'kilometraje' => $detallesCheck->kilometraje,
			'nivel_temperatura' => $detallesCheck->nivel_temperatura,
			'reloj' => $detallesCheck->reloj,
			'nivel_combustible' => $detallesCheck->nivel_combustible,
			'mica' => $detallesCheck->mica,
			'direccionales' => $detallesCheck->direccionales,
			'pisos'  => $detallesCheck->pisos	,
			'timon_claxon' => $detallesCheck->timon_claxon,
			'ventanas' => $detallesCheck->ventanas,
			'guantera' => $detallesCheck->guantera,
			'cinturon_seguridad' => $detallesCheck->cinturon_seguridad,
			'cajonera' => $detallesCheck->cajonera,
			'tapa_combustible' => $detallesCheck->tapa_combustible,
			'agua' => $detallesCheck->agua,
			'aceite'	 => $detallesCheck->aceite,
			'liquido_freno' => $detallesCheck->liquido_freno,
			'hidrolima' => $detallesCheck->hidrolima,
			'luces_delanteras' => $detallesCheck->luces_delanteras,
			'luces_posteriores' => $detallesCheck->luces_posteriores,
			'direccion_derecho' => $detallesCheck->direccion_derecho,
			'direccion_izquierda' => $detallesCheck->direccion_izquierda,
			'luces_freno' => $detallesCheck->luces_freno,
			'luces_cabina_delantera' => $detallesCheck->luces_cabina_delantera,
			'luces_cabecera_posterior' => $detallesCheck->luces_cabecera_posterior,
			'circulina' => $detallesCheck->circulina,
			'modulo_parlantes' => $detallesCheck->modulo_parlantes,
			'tapa_com_exterior' => $detallesCheck->tapa_com_exterior,
			'espejos_laterales' => $detallesCheck->espejos_laterales,
			'mascara' => $detallesCheck->mascara,
			'plumillas' => $detallesCheck->plumillas,
			'parachoque_delantero' => $detallesCheck->parachoque_delantero,
			'parachoque_trasero' => $detallesCheck->parachoque_trasero,
			'carroceria' => $detallesCheck->carroceria,
			'neumaticos' => $detallesCheck->neumaticos,
			'tubo_escape' => $detallesCheck->tubo_escape,
			'cierre_puertas' => $detallesCheck->cierre_puertas,
			'documentos' => $detallesCheck->documentos,
			'tarjeta_propiedad' => $detallesCheck->tarjeta_propiedad,
			'soat' => $detallesCheck->soat,
			'revision_tecnica' => $detallesCheck->revision_tecnica,
			'radiador_tapa' => $detallesCheck->radiador_tapa,
			'deposito_refri' => $detallesCheck->deposito_refri,
			'baterias' => $detallesCheck->baterias,
			'arrancador' => $detallesCheck->arrancador	,
			'tapa_liquido' => $detallesCheck->tapa_liquido,
			'paletas_ventilador' => $detallesCheck->paletas_ventilador,
			'varilla_medicion' => $detallesCheck->varilla_medicion,
			'tapa_ace_motor' => $detallesCheck->tapa_ace_motor,
			'llave_ruedas'	 => $detallesCheck->llave_ruedas,
			'gato_dado_pala'	 => $detallesCheck->gato_dado_pala,
			'cono_seguridad' => $detallesCheck->cono_seguridad,
			'triangulo_segu' => $detallesCheck->triangulo_segu,
			'herramienta'	 => $detallesCheck->herramienta,
			'neumatico' => $detallesCheck->neumatico,
			'tablero' => $detallesCheck->tablero,
			'guia_calles'	 => $detallesCheck->guia_calles,
			'linterna' => $detallesCheck->linterna,
			'cable_corriente' => $detallesCheck->cable_corriente,
		);
		$paramedico = 	User::where('id',$hojaderuta->paramedico_id)->where('status',1)->first();
		$piloto = 	User::where('id',$hojaderuta->piloto_id)->where('status',1)->first();	
		$horario = 	fechas_list::where('id',$hojaderuta->turno_horas)->where('status',1)->first();	
		$sede = 	Sedes::where('id',$hojaderuta->sede_id)->where('status',1)->first();	
		$sede_amblancia = 	Sedes::where('id',$hojaderuta->sede_ambulancia)->where('status',1)->first();	
		$km_final = Hojaderutadetalle::where('id_hoja',$hojaderuta->id)->max('kilometraje');

		$data['paramedico'] = $paramedico->name.' '. $paramedico->last_name;
		$data['piloto'] = $piloto->name.' '.$piloto->last_name;
		$data['turno_horas'] = $horario->entrada.' - '.$horario->salida;
		$data['sub_base'] = $sede->name;
		$data['sede_ambulancia'] = $sede_amblancia->name ;
		$data['km_final'] = $km_final;


		$data['data'] = $hojaderuta;
		$data['checklist'] = $rutasCheck;
		$pdf = PDF::loadView('/content/panel/myPDF', $data);
		return $pdf->download('archivo.pdf');
    }

	public function delete(Request $request, $hoja)
	{
		$Hojas = Hojaderuta::where('id',$hoja)->update(['status'=>0]);
		echo json_encode(array("sw_error" => 0, "message" => "Se elimino la hoja de ruta."));
	}
}



