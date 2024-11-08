<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Permission;
use DB;
use App\Models\Roles;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use PDO;

class RoleController extends Controller
{

    public function index()
    {
        $title = 'Roles';
        $get_role = Roles::where('status', '!=', 3)->where('id', '!=', 1)->orderBy('id', 'desc')->get();
        return view('roles.index', compact('title', 'get_role'));
    }

    public function store_roles(Request $request)
    {

        if ($request->hidden_id) {
            $check_data = $this->check_exist_data($request->title, $request->hidden_id);
            if ($check_data) {
                return redirect()->route('roles')->with('error', 'Role already exists.');
            }
            $role = Roles::findOrFail($request->hidden_id);
            $request->validate([
                'title' => 'required',
                'status' => 'required'
            ]);

            $role->title = $request->title;
            $role->status = $request->status;
            $role->update();
            return redirect()->route('roles')->with('success', 'Role updated successfully.');
        }
        $check_data =  $this->check_exist_data($request->title, null);
        if ($check_data) {
            return redirect()->route('roles')->with('error', 'Role already exists.');
        }
        $request->validate([
            'status' => 'required',
            'title' => 'required',
        ]);
        $role = new Roles();
        $role->title = $request->title;
        $role->status = $request->status;
        $role->save();
        return redirect()->route('roles')->with('success', 'Role created successfully.');
    }

    public function edit_roles($id)
    {
        $title = 'Edit Role';
        $find_role = Roles::find($id);
        $get_role = Roles::where('status', '!=', 3)->where('id', '!=', 1)->orderBy('id', 'desc')->get();
        return view('roles.index', compact('title', 'get_role', 'find_role'));
    }

    public function destroy_roles($id)
    {

        $role = Roles::findOrFail($id);
        $role->status = 3;
        $role->update();
        return redirect()->route('roles')->with('success', 'Role deleted successfully.');
    }

    public function check_exist_data($title, $id)
    {

        if ($id != null && $title != null) {
            $check_role = Roles::where('id', '!=', $id)->where('title', $title)->where('status', '!=', 3)->first();
            if ($check_role) {
                return true;
            }
        } else {
            $check_role = Roles::where('title', $title)->where('status', '!=', 3)->first();
            if ($check_role) {
                return true;
            }
        }
    }

    public function permission($id)
    {
        $title = 'Permission';
        $getallpermission = array();
        $permissions = Permission::where('status', 1)->get();
        foreach ($permissions as $permission) {
            $fetch_status = DB::table('role_permission')->where('permission_id', $permission->id)->where('role_id', $id)->first();
            $permission['permission_status'] = $fetch_status;
            $getallpermission[]  = $permission;
        }
        $getrole = Roles::find($id);
        return view('roles.permission', compact('title', 'getallpermission', 'getrole'));
    }

    public function update_permission(Request $request)
    {

        $check_update_permision = DB::table('role_permission')->where('role_id', $request->role_id)->first();
        if ($check_update_permision == null) {
            foreach ($request->hidden_id as $permission) {
                DB::table('role_permission')->insert(['role_id' => $request->role_id, 'permission_id' => $permission]);
            }
            if (isset($request->permission)) {
                foreach ($request->permission as $permission) {
                    DB::table('role_permission')->where('role_id',$request->role_id)->where('permission_id',$permission)->update(['permission_status'=>1]);
                }
            }
            return redirect()->route('roles', $request->role_id)->with('success', 'Update Permission successfully.');
        } else {
            DB::table('role_permission')->where('role_id', $request->role_id)->update(['permission_status' => 2]);
            if (isset($request->permission)) {
                foreach ($request->permission as $update_per_id) {
                    DB::table('role_permission')->where('id', $update_per_id)->update(['permission_status' => 1]);
                }
            }
            return redirect()->route('roles')->with('success', 'Update Permission successfully.');
        }
    }

    public function change_status(Request $request)
    {
        $table_name = $request->table_name;
        $id = $request->id;
        $status = $request->status;

        $change_status = DB::table($table_name)->where('id', $id)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);

        if ($change_status) {
            return response()->json(['status' => 'status changed successfully']);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
