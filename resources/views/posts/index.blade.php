@extends('layouts.app')
@section('content')
  <div class='container'>

    <h2 class='page-header'>掲示板</h2>

    <form action="{{ route('posts.search') }}" method="GET" id="search-form" class="search-form">
      <input type="text" class="search-input" name="query" placeholder="検索キーワード">
      <button class="search-button" type="submit">検索</button>
    </form>

    <p class="pull-right"><a class="btn btn-success" href="/create-form">投稿する</a></p>

    <div id="posts-container">
      @foreach ($lists as $list)
        <div class="post-box">
          <div class="post-item">
            <p class="name">{{ $list->user_name ?: '例' }}</p> <!-- user_nameがない場合は「例」と表示 -->
          </div>
          <div class="post-item">
            <p class="content">{{ $list->contents }}</p> <!-- contentsを表示 -->
          </div>
          <div class="post-item">
            <p class="time">{{ $list->created_at }}</p>
          </div>

          @if(Auth::check() && Auth::user()->name == $list->user_name) <!-- 修正: user_nameを使って比較 -->
            <div class="button-container">
              <a class="btn btn-primary" href="/post/{{ $list->id }}/update-form">更新</a>
              <a class="btn btn-danger" href="/post/{{ $list->id }}/delete" onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')">削除</a>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          $('#search-form').on('submit', function(e) {
              e.preventDefault();
              $.ajax({
                  url: $(this).attr('action'),
                  method: 'GET',
                  data: $(this).serialize(),
                  success: function(response) {
                      // 検索結果のコンテナを空にする
                      $('#posts-container').empty();

                      if (response.length === 0) {
                          // 取得したデータがない場合
                          $('#posts-container').append('<p>検索結果は0件です</p>'); // 検索結果がない場合のメッセージを表示
                      } else {
                          // 取得したデータを新しい順にソート
                          response.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                          // 取得したデータをループしてHTMLを生成
                          $.each(response, function(index, list) {
                              let postHtml = `
                                  <div class="post-box">
                                      <div class="post-item">
                                          <p class="name">${list.user_name || '例'}</p>
                                      </div>
                                      <div class="post-item">
                                          <p class="content">${list.contents}</p>
                                      </div>
                                      <div class="post-item">
                                          <p class="time">${list.created_at}</p>
                                      </div>
                              `;

                              // ユーザーがログインしており、投稿者であれば「更新」と「削除」ボタンを追加
                              @if(Auth::check())
                              if ("{{ Auth::user()->name }}" == list.user_name) {
                                  postHtml += `
                                      <div class="button-container">
                                          <a class="btn btn-primary" href="/post/${list.id}/update-form">更新</a>
                                          <a class="btn btn-danger" href="/post/${list.id}/delete" onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')">削除</a>
                                      </div>
                                  `;
                              }
                              @endif

                              postHtml += `</div>`;
                              $('#posts-container').append(postHtml);
                          });
                      }
                  },
              });
          });
      });

  </script>

@endsection
