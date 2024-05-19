<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuUser;
use App\Models\UserLevel;
use Carbon\Carbon;
use File;
use Auth;
use Illuminate\Support\Facades\Route;

class UserRoleController extends Controller
{
    private $menubar;
    public function __construct()
    {
        $this->middleware('auth');
        $this->menubar = Menu::all();
    }

    public function index()
    {
        $getmenu = Menu::where('link',Request()->path())->first();
        $menu = $getmenu->menu;
        $submenu=$getmenu->submenu;
        $menubar=$this->menubar;
        $userlevel = UserLevel::where('user_level',2)->get();
        $data_param = [
            'submenu','menu','menubar','userlevel'
        ];

        $cekmenuuser = MenuUser::where('fk_user_level','=',Auth::user()->user_level)->where('fk_menu','=',$getmenu->id)->get();
        if(count($cekmenuuser)>0 || Auth::user()->user_level==1){
            return view('master/userrole')->with(compact($data_param));
        }else{
            return view('ErrorPage');
        }
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::orderBy('id','asc')->get();
        foreach ($menu as $key) {
            $x = "menu_".$key->id;
            $menuinput = $request->$x;
            if($menuinput=='on'){
                $post = MenuUser::updateOrCreate([
                    'fk_menu' => $key->id,
                    'fk_user_level' => $id
                ], [
                    'created_by' => Auth::id(),
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => Auth::id(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);
            }else{
                $updateData = MenuUser::where('fk_menu',$key->id)->where('fk_user_level',$id)->forceDelete();
            }
        }

        // $createData = Menu::create($data); 
            
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }
}
