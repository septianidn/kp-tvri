<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id){
        $user = User::findOrFail($id);

        return response()->json($user);
    }
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('profil.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        if(Auth::Check())
    {
        $requestData = $request->All();
        $validator = $this->validatePasswords($requestData);
        if($validator->fails())
        {
            return response()->json($validator->getMessageBag(), 422);
        }
        else
        {
            $currentPassword = Auth::User()->password;
            if(Hash::check($requestData['password'], $currentPassword))
            {
                $userId = Auth::User()->id;
                $user = User::find($userId);
                $user->password = Hash::make($requestData['new_password']);;
                $user->save();
                return response()->json(['message', 'Your password has been updated successfully.']);
            }
            else
            {
                return response()->json(['message' => 'Sorry, your current password was not recognised. Please try again.'], 422);
            }
        }
    }
    else
    {
        // Auth check failed - redirect to domain root
        return redirect()->to('/profil');
    }
    }

    public function validatePasswords(array $data)
{
    $messages = [
        'password.required' => 'Please enter your current password',
        'new_password.required' => 'Please enter a new password',
        'new_password_confirmation.not_in' => 'Sorry, common passwords are not allowed. Please try a different new password.'
    ];

    $validator = Validator::make($data, [
        'password' => 'required',
        'new_password' => ['required', 'same:new_password', 'min:8'],
        'new_password_confirmation' => 'required|same:new_password',
    ], $messages);

    return $validator;
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::findOrFail($id);
        
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'   => 'required|min:1',
            'address'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user->update([
            'name'     => $request->name, 
            'phone'   => $request->phone,
            'address'   => $request->address,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $user  
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
        //
    }
}
