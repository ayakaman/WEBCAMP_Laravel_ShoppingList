<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListRegisterPostRequest;
use App\Models\Shopping_list as Shopping_listModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    /**
     * トップページ を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // 1Page辺りの表示アイテム数を設定
        $per_page = 10;

        $list = Shopping_listModel::where('user_id', Auth::id())
                                  ->paginate($per_page);
                                  //->get();
//$sql = Shopping_listModel::toSql();
//echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('shopping_list.list', ['list' => $list]);

    }

    /**
     * タスクの新規登録
     */
    public function register(ShoppingListRegisterPostRequest $request)
    {
        // validate済みのデータの取得
        $datum = $request->validated();
        //var_dump($datum); exit;
        $datum['user_id'] = Auth::id();

        // INSERT
        try {
            $r = Shopping_listModel::create($datum);
        } catch(\Throwable $e) {
            echo $e->getMessage();
            exit;
        }

        // タスク登録成功
        $request->session()->flash('front.shoppinglist_register_success', true);

        //
        return redirect('/shopping_list/list');
    }

     /**
     * 削除処理
     */
    public function delete(Request $request, $shopping_list_id)
    {
        // shopping_list_idのレコード取得
        $shopping_list = $this->getShopping_listModel($shopping_list_id);
        // タスクを削除する
        if ($shopping_list !== null) {
            $shopping_list->delete();
            $request->session()->flash('front.shoppinglist_delete_success', true);
        }
        // 一覧に遷移
        return redirect('/shopping_list/list');
    }
}