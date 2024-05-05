<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" action="{{ route('question.update', $question->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>SỬA THÔNG TIN</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="question">CÂU HỎI</label>
                            <input type="text" value="{{$question->question}}" name="question" id="question" placeholder="QUESTION ABCD" class="form-control">
                            @error('question')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_1">A.</label>
                            <input type="text" value="{{$question->option_1}}" name="option_1" id="option_1" placeholder="OPTION 1" class="form-control">
                            @error('option_1')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_2">B.</label>
                            <input type="text" value="{{$question->option_2}}" name="option_2" id="option_2" placeholder="OPTION 2" class="form-control">
                            @error('option_2')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_3">C.</label>
                            <input type="text" value="{{$question->option_3}}" name="option_3" id="option_3" placeholder="OPTION 3" class="form-control">
                            @error('option_3')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="option_4">D.</label>
                            <input type="text" value="{{$question->option_4}}" name="option_4" id="option_4" placeholder="OPTION 4" class="form-control">
                            @error('option_4')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="answer">ĐÁP ÁN</label>
                            <select id="answer" name="answer">
                                <option value="option_1" @if($question->answer == 'option_1') selected @endif>A</option>
                                <option value="option_2" @if($question->answer == 'option_2') selected @endif>B</option>
                                <option value="option_3" @if($question->answer == 'option_3') selected @endif>C</option>
                                <option value="option_4" @if($question->answer == 'option_4') selected @endif>D</option>
                            </select>
                            @error('answer')
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

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file đã được chọn

        if (file) {
            const reader = new FileReader(); // Tạo một đối tượng FileReader

            reader.onload = function(event) {
                const imgElement = document.createElement('img'); // Tạo thẻ <img> mới
                imgElement.src = event.target.result; // Gán giá trị của file đã đọc vào thuộc tính src của thẻ <img>
                imgElement.style.maxWidth = '100%'; // Thiết lập chiều rộng tối đa của ảnh
                document.getElementById('imageContainer').innerHTML = ''; // Xóa bất kỳ ảnh trước đó trong container
                document.getElementById('imageContainer').appendChild(imgElement); // Thêm ảnh vào container
            };

            reader.readAsDataURL(file); // Đọc file dưới dạng Data URL
        }
    });
</script>
