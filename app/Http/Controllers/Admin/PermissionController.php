<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $data['routes'] = Helper::getRouteNames();
        // dd($data['routes']);
        $permissions = Permission::orderBy('name','asc')->get();
        $data['permissions'] = $permissions->groupBy('menu')->toArray();
        return view('admin.permissions.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'data.*.menu' => 'required',
            'data.*.admin' => 'required',
            'data.*.parent_label' => 'required',
            'data.*.label' => 'required',
            'data.*.name' => 'required|distinct',
        ]);
        $data = $request->all();
        foreach ($data['data'] as $key => $value) {
            Permission::updateOrCreate([
                'id' => $key
            ],$value);
        }
        return response()->json([
            'success' => true,
            'msg' => 'Data Saved'
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Helper::deleteRecord(base64_decode(urldecode($id)),'permissions');
    }
}
