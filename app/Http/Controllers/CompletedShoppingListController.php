<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Completed_Shopping_list as Completed_Shopping_listModel;
use Illuminate\Support\Facades\Auth;


class CompletedShoppingListController extends Controller
{

     /**
     * 一覧用インスタンス取得（Illuminate\Database\Eloquent\Builder）
     */
/*
    protected function getListBuilder()
    {
        return Completed_Shopping_listModel::where('user_id', Auth::id())
                         ->orderBy('priority', 'DESC')
                         ->orderBy('period')
                         ->orderBy('created_at');
    }
*/

    /**
     * 一覧ページ表示
     * @return \Illuminate\View\View
     */
    public function list()
    {


        // 1Page辺りの表示アイテム数を設定
        $per_page = 10;

        $list = Completed_Shopping_listModel::where('user_id', Auth::id())
                                  ->paginate($per_page);
                                  //->get();
//$sql = Shopping_listModel::toSql();
//echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('/completed_shopping_list.list', ['list' => $list]);
    }
}