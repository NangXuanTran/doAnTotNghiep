<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" id="yourFormId" action="{{ route('class_lesson.store', $class->id) }}">
            @csrf
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>SỬA THÔNG TIN BUỔI HỌC</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="lesson_name">TÊN BUỔI HỌC</label>
                            <input type="text" name="lesson_name" id="lesson_name" placeholder="TOEIC CĂN BẢN" class="form-control" value="{{ $lesson->lesson_name }}">
                            @error('lesson_name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="start_time">THỜI GIAN BẮT ĐẦU</label>
                            <input type="text" id="start_time" name="start_time" class="form-control" placeholder="01/01/2025 12:00">
                            @error('start_time')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="time">THỜI LƯỢNG (PHÚT)</label>
                            <input type="text" name="time" id="time" placeholder="120" class="form-control">
                            @error('time')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="homeworks">BÀI TẬP VỀ NHÀ</label>
                            <select class="multi-student form-control" name="homeworks[]" multiple="multiple">
                                @foreach ($homeworks as $homework)
                                    <option value="{{ $homework->id }}" {{ $homeworkIds->contains($homework->id) ? 'selected' : ''}}>
                                        <span style="font-size: bold">{{ $homework->homework_name }}</option>
                                @endforeach
                            </select>
                            @error('homeworks')
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#start_time", {
        enableTime: true,
        dateFormat: "d/m/Y H:i",
        time_24hr: false,
        onReady: function(selectedDates, dateStr, instance) {
            instance.input.removeAttribute('readonly');
        }
    });
</script>
