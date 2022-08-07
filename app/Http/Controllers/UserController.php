<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{

public function index(Request $request)
{
$users = User::orderBy('id','DESC')->paginate(5);
return view('users.show_users',compact('users'))
->with('i', ($request->input('page', 1) - 1) * 5);
}


public function create()
{
$roles = Role::pluck('name','name')->all();
return view('users.Add_user',compact('roles'));

}

public function store(StoreUserRequest $request)
{
$input = $request->all();
$input['password'] = Hash::make($input['password']);
$user = User::create($input);
$user->assignRole($request->input('roles_name'));
session()->flash('add_user');
return redirect()->route('users.index');
}


public function show($id)
{
$user = User::find($id);
return view('users.show',compact('user'));
}

public function edit($id)
{
$user = User::find($id);
$roles = Role::pluck('name','name')->all();
$userRole = $user->roles->pluck('name','name')->all();
return view('users.edit',compact('user','roles','userRole'));
}

public function update(Request $request, $id)
{
$this->validate($request, [
'name' => 'required',
'email' => 'required|email|unique:users,email,'.$id,
'password' => 'same:confirm-password',
'roles' => 'required'
]);
$input = $request->all();
if(!empty($input['password'])){
$input['password'] = Hash::make($input['password']);
}else{
$input = Arr::except($input,array('password'));
}
$user = User::find($id);
$user->update($input);
DB::table('model_has_roles')->where('model_id',$id)->delete();
$user->assignRole($request->input('roles'));
session()->flash('edit');
return redirect()->route('users.index');
}

public function destroy(Request $request)
{
    User::find($request->user_id)->delete();
    session()->flash('delete');
    return redirect()->route('users.index');
}
}
