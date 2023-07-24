<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesCheck extends Model
{
	use HasFactory;
	protected $table = 'rutaschecklist';
	protected $fillable = [
            'ruta_id',
            'obser_entrante',
            'obser_saliente',
            'ruta_incidencia',
            'incidencia',
            'pedal_embriague',
			'pedal_freno',
			'pedal_acelera',
			'asientos_cabezal',
			'espejo_retrovisor',
			'freno_mano',
			'cenicero',
			'manijas',
			'palanca_cambios',
			'parabrisas',
			'planilla_luces',
			'radio',
			'tapasol',
			'tapis',
			'extintor',
			'estribos',
			'mivel_aceite',
			'freno',
			'nivel_bateria',
			'kilometraje',
			'nivel_temperatura',
			'reloj',
			'nivel_combustible',
			'mica',
			'direccionales',
			'pisos	' ,
			'timon_claxon',
			'ventanas',
			'guantera',
			'cinturon_seguridad',
			'cajonera',
			'tapa_combustible',
			'agua',
			'aceite'	,
			'liquido_freno',
			'hidrolima',
			'luces_delanteras',
			'luces_posteriores',
			'direccion_derecho',
			'direccion_izquierda',
			'luces_freno',
			'luces_cabina_delantera',
			'luces_cabecera_posterior',
			'circulina',
			'modulo_parlantes',
			'tapa_com_exterior',
			'espejos_laterales',
			'mascara',
			'plumillas',
			'parachoque_delantero',
			'parachoque_trasero',
			'carroceria',
			'neumaticos',
			'tubo_escape',
			'cierre_puertas',
			'documentos',
			'tarjeta_propiedad',
			'soat',
			'revision_tecnica',
			'radiador_tapa',
			'deposito_refri',
			'baterias',
			'arrancador	',
			'tapa_liquido',
			'paletas_ventilador',
			'varilla_medicion',
			'tapa_ace_motor',
			'llave_ruedas'	,
			'gato_dado_pala'	,
			'cono_seguridad',
			'triangulo_segu',
			'herramienta'	,
			'neumatico',
			'tablero',
			'guia_calles'	,
			'linterna',
			'cable_corriente',
	];

	public function enfermeros()
	{
		return $this->hasMany(User::class, 'id', 'sub_base');
	}
}
