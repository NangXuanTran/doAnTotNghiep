<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" id="yourFormId" action="{{ route('class.store') }}">
            @csrf
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>THÊM LỚP HỌC</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="name">TÊN LỚP HỌC</label>
                            <input type="text" name="name" id="name" placeholder="TOEIC CĂN BẢN" class="form-control">
                            @error('name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="teacher_id">GIÁO VIÊN</label>
                            <select class="form-control" id="teacher_id" name="teacher_id" placeholder="">
                                <option value="">--- Lựa chọn ---</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="room_id">CHỌN PHÒNG HỌC</label>
                            <select class="form-control" id="room_id" name="room_id">
                                <option value="">--- Lựa chọn ---</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="students">HỌC VIÊN</label>
                            <select class="multi-student form-control" name="students[]" multiple="multiple">
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"><span style="font-size: bold">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('students')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="fee">HỌC PHÍ (VND)</label>
                            <input type="text" name="fee" id="fee" placeholder="1000000" class="form-control">
                            @error('fee')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="mt-6 mb-0 btn btn-white btn-sm">XÁC NHẬN</button>
                </div>
            </div>
        </form>
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

<script>
    $(document).ready(function() {
        $('.multi-student').select2();
    });
</script>

