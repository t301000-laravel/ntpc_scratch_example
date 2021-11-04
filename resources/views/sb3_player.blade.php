@extends('layouts.player')

@section('content')
    <div class="container">
        <h4 class="text-center text-white">{{ $fileInfo['group'] }} {{ $fileInfo['filename'] }}</h4>

        <div class="d-flex position-relative mx-auto" style="width: 80%;">
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

        <div style="position: fixed; bottom: 30px; left: 30px; width: 150px;">
            <button type="button" class="btn btn-primary" id="btnCapture">capture</button>
            <div id="imgCapture">
                <span class="text-white">擷圖中</span>
            </div>
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

        const imgCapture = document.getElementById('imgCapture')

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
                // 透過 Scratch.vm workspaceUpdate 事件自動抓取擷圖
                if (imgCapture !== null) {
                    Scratch.vm.on('workspaceUpdate', captureCanvasToPng)
                }
                Scratch.vm.loadProject(projectContent)
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
            let imgBase64 = Scratch.renderer.canvas.toDataURL('image/png')
            console.log('0 ' + imgBase64)
            console.log('0 ' + imgBase64.length)

            let base64 = imgBase64;

            let counter = 1
            const maxCounter = 20 // 最多重試次數
            let timer = null
            timer = setInterval(
                () => {
                    imgBase64 = Scratch.renderer.canvas.toDataURL('image/png')
                    console.log(counter + ' ' + imgBase64)
                    console.log(counter + ' ' + imgBase64.length)

                    if (base64.length === imgBase64.length) {
                        counter++
                        if (counter === maxCounter) clearInterval(timer)
                    } else {
                        const biggerBase64 = base64.length > imgBase64.length ? base64 : imgBase64
                        console.log('Captured ' + biggerBase64)
                        console.log('Captured ' + biggerBase64.length)
                        imgCapture.innerHTML = `<img src="${biggerBase64}" class="img-fluid">`
                        clearInterval(timer)
                    }
                }, 1000)
        }
    </script>
@endsection
