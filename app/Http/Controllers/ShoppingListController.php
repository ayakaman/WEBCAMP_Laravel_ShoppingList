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
        return view('shopping_list.list');
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
}