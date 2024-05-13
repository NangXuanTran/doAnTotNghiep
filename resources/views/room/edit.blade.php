<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <form method="POST" action="{{ route('room.update', $room->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-5 row justify-content-center" style="margin-top: 3%">
                <div class="col-lg-6 col-12 ">
                    <div class="card-header" style="margin-bottom: 20px">
                        <h5>SỬA THÔNG TIN PHÒNG HỌC</h5>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <label for="name">TÊN</label>
                            <input type="text" name="name" id="name" value="{{ $room->name }}" placeholder="Room ABC" class="form-control">
                            @error('name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-9">
                            <label for="description">MÔ TẢ</label>
                            <input type="text" name="description" id="description" value="{{ $room->description }}" placeholder=""
                            class="form-control">
                            @error('description')
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
