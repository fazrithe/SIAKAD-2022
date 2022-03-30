<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @internal
 * @coversNothing
 */
class MMedia extends Model
{

    public $table = 'media';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'model_type',
        'model_id',
        'name',
        'created_at',
        'updated_at',
    ];
}
