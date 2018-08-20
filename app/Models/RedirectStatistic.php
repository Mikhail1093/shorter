<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedirectStatistic extends Model
{
    protected $table = 'redirects_statistic';

    protected $fillable = [
        'id',
        'links_data_id',
        'ip',
        'browser_version',
        'refer_link',
        'country'
    ];
}
