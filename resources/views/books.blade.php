@extends('layouts.app')
@section('content')
<div class="card-body">
  <div class="card-title">
    本のタイトル
  </div>
  <!--バリデーションエラーの表示-->
  @include('common.errors')
  <!--バリデーションエラーの表示-->

  <!--本のタイトル-->
  <form action="{{url('/books')}}" method="post" class="form-horizontal">
    @csrf
    <!--本のタイトル-->
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="book" class="col-sm-3 control-label">Book</label>
        <input type="text" name="item_name" class="form-control">
      </div>

      <div class="form-group col-md-6">
        <label for="amount" class="col-sm-3 control-label">金額</label>
        <input type="text" name="item_amount" class="form-control">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="number" class="col-sm-3 control-label">数</label>
        <input type="text" name="item_number" class="form-control">
      </div>

      <div class="form-group col-md-6">
        <label for="published" class="col-sm-3 control-label">公開日</label>
        <input type="date" name="published" class="form-control">
      </div>
    </div>



    <!--本登録ボタン-->
    <div class="form-row">
      <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-primary">
          Save
        </button>
      </div>
    </div>
  </form>
</div>

@if (session('message'))
<div class="alert alert-success">
  {{session('message')}}
</div>
@endif

<!--既に登録されている本のリスト-->
@if (count($books) > 0)
<div class="card-body">
  <div class="card-body">
    <table class="table table-striped task-table">
      <thead>
        <th>本一覧</th>
        <th>&nbsp;</th>
      </thead>
      <tbody>
        @foreach ($books as $book)
        <tr>
          <td class="table-text">
            <div>{{$book->item_name}}</div>
          </td>

          <!--本更新ボタン-->
          <td>
            <form action="{{url('booksedit/'.$book->id)}}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">
              更新
            </button>
            </form>
          </td>
          <!--本削除ボタン-->
          <td>
            <form action="{{url('book/'.$book->id)}}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">
                削除
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
<div class="row">
  <div class="col-md-4 offset-md-4">
    {{$books->links()}}
  </div>
</div>
@endif

@endsection