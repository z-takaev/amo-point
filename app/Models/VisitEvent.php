<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class VisitEvent extends Model
{
    protected $fillable = [
        'ip',
        'city',
        'device',
    ];
}
