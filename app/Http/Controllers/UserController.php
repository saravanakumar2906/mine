<?php

namespace App\Http\Controllers;
  
use App\User;
use Illuminate\Http\Request;
use Hash;  
use DB;
use Gate;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Gate::denies('isAdmin')) {
            abort(403);
        }
       // $user = User::latest()->paginate(5);
  $user = DB::table('users')->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('performance', 'users.id', '=', 'performance.user_id')
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->select('users.*','performance.rate','performance.year', 'profiles.first_name','profiles.last_name')
            ->where('user_role.role_id',2)
            ->whereNull('users.deleted_at')
            ->get();
            
        return view('user.index',compact('user'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('isAdmin')) {
            abort(403);
        }
        return view('user.create');
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('isAdmin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
  
        $user=new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
       
      $profile= DB::table('profiles')->insert([
    'email' => $request->email,
    'user_id' => $user->id,
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
      ]);
   
   $performance= DB::table('performance')->insert([
    'rate' => $request->rating,
    'user_id' => $user->id,
    'year' => $request->year,
    //'last_name' => $request->last_name,
      ]);
   
   $user_role= DB::table('user_role')->insert([
    'role_id' => 2,
    'user_id' => $user->id,
    
      ]);
   
        return redirect()->route('admin.user.index')
                        ->with('success','user created successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(Gate::denies('isAdmin')) {
            abort(403);
        }
        return view('user.show',compact('user'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('isAdmin')) {
            abort(403);
        }
        $user = DB::table('users')->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('performance', 'users.id', '=', 'performance.user_id')
            ->select('users.*','performance.rate','performance.year', 'profiles.first_name','profiles.last_name')
            ->where('users.id',$id)
            ->first();
           
        return view('user.edit',compact('user'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('isAdmin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
  
       
        $user=User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
       
      $profile= DB::table('profiles')->whereuser_id($request->id)->update([
    'email' => $request->email,
    'user_id' => $user->id,
    'first_name' => $request->first_name,
    'last_name' => $request->last_name,
      ]);
   
   $performance= DB::table('performance')->whereuser_id($request->id)->update([
    'rate' => $request->rating,
    'user_id' => $user->id,
    'year' => $request->year,
    
      ]);
   
  
        return redirect()->route('admin.user.index')
                        ->with('success','user updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('isAdmin')) {
            abort(403);
        }
        $user=User::find($id);
        $user->deleted_at = date('Y-m-d h:i:s');
        $user->save();
  $performance= DB::table('performance')->whereuser_id($id)->update([
    'deleted_at' => date('Y-m-d h:i:s'),
   ]);
  $profile= DB::table('profiles')->whereuser_id($id)->update([
    'deleted_at' => date('Y-m-d h:i:s'),
    
      ]);
        return redirect()->route('admin.user.index')
                        ->with('success','user deleted successfully');
    }
}
