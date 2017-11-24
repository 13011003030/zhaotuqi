<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:50',
            'password' => 'required|max:60',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '登陆成功！');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '密码错误！');
            return redirect()->back();
        }
        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '退出成功！');
        return redirect()->route('login');
    }
}
