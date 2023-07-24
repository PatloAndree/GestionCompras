<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Asignacionesdiarias;
use App\Models\Chats;
use App\Models\Chatsdetalles;
use App\Models\Configuraciones;
use App\Models\Whatsapp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class MensajesController extends Controller
{
	function sendAsignacionDiaria()
	{

		$credenciales = Configuraciones::where('id', 1)->where('status', 1)->first();
		if ($credenciales) {
			$whatsapp = Whatsapp::where('id', 1)->where('status', 1)->first();
			$headerComponent = json_decode($whatsapp->header);
			$bodyComponent = json_decode($whatsapp->body);
			$usuariosAsignaciones = Asignacionesdiarias::where('status', 1)->where('fecha_asignada', Carbon::tomorrow()->format('Y-m-d'))->get();
			foreach ($usuariosAsignaciones as $usuarioAsignacion) {
				$headerComponent->parameters[0]->text = 'Buenas tardes ' . $usuarioAsignacion->usuario->name . ' ' . $usuarioAsignacion->usuario->last_name;
				$bodyComponent->parameters[0]->text =  Helper::getDaySpanish(Carbon::tomorrow()->format('w')) . ' ' . Carbon::tomorrow()->format('d/m/Y');
				$bodyComponent->parameters[1]->text = $usuarioAsignacion->sede->name;
				$phone = '51' . $usuarioAsignacion->usuario->phone;
				$header = [
					'Accept' => 'application/json',
					'Authorization' => 'Bearer ' . $credenciales->configuracion1
				];
				$body = [
					'messaging_product' => 'whatsapp',
					'to' => $phone,
					'type' => 'template',
					'template' => [
						'name' => $whatsapp->lista,
						'language' => [
							'code' => 'es'
						],
						'components' => array($headerComponent, $bodyComponent)
					]
				];

				$response = Http::withHeaders($header)->post('https://graph.facebook.com/v14.0/' . $credenciales->configuracion2 . '/messages', $body);
				$responseDecode = json_decode($response);
				if (isset($responseDecode->error)) {
					$send = Mail::raw(json_encode($responseDecode->error), function ($message) {
						$message->to('carloszavaletaramirez@gmail.com');
						$message->subject('Asignacion Diaria - Error');
					});
				} else {
					$mensajeTemplate = '<strong>' . $headerComponent->parameters[0]->text . '</strong><br>
										📌Se le recuerda que mañana ' . $bodyComponent->parameters[0]->text . ' tiene turno en Perú Medical.🚑📝 <br>
										La sede asignada para mañana es <strong>' . $bodyComponent->parameters[1]->text . '<strong>.<br>
										Por favor salir con anticipación para que llegue a tiempo .<br>
										Confirmar lectura.<br>
										<small>Saludos cordiales - Perú Medical</small>';
					$chatwsp = Chats::where('user_id', $usuarioAsignacion->usuario_id)->first();
					if ($chatwsp) { //EXISTENTE
						$dataDetalle = array();
						$dataDetalle['chat_id'] = $chatwsp->id;
						$dataDetalle['mensaje'] = $mensajeTemplate;
						$dataDetalle['watsapp_id'] = $responseDecode->messages[0]->id;
						$dataDetalle['tipo'] = 1;
						$dataDetalle['sw_leido'] = 1;
						$dataDetalle['data_recibida'] = json_encode($responseDecode);
						$detalle = Chatsdetalles::create($dataDetalle);
					} else { //NUEVO
						$dataChat = array();
						$dataChat['user_id'] = $usuarioAsignacion->usuario_id;
						$dataChat['wa_id'] = $phone;
						$dataChat['status'] = 1;
						$chat = Chats::create($dataChat);
						if ($chat) {
							$dataDetalle = array();
							$dataDetalle['chat_id'] = $chat->id;
							$dataDetalle['mensaje'] = $mensajeTemplate;
							$dataDetalle['watsapp_id'] =  $responseDecode->messages[0]->id;
							$dataDetalle['tipo'] = 1;
							$dataDetalle['sw_leido'] = 1;
							$dataDetalle['data_recibida'] = json_encode($responseDecode);

							$detalle = Chatsdetalles::create($dataDetalle);
						}
					}
				}
			}

			$send = Mail::raw(json_encode(array("usuarios_asignados" => count($usuariosAsignaciones))), function ($message) {
				$message->to('carloszavaletaramirez@gmail.com');
				$message->subject('Asignación Diaria Cantidad');
			});
		} else {
			//Aca enviara un error, solo si no se enviara el mensaje.
		}
	}

	function sendAsignacionDiaria2()
	{
		$usuariosAsignaciones = Asignacionesdiarias::where('status', 1)->where('fecha_asignada', Carbon::tomorrow()->format('Y-m-d'))->get();
		$send = Mail::raw(json_encode(array("usuarios_asignados" => count($usuariosAsignaciones))), function ($message) {
			$message->to('carloszavaletaramirez@gmail.com');
			$message->subject('Asignación Diaria Cantidad');
		});
	}
}
