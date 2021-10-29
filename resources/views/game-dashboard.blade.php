@php
    use \Illuminate\Support\Str;
    use \App\Models\Config;
@endphp

@extends('layouts.app')

@section('title', $group . ' 上傳結果')

@section('content')
    <div class="container">
        <h1 class="text-center position-relative">
            {{ $group . ' 上傳結果' }}
            <div class="form-check position-absolute top-50 end-0 fs-6">
                <input class="form-check-input" type="checkbox" value="" id="pause-refresh">
                <label class="form-check-label" for="pause-refresh">
                    暫停畫面重整
                </label>
            </div></h1>

        <div class="mt-3 row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @foreach($players as $player)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-header text-white @if(count($player->files) > 0) bg-success @else bg-danger @endif">
                            {{ $player->team->school_name }}
                            <span class="d-inline-block float-end">{{ $player->username }}</span>
                        </div>
                        <div class="card-body">
                            @if(count($player->files) > 0)
                                <p class="card-title text-success fw-bold text-center">已上傳</p>
                                <p class="card-text">
                                    @if(Config::whereName('public_view')->first()->enable)
                                        <a href="{{ route('player', $player->files->first()) }}" target="_blank">
                                            {{ Str::replaceFirst("sb3/{$group}/", '', $player->files->first()->path) }}
                                        </a>
                                    @else
                                        {{ Str::replaceFirst("sb3/{$group}/", '', $player->files->first()->path) }}
                                    @endif
                                </p>
                            @else
                                <p class="card-title text-danger fw-bold text-center">未上傳</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
        const pause = document.getElementById('pause-refresh');
        const intervalSec = 20; // 頁面重整間隔秒數

        setTimeout(refresh, intervalSec * 1000);

        function refresh() {
            if (pause.checked) {
                setTimeout(refresh, intervalSec * 1000)
            } else {
                location.reload()
            }
        }
    </script>
@endsection
