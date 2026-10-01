<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysRastreioHistorico
 * 
 * @property int $historico_pk
 * @property int $rastreio_fk
 * @property int $pedido_fk
 * @property int $status_fk
 * @property string|null $correios_id
 * @property string|null $correios_status
 * @property Carbon $created
 * @property Carbon $updated
 *
 * @package App\Models
 */
class SysRastreioHistorico extends Model
{
	protected $table = 'sys_rastreio_historico';
	protected $primaryKey = 'historico_pk';
	public $timestamps = false;

	protected $casts = [
		'rastreio_fk' => 'int',
		'pedido_fk' => 'int',
		'status_fk' => 'int',
		'created' => 'datetime',
		'updated' => 'datetime'
	];

	protected $fillable = [
		'rastreio_fk',
		'pedido_fk',
		'status_fk',
		'correios_id',
		'correios_status',
		'created',
		'updated'
	];
}
