<?php

namespace App\Http\Controllers;


use App\Models\Pass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guest() && auth()->user()->role->name === 'Admin') {
            return response()->json(Pass::with('address')->get());
        } else {
            $passId = $request->cookie('passId');
            $pass = Pass::where('id', $passId)->with('address')->get();
            return response()->json($pass);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $pass = new Pass();
        $pass->fio = $data['fio'];
        $pass->status = 'Обрабатывается';
        $pass->address_id = $data['address_id'];
        $pass->save();
        setcookie('passId', $pass->id, ["path" => "*", "expires" => time()+(60*60*24*7)]);

        return response()->json($pass);
    }

    public function update(Request $request, int $id)
    {
        if (!Auth::guest() && auth()->user()->role->name === 'Admin') {
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
        if (!Auth::guest() && auth()->role->name === 'Admin') {
            $pass = Pass::where('id', $id)->first();
            $pass->delete();
            return response()->json(['message' => 'ok']);
        }

        throw new \Exception('unauth');
    }
}
