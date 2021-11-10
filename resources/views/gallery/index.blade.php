@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="container">
        <h1>Gallery</h1>

        <div class="d-flex">
            <a href="{{ route('gallery.create') }}" class="btn btn-primary px-5 btn-lg mt-3 ms-auto" id="btn-submit">上傳</a>
        </div>

        @foreach($items as $item)
            <div>
                <img  style="width: 200px;" src="{{ asset($item->thumb_path) }}">
            </div>
        @endforeach
    </div>
@endsection
