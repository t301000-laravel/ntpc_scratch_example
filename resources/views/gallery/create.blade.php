@extends('layouts.player')

@section('content')
    <div class="container">
        <h4 class="text-center text-white">新增</h4>

        <div class="row mt-5">
            <div class="col">
                <form action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data" id="upload-form">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">選擇要上傳的作品檔案</label>
                        <input class="form-control" type="file" name="myfile" id="formFile" accept=".sb3" required>
                    </div>

                    <input type="hidden" name="img_base64" id="img-base64" value="">

                    <div class="float-end">
                        <button type="submit" class="btn btn-primary px-5 btn-lg" id="btn-submit">上傳</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3 g-5">
            <div class="col text-center">
                <h2 class="bg-warning text-white p-3">作品預覽</h2>
                <div class="position-relative border border-secondary border-1" style="display: none;" id="sb3-player">

                    {{-- player html 會由 javascript 在此 插入 / 移除 --}}

                    <div id="btns" class="d-flex align-items-center">
                        <button id="green" title="start"></button>
                        <button id="stop" title="stop"></button>
                        <button id="f" title="fullscreen" class="ms-auto"></button>
                    </div>

                    <div id="loading"><span>載入中....</span></div>
                </div>
            </div>

            <div class="col text-center">
                <h2 class="bg-warning text-white p-3">作品截圖</h2>
                <button type="button" class="btn btn-primary btn-lg mt-2 px-5 d-none" id="btnCapture">截圖</button>
                <div id="imgCapture" class="mx-auto w-75 p-3"></div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        #imgCapture {
            font-size: 20px;
            font-weight: bold;
        }
        #loading {
            position: absolute;
            top: 0;
            left: 0;
            font-size: 24px;
            font-weight: bolder;
            color: #a20f15;
            background-color: white;
            width: 100%;
            height: 100%;
            /*transform: translate(-50%, -50%);*/
            display: none;
            z-index: 9999;
        }
        #l {
            display: none;
        }
        #btns {
            position: relative;
            height: 30px;
            border: none;
            background: none;
            background-color: #000;
        }
        #green {
            -webkit-appearance: none;
            border: none;
            background: none;
            /*position: absolute;*/
            /*top: -35px;*/
            /*left: 0;*/
            width: 30px;
            height: 30px;
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 24px;
            background-image: url({{ asset('sb3_player/js/greenFlag.svg') }});
            /*background-color: rgba(0, 0, 0, 0.5);*/
            /*border-bottom-left-radius: 10px;*/
        }
        #stop {
            -webkit-appearance: none;
            border: none;
            background: none;
            /*position: absolute;*/
            /*top: -35px;*/
            /*left: 32px;*/
            width: 30px;
            height: 30px;
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 24px;
            background-image: url({{ asset('sb3_player/js/stop.svg') }});
            /*background-color: rgba(0, 0, 0, 0.5);*/
            /*border-bottom-left-radius: 10px;*/
        }
        #f {
            -webkit-appearance: none;
            border: none;
            background: none;
            /*position: absolute;*/
            /*top: -35px;*/
            /*right: 0;*/
            width: 30px;
            height: 30px;
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 24px;
            background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"%3E%3Cpath d="M14 28h-4v10h10v-4h-6v-6zm-4-8h4v-6h6v-4H10v10zm24 14h-6v4h10V28h-4v6zm-6-24v4h6v6h4V10H28z" fill="%23fff"/%3E%3C/svg%3E');
            /*background-color: rgba(0, 0, 0, 0.5);*/
            /*border-bottom-left-radius: 10px;*/
        }
        .fullscreen #f {
            background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"%3E%3Cpath d="M10 32h6v6h4V28H10v4zm6-16h-6v4h10V10h-4v6zm12 22h4v-6h6v-4H28v10zm4-22v-6h-4v10h10v-4h-6z" fill="%23fff"/%3E%3C/svg%3E');
        }
        #m {
            position: absolute;
            top: 0;
            left: 0;
        }
        .monitor {
            position: fixed;
            top: 0;
            background-color: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.25rem;
            font-size: 0.75rem;
            overflow: hidden;
            padding: 3px;
            color: white;
            white-space: pre;
        }
        .monitor-label {
            margin: 0 5px;
            font-weight: bold;
        }
        .monitor-value {
            display: inline-block;
            vertical-align: top;
            min-width: 34px;
            text-align: center;
            border-radius: 0.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            user-select: text;
            transform: translateZ(0);
        }
    </style>
@endsection

@section('script')

    <script type="text/javascript">
        const uploadForm = document.querySelector("#upload-form");
        const btnSubmit = document.querySelector("#btn-submit");
        const imgBase64Input = document.querySelector("#img-base64");
        const fileInput = document.querySelector("#formFile");
        const sb3Player  = document.getElementById('sb3-player');
        let isFirstRun = true;
        let FILE;

        // player html 會動態插入 / 移除
        const player_html = `
            <div id="w">
                <canvas id="s" class="w-100"></canvas>
                <div id="m"></div>
                <div id="b">
                    <label id="q" for="a" class="d-none">Question</label>
                    <input type="text" id="a" class="d-none">
                </div>
            </div>
        `

        let captureSuccess = false

        btnSubmit.addEventListener('click', (e) => {
            e.preventDefault()
            if (!document.querySelector('#imgCapture>img')) {
                alert('請先選擇檔案並完成截圖')
                return
            }

            imgBase64Input.value = document.getElementById('captured-img').src
            uploadForm.submit()
        })

        // listen for the change event so we can capture the file
        fileInput.addEventListener("change", (e) => {
            // get a reference to the file
            const file = e.target.files[0];

            if (!file) {
                return
            }

            // 如果 DOM 有 player 則移除之
            const node_w = document.getElementById('w')
            if (node_w) {
                sb3Player.removeChild(node_w)
            }

            document.getElementById('loading').style.display = 'block';

            // encode the file using the FileReader API
            const reader = new FileReader();
            reader.onloadend = () => {
                sb3Player.insertAdjacentHTML('afterbegin', player_html)
                // log to console
                // logs data:<type>;base64,wL2dvYWwgbW9yZ...
                //console.log(reader.result);
                FILE = reader.result
                if (isFirstRun) {
                    loadScriptsInOrder([
                        '{{ asset('sb3_player/js/vm.min.js') }}',
                        '{{ asset('sb3_player/js/play_scratch.js') }}',
                    ]).then(function () {
                        sb3Player.style.display = 'block'
                    }).then(() => loadScriptsInOrder([
                        '{{ asset('sb3_player/js/load_player.js') }}',
                    ]))
                } else {
                    imgCapture.innerHTML = ""
                    Scratch.vm.runtime.stopAll()
                    Scratch.vm.runtime.dispose()
                    Scratch.vm.clear()

                    fetchFile()
                }
            };
            reader.readAsDataURL(file);
        });

        // Load a script from given `url`
        const loadScript = function (url) {
            return new Promise(function (resolve, reject) {
                const script = document.createElement('script');
                script.src = url;

                script.addEventListener('load', function () {
                    // The script is loaded completely
                    resolve(true);
                });

                document.head.appendChild(script);
            });
        };

        // Perform all promises in the order
        const waterfall = function (promises) {
            console.log(promises)
            return promises.reduce(
                function (p, c) {
                    // console.log(p,c)
                    // Waiting for `p` completed
                    return p.then(function () {
                        // and then `c`
                        // 原程式碼執行時出現 c 不是 function 之錯誤
                        // 修正為檢查 c 是否為 function
                        if (c instanceof Function) {
                            // 是則執行原程式碼
                            return c().then(function (result) {
                                return true;
                            });
                        } else {
                            // 不是 function 則回傳 true
                            return true
                        }
                    });
                },
                // The initial value passed to the reduce method
                Promise.resolve([])
            );
        };

        // Load an array of scripts in order
        const loadScriptsInOrder = function (arrayOfJs) {
            const promises = arrayOfJs.map(function (url) {
                return loadScript(url);
            });
            return waterfall(promises);
        };
    </script>
@endsection
