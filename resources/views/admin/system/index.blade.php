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
                開放觀摩：
                <a href="{{ route('admin.system-config.update', ['name' => 'public_view']) }}"
                   class="btn {{ $config['public_view'] ? "btn-success" : "btn-outline-dark" }}">
                    {{ $config['public_view'] ? "已開放" : "已關閉" }}
                </a>
            </div>

            <div class="col mt-4">
                <div class="row">
                    <div class="col">開放上傳：</div>
                </div>

                <div class="row flex-column g-3">
                    <div class="col ps-5">
                        國小遊戲組：
                        <a href="{{ route('admin.system-config.update', ['name' => 'eg_upload']) }}"
                           class="btn {{ $config['eg_upload'] ? "btn-success" : "btn-outline-dark" }}">
                            {{ $config['eg_upload'] ? "已開放" : "已關閉" }}
                        </a>
                    </div>
                    <div class="col ps-5">
                        國小動畫組：
                        <a href="{{ route('admin.system-config.update', ['name' => 'ea_upload']) }}"
                           class="btn {{ $config['ea_upload'] ? "btn-success" : "btn-outline-dark" }}">
                            {{ $config['ea_upload'] ? "已開放" : "已關閉" }}
                        </a>
                    </div>
                    <div class="col ps-5">
                        國中遊戲組：
                        <a href="{{ route('admin.system-config.update', ['name' => 'jg_upload']) }}"
                           class="btn {{ $config['jg_upload'] ? "btn-success" : "btn-outline-dark" }}">
                            {{ $config['jg_upload'] ? "已開放" : "已關閉" }}
                        </a>
                    </div>
                    <div class="col ps-5">
                        國中動畫組：
                        <a href="{{ route('admin.system-config.update', ['name' => 'ja_upload']) }}"
                           class="btn {{ $config['ja_upload'] ? "btn-success" : "btn-outline-dark" }}">
                            {{ $config['ja_upload'] ? "已開放" : "已關閉" }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
    </script>
@endsection
