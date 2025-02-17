<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Events\SendMail;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
     $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|max:20',
        'password_confirmation' => 'required|same:password',
        'state_id' => 'required|exists:states,id',
        'city_id' => 'required|exists:cities,id',
        'gender' => 'required|in:male,female',
        'hobbies' => 'nullable|array',
        'hobbies.*' => 'in:reading,writing,swimming',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
     ]);

     if($validator->fails()){
        return response()->json([
            'status' => 'failed',
            'errors' => $validator->errors()
        ], 401);
     }

    //  $uploadPath = public_path('uploads');
    //  if (!file_exists($uploadPath)) {
    //      mkdir($uploadPath, 0755, true);
    //  }

     // Store the image
     if ($request->file('image')) {
        //  $imageName = time() . '.' . $request->image->extension();
        //  $request->image->move($uploadPath, $imageName);
        //  $imagePathName = 'uploads/'.$imageName;

        $file = $request->file('image');

        // Rename file with timestamp
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store in storage/app/public/uploads
        $filePath = $file->storeAs('uploads', $fileName, 'public');
     }

     $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'state_id' => $request->state_id,
        'city_id' => $request->city_id,
        'gender' => $request->gender,
        'hobbies' => isset($request->hobbies) ? json_encode($request->hobbies) : null,
        'image' => $filePath,
     ]);

     SendMail::dispatch($user->id);

     $token = $user->createToken('userAuthToken')->plainTextToken;
     return response()->json([
         'status' => 'success',
         'token' => $token,
         'message' => 'User Registered Successfully.'
     ], 200);
    }

    
    public function update(Request $request)
    {
     $validator = Validator::make($request->all(),[
        'name' => 'required',
        'state_id' => 'required|exists:states,id',
        'city_id' => 'required|exists:cities,id',
        'gender' => 'required|in:male,female',
        'hobbies' => 'nullable|array',
        'hobbies.*' => 'in:reading,writing,swimming',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
     ]);

     if($validator->fails()){
        return response()->json([
            'status' => 'failed',
            'errors' => $validator->errors()
        ], 401);
     }

    //  $uploadPath = public_path('uploads');
    //  if (!file_exists($uploadPath)) {
    //      mkdir($uploadPath, 0755, true);
    //  }


     $user = User::where('id', $request->id)->first();
    
     
     // Store the image
     if ($request->file('image')) {
        //  $imageName = time() . '.' . $request->image->extension();
        //  $request->image->move($uploadPath, $imageName);
        //  $imagePathName = 'uploads/'.$imageName;

        // Delete old file
        if (Storage::disk('public')->exists(str_replace('storage/', '', $user->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $user->image));
        }
        $file = $request->file('image');

        // Rename file with timestamp
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store in storage/app/public/uploads
        $filePath = $file->storeAs('uploads', $fileName, 'public');
     }

     $user->update([
        'name' => $request->name,
        'state_id' => $request->state_id,
        'city_id' => $request->city_id,
        'gender' => $request->gender,
        'hobbies' => isset($request->hobbies) ? json_encode($request->hobbies) : null,
        'image' => $filePath,
     ]);
     
     return response()->json([
         'status' => 'success',
         'message' => 'User updated Successfully.',
         'data' => $user
     ], 200);
    }

    public function delete(Request $request){
        try{
            $user = User::where('id', $request->id)->first();
            // dd($user);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted Successfully.'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
