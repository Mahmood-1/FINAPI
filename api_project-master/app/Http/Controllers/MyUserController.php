<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;

class MyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return parent::success($users);
    }

    /*
     * Login Function For users
    */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        

        // After Validation
        $email = $request['email'];
        $password = $request['password'];
        // dd([$email, $password]);

        $result = auth()->attempt(['email' => $email, 'password' => $password]);
        if ($result) {
            $user = User::find(auth()->user()->id);
            $token = $user->createToken('android')->accessToken;
            return parent::success($token);
        }
        return parent::error('Can not login', 403);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'username' => 'required|min:3|max:16|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'photo' => 'mimes:jpg,png,jpeg,gif,svg',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ( $validation->fails() ) {
            return parent::error($validation->errors());
        }
        $user = new User();
        if ($request->file('photo') != null) {
            $request['image'] = parent::image_upload($request->file('photo'), 'users');
        }

        $request['password'] = \Hash::make($request['password']);
        $user->fill($request->all());
        $result = $user->save();
        return parent::success($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with('activity')->findOrFail($id);
            return parent::success($user);
        } catch (error $e) {
            return parent::error('User Not Found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user() != null && auth()->user()->id == $id) {
            $rules = [
                'name' => 'required|min:3',
                'username' => 'required|min:3|max:16|unique:users,id,' . $id,
                'email' => 'required|email|unique:users,id,' . $id,
                'password' => 'required|min:8',
                'photo' => 'mimes:jpg,png,jpeg,gif,svg',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ( $validation->fails() ) {
                return parent::error($validation->errors());
            }
            try {
                $user = User::findOrFail($id);
                if ($request['password'] != null) {
                    $request['password'] = \Hash::make($request['password']);
                }
                $user->fill($request->all());
                $result = $user->update();
                if ($result == 1) {
                    return parent::success($user);
                } else {
                    return parent::error('Something Went Wrong!!');
                }
            } catch (error $e) {
                return parent::error('User Not Found', 404);
            }
        } else {
            return parent::error('Unauthorized', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return parent::success('User Deleted Successfully');
        } catch (error $e) {
            return parent::error('User Not Found', 404);
        }
    }

    public function start_activity(Request $request) {
        $user_id = 1;
        DB::table('user_activities')->insert([
            'user_id' => $user_id,
            'activity_id' => $request['activity_id'],
            'family_number' => $request['family_number'],
            'girls_number' => $request['girls_number'],
            'boys_number' => $request['boys_number'],
        ]);
    }

    public function add_friend($friend_id) {
        // Check if they are not friend

        // Save Data to tavle
        if ( auth()->user()->id != $friend_id) {
            DB::table('friends')->insert([
                'sender_id' => auth()->user()->id,
                'reciver_id' => $friend_id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ]);
        }
    }

    public function forgot(Request $request) {
        try {
            $user = User::where('email', $request->email)->first();
            $code = rand(100000, 999999);
            \Log::info("Code For Email $request->email is $code");
            DB::table('reset_passwor_code')->insert([
                'user_id' => $user->id,
                'code' => bcrypt($code)
            ]);
            return parent::success('Password Reset Successfully - Check You Email');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return parent::error('User Not Found!!');
        }
    }

    public function reset(Request $request, $code)
    {
        $rules = [
            'password' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return parent::error($validation->errors());
        }
        try {
            $user = User::where('email', $request->email)->first();
            $code_hash = DB::table('reset_passwor_code')->where('user_id', $user->id)->orderBy('id', 'DESC')->first();
            \Log::info("Rest Code For Email $request->email is $code_hash->code");
            if (\Hash::check($code, $code_hash->code)) {
                $user->password = \Hash::make($request->password);
                $user->update();
                return parent::success('Password Updated Successfully');
            }
        } catch (\Exception) {
            return parent::error('User Not Found!!');
        }
    }
}
