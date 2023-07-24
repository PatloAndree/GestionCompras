<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use App\Models\Chatsdetalles;
use App\Models\Logs;
use App\Models\Productos;
use App\Models\ProductosDetalle;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
	public function suscription(Request $request)
	{	
		$t1 = strtotime(date('Y-m-d H:i:s'));
		$t2 = strtotime("2022-11-28 14:21:00");
		$diff = $t1 - $t2;
		$hours = $diff / ( 60 * 60 );

		echo $hours;exit;
		/*$curl = curl_init();
		$curlUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations=-33.3666145,-70.6665119&origins=-33.3666609,-70.6738113&key=AIzaSyDVLlTDsSRurq1-B_HPl5ly1Mo2B997yGU';
		curl_setopt_array($curl, array(
			CURLOPT_URL => $curlUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_HTTPHEADER => array(
				'Accept' => 'application/json',
				'Content-Type' => 'application/json'
			),
			CURLOPT_CUSTOMREQUEST => 'GET',
		));
		$response = curl_exec($curl);

		curl_close($curl);
		$response_decode = json_decode($response);
		$response_decode = $response_decode->rows[0]->elements[0];
		$distanceMatrix = $response_decode->distance;
		$durationMatrix = $response_decode->duration;
		echo "<pre>";
		print_r($durationMatrix);
		echo "</pre>";
		echo "<pre>";
		print_r(date('Y-m-d H:i:s'));
		echo "</pre>";
		echo "<pre>";
		print_r(date('Y-m-d H:i:s', strtotime("+$durationMatrix->value sec")));
		echo "</pre>";
		exit;*/
		$mode = $request->hub_mode;
		$token = $request->hub_verify_token;
		$send = Mail::raw(json_encode($request->all()), function ($message) {
			$message->to('carloszavaletaramirez@gmail.com');
			$message->subject('Whatsapp api');
		});
		if ($mode && $token) {

			if ($mode === 'subscribe' && $token === 'perumedical-wsp-product-01') {
				return response($request->hub_challenge, 200)->header('Content-Type', 'text/plain');
			} else {
				return response(null, 403)->header('Content-Type', 'text/plain');
			}
		} else {
			return response(null, 403)->header('Content-Type', 'text/plain');
		}
	}

	public function whatsapp(Request $request)
	{

		/*$send = Mail::raw(json_encode($request->all()), function ($message) {
			$message->to('carloszavaletaramirez@gmail.com');
			$message->subject('Peru Medical - Inicial');
		});*/
		$logsInsert = array();
		$logsInsert['tipo'] = 'whatsapp';
		$logsInsert['contenido'] = json_encode($request->all());
		$logs = Logs::create($logsInsert);
		if (isset($request->object) && isset($request->entry)) {
			$mode = $request->object;
			$entry = $request->entry;
			$changes = (isset($entry[0]['changes'][0]) ? $entry[0]['changes'][0] : false);

			if ($changes) {
				/*$send = Mail::raw(json_encode($changes), function ($message) {
					$message->to('carloszavaletaramirez@gmail.com');
					$message->subject('Peru Medical - IF CHANGES');
				});*/
				$messages = (isset($changes['value']['messages'])) ? $changes['value']['messages'] : false;
				$contacts = (isset($changes['value']['contacts'])) ? $changes['value']['contacts'] : false;
				$statuses = (isset($changes['value']['statuses'])) ? $changes['value']['statuses'] : false;
				if ($statuses) { // VERIFICAMOS ESTADO DE UN MENSAJE
					$idmensaje = $statuses[0]['id'];
					$status = $statuses[0]['status'];

					$mensajeDB = Chatsdetalles::where('watsapp_id', $idmensaje)->first();
					if ($mensajeDB) {
						if ($status === 'delivered' && $mensajeDB->sw_leido === 0) {
							$mensajeDB->sw_leido = 1;
							$mensajeDB->update();
						}
					}
				}
				/*$send = Mail::raw(json_encode($changes), function ($message) {
					$message->to('carloszavaletaramirez@gmail.com');
					$message->subject('Peru Medical - FIRST');
				});*/
				if ($messages && $contacts) { // RECIBIENDO MENSAJE
					if (!$messages[0]['text']) {
						$send = Mail::raw(json_encode($request->all()), function ($message) {
							$message->to('carloszavaletaramirez@gmail.com');
							$message->subject('Peru Medical - Inicial');
						});
					}
					$mensajeid = $messages[0]['id'];
					$phone = $contacts[0]['wa_id']; //$messages[0]['messages'];
					$mensaje = $messages[0]['text']['body'];

					$chat = Chats::where('wa_id', $phone)->where('status', 1)->first();
					if ($chat) { // ya existe un chat.
						$dataDetalle = array();
						$dataDetalle['chat_id'] = $chat->id;
						$dataDetalle['watsapp_id'] = $mensajeid;
						$dataDetalle['mensaje'] = $mensaje;
						$dataDetalle['tipo'] = 2;
						$dataDetalle['sw_leido'] = 0;
						$dataDetalle['data_recibida'] = json_encode($request->all());
						$detalle = Chatsdetalles::create($dataDetalle);
					} else { // no existe el chat

						$usuario = User::where('phone', substr($phone, 2, 9))->where('status', 1)->first();
						if ($usuario) { //El usuario existe
							$dataChat = array();
							$dataChat['user_id'] = trim($usuario->id);
							$dataChat['wa_id'] = $phone;
							$dataChat['status'] = 1;
							$chat = Chats::create($dataChat);
							if ($chat) {
								$dataDetalle = array();
								$dataDetalle['chat_id'] = $chat->id;
								$dataDetalle['watsapp_id'] = $mensajeid;
								$dataDetalle['mensaje'] = $mensaje;
								$dataDetalle['tipo'] = 2;
								$dataDetalle['sw_leido'] = 0;
								$dataDetalle['data_recibida'] = json_encode($request->all());
								$detalle = Chatsdetalles::create($dataDetalle);
							}
						}
					}
				}
			}
		}
	}

	public function productos_stock(){
		$productos=Productos::where('status',1)->get();

		foreach ($productos as $producto) {
			Productos::where('id',$producto->id)->update([
				"stock"=>20,
				"fecha_caducidad"=>"2024-01-27"
			]);
			ProductosDetalle::create([
				"producto_id"=>$producto->id,
				"cantidad"=>20,
				"fecha_vencimiento"=>"2024-01-27",
				"status"=>1
			]);
		}
	}
}
