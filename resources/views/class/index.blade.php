<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        @if (!isset($classes))
            <h4>Dữ liệu trống</h4>
        @else
            <div class="px-5 py-4 container-fluid">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="pb-0 card-header">
                                <div class="row">
                                    <div class="col-6" style="margin-top:10px">
                                        <h5 class="">QUẢN LÝ LỚP HỌC</h5>
                                    </div>
                                    @if (auth()->user()->role == 1)
                                        <div class="col-6 text-end">
                                            <a href="{{ route('class.create') }}" class="btn btn-dark btn-primary">
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
                                                TÊN</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                GIÁO VIÊN</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                BUỔI HỌC</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                HỌC VIÊN</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                PHÒNG HỌC</th>
                                            <th
                                                class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                HỌC PHÍ (VND)</th>
                                            <th
                                                class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                HÀNH ĐỘNG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classes as $key => $class)
                                            <tr>
                                                <td class="align-middle bg-transparent border-bottom">{{ $key+ 1 }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $class->name }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $class->teacher->name }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $class->count_finished }} / {{ count($class->lessons) }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ count($class->students) }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ $class->room->name }}</td>
                                                <td class="align-middle bg-transparent border-bottom">{{ number_format($class->fee , 0, ',', ',')}}</td>
                                                <td class="text-center align-middle bg-transparent border-bottom">
                                                    <a style="margin-right: 10px" href="{{ route('class_student.index', $class->id )}}" title="Học viên">
                                                        <i class="fas fa-user-tie" aria-hidden="true"></i>
                                                    </a>
                                                    <a style="margin-right: 10px" href="{{ route('class_lesson.index', $class->id )}}" title="Chi tiết">
                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a style="margin-right: 10px" href="{{ route('class.show', $class->id )}}" title="Sửa thông tin">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $classes->links('layouts.paginate') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

