<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(10)->withQueryString();

        return view('room.index', compact('rooms'));
    }

    public function create() {
        return view('room.add');
    }

    public function store(StoreRoomRequest $request) {
        $room = Room::create($request->all());

        flash()->addSuccess('Thêm thông tin thành công.');
        return redirect()->route('room.index');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);

        return view('room.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('rooms')->ignore($id),
            ],
            'description' => ['string']
        ]);

        unset($request['_token'], $request['_method']);

        $room = Room::where('id', $id)->update($request->all());

        flash()->addSuccess('Cập nhật thông tin thành công');
        return redirect()->route('room.index');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        flash()->addSuccess('Xóa thông tin thành công.');
        return redirect()->route('user.index');
    }
}
