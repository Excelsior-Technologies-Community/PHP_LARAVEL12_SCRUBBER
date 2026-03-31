<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrubbedData extends Model
{
    // Laravel 12 ma by default badhu barabar hase
    // Jo table nu naam migration ma alag hoy to j ahi badlavvu pade
    protected $table = 'scrubbed_data';
    
protected $fillable = ['original_content', 'cleaned_content', 'type'];
}