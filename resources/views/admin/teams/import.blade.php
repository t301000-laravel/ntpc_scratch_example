@extends('layouts.app')

@section('title', '匯入名單')

@section('content')
    <div class="container">
        <h1>匯入名單</h1>

        <div class="card w-50">
            <div class="card-body">
                <form action="{{ route('admin.teams.import') }}" method="post" enctype="multipart/form-data" id="form-import">
                    @csrf
                    <div class="mt-3 mb-3">
                        <label for="list" class="form-label">選擇 .xlsx 檔</label>
                        <input type="file" name="list" class="form-control" id="list" required accept=".xlsx">
                        <div class="invalid-feedback d-block">
                            注意：匯入前將會清空資料庫，並刪除已上傳之檔案。
                        </div>
                    </div>

                    <div class="float-end">
                        <button type="submit" class="btn btn-danger px-4" id="btn-import">匯入</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">上一頁</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const btn = document.querySelector('#btn-import');
        const f = document.querySelector('#form-import');

        btn.addEventListener('click', clickHandler);

        function clickHandler(e) {
            e.preventDefault();
            if (confirm('確定匯入？')) {
                f.submit();
            }
        }
    </script>
@endsection
