<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    public function getMember($matricule = null)
    {

        // $matricule = \Request::get('matricule');

        $users = User::where('role_id', '=', 6)
            ->where(function ($q) use ($matricule) {
                if ($matricule) {
                    $q->where('numero_matricule', 'like', '%' . $matricule);
                }
            })
            ->paginate();

        return $users;
    }

    public function change_user_password(Request $request)
    {

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();
        $user->tokens()->delete();

        return response()->json([
            'success' => 'Modification réussi'
        ]);
    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $data = User::where('role_id', '!=', 6)
                    ->whereHas('role', function($q) {
                        $q->where('name', 'not like', '%EMPLOYEUR%');
                    })
                    ->with('role')
                    ->paginate($perPage);
        return  $data;
    }

    public function change_password(Request $request)
    {

        $user = Auth::user();


        $credintial = $user->email;

        $field = 'email';

        if (!filter_var($credintial, FILTER_VALIDATE_EMAIL)) {
            $field = 'numero_matricule';
            $credintial = $user->numero_matricule;
        }

        // if (!Auth::attempt([$field => $credintial, 'password' => $request->password])) {
        //     return response()->json([
        //         'message' => 'Invalid password'
        //     ], 401);
        // }

        $user->password = bcrypt($request->password);
        $user->save();
        $user->tokens()->delete();

        return response()->json([
            'success' => 'Modification réussi'
        ]);
    }

    public function saveMember(Request $request)
    {

        // Validate request data
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'numero_matricule' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }
        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->firstName . '  ' . $request->lastName,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'description' => $request->description,
                'numero_matricule' => $request->numero_matricule,
                'password' => Hash::make($request->password),
                'role_id' => 6,
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'data' => $user ?? [
                    'name' => $request->firstName . '  ' . $request->lastName,
                    'email' => $request->email,
                    'telephone' => $request->telephone,
                    'description' => $request->description,
                    'numero_matricule' => $request->numero_matricule,
                    'role_id' => 6,
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return  $request->all();
    }

    public function search(Request $request, $search_key)
    {
        $perPage = $request->input('per_page', 20);

        if ($search_key == 'ALL_DATA') {
            return User::where('role_id', '!=', 6)
                        ->whereHas('role', function($q) {
                             $q->where('name', 'not like', '%EMPLOYEUR%');
                        })
                        ->with('role')
                        ->latest()
                        ->paginate($perPage);
        }

        $users = User::where(function ($query) use ($search_key) {
            if ($search_key) {
                $query->where('name', 'like', '%' . $search_key . '%')
                    ->orWhere('email', 'like', '%' . $search_key . '%');
            }
        })->paginate($perPage);


        return $users;
    }




    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return $roles;
    }

    public function addRole($role_id)
    {

        $user->roles()->sync($request->roles);
        return response()->json([
            "success" => "Role add successfully"
        ]);
    }
    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required'

        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        // return redirect()->route('users.index')
        //   ->with('success','User created successfully');
        return response()->json([
            'success',
            'User created successfully'
        ]);
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $user = User::find($id);

        return $user;
    }

    public function foregetPassword(Request $request)
    {
        $email = $request->email;

        $user = User::where('email', $email)->first();
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $user = User::find($id);

        $roles = Role::pluck('name', 'name')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();

        return response()->json([

            "user" => $user,
            "roles" => $roles,
            "userRole" => $userRole,

        ]);
        // return view('users.edit',compact('user','roles','userRole'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email,' . $id,

        ]);

        $input = $request->all();

        if (!empty($input['password'])) {

            $input['password'] = Hash::make($input['password']);
        } else {

            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);

        $user->update($input);

        return response()->json([
            'success',
            'User updated successfully'
        ]);
    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        User::find($id)->forceDelete();

        // return redirect()->route('users.index')

        //                 ->with('success','User deleted successfully');
        return response()->json([
            'success',
            'User deleted successfully'
        ]);
    }
}
