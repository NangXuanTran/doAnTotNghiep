<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" id="yourFormId" action="{{ route('homework.store') }}">
            @csrf
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>THÊM BÀI TẬP VỀ NHÀ</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="homework_name">TÊN</label>
                            <input type="text" name="homework_name" id="homework_name" placeholder="HOMEWORK ABC" class="form-control">
                            @error('name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="time">THỜI GIAN LÀM BÀI (PHÚT)</label>
                            <input type="text" name="time" id="time" placeholder="30" class="form-control">
                            @error('time')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="end_time">HẠN CHÓT</label>
                            <input type="datetime-local" name="end_time" id="end_time" placeholder="" class="form-control">
                            @error('end_time')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="end_time">CÂU HỎI</label>
                            <select class="multi-question form-control" name="questions[]" multiple="multiple">
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id }}"><span style="font-size: bold">Câu hỏi {{ $question->id }}: </span>{{ $question->question }}</option>
                                @endforeach
                            </select>
                            @error('end_time')
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
        $('.multi-question').select2();
    });
</script>

