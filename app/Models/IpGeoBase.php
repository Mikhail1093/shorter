<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpGeoBase extends Model
{
    protected $table = 'ip_geo_base';

    protected $fillable = [
        'ip',
        'city',
        'state',
        'country',
        'country_code',
        'continent',
        'continent_code'
    ];
}
