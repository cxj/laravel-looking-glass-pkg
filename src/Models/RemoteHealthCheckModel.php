<?php

namespace Cxj\LookingGlass\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $app_name
 * @property string $check_name
 * @property mixed  $result
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Builder;
 */
class RemoteHealthCheckModel extends Model
{
    protected $table = 'remote_health_checks';
    /**
     * @var array <string>
     */
    protected $fillable = [
        'app_name',
        'check_name',
        'result',
        'created_at',
        'updated_at',
    ];
}
