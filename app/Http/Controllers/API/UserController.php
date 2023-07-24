<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $userRole = $user->role()->first();

            $user_name = $user->name;
            $success['token'] = $user->createToken('MyApp', [$userRole->role])->accessToken;
            return response()->json(['success' => $success, 'name' => $user_name], $this->successStatus);
            //return response()->json(['message' => "success", 'id' => $user_id, 'name' => $user_name], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
            //return response()->json(['message' => "error"], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            //return response()->json(['error' => $validator->errors()], 401);
            return response()->json(['message' => "error"], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Atribuirea rolului "basic" utilizatorului creat
        $role = new Role();
        $role->user_id = $user->id;
        $role->role = 'basic';
        $role->save();

        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        //return response()->json(['success' => $success], $this->successStatus);
        return response()->json(['message' => "success"], $this->successStatus);
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    // CRUD
    function getUsers(Request $request)
    {

        return User::join('roles', 'users.id', '=', 'roles.user_id')->select('users.*', 'roles.role')->get();
    }

    function addUser(Request $request)
    {

        return User::create($request->all());
    }

    function editUser(Request $request, $userId)
    {
        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 403);
        }

        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully.']);
    }

    function deleteUser(Request $request, $userId)
    {

        try {
            $user = User::find($userId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 403);
        }
        // stergerea rolului asociat user-ului
        $user->role()->delete();

        // stergerea comenzilor asociate user-ului
        //$user->orders()->delete();

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    // Modificare basic user in admin
    function makeAdmin(Request $request, $userId)
    {

        try {
            $user = User::findOrFail($userId);

            // Actualizare coloană "role" la valoarea "admin"
            $user->role()->update(['role' => 'admin']);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 403);
        }

        return response()->json(['message' => 'Successfully.']);
    }
}