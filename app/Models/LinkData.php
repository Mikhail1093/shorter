<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null user_id
 */
class LinkData extends Model
{
    protected $table = 'links_data';

    protected $fillable = [
        'id',
        'initial_url',
        'short_url',
        'redirect_count',
        'redirect_count'
    ];
}
