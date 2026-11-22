<?php

namespace App\Http\Controllers;

use App\Models\JadwalFilm;
use Illuminate\Http\Request;

class JadwalFilmController extends Controller
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

    private function formatData($jadwalFilm)
    {
        $data = $jadwalFilm->toArray();

        $data['created_at'] = $jadwalFilm->created_at
            ? $jadwalFilm->created_at->format('d-m-Y H:i:s') : null;

        $data['updated_at'] = $jadwalFilm->updated_at
            ? $jadwalFilm->updated_at->format('d-m-Y H:i:s') : null;

        return $data;
    }

    public function index(Request $request)
    {
        $query = JadwalFilm::query();

        if ($request->has('bioskop_id')) {
            $query->where('bioskop_id', $request->input('bioskop_id'));
        }

        $jadwalFilm = $query->get()->map(function ($item) {
            return $this->formatData($item);
        });

        return $this->responseData($jadwalFilm->toArray());
    }

    public function show($id)
    {
        $jadwalFilm = JadwalFilm::find($id);

        if (!$jadwalFilm) {
            return $this->responseData([
                'message' => 'Jadwal film tidak ditemukan'
            ], 404);
        }

        return $this->responseData($this->formatData($jadwalFilm));
    }

    public function store(Request $request)
    {
        $jadwalFilm = JadwalFilm::create($request->all());

        return $this->responseData([
            'message' => 'Jadwal film berhasil ditambahkan',
            'data' => $this->formatData($jadwalFilm)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $jadwalFilm = JadwalFilm::find($id);

        if (!$jadwalFilm) {
            return $this->responseData([
                'message' => 'Jadwal film tidak ditemukan'
            ], 404);
        }

        $jadwalFilm->update($request->all());

        return $this->responseData([
            'message' => 'Jadwal film berhasil diperbarui',
            'data' => $this->formatData($jadwalFilm->fresh())
        ]);
    }

    public function destroy($id)
    {
        $jadwalFilm = JadwalFilm::find($id);

        if (!$jadwalFilm) {
            return $this->responseData([
                'message' => 'Jadwal film tidak ditemukan'
            ], 404);
        }

        $jadwalFilm->delete();

        return $this->responseData([
            'message' => 'Jadwal film berhasil dihapus'
        ]);
    }
}