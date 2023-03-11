<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as Download;

class UploadS3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('uploads.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $file = $request->file('formFile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file = storage_path('app\public\test.xml');

            Storage::disk('s3')->put('insurance/new/test.xml', file_get_contents($file));

            return back()
            ->with('success', 'File has been uploaded.')
            ->with('file', $fileName);
        } catch (\Exception $e) {
            dd($e);
            return back()
                ->with('success', 'Error upload not success');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $xml = new \DOMDocument();
        $xml_album = $xml->createElement("Album");
        $xml_track = $xml->createElement("Track");
        $xml_album->appendChild($xml_track);
        $xml->appendChild($xml_album);
        $path = storage_path('app\public');
        $xml->save($path.'\test.xml');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $config = new stdClass;
        $config->name = 'bar.xml';
        $config->path = 'insurance/new/test.xml';
        if (Storage::disk('s3')->exists($config->path)) {
            $headers = [
                'Content-Type'        => 'Content-Type: application/zip',
                'Content-Disposition' => 'attachment; filename="' . $config->name . '"',
            ];

            return Download::make(Storage::disk('s3')->get($config->path), Response::HTTP_OK, $headers);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
