@extends('layouts.player')

@section('content')
    <div class="container">
        <h4 class="text-center text-white">{{ $fileInfo['group'] }} {{ $fileInfo['filename'] }}</h4>

        <div class="d-flex position-relative mx-auto" style="width: 85%;">
            <div id="w">
                <canvas id="s"></canvas>
                <div id="m"></div>
                <div id="b">
                    <label id="q" for="a">Question</label>
                    <input type="text" id="a">
                </div>
            </div>

            <button id="green" title="start"></button>
            <button id="stop" title="stop"></button>
            <button id="f" title="fullscreen"></button>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('sb3_player/js/player.css') }}">
@endsection

@section('script')
    <script src="{{ asset('sb3_player/js/vm.min.js') }}"></script>
    <script src="{{ asset('sb3_player/js/play_scratch.js') }}"></script>

    <script type="text/javascript" id="j">
        let AutoStart = false;
        let FILE = "data:application/octet-stream;base64,{{ $fileInfo['base64'] }}";

        let DESIRED_USERNAME = "griffpatch", COMPAT = true, TURBO = false;
        let SRC = "file";

        fetch(FILE)
            .then(r => r.arrayBuffer())
            .then(loadProject)
            .catch((e) => console.log(e));

        let t = null;
        function loadProject(b) {
            if (Scratch.vm === undefined) {
                t = setInterval(() => loadProject(b), 500)
            } else {
                Scratch.vm.loadProject(b)
                if (t !== null) {
                    clearInterval(t);
                }
            }
        }
    </script>
@endsection
