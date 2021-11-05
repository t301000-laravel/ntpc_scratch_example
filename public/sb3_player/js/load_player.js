let capturing = false
let AutoStart = false;
let DESIRED_USERNAME = "griffpatch", COMPAT = true, TURBO = false;
let SRC = "file";

// console.log(FILE)

const imgCapture = document.getElementById('imgCapture')

let projectContent = null;

setTimeout(fetchFile, 1000)

function fetchFile() {
    fetch(FILE)
        .then(r => r.arrayBuffer())
        .then(b => projectContent = b)
        .then(() => runBenchmark())
        .then(loadProject)
        .catch((e) => {
            console.log(e)
        });
}

function loadProject() {
    if (Scratch.vm === undefined) {
        timerForDetectIfVmIsReady()
    } else {
        //console.log("FistRun : " + isFirstRun)
        // 透過 Scratch.vm workspaceUpdate 事件自動抓取擷圖
        if (imgCapture !== null) {
            //console.log('add handler to vm')
            Scratch.vm.on('workspaceUpdate', captureCanvasToPng)
        }
        Scratch.vm.loadProject(projectContent)
        document.getElementById('loading').style.display = 'none'
        isFirstRun = false
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
function captureCanvasToPng() {
    if (capturing) return

    capturing = true
    captureSuccess = false
    if (!btnCapture) {
        btnCapture.classList.add('d-none')
    }
    imgCapture.innerHTML = `<span>擷圖中</span>`
    let imgBase64 = Scratch.renderer.canvas.toDataURL('image/png')
    //console.log('0 ' + imgBase64)
    console.log('0 ' + imgBase64.length)

    let base64 = imgBase64;

    let counter = 1
    const maxCounter = 20 // 最多重試次數
    let timer = null
    timer = setInterval(
        () => {
            imgBase64 = Scratch.renderer.canvas.toDataURL('image/png')
            //console.log(counter + ' ' + imgBase64)
            console.log(counter + ' ' + imgBase64.length)

            if (base64.length === imgBase64.length) {
                counter++
                if (counter === maxCounter) {
                    clearInterval(timer)
                    imgCapture.innerHTML = `<span>截圖失敗，請重試</span>`
                    capturing = false
                    if (!btnCapture) {
                        btnCapture.classList.remove('d-none')
                    }
                }
            } else {
                const biggerBase64 = base64.length > imgBase64.length ? base64 : imgBase64
                //console.log('Captured ' + biggerBase64)
                console.log('Captured ' + biggerBase64.length)
                imgCapture.innerHTML = `<img src="${ biggerBase64 }" class="img-fluid" id="captured-img">`
                clearInterval(timer)
                capturing = false
                captureSuccess = true
                console.log('monitors : ' + document.getElementsByClassName('monitor').length)
            }
        }, 1000)
}
