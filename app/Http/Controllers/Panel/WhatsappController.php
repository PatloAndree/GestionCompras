<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\Chatsdetalles;
use App\Models\Configuraciones;
use App\Models\User;
use App\Models\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		$usuarios = User::where('status', 1)->get();
		$chatsDb = Chats::where('status', 1)->get();
		$chats = array();
		foreach ($chatsDb as $chat) {
			$mensaje = collect($chat->mensajes);
			$cantidad = $mensaje->where('tipo', 2)->where('sw_leido', 0)->count();
			$lastChat = $mensaje->last();
			$date = Carbon::parse($lastChat->created_at)->locale('es');
			array_push($chats, array(
				"id" => $chat->id,
				"wa_id" => $chat->wa_id,
				"usuario" => array(
					"id" => $chat->usuario->id,
					"name" => $chat->usuario->name,
					"last_name" => $chat->usuario->last_name,
				),
				"mensaje" => array(
					"hora" => sprintf('%s', $date->format('h:i A')),
					"mensaje" => substr(strip_tags($lastChat->mensaje), 0, 25) . ((strlen(trim(strip_tags($lastChat->mensaje))) > 25) ? '...' : ''),
					"sw_leido" => "",
					"cantidad" => $cantidad
				)
			));
		}

		/*$chat = array(
			"id"=>$chatsDb->id,
			"usuario"=>array("name"=>)
		)*/
		$data['usuarios'] = $usuarios;
		$data['chats'] = $chats;
		return view('/content/panel/whatsapp', $data);
	}

	public function chat(Request $request, User $user)
	{
		if ($user) {
			$chat = Chats::where('user_id', $user->id)->where('status', 1)->first();
			if ($chat) {
				Chatsdetalles::where('chat_id', $chat->id)->where('tipo', 2)->where('sw_leido', 0)->update(['sw_leido' => 1]);
				//$ec = $chat->mensajes->where('tipo', 2)->where('sw_leido', 0)->update(['sw_leido', 1]);
				echo json_encode(array("mensajes" => $chat->mensajes, "chat_id" => $chat->id));
			} else {
				echo json_encode(array("mensajes" => array(), "chat_id" => '0'));
			}
		} else {
			echo json_encode(array("mensajes" => array(), "chat_id" => '0'));
		}
	}

	public function send(Request $request)
	{
		$credenciales = Configuraciones::where('id', 1)->where('status', 1)->first();
		if ($credenciales) {
			$usuario = User::where('id', $request->userid)->where('status', 1)->first();
			$header = [
				'Accept' => 'application/json',
				'Authorization' => 'Bearer ' . $credenciales->configuracion1
			];
			$body = [
				'messaging_product' => 'whatsapp',
				'recipient_type' => 'individual',
				'to' => "51" . $usuario->phone,
				'type' => 'text',
				'text' => [
					'body' => $request->message
				]
			];

			$whatsapp = Whatsapp::where('id', 1)->where('status', 1)->first();
			//https://graph.facebook.com/v14.0/109958401825883/messages
			$response = Http::withHeaders($header)->post('https://graph.facebook.com/v14.0/' . $credenciales->configuracion2 . '/messages', $body);
			$response_decode = json_decode($response);
			if (!isset($response_decode->error)) {
				$chatwsp = Chats::where('user_id', $usuario->id)->first();
				if ($chatwsp) { //EXISTENTE
					$dataDetalle = array();
					$dataDetalle['chat_id'] = $chatwsp->id;
					$dataDetalle['mensaje'] = $request->message;
					$dataDetalle['watsapp_id'] = $response_decode->messages[0]->id;
					$dataDetalle['tipo'] = 1;
					$dataDetalle['sw_leido'] = 1;
					$dataDetalle['data_recibida'] = json_encode($response_decode);
					$detalle = Chatsdetalles::create($dataDetalle);
					if ($detalle) {
						echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => 'Mensaje enviado'));
					} else {
						echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => 'Se envio el mensaje, pero ocurrio un problema registrando el detalle.'));
					}
				} else { //NUEVO
					$dataChat = array();
					$dataChat['user_id'] = trim($request->userid);
					$dataChat['wa_id'] = "51" . $usuario->phone;
					$dataChat['status'] = 1;
					$chat = Chats::create($dataChat);
					if ($chat) {
						$dataDetalle = array();
						$dataDetalle['chat_id'] = $chat->id;
						$dataDetalle['mensaje'] = $request->message;
						$dataDetalle['watsapp_id'] =  $response_decode->messages[0]->id;
						$dataDetalle['tipo'] = 1;
						$dataDetalle['sw_leido'] = 1;
						$dataDetalle['data_recibida'] = json_encode($response_decode);

						$detalle = Chatsdetalles::create($dataDetalle);
						if ($detalle) {
							echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => 'Mensaje enviado'));
						} else {
							echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => 'Se envio el mensaje, pero ocurrio un problema registrando el detalle.'));
						}
					} else {
						echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => 'Se envio el mensaje, pero ocurrio un problema registrando el chat.'));
					}
				}
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $response_decode->error->message));
			}
		}
	}
}
