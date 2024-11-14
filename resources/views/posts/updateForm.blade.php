@extends('layouts.app')
@section('content')
    <div class='container update-form'>
        <h2 class='form-title'>投稿内容を変更する</h2>
        {!! Form::open(['url' => '/post/update']) !!}

        <div class="form-group">
            {!! Form::hidden('id', $post->id) !!}
            {!! Form::textarea('upPost', old('upPost', $post->contents), ['required', 'class' => 'form-control', 'placeholder' => '投稿内容を入力してください']) !!}
            @error('upPost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        {!! Form::close() !!}
    </div>
@endsection
