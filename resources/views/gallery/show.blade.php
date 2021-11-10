@extends('layouts.player')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="d-flex position-relative mt-5 mx-auto" style="width: 80%;">
            {{--        <div class="d-flex position-relative mx-auto" style="width: 520px;">--}}
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
        let FILE = "data:application/octet-stream;base64,{{ $base64 }}";

        let DESIRED_USERNAME = "griffpatch", COMPAT = true, TURBO = false;
        let SRC = "file";

        let projectContent = null;
        fetch(FILE)
            .then(r => r.arrayBuffer())
            .then(b => projectContent = b)
            .then(loadProject)
            .catch((e) => console.log(e));

        function loadProject() {
            if (Scratch.vm === undefined) {
                timerForDetectIfVmIsReady()
            } else {
                Scratch.vm.loadProject(projectContent)
            }
        }

        function timerForDetectIfVmIsReady() {
            setTimeout(loadProject, 500)
        }
    </script>
@endsection
