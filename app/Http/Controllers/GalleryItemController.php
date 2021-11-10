<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index()
    {
        return view('gallery.index', ['items' => GalleryItem::orderByDesc('id')->get()]);
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'myfile' => ['file'],
            'img_base64' => ['required']
        ]);

        $filename = now()->timestamp;
        $path = Storage::putFileAs('gallery', $request->file('myfile'), $filename . '.sb3');

        $base64_image = $request->get('img_base64'); // your base64 encoded
        list($type, $file_data) = explode(';', $base64_image);
        list(, $file_data) = explode(',', $file_data);

        $thumbStoredPath = 'public/gallery/thumbs/' . $filename . '.png';
        $thumbUrl = 'files/gallery/thumbs/' . $filename . '.png';
        Storage::put($thumbStoredPath, base64_decode($file_data));

        GalleryItem::create([
            'name' => $request->get('name'),
            'sb3_path' => $path,
            'thumb_path' => $thumbUrl
        ]);

        return redirect()->route('gallery.index');
    }

    public function show(Request $request, GalleryItem $gallery)
    {
        abort_if(Storage::missing($gallery->sb3_path), 404);

        $base64 = base64_encode(Storage::get($gallery->sb3_path));

        return view('gallery.show', [
            'title' => $gallery->name,
            'base64' => $base64,
        ]);
    }
}
