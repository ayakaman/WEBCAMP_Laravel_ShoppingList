<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Completed_Shopping_list extends \App\Models\Shopping_list
{
    use HasFactory;


    /**
     * 複数代入不可能な属性
     */
    protected $guarded = [];
}
