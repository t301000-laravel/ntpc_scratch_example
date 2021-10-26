@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">新北市國中小 SCRATCH 程式設計競賽複賽</h1>

        <div class="row mt-5 py-5 align-items-end  row-cols-1 row-cols-md-4 g-4">
            <div class="col text-center">
                <a href="{{ route('dashboard', '國小遊戲組') }}">
                    <img src="{{ asset('img/em.jpg') }}" class="img-fluid">
                </a>
            </div>

            <div class="col text-center">
                <a href="{{ route('dashboard', '國小動畫組') }}">
                    <img src="{{ asset('img/ep.jpg') }}" class="img-fluid">
                </a>
            </div>

            <div class="col text-center">
                <a href="{{ route('dashboard', '國中遊戲組') }}">
                    <img src="{{ asset('img/jp.jpg') }}" class="img-fluid">
                </a>
            </div>

            <div class="col text-center">
                <a href="{{ route('dashboard', '國中動畫組') }}">
                    <img src="{{ asset('img/jm.jpg') }}" class="img-fluid">
                </a>
            </div>
        </div>
    </div>
@endsection
