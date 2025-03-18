<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function upload(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validatedData['name'];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatar, public');
            if ($user->avatar && $user->avatar !== 'avatar/1.png') {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $path;
        }
        $user->save();

        return response()->json([
            'message' => 'Image uploaded successfully',
            'user' => $user,
        ]);
    }
}