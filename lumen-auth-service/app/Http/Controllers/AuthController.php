<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;               // ← add
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        // 1. validate input
        $this->validate($r, [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // 2. create user in auth_db
        $user = User::create([
            'name'     => $r->name,
            'email'    => $r->email,
            'password' => Hash::make($r->password),
        ]);

        // 3. push a profile to user-service
        $this->syncProfileToUserService($user);

        // 4. return normal response
        return response()->json($user, 201);
    }

    private function syncProfileToUserService(User $user): void
    {
        $client = new Client(['base_uri' => env('USER_SERVICE_URL')]);

        try {
            $client->post('/api/users', [
                'json' => [                       // ← sends JSON body
                    'auth_id' => $user->id,       // we keep ref to auth-service ID
                    'name'    => $user->name,
                    'email'   => $user->email,
                ],
                'timeout' => 2,                   // fail fast (seconds)
            ]);
        } catch (\Throwable $e) {
            // don’t break registration if sync fails – just log it
            Log::error('User-service sync failed: '.$e->getMessage());
        }
    }

    /* ...login() stays unchanged... */
}
