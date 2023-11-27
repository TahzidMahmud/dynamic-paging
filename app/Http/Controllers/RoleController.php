<?php

namespace App\Http\Controllers;

use App\Models\Permission as ModelsPermission;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\RoleActionLog;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_staff_roles'])->only('index');
        $this->middleware(['permission:add_staff_roles'])->only('create');
        $this->middleware(['permission:edit_staff_roles'])->only('edit');
        $this->middleware(['permission:delete_staff_roles'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.staff.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.staff.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);

        RoleActionLog::create([
            'role_id' => $role->id,
            'user_id' => auth()->user()->id,
            'action' => 'Create',
            'role_name' => $role->name,
            'user_name' => auth()->user()->name,
            'permission_update' => null
        ]);
        flash(translate('New Role has been added successfully'))->success();
        return redirect()->route('roles.index');
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
        $role = Role::findOrFail(decrypt($id));
        return view('backend.staff.roles.edit', compact('role'));
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
        // echo $request->name; die();
        $role = Role::findOrFail($id);

        $role->name = $request->name;


        $data_change = [];
        $new_permissions = $request->permissions;
        $permissions = [];
        foreach($role->permissions as $permission){
            array_push($permissions, (String)$permission->id);
        }
        $new_added = array_diff($new_permissions,$permissions);
        $deleted = array_diff($permissions, $new_permissions);

        if($new_added){

            $data_change['new_added'] = Permission::whereIn('id',$new_added)->pluck('name')->toArray();
        }
        if($deleted){
            $data_change['deleted'] = Permission::whereIn('id',$deleted)->pluck('name')->toArray();
        }

        RoleActionLog::create([
            'role_id' => $role->id,
            'user_id' => auth()->user()->id,
            'action' => 'Update',
            'role_name' => $role->name,
            'user_name' => auth()->user()->name,
            'permission_update' => !empty($data_change) ? json_encode($data_change) : null
        ]);

        // dd(json_encode($data_change));

        $role->syncPermissions($request->permissions);
        $role->save();
        flash(translate('Role has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        // dd($role);
        RoleActionLog::create([
            'role_id' => $role->id,
            'user_id' => auth()->user()->id,
            'action' => 'Delete',
            'role_name' => $role->name,
            'user_name' => auth()->user()->name,
            'permission_update' => null
        ]);
        Role::destroy($id);
        flash(translate('Role has been deleted successfully'))->success();
        return redirect()->route('roles.index');
    }
}
