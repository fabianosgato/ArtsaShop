<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysTemplateEmail
 * 
 * @property int $template_id
 * @property string $template_code
 * @property string $template_text
 * @property string|null $template_styles
 * @property int|null $template_type
 * @property string $template_subject
 * @property string|null $template_sender_name
 * @property string|null $template_sender_email
 * @property Carbon|null $created
 * @property Carbon|null $modified
 * @property bool|null $flg_liberado
 * @property bool|null $flg_excluido
 *
 * @package App\Models
 */
class SysTemplateEmail extends Model
{
	protected $table = 'sys_template_emails';
	protected $primaryKey = 'template_id';
	public $timestamps = false;

	protected $casts = [
		'template_type' => 'int',
		'created' => 'datetime',
		'modified' => 'datetime',
		'flg_liberado' => 'bool',
		'flg_excluido' => 'bool'
	];

	protected $fillable = [
		'template_code',
		'template_text',
		'template_styles',
		'template_type',
		'template_subject',
		'template_sender_name',
		'template_sender_email',
		'created',
		'modified',
		'flg_liberado',
		'flg_excluido'
	];
}
