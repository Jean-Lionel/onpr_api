<?php
namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {

        $data = User::with('role')->orderBy('id','DESC')->paginate(20);
        return  $data;
    }

     public function search($search_key){

         //$search_key = $request->query('search_key');

         if($search_key == 'ALL_DATA') return User::with('role')->orderBy('id','DESC')->paginate(20);

        $users = User::where(function($query) use ($search_key){
            if($search_key){
                $query->where('name', 'like', '%'.$search_key . '%' )
                  ->orWhere('email', 'like', '%'.$search_key. '%');
            }
        })->paginate(20);


        return $users;
    }


    

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return $roles;
    }

    public function addRole($role_id){
        
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
            'success','User created successfully'
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

    public function foregetPassword(Request $request){
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

        $roles = Role::pluck('name','name')->all();

        $userRole = $user->roles->pluck('name','name')->all();

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

            'email' => 'required|email|unique:users,email,'.$id,

        ]);
        
        $input = $request->all();

        if(!empty($input['password'])){ 

            $input['password'] = Hash::make($input['password']);

        }else{

            $input = Arr::except($input,array('password'));    

        }
        $user = User::find($id);

        $user->update($input);
        
       return response()->json([
        'success','User updated successfully'
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

        User::find($id)->delete();

        // return redirect()->route('users.index')

        //                 ->with('success','User deleted successfully');
        return response()->json([
            'success','User deleted successfully'
        ]);

    }

}