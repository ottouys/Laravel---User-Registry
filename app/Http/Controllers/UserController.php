<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Load the Home Page
     */
    public function index() : View
    {
        // Truncate for testing
        //User::truncate();

        // Check if users exists
        $userCount = DB::table('users')->count();

        // If no users exists, lets generate using our factory
        if(DB::table('users')->count() == 0){
            $users = User::factory()->count(30)->create();
        } else {
            $users = DB::table('users')->get();
        }        

        return view('welcome')
            ->with('users', $users);  
    }

    /**
     * Return All Users
     */
    public function getAllUsers()
    {
        // Truncate for testing
        //User::truncate();

        // Check if users exists
        $userCount = DB::table('users')->count();

        // If no users exists, lets generate using our factory
        if(DB::table('users')->count() == 0){
            $users = User::factory()->count(30)->create();
        } else {
            $users = DB::table('users')->orderBy('created_at', 'DESC')->get();
        }        

        $response = array(
            'status' => 'success',
            'users' => $users,
        );
        return response()->json($response);
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $email = $request->input('email');

        if (User::where('email', '=', $email)->exists()) {
            $response = array(
                'status' => 'error',
                'msg' => 'User Email already used. Please use a different email.',
            );
            return response()->json($response);
        } else{

            $name = $request->input('name');
            $surname = $request->input('surname');            
            $position = $request->input('position');

            $user = User::create([
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'position' => $position,
                'password' => bcrypt('secret')
            ]);

            if($user->exists) {
                $response = array(
                    'status' => 'success',
                    'msg' => 'User created successfully',
                );
                return response()->json($response);
            } else{
                $response = array(
                    'status' => 'error',
                    'msg' => 'An error occured creating the user',
                );
                return response()->json($response);
            }            
        }        
    }

    /**
     * Delete User
     */
    public function deleteUser(Request $request) 
    {
        $id = $request->input('id');

        if (User::where('id', '=', $id)->exists()) {
            User::find($id)->delete();

            $response = array(
                'status' => 'success',
                'msg' => 'User deleted successfully',
            );
            return response()->json($response);
        } else{
            $response = array(
                'status' => 'error',
                'msg' => 'User not found',
            );
            return response()->json($response);
            
        }
    }
}
