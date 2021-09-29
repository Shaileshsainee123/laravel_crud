<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CrudController extends Controller
{
    public function saveform(Request $r)
    {
        $this->validate($r, [
            "id" => 'nullable|integer|exists:records,id',
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "mobile" => "required|numeric|digits:10"
        ]);

        return     Record::updateOrCreate(
            [
                'id' => $r->id,
            ],
            [
                'name' => $r->name,
                'email' => $r->email,
                'mobile' => $r->mobile,
            ]
        );
    }
    public function getrecords()
    {
        $data = Record::latest()->get()->toArray();
        return ['data' => $data];
    }

    public function delete(Record $record)
    {
        $record->delete();
    }

    public function getrec(Record $record)
    {
        return $record;
    }
}
