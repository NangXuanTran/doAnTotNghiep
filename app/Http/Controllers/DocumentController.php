<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Exception;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::paginate(10)->withQueryString();
        foreach ($documents as $document) {
            $document['link_url'] = basename($document['link_url']);
        }

        return view('document.index', compact('documents'));
    }

    public function uploadFile(Request $request)
    {
        if ($request->file('file')->extension() != 'pdf') {
            flash()->addError('Chỉ hỗ trợ upload file dạng pdf.');

            return redirect()->route('document.index');
        }
        $request['link_url'] = $this->upload($request);

        unset($request['file']);
        Document::create($request->all());

        flash()->addSuccess('Thêm thông tin thành công.');

        return redirect()->route('document.index');
    }

    public function downloadFile(Request $request, $id)
    {
        $documentUrl = Document::find($id)->link_url;

        if (file_exists($documentUrl)) {
            return response()->file($documentUrl, [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="'.basename($documentUrl).'"',
            ]);
        } else {
            flash()->addError('Download file không thành công.');

            return redirect()->route('document.index');
        }
    }

    public function destroy($id)
    {
        Document::where('id', $id)->delete();

        flash()->addSuccess('Xóa thông tin thành công.');

        return redirect()->route('document.index');
    }

    public function upload($request)
    {
        $file = $request->file('file');

        try {
            return $this->uploadImage($file);
        } catch (Exception $e) {
            return false;
        }
    }

    public function uploadImage($file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        $imageUrl = url('uploads/'.$fileName);

        return $imageUrl;
    }

    public function prepairFolder()
    {
        $year = date('Y');
        $month = date('m');
        $storagePath = "$year/$month/";

        if (! file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        return $storagePath;
    }
}
