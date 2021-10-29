@extends('layouts.app')

@section('title', '系統設定')

@php
    $config = \App\Models\Config::all()->pluck('enable', 'name');
    // dd($config);
@endphp

@section('content')
    <div class="container">
        <h1>系統設定</h1>

        @if(session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('msg') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mt-3 flex-column">
            <div class="col">
                觀摩：
                <a href="{{ route('admin.system-config.update', ['name' => 'public_view']) }}" class="btn btn-outline-dark">
                    {{ $config['public_view'] ? "關閉" : "開放" }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
    </script>
@endsection
