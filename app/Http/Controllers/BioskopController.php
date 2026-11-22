<?php

namespace App\Http\Controllers;

use App\Models\Bioskop;
use Illuminate\Http\Request;

class BioskopController extends Controller
{
    private function responseData($data, $status = 200)
    {
        if (request()->header('Accept') == 'application/xml') {
            $xml = new \SimpleXMLElement('<response/>');
            $this->arrayToXml($data, $xml);

            return response($xml->asXML(), $status)
                ->header('Content-Type', 'application/xml');
        }

        return response()->json($data, $status);
    }

    private function arrayToXml($data, $xml)
    {
        foreach ($data as $key => $value) {
            $key = is_numeric($key) ? 'item' : $key;

            if (is_array($value)) {
                $child = $xml->addChild($key);
                $this->arrayToXml($value, $child);
            } else {
                $xml->addChild($key, htmlspecialchars((string) $value));
            }
        }
    }

    private function formatData($bioskop)
    {
        $data = $bioskop->toArray();

        $data['created_at'] = $bioskop->created_at
            ? $bioskop->created_at->format('d-m-Y H:i:s') : null;

        $data['updated_at'] = $bioskop->updated_at
            ? $bioskop->updated_at->format('d-m-Y H:i:s') : null;

        return $data;
    }

    public function index()
    {
        $bioskop = Bioskop::all()->map(function ($item) {
            return $this->formatData($item);
        });

        return $this->responseData($bioskop->toArray());
    }

    public function show($id)
    {
        $bioskop = Bioskop::find($id);

        if (!$bioskop) {
            return $this->responseData(['message' => 'Bioskop tidak ditemukan'], 404);
        }

        return $this->responseData($this->formatData($bioskop));
    }

    public function store(Request $request)
    {
        $bioskop = Bioskop::create($request->all());

        return $this->responseData([
            'message' => 'Bioskop berhasil ditambahkan',
            'data' => $this->formatData($bioskop)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $bioskop = Bioskop::find($id);

        if (!$bioskop) {
            return $this->responseData(['message' => 'Bioskop tidak ditemukan'], 404);
        }

        $bioskop->update($request->all());

        return $this->responseData([
            'message' => 'Bioskop berhasil diperbarui',
            'data' => $this->formatData($bioskop->fresh())
        ]);
    }

    public function destroy($id)
    {
        $bioskop = Bioskop::find($id);

        if (!$bioskop) {
            return $this->responseData(['message' => 'Bioskop tidak ditemukan'], 404);
        }

        $bioskop->delete();

        return $this->responseData(['message' => 'Bioskop berhasil dihapus']);
    }
}