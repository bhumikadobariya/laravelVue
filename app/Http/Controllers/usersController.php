<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use Validator;
use Input;
use Response;
use Auth;
use Hash;

class usersController extends Controller
{
  /**
   * CategoriesController constructor.
   */
  public function __construct()
  {
      $this->middleware('auth:api');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = User::where('id','!=',Auth::user()->id)->get();
    return $user;
  }

  /**
   * Update the given user.
   *
   * @param  Request  $request
   * @param  string  $userId
   * @return Response
   */
  public function update(Request $request, $userId)
  {
    $name = $request->input('name');
    $email = $request->input('email');
    $rules = array(
            'name'=>'required|max:255',
            'email'=>'required|email|max:255',
            );
    $validator = Validator::make($request->all(), $rules);
    if($validator->fails()) {
      $messages = $validator->messages()->toArray();
       return Response::json([
                              'success' => false,
                              'errors'    => $messages,
                              'data' => []
                            ], 500)->header('Content-Type', 'application/json');
    } else {
      $user = User::find($userId);
      if($user) {
        $user->name = $name;
        $user->email = $email;
        $user->save();
        return response()->json(['success' => 'true', 'message' => 'user updated successfully', 'data' => []], 200);
      } else {
        return response()->json(['success' => 'false', 'message' => 'Not found users', 'data' => []], 500);
      }

    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);

    if($user){
      $user->delete();
    }else{
      return response()->json(['success' => 'false', 'message' => 'Not found users', 'data' => []], 400);
    }
    return response()->json(['success' => 'true', 'message' => 'user deleted successfully', 'data' => []], 200);
  }

  public function getProfile(){
    return Auth::user();
  }

  public function updatePassword($userID){
    $inputs = $request->all();
    $user =User::find($userID);
    $rules = array(
        'password'      => 'required|min:3'
    );

    $validator = Validator::make($inputs, $rules);

    if ($validator->fails()) {

        $messages = $validator->messages();
        return Response::json([
                              'success' => false,
                              'errors'    => $messages->first('password'),
                              'data' => []
                            ], 500)->header('Content-Type', 'application/json');

    }
    // $user = User:: findOrFail($user->id);
    if(isset($inputs['old_password']) && $inputs['old_password'] != '')
    {
        if(!Hash::check($request->get('old_password'), $user->password)){
          return Response::json([
                              'success' => false,
                              'errors'    =>'old password does not match',
                              'data' => []
                            ], 401)->header('Content-Type', 'application/json');
        }
    }

    $user->password = $inputs['password'];
    $user->save();
     return Response::json([
                              'success' => true,
                              'message'    => "Password Changed Successfully",
                              'data' => []
                            ], 200)->header('Content-Type', 'application/json');

  }
}
