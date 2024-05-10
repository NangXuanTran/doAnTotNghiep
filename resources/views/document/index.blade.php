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
                                    <h5 class="">QUẢN LÝ TÀI LIỆU</h5>
                                </div>

                                <div class="col-6 text-end">
                                    <form id="uploadForm" action="{{ route('document.upload') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label for="fileUpload" class="btn btn-dark btn-primary">
                                            <i class="fas fa-upload me-2"></i> UPLOAD
                                        </label>
                                        <input type="file" id="fileUpload" style="display: none;" name="file">
                                        <input type="submit" id="submitBtn" style="display: none;">
                                    </form>
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
                                            FILE</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            NGÀY CẬP NHẬT</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            HÀNH ĐỘNG   </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $key => $document)
                                        <tr>
                                            <td class="align-middle bg-transparent border-bottom">{{ $document->id }}</td>
                                            <td class="align-middle bg-transparent border-bottom"
                                                style="text-decoration-line: underline; color: #1e293b">
                                                <a href="{{ route('document.download', $document->id )}}">
                                                    {{$document->link_url}}
                                                </a>
                                            </td>
                                            <td class="align-middle bg-transparent border-bottom">{{ $document->updated_at}}</td>
                                            <td class="text-center align-middle bg-transparent border-bottom">
                                                <a href="{{ route('document.destroy', $document->id )}}"
                                                    type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal"
                                                    data-document-id="{{ $document->id }}"
                                                >
                                                <i class="fas fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $documents->links('layouts.paginate') }}
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

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 20%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Xác nhận xóa người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa file này không?
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
        var documentId = button.data('document-id');

        var actionUrl = '/document/' + documentId;
        var modal = $(this);
        modal.find('#deleteUserForm').attr('action', actionUrl);
    })

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("fileUpload").addEventListener("change", handleFileSelect);
    });

    function handleFileSelect(event) {
        document.getElementById("submitBtn").click();
    }
</script>
