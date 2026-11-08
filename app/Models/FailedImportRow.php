<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FailedImportRow
 * 
 * @property int $failed_import_id
 * @property int $import_id
 * @property array $data
 * @property string|null $validation_error
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Import $import
 *
 * @package App\Models
 */
class FailedImportRow extends Model
{
	protected $table = 'failed_import_rows';
	protected $primaryKey = 'failed_import_id';

	protected $casts = [
		'import_id' => 'int',
		'data' => 'json'
	];

	protected $fillable = [
		'import_id',
		'data',
		'validation_error'
	];

	public function import()
	{
		return $this->belongsTo(Import::class);
	}
}
