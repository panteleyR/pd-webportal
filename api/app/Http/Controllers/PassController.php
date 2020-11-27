<?php

namespace App\Http\Controllers;


use App\Models\Pass;
use Illuminate\Http\Request;

class PassController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->role->name === 'admin') {
            return response()->json(Pass::all());
        } else {
            $passId = $request->cookie('passId');
            $pass = Pass::where('id', $passId)->first();
            return response()->json($pass);
        }
    }

    public function post(Request $request)
    {
        $data = $request->all();
        $pass = new Pass();
        $pass->fio = $data['fio'];
        $pass->status = 'waiting';
        $pass->address_id = $data['address_id'];
        $pass->save();
        setcookie('passId', $pass->id, ["path" => "*", "expires" => time()+(60*60*24*30)]);

        return response()->json($pass);
    }

    public function update(Request $request, int $id)
    {
        if (auth()->role->name === 'admin') {
            $data = $request->all();
            $pass = Pass::where('id', $id)->first();
            $pass->fio = $data['fio'];
            $pass->status = $data['status'];
            $pass->address_id = $data['address_id'];
            $pass->save();
            return response()->json($pass);
        }

        throw new \Exception('unauth');
    }

    public function destroy(int $id)
    {
        if (auth()->role->name === 'admin') {
            $pass = Pass::where('id', $id)->first();
            $pass->delete();
            return response()->json(['message' => 'ok']);
        }

        throw new \Exception('unauth');
    }
}
