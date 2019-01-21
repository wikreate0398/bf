<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsReport extends Model
{
	public $timestamps = true;

	protected $table = 'logs_report';

	protected $fillable = [
        'id_user',
        'action',
        'data',
        'guard'
    ];

	protected $casts = [
	    'guard' => 'integer'
    ];

	public function log_define()
    {
        return $this->hasOne('App\Models\LogDefines', 'define', 'action');
    }
}
