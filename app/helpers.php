<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Carbon\Carbon;
use Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class Helper
{
	public static function applClasses()
	{
		// default data array
		$DefaultData = [
			'mainLayoutType' => 'vertical',
			'theme' => 'light',
			'sidebarCollapsed' => false,
			'navbarColor' => '',
			'horizontalMenuType' => 'floating',
			'verticalMenuNavbarType' => 'floating',
			'footerType' => 'static', //footer
			'layoutWidth' => 'boxed',
			'showMenu' => true,
			'bodyClass' => '',
			'pageClass' => '',
			'pageHeader' => true,
			'contentLayout' => 'default',
			'blankPage' => false,
			'defaultLanguage' => 'en',
			'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
		];

		// if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
		$data = array_merge($DefaultData, config('custom.custom'));

		// All options available in the template
		$allOptions = [
			'mainLayoutType' => array('vertical', 'horizontal'),
			'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
			'sidebarCollapsed' => array(true, false),
			'showMenu' => array(true, false),
			'layoutWidth' => array('full', 'boxed'),
			'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
			'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
			'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
			'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
			'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
			'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
			'pageHeader' => array(true, false),
			'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
			'blankPage' => array(false, true),
			'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
			'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
			'defaultLanguage' => array('en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt', 'es' => 'es'),
			'direction' => array('ltr', 'rtl'),
		];

		//if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
		foreach ($allOptions as $key => $value) {
			if (array_key_exists($key, $DefaultData)) {
				if (gettype($DefaultData[$key]) === gettype($data[$key])) {
					// data key should be string
					if (is_string($data[$key])) {
						// data key should not be empty
						if (isset($data[$key]) && $data[$key] !== null) {
							// data key should not be exist inside allOptions array's sub array
							if (!array_key_exists($data[$key], $value)) {
								// ensure that passed value should be match with any of allOptions array value
								$result = array_search($data[$key], $value, 'strict');
								if (empty($result) && $result !== 0) {
									$data[$key] = $DefaultData[$key];
								}
							}
						} else {
							// if data key not set or
							$data[$key] = $DefaultData[$key];
						}
					}
				} else {
					$data[$key] = $DefaultData[$key];
				}
			}
		}

		//layout classes
		$layoutClasses = [
			'theme' => $data['theme'],
			'layoutTheme' => $allOptions['theme'][$data['theme']],
			'sidebarCollapsed' => $data['sidebarCollapsed'],
			'showMenu' => $data['showMenu'],
			'layoutWidth' => $data['layoutWidth'],
			'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
			'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
			'navbarColor' => $data['navbarColor'],
			'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
			'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
			'footerType' => $allOptions['footerType'][$data['footerType']],
			'sidebarClass' => '',
			'bodyClass' => $data['bodyClass'],
			'pageClass' => $data['pageClass'],
			'pageHeader' => $data['pageHeader'],
			'blankPage' => $data['blankPage'],
			'blankPageClass' => '',
			'contentLayout' => $data['contentLayout'],
			'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
			'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
			'mainLayoutType' => $data['mainLayoutType'],
			'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
			'direction' => $data['direction'],
		];
		// set default language if session hasn't locale value the set default language
		if (!session()->has('locale')) {
			app()->setLocale($layoutClasses['defaultLanguage']);
		}

		// sidebar Collapsed
		if ($layoutClasses['sidebarCollapsed'] == 'true') {
			$layoutClasses['sidebarClass'] = "menu-collapsed";
		}

		// blank page class
		if ($layoutClasses['blankPage'] == 'true') {
			$layoutClasses['blankPageClass'] = "blank-page";
		}

		return $layoutClasses;
	}

	public static function getMonthSpanish($mes_numero)
	{
		$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$mes = $meses[($mes_numero) - 1];
		return $mes;
	}
	public static function getDaySpanish($dia_numero)
	{
		$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
		$dia = $dias[$dia_numero];
		return $dia;
	}
	public static function updatePageConfig($pageConfigs)
	{
		$demo = 'custom';
		if (isset($pageConfigs)) {
			if (count($pageConfigs) > 0) {
				foreach ($pageConfigs as $config => $val) {
					Config::set('custom.' . $demo . '.' . $config, $val);
				}
			}
		}
	}


	public static function consultaDni($documento)
	{
		//Apis-NET
		//https://apis.net.pe/
		$response = Http::withHeaders(['Accept' => 'application/json', 'Authorization' => 'Bearer apis-token-2588.LYpxFtz0HsmZJ1vyhyH33mVyeagmVhDQ'])->get('https://api.apis.net.pe/v1/dni?numero=' . $documento);

		$response = json_decode($response);
		if (is_object($response) && isset($response->apellidoPaterno)) {
			//return $response; //json_decode($response);
			return array(
				"name" => $response->nombres,
				"last_name" => $response->apellidoPaterno . ' ' . $response->apellidoMaterno,
				"date_of_birth" => "",
				"address" => "",
				"sex" => "",
				"phone" => "",
				"email" => ""
			);
		}

		//API-PERÚ
		//http://apiperu.pe/
		$response = Http::get('https://consulta.api-peru.com/api/dni/' . $documento . '/35e193dbbafc3640c82c51495a6beb84');

		$response = json_decode($response);

		if (is_object($response) && $response->success == 1) {
			//return $response; //json_decode($response);
			if ($response->data->sexo == 'MASCULINO') {
				$sexo = 1;
			} else if ($response->data->sexo == 'FEMENINO') {
				$sexo = 2;
			} else {
				$sexo = '';
			}
			return array(
				"name" => $response->data->nombres,
				"last_name" => $response->data->apellido_paterno . ' ' . $response->data->apellido_materno,
				"date_of_birth" => $response->data->fecha_nacimiento,
				"address" => "",
				"sex" => $sexo,
				"phone" => "",
				"email" => ""
			);
		}


		//API-PERÚ DEV
		//https://apiperu.dev/
		$response = Http::get('https://apiperu.dev/api/dni/' . $documento . '?api_token=56aab31d4db24a55c17d3d0db0ff81b79bef4954c18460c16d3cc9c5c39d9e81');

		$response = json_decode($response);
		if (is_object($response) && $response->success == 1) {
			//return $response; //json_decode($response);
			return array(
				"name" => $response->data->nombres,
				"last_name" => $response->data->apellido_paterno . ' ' . $response->data->apellido_materno,
				"date_of_birth" => "",
				"address" => "",
				"sex" => "",
				"phone" => "",
				"email" => ""
			);
		}


		//NOVO API 
		//vwJDVkLTF4zbeITRxeVzTckkef05YO936L18cxBE
		//https://apiperu.dev/
		$response = Http::get('https://cloud.novoapi.com/api/reniec/vwJDVkLTF4zbeITRxeVzTckkef05YO936L18cxBE/' . $documento);

		$response = json_decode($response);
		if (is_object($response) && isset($response->nombres)) {
			return $response; //json_decode($response);
			return array(
				"name" => $response->nombres,
				"last_name" => $response->apellidoMaterno . ' ' . $response->apellidoPaterno,
				"date_of_birth" => "",
				"address" => "",
				"sex" => "",
				"phone" => "",
				"email" => ""
			);
		}

		return null;
	}
}
