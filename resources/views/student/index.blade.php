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
                                    <h5 class="">QUẢN LÝ HỌC VIÊN</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('user.create') }}" class="btn btn-dark btn-primary">
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
                        <div class="table-responsive">
                            <table class="table text-secondary text-center">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            ID</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            ẢNH</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            HỌ TÊN</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            EMAIL</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            SỐ ĐIỆN THOẠI</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            NGÀY SINH</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            HÀNH ĐỘNG   </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="align-middle bg-transparent border-bottom">{{$user->id}}</td>
                                            <td class="align-middle bg-transparent border-bottom">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img src="../assets/img/team-1.jpg" class="rounded-circle mr-2"
                                                        alt="user1" style="height: 36px; width: 36px;">
                                                </div>
                                            </td>
                                            <td class="align-middle bg-transparent border-bottom">{{$user->name}}</td>
                                            <td class="align-middle bg-transparent border-bottom">{{$user->email}}</td>
                                            <td class="text-center align-middle bg-transparent border-bottom">{{$user->phone_number}}</td>
                                            <td class="text-center align-middle bg-transparent border-bottom">{{$user->birthday}}</td>
                                            <td class="text-center align-middle bg-transparent border-bottom">
                                                <a href="{{ route('user.show', $user->id )}}"><i class="fas fa-user-edit" aria-hidden="true"></i></a>
                                                <a href="{{ route('user.destroy', $user->id )}}"
                                                    type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal"
                                                    data-user-id="{{ $user->id }}"
                                                >
                                                <i class="fas fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links('layouts.paginate') }}
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

        var actionUrl = '/user/' + userId;
        var modal = $(this);
        modal.find('#deleteUserForm').attr('action', actionUrl);
    })
</script>
