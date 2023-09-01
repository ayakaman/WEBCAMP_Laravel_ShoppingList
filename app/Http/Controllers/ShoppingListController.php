<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingListRegisterPostRequest;
use App\Models\Shopping_list as Shopping_listModel;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ShoppingListController extends Controller
{
    /**
     * 一覧ページ表示
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // 1Page辺りの表示アイテム数を設定
        $per_page = 10;

        $list = $this->getListBuilder()
                     ->paginate($per_page);
/*
$sql = $this->getListBuilder()
         ->toSql();
echo "<pre>\n"; var_dump($sql, $list); exit;
*/
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

            //$shopping_lists側の削除
            $shopping_list->delete();
//var_dump($shopping_list->toArray()); exit;

            //completed_shopping_list側にinsert
            $dask_datum = $shopping_list->toArray();
            unset($dask_datum['updated_at']);
            $r = CompletedShoppingListModel::create($dask_datum);
            if ($r === null) {
               throw new \Exception('');  // insertで失敗したのでトランザクション終了
            }
//echo '処理成功'; exit;

            // トランザクション終了
            DB::commit();

            //完了メッセージ
            $request->session()->flash('front.shoppinglist_completed_success', true);
        } catch(\Throwable $e) {
var_dump($e->getMessage()); exit;
            // トランザクション異常終了
            DB::rollBack();
            //失敗メッセージ
            $request->session()->flash('front.shoppinglist_completed_failure', true);
        }

        // 一覧に遷移
        return redirect('/shopping_list/list');
    }

     /**
     * 単一タスクmodel取得
     */
     protected function getShopping_listModel($shopping_list_id)
     {
          //shopping_listk_idレコード取得
         $shopping_list = Shopping_listModel::find($shopping_list_id);
         if ($shopping_list === null) {
             return null;
         }

         //本人以外タスクならNG
         if ($shopping_list->user_id !== Auth::id()) {
             return null;
         }

         //
         return $shopping_list;
     }

      /**
      * 一覧用の Illuminate\Database\Eloquent\Builder インスタンス取得
      */
     protected function getListBuilder()
     {
         return Shopping_listModel::where('user_id', Auth::id())
                         ->orderBy('created_at');
     }



}