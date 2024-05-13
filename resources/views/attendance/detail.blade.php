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
                                    <h5 class="">{{ $class->class_name }}</h5>
                                </div>
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
                                            LỚP HỌC</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            SỐ BUỔI HỌC</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            SỐ HỌC SINH</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            HÀNH ĐỘNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($class->lessons as $key => $lesson)
                                        <tr @unless($lesson->isFinish) disabled @endunless>
                                            <td class="align-middle bg-transparent border-bottom">{{ $lesson->id }}</td>
                                            <td class="align-middle bg-transparent border-bottom">{{ $lesson->name }}</td>
                                            <td class="align-middle bg-transparent border-bottom">{{ $lesson->countLesson }}</td>
                                            <td class="align-middle bg-transparent border-bottom">{{ $lesson->countStudent }}</td>
                                            @if ($lesson->isFinish)
                                                <td class="text-center align-middle bg-transparent border-bottom">
                                                    <a href="{{ route('room.show', $lesson->id )}}"><i class="fas fa-view" aria-hidden="true"></i></a>
                                                </td>
                                            @else
                                                <td class="text-center align-middle bg-transparent border-bottom">
                                                    <a href="{{ route('room.show', $lesson->id )}}"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

