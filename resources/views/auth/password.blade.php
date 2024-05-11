<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" action="{{ route('auth.change-my-password', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>ĐỔI MẬT KHẨU</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="password">MẬT KHẨU CŨ</label>
                            <input type="password" name="password" id="password"  class="form-control">
                            @error('password')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="new_password">MẬT KHẨU MỚI</label>
                            <input type="password" name="new_password" id="new_password"
                            class="form-control" >
                            @error('new_password')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="confirm_password">XÁC NHẬN MẬT KHẨU</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                 class="form-control" >
                            @error('confirm_password')
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
