@extends('layouts.player')

@section('content')
    <div class="container">
        <h4 class="text-center text-white">{{ $fileInfo['group'] }} {{ $fileInfo['filename'] }}</h4>

{{--        <div>--}}
{{--            <button type="button" class="btn btn-primary" id="btnCapture">capture</button>--}}
{{--            <div id="imgCapture" style=""></div>--}}
{{--        </div>--}}

        <div class="d-flex position-relative mx-auto" style="width: 80%;">
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

        let data = null;
        fetch(FILE)
            .then(r => r.arrayBuffer())
            .then(b => data = b)
            .then(loadProject)
            .catch((e) => console.log(e));

        let t = null;
        function loadProject() {
            if (Scratch.vm === undefined) {
                timerForDetectIfVmIsReady()
            } else {
                Scratch.vm.loadProject(data)
            }
        }

        function timerForDetectIfVmIsReady() {
            setTimeout(loadProject, 500)
        }

        const btnCapture = document.getElementById('btnCapture')
        if (btnCapture !== null) {
            btnCapture.addEventListener('click', captureCanvasToPng)
        }

        // 擷取 canvas 為 png
        function captureCanvasToPng () {
            let canvasWidth = Scratch.renderer.canvas.clientWidth;
            let sizeToRetry = getSizeToRetry(canvasWidth);
            let imgBase64 = Scratch.renderer.canvas.toDataURL('image/png')
            console.log('0 ' + imgBase64.length)

            let counter = 1
            const maxCounter = 20 // 最多重試次數
            let timer = null
            timer = setInterval(
                () => {
                    imgBase64 = Scratch.renderer.canvas.toDataURL('image/png')
                    console.log(counter + ' ' + imgBase64.length)
                    if (imgBase64.length === sizeToRetry) {
                        counter++
                        if (counter === maxCounter) clearInterval(timer)
                    } else {
                        document.getElementById('imgCapture').innerHTML = `<img src="${imgBase64}">`
                        clearInterval(timer)
                    }
                }, 1000)
        }

        // 依照 canvas width 取得重試的 size
        function getSizeToRetry (canvasWidth) {
            let sizeToRetry = 0;
            switch (canvasWidth) {
                case 150:
                    sizeToRetry = 1474
                    break;
                case 200:
                    sizeToRetry = 2350
                    break;
                case 250:
                    sizeToRetry = 3318
                    break;
                case 300:
                    sizeToRetry = 4454
                    break;
                case 350:
                    sizeToRetry = 6086
                    break;
                case 400:
                    sizeToRetry = 7734
                    break;
                case 450:
                    sizeToRetry = 9438
                    break;
                case 500:
                    sizeToRetry = 11650
                    break;
            }

            return sizeToRetry;
        }
    </script>
@endsection
