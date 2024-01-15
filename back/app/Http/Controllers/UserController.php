<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers(Request $request, $page)
    {
        $perPage = $request->input('per_page', 10);

        $users = User::orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);


        if ($page > $users->lastPage()) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return response()->json([
            'users' => $users->items(),
            'page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
        ], 200);
    }

    public function deleteUser($userId) {
        $user = User::findOrFail($userId);
        $user->delete();
    }


}
