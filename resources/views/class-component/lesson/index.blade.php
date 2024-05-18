<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
            <div class="px-5 py-4 container-fluid">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="pb-0 card-header">
                                <div class="row">
                                    <div class="col-6" style="margin-top:10px">
                                        <h5 class="">DANH SÁCH BUỔI HỌC ({{$class->name}})</h5>
                                    </div>
                                    @if (auth()->user()->role == 1)
                                        <div class="col-6 text-end">
                                            <a href="{{ route('homework.create') }}" class="btn btn-dark btn-primary">
                                                <i class="fas fa-plus me-2"></i> THÊM
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="">
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert" id="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert" id="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-secondary text-center">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                ID</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                BUỔI HỌC</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                BẮT ĐẦU</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                KẾT THÚC</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                SỸ SỐ</th>
                                            <th
                                                class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                HÀNH ĐỘNG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lessons as $key => $lesson)
                                            <tr>
                                                <td class="align-middle bg-transparent border-bottom">{{ $key + 1 }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $lesson->lesson_name }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $lesson->start_time }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $lesson->end_time }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $lesson->attendance }} / {{ count($class->students) }}</td>
                                                <td class="text-center align-middle bg-transparent border-bottom">
                                                    <a style="margin-right: 10px" href="{{ route('class.show', $lesson->id )}}"><i class="fas fa-eye" aria-hidden="true"></i></a>
                                                    <a class="{{ $lesson->is_finished ? 'disabled-link' : '' }}" href="{{ route('class.show', $lesson->id )}}"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <x-app.footer />
    </main>

</x-app-layout>

<script src="/assets/js/plugins/datatables.js"></script>
<script>
    const dataTableBasic = new simpleDatatables.DataTable("#datatable-search", {
        searchable: true,
        fixedHeight: true,
        columns: [{
            select: [2, 6],
            sortable: false
        }]
    });
</script>
