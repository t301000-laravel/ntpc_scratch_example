@extends('layouts.app')

@section('title', '名單管理')

@section('content')
    <div class="container">
        <h1>名單管理 - {{ $group }}</h1>

        @if(session()->has('msg'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('msg') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mt-3">
            <div class="col-12 col-md-2 d-flex flex-row flex-md-column px-md-2 py-md-5">
                <a href="{{ route('admin.teams.index', ['group' => '國小遊戲組']) }}" class="btn btn-outline-primary mb-md-3">國小遊戲組</a>
                <a href="{{ route('admin.teams.index', ['group' => '國小動畫組']) }}" class="btn btn-outline-primary mb-md-3">國小動畫組</a>
                <a href="{{ route('admin.teams.index', ['group' => '國中遊戲組']) }}" class="btn btn-outline-primary mb-md-3">國中遊戲組</a>
                <a href="{{ route('admin.teams.index', ['group' => '國中動畫組']) }}" class="btn btn-outline-primary mb-md-3">國中動畫組</a>
                <a href="{{ route('admin.teams.import') }}" class="btn btn-outline-danger mb-md-3">匯入名單</a>
                <a href="{{ url('files/名單範例.xlsx') }}" class="btn btn-link mb-md-3">匯入範例檔下載</a>
            </div>
            <div class="col-12 col-md-6 px-md-5">
                <div class="float-end">
                    <a href="{{ route('admin.teams.create', ['group' => $group]) }}" class="btn btn-outline-secondary px-4">新增</a>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">帳號</th>
                            <th scope="col">學校</th>
                            <th scope="col">管理</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr class="align-middle">
                                <td scope="row">{{ $team->user->username }}</td>
                                <td id="school-name-{{ $team->id }}">{{ $team->school_name }}</td>
                                <td>
                                    <a href="{{ route('admin.teams.edit', ['team' => $team]) }}" class="btn btn-outline-primary">變更密碼</a>
                                    <form action="{{ route('admin.teams.destroy', ['team' => $team]) }}" method="post"
                                          id="form-{{ $team->id }}" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-outline-danger del-btn" data-id="{{ $team->id }}">刪除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($teams) === 0)
                            <tr class="text-center align-middle">
                                <td colspan="3">沒有參賽名單</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.del-btn').forEach(btn => btn.addEventListener('click', clickDeleteHandler));

        setTimeout(closeAlert, 5000);

        function clickDeleteHandler(e) {
            e.preventDefault();
            const id = e.target.dataset.id;
            const schoolName = document.getElementById('school-name-' + id).innerText;
            if (confirm('確定刪除 ' + schoolName + ' 資料與檔案？')) {
                document.getElementById('form-' + id).submit();
            }
        }

        function closeAlert() {
            const alertNode = document.querySelector('.alert');
            if (alertNode !== null) {
                bootstrap.Alert.getOrCreateInstance(alertNode).close();
            }
        }
    </script>
@endsection
