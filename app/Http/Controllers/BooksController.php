<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Validator;
use Auth;

class BooksController extends Controller
{

    //コンストラクタ
    public function __construct()
    {
        $this->middleware('auth');
    }


    //一覧表示
    public function index() {
      $books = Book::where('user_id', Auth::user()->id)
              ->orderBy('created_at', 'asc')
              ->paginate(3);
      return view('books', compact('books'));
    }

    //登録処理
    public function store(Request $request) {
      //バリデーション
      $validator = Validator::make($request->all(), [
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required | min:1 | max:3',
        'item_amount' => 'required | max:6',
         'published'   => 'required',
      ]);

      //バリデーションエラー
      if ($validator->fails()) {
        return redirect('/')
          ->withInput()
          ->withErrors($validator);
      }

      //登録処理
      $books = new Book;
      $books->user_id = Auth::user()->id;
      $books->item_name = $request->item_name;
      $books->item_number = $request->item_number;
      $books->item_amount = $request->item_amount;
      $books->published = $request->published;
      $books->save();
      return redirect('/')->with('mesaage', '本登録が完了しました');
    }


    //更新画面
    public function edit($id) {
      $books = Book::where('user_id', Auth::user()->id)->find($id);
      return view('booksedit', ['book' => $books]);
    }


    //更新処理
    public function update(Request $request) {
      //バリデーション
      $validator = Validator::make($request->all(), [
        'id' => 'required',
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required | min:1 | max:3',
        'item_amount' => 'required | max:6',
        'published'   => 'required',
      ]);

      //バリデーションエラー
      if ($validator->fails()) {
        return redirect('/')
          ->withInput()
          ->withErrors($validator);
      }

      //更新処理
      $books = Book::where('user_id', Auth::user()->id)->find($request->id);
      $books->item_name = $request->item_name;
      $books->item_number = $request->item_number;
      $books->item_amount = $request->item_amount;
      $books->published = $request->published;
      $books->save();
      return redirect('/');
    }

    //削除処理
    public function destroy(Book $book) {
      $book->delete();
      return redirect('/');
    }
}
