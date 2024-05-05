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
                                    <h5 class="">NGÂN HÀNG CÂU HỎI</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('question.create') }}" class="btn btn-dark btn-primary">
                                        <i class="fas fa-user-plus me-2"></i> THÊM
                                    </a>
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

                        @foreach ($questions as $question)
                            <div class="card shadow-xs border col-lg-9 col-12" style="margin: 2% 0 0 12%">
                                <h5 style="padding: 10px 10px 5px 10px; "><span style="color:blue">
                                    Câu hỏi {{ $question->id}}:</span> <span>{{ $question->question }}</span>
                                </h5>
                                <div style="position: absolute;margin: 10% 0 0 102%; display:flex">
                                    <a href="{{ route('user.show', $question->id )}}"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                    <a style="margin-left: 5px" href="{{ route('user.destroy', $question->id )}}"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal"
                                        data-user-id="{{ $question->id }}"
                                    >
                                    <i class="fas fa-trash" aria-hidden="true"></i></a>
                                </div>
                                <p style="padding-left: 30px">
                                    <span style="font-weight: bold; ">A. </span>
                                    {{$question->option_1}} <span style="margin-left: 5px;color: blue; font-weight:800">{{ $question->answer == 'option_1' ? 'Đ' : ''}}</span></p>
                                <p style="padding-left: 30px">
                                    <span style="font-weight: bold; ">B. </span>
                                    {{$question->option_2}} <span style="margin-left: 5px;color: blue; font-weight:800">{{ $question->answer == 'option_2' ? 'Đ' : ''}}</span></p>
                                <p style="padding-left: 30px">
                                    <span style="font-weight: bold; ">C. </span>
                                    {{$question->option_3}} <span style="margin-left: 5px;color: blue; font-weight:800">{{ $question->answer == 'option_3' ? 'Đ' : ''}}</span></p>
                                <p style="padding-left: 30px">
                                    <span style="font-weight: bold; ">D. </span>
                                    {{$question->option_4}} <span style="margin-left: 5px;color: blue; font-weight:800">{{ $question->answer == 'option_4' ? 'Đ' : ''}}</span></p>
                            </div>
                        @endforeach
                        <p></p>
                        {{ $questions->links('layouts.paginate') }}
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

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Xác nhận xóa người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa người dùng này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteUserForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('user-id');

        var actionUrl = '/question/' + userId;
        var modal = $(this);
        modal.find('#deleteUserForm').attr('action', actionUrl);
    })
</script>
