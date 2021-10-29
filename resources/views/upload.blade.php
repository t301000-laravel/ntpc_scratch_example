@extends('layouts.app')

@section('title', '作品上傳')

@section('content')
    @php use Illuminate\Support\Str; @endphp

    <div class="container">
        <h1>作品上傳</h1>

        @error('myfile')
            <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                <strong>{{ $errors->first('myfile') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror

        @if (session('status'))
            <div class="alert alert-{{ session('status')['type'] }} mt-3 alert-dismissible fade show" role="alert">
                <strong>{{ session('status')['msg'] }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($user->team)
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0">
                            帳號： {{ $user->username }}
                        </li>
                        <li class="list-group-item border-0">
                            學校： {{ $user->team->school_name }}
                        </li>
                        <li class="list-group-item border-0">
                            組別： {{ $user->team->game_group }}
                        </li>
                    </ul>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col">
                    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">選擇要上傳的作品檔案</label>
                            <input class="form-control" type="file" name="myfile" id="formFile" accept=".sb3">
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary px-5">上傳</button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <h6 class="fw-bold">上傳歷史</h6>

                    @if(count($user->files) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($user->files as $file)
                                <li class="list-group-item border-bottom-0">
                                    <div class="mx-2 py-2 w-50 d-inline-block">
                                        {{ Str::replaceFirst("sb3/{$user->team->game_group}/", '', $file->path) }}
                                        {{ $file->created_at->toTimeString() }}
                                    </div>
                                    <div class="d-inline-block">
                                        <a href="{{ route('download', $file) }}" class="btn btn-link">
                                            下載
                                        </a>
                                        <a href="{{ route('player', $file) }}" class="btn btn-link">
                                            觀看
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">
                <strong>沒有上傳檔案的權限</strong>
            </div>
        @endif
    </div>
@endsection
