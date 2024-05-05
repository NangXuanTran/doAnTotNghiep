<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" action="{{ route('question.store') }}">
            @csrf
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>THÊM CÂU HỎI</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="question">CÂU HỎI</label>
                            <input type="text" name="question" id="question" placeholder="QUESTION ABCD" class="form-control">
                            @error('question')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_1">A.</label>
                            <input type="text" name="option_1" id="option_1" placeholder="OPTION 1" class="form-control">
                            @error('option_1')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_2">B.</label>
                            <input type="text" name="option_2" id="option_2" placeholder="OPTION 2" class="form-control">
                            @error('option_2')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_3">C.</label>
                            <input type="text" name="option_3" id="option_3" placeholder="OPTION 3" class="form-control">
                            @error('option_3')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_4">D.</label>
                            <input type="text" name="option_4" id="option_4" placeholder="OPTION 4" class="form-control">
                            @error('option_4')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="answer">ĐÁP ÁN</label>
                            <select id="answer" name="answer">
                                <option value="option_1">A</option>
                                <option value="option_2">B</option>
                                <option value="option_3">C</option>
                                <option value="option_4">D</option>
                            </select>
                            @error('answer')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- <button type="submit" class="mt-6 mb-0 btn btn-white btn-sm float-end">Save
                        changes</button> --}}
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
