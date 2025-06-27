<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileSyncController extends Controller
{
    public function store(Request $r)
    {
        $this->validate($r, [
            'auth_id' => 'required|integer',
            'name'    => 'required|string',
            'email'   => 'required|email|unique:profiles,email',
        ]);

        $profile = Profile::create($r->only('auth_id','name','email'));

        return response()->json($profile, 201);
    }
}
