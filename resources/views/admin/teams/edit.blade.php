@extends('layouts.app')

@section('title', '名單管理')

@section('content')
    <div class="container">
        <h1>名單管理 - 變更密碼</h1>

        <div class="card w-25">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">帳號： {{ $team->user->username }}</li>
                    <li class="list-group-item">學校： {{ $team->school_name }}</li>
                    <li class="list-group-item">組別： {{ $team->game_group }}</li>
                </ul>
                <form action="{{ route('admin.teams.update', $team) }}" method="post" class="mt-3">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">新密碼</label>
                        <input type="text" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-primary px-4">確定</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">上一頁</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
