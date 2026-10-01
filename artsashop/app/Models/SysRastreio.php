<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysRastreio
 * 
 * @property int $rastreio_pk
 * @property int $pedido_fk
 * @property int $item_fk
 * @property int $status_fk
 * @property int $empresa_fk
 * @property string $codigo
 * @property string|null $amazon_track
 * @property string|null $amazon_code
 * @property string|null $correios_track
 * @property string|null $hawb_track
 * @property Carbon|null $delivery_date
 * @property bool|null $flg_liberado
 * @property bool|null $flg_excluido
 *
 * @package App\Models
 */
class SysRastreio extends Model
{
	protected $table = 'sys_rastreio';
	protected $primaryKey = 'rastreio_pk';
	public $timestamps = false;

	protected $casts = [
		'pedido_fk' => 'int',
		'item_fk' => 'int',
		'status_fk' => 'int',
		'empresa_fk' => 'int',
		'delivery_date' => 'datetime',
		'flg_liberado' => 'bool',
		'flg_excluido' => 'bool'
	];

	protected $fillable = [
		'pedido_fk',
		'item_fk',
		'status_fk',
		'empresa_fk',
		'codigo',
		'amazon_track',
		'amazon_code',
		'correios_track',
		'hawb_track',
		'delivery_date',
		'flg_liberado',
		'flg_excluido'
	];
}
