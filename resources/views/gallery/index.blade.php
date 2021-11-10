@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="container">
        <h1>Gallery</h1>

        <div class="d-flex">
            <a href="{{ route('gallery.create') }}" class="btn btn-outline-primary px-5 btn-lg ms-auto" id="btn-submit">上傳</a>
        </div>

        @if(count($items) > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
                @foreach($items as $item)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset($item->thumb_path) }}" class="card-img-top img-fluid">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <a href="{{ route('gallery.show', $item) }}" class="stretched-link" target="_blank">觀看</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
