<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $users = User::all();
        return $this->validResponse($users);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);
        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);
    }


    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return $this->validResponse($user);
    }

    public function update(Request $request, int $id)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email,'.$id,
            'password' => 'min:6|confirmed',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($id);
        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->isClean()) {
            return $this->errorResponse("At least one value must change", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->validResponse($user);
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->validResponse($user);
    }

    public function me(Request $request)
    {
        return $this->validResponse($request->user());
    }
}