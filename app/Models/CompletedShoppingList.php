<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedShoppingList extends \App\Models\Shopping_list
{
    use HasFactory;


    /**
     * 複数代入不可能な属性
     */
    //protected $guarded = [];

    /**
     * 重要度の文字列を取得する
     */
/*
    public function getPriorityString()
    {
        return $this::PRIORITY_VALUE[ $this->priority ] ?? '';
    }
*/
}
