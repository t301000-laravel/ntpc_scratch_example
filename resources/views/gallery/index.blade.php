@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="container">
        <h1>Gallery</h1>

        @foreach($items as $item)
            <div>
                <img  style="width: 200px;" src="{{ asset($item->thumb_path) }}">
            </div>
        @endforeach
    </div>
@endsection
