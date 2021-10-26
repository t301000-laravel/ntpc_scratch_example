@extends('layouts.app')

@section('title', '帳號資訊')

@section('content')
    <div class="container">
        <h1>帳號資訊</h1>

        <div class="card w-25">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">帳號： {{ $user->username }}</li>
                    @if($user->team)
                        <li class="list-group-item">學校： {{ $user->team->school_name }}</li>
                        <li class="list-group-item">組別： {{ $user->team->game_group }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
