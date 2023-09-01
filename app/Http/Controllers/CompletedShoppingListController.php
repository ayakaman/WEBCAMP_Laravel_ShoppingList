<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;


class CompletedShoppingListController extends Controller
{

     /**
     * 一覧用インスタンス取得（Illuminate\Database\Eloquent\Builder）
     */

    protected function getListBuilder()
    {
        return CompletedShoppingListModel::where('user_id', Auth::id())
                         ->orderBy('created_at');
    }


    /**
     * 一覧ページ表示
     * @return \Illuminate\View\View
     */
    public function list()
    {

        // Page
        $per_page = 10;

        $list = $this->getListBuilder()
                     ->paginate($per_page);
/*
$sql = $this->getListBuilder()
             ->toSql();
echo "<pre>\n"; var_dump($sql, $list); exit;
var_dump($sql);
*/
        return view('completed_shopping_list.list', ['list' => $list]);
    }
}