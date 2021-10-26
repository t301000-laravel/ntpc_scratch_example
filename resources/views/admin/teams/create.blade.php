@extends('layouts.app')

@section('title', '名單管理 - 新增')

@section('content')
    <div class="container">
        <h1>新增名單 - {{ $group }}</h1>

        @if(count($errors) > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                @foreach($errors->all() as $error)
                    <strong>{{ $error }}</strong><br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mt-3">
            <div class="col-12 col-md-6 col-lg-5">
                <form action="{{ route('admin.teams.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">帳號</label>
                        <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密碼</label>
                        <input type="text" name="password" class="form-control" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="school_name" class="form-label">學校</label>
                        <input type="text" name="school_name" class="form-control" id="school_name">
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-primary px-4">新增</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">上一頁</a>
                    </div>
                    <input type="hidden" name="game_group" value="{{ $group }}">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script></script>
@endsection
