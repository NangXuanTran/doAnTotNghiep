<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>THÊM HỌC VIÊN</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="name">HỌ TÊN</label>
                            <input type="text" name="name" id="name" placeholder="Nguyen Van An" class="form-control">
                            @error('name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="email">EMAIL</label>
                            <input type="text" name="email" id="email" placeholder="nangxxx@gmail.com" class="form-control">
                            @error('email')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="phone_number">SỐ ĐIỆN THOẠI</label>
                            <input type="text" name="phone_number" id="phone_number" placeholder="0333501xxx"
                                 class="form-control">
                            @error('phone_number')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="birthday">NGÀY SINH</label>
                            <input type="date" name="birthday" id="birthday" class="form-control">
                            @error('birthday')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="image">ẢNH ĐẠI DIỆN</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @error('image')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div id="imageContainer"></div>

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
