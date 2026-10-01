<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrubbedData extends Model
{
    protected $table = 'scrubbed_data';

    protected $fillable = [
        'original_content',
        'cleaned_content',
        'type',
    ];
}