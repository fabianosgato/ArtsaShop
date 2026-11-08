<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerValidationEntity
 * 
 * @property int $entity_id
 * @property string $consulta_id
 * @property string $numero_documento
 * @property string $nome_completo
 * @property Carbon|null $data_nascimento
 * @property string|null $situacao_receita
 * @property bool|null $consta_obito
 * @property string|null $pdf_url_file
 * @property string|null $uniqueIdentifier
 * @property Carbon|null $created
 * @property Carbon|null $updated
 *
 * @package App\Models
 */
class CustomerValidationEntity extends Model
{
	protected $table = 'customer_validation_entity';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'data_nascimento' => 'datetime',
		'consta_obito' => 'bool',
		'created' => 'datetime',
		'updated' => 'datetime'
	];

	protected $fillable = [
		'consulta_id',
		'numero_documento',
		'nome_completo',
		'data_nascimento',
		'situacao_receita',
		'consta_obito',
		'pdf_url_file',
		'uniqueIdentifier',
		'created',
		'updated'
	];
}
