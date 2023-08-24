<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListRegisterPostRequest;
use App\Models\Shopping_list as Shopping_listModel;
use App\Models\Completed_Shopping_list as Completed_Shopping_listModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

     /**
     * タスクの完了
     */
    public function complete(Request $request, $shopping_list_id)
    {
        /* タスクを完了テーブルに移動 */
        try {
            DB::beginTransaction();// トランザクション開始

            // shopping_list_idのレコード取得
            $shopping_list = $this->getShopping_listModel($shopping_list_id);
            if ($shopping_list === null) {
                throw new \Exception(''); // 不正によるトランザクション終了
            }

            // shopping_lists側を削除
            $shopping_list->delete();
//var_dump($shopping_list->toArray()); exit;

            // completed_shopping_lists側にinsert
            $dask_datum = $shopping_list->toArray();
            unset($dask_datum['created_at']);
            $r = Completed_Shopping_listModel::create($dask_datum);
            if ($r === null) {
                // insertで失敗したのでトランザクション終了
                throw new \Exception('');
            }

            // トランザクション終了
            DB::commit();

            //完了メッセージ
            $request->session()->flash('front.shoppinglist_completed_success', true);
        } catch(\Throwable $e) {
//var_dump($e->getMessage()); exit;
            // トランザクション異常終了
            DB::rollBack();
            //失敗メッセージ
            $request->session()->flash('front.shoppinglist_completed_failure', true);
        }

        // 一覧に遷移
        return redirect('/shopping_list/list');
    }
}