<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping_list extends Model
{
    use HasFactory;

      /**
     * 複数代入不可の属性
     */
     protected $guarded = ['id'];

}
