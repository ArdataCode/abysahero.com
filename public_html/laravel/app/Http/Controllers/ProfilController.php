<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MasterMember;
use Carbon\Carbon;
use Auth;
use Hash;
use File;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $userlevel = auth()->user()->user_level;
        $menu = "home";
        $submenu="";
        
        $member = MasterMember::orderBy('harga','asc')->where('status',1)->get();
        $user = User::where('user_level',2)->get();
        $data_param = [
            'submenu','menu','user','member'
        ];

        if($userlevel==1){
            return view('home/admin')->with(compact($data_param));
        }elseif($userlevel==2){
            return view('home/user')->with(compact($data_param));
        }
        
    }

    public function profil()
    {
        $menu = "";
        $submenu="";
        $menubar="";
        $data_param = [
            'submenu','menu','menubar'
        ];

        return view('profil/UserProfil')->with(compact($data_param));
    }

    public function update(Request $request)
    {
        $iduser=Auth::user()->id;
        $nameuser=Auth::user()->username;

        $data['jenis_kelamin'] = $request->input('jenis_kelamin');
        // $data['ttl'] = Carbon::createFromFormat('d-m-Y',$request->input('ttl'))->isoFormat('YYYY-MM-DD');
        $data['email'] = $request->input('email');
        $data['name'] = $request->input('name');
        $data['alamat'] = $request->input('alamat');

        if ($files = $request->file("photo")) {
            $dataUser = User::find($iduser);
            File::delete($dataUser->photo);
            
            $destinationPath = 'image/upload/admin/'.$nameuser.'/';
            $file = 'Photo_Profil_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $namafile = $destinationPath.$file;
            $data['photo'] = $destinationPath.$file;
        }

        User::find($iduser)->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah'
        ]);
    }

    public function updatepassword(Request $request)
    {
        $oldPassword = $request->input('password');
        $newPassword = bcrypt($request->input('passwordbaru'));
        $hashedPassword = Auth::user()->password;
        $iduser = Auth::user()->id;
        if (Hash::check($oldPassword, $hashedPassword)) 
        {
            $data['password'] = $newPassword;
            User::find($iduser)->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Password berhasil diubah'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Passord lama tidak sesuai!'
            ]);
        }
    }
}
