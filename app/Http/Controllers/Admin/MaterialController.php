<?php

namespace App\Http\Controllers\Admin;

use getID3;
use App\Models\Module;
use App\Helpers\Helper;
use App\Models\Material;
use App\Models\SubModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Material::with('sub_module')->whereIn('status', [0, 1])
                ->orderBy('id', 'desc')
                ->latest()->get();
            // dd($data);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->status == 1) {
                        $action_1 = '<span data-d="' . base64_encode($row->id) . '"><a href="javascript:;" class="btn btn-outline-dark status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('disable') . '" data-name="' . $row->name . '" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="' . base64_encode($row->id) . '" class="d-none"><a href="javascript:;" class="btn btn-outline-success status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('enable') . '" data-name="' . $row->name . '" title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                    } else {
                        $action_1 = '<span class="d-none" data-d="' . base64_encode($row->id) . '"><a href="javascript:;" class="btn btn-outline-dark status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('disable') . '" data-name="' . $row->name . '" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="' . base64_encode($row->id) . '"><a href="javascript:;" class="btn btn-outline-success status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('enable') . '" data-name="' . $row->name . '"  title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                    }
                    $edit_url = url('/course-material/edit', ['id' => base64_encode($row->id)]);

                    $action_2 = '<a href="' . $edit_url . '" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                    $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';

                    $action =   '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                ' . $action_1 . '
                                ' . $action_2 . '
                                ' . $action_3 . '
                                </div>
                            </div>';

                    $action = '';
                    if (Auth::user()->user_type != '0') {
                        $childs = Helper::get_user_permission();
                        $permissions = DB::table('action_masters')->whereIn('id', $childs)->get();
                        // dd($permissions);
                        foreach ($permissions as $item) {
                            $action .= '<div class="d-flex align-items-center">
                                                ' . (isset($item->action) && $item->action == 'course-create' ? $action_1 : null) . '
                                                ' . (isset($item->action) && $item->action == 'course/edit' ? $action_2 : null) . '
                                                ' . (isset($item->action) && $item->action == 'course-delete' ? $action_3 : null) . '

                                        </div>';
                        }
                    } else {
                        $action = '<div class="d-flex align-items-center">
                                        <div class="d-flex">
                                            ' . $action_1 . '
                                            ' . $action_2 . '
                                            ' . $action_3 . '
                                        </div>
                                    </div>';
                    }
                    return $action;
                })

                ->editColumn('created_at', function ($user) {
                    return [
                        'display' => e($user->created_at->format('m-d-Y')),
                        'timestamp' => $user->created_at->timestamp
                    ];
                })

                ->addColumn('status', function ($data) {
                    if ($data->status == 0) {
                        return '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-danger">Inactive</span>
                        <span data-ac="' . base64_encode($data->id) . '" class="badge badge-success d-none">Active</span>';
                    } else {
                        return '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-danger d-none">Inactive</span>
                        <span data-ac="' . base64_encode($data->id) . '" class="badge badge-success">Active</span>';
                    }
                })

                ->rawColumns(['action', 'status', 'image', 'content'])
                ->make(true);
        }

        return view('admin.course-material.index');
    }

    public function subModuleData(Request $request)
    {
        $module_id = $request->module_id;

        $sub_module = DB::table('sub_modules')->where('module_id', $module_id)->get();

        return response()->json($sub_module);
    }

    public function create(Request $request)
    {
        $sub_module_id = base64_decode($request->id);

        $subModule = SubModule::where('id', $sub_module_id)->first();

        return view('admin.course-material.create', compact('subModule'));
    }

    public function store(Request $request)
    {
        $rules = [
            'video_name.*'       => 'required',
            'material_name.*'    => 'required',
            'reading_material.*'  => 'required',
            'lecture_video.*'    => 'required|mimes:mp4,mov,ogg,qt|max:20000',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

        DB::beginTransaction();
        try {

            $video_names = [];
            if ($request->hasFile('leacture_video')) {
                foreach ($request->file('leacture_video') as $video) {
                    $date = date('YmdHis');
                    $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                    $random_no = substr($no, 0, 2);
                    $final_image_name = $date . $random_no . '.' . $video->getClientOriginalExtension();

                    $destination_path = public_path('/uploads/materialVideo/');
                    if (!File::exists($destination_path)) {
                        File::makeDirectory($destination_path, $mode = 0777, true, true);
                    }
                    $video->move($destination_path, $final_image_name);
                    $video_names[] = $final_image_name;
                }
            }

            $reading_materials = $request->input('reading_material');
            $material_names = $request->input('material_name');
            $vi_names = $request->input('video_name');

            // Insert each reading material and corresponding video into the database
            foreach ($reading_materials as $index => $reading_material) {
                $data = [
                    'sub_module_id'     => $request->input('sub_module_id'),
                    'video_name'        => isset($vi_names[$index]) ? $vi_names[$index] : null, // Assuming 'video_name' field is for something else
                    'leacture_video'    => isset($video_names[$index]) ? $video_names[$index] : null,
                    'reading_material'  => $reading_material,
                    'material_name'     => isset($material_names[$index]) ? $material_names[$index] : null,
                    'status'            => 1,
                    'created_at'        => now(),
                ];
                DB::table('materials')->insert($data);
            }


            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function courseMaterialEdit(Request $request)
    {
        $material_id = base64_decode($request->id);
        // dd($material_id);
        $materials = DB::table("materials")->where('id', $material_id)->first();
        // dd($materials);
        $courseModule = Module::where('status', '1')->get();
        $subModule = SubModule::where('id', $material_id)->get();
        return view('admin.course-material.edit', compact('materials', 'courseModule', 'subModule'));
    }


    public function courseMaterialUpdate(Request $request)
    {
        $rules = [
            'name'    => 'required|string|max:255',
            'reading' => 'required',
            'content' => 'required_if:reading,1',
            'ppt'     => 'nullable|file|mimes:ppt,pptx',
        ];

        $msgs = [
            'name.required'        => 'Name is required.',
            'reading.required'     => 'Material type is required.',
            'content.required_if'  => 'Content is required for reading material.',
        ];

        $request->validate($rules, $msgs);

        $data = $request->except(['content', 'ppt']);
        $id = base64_decode($request->id);

        DB::beginTransaction();
        try {
            if ($request->reading == 0) {
                // Video material
                if ($request->hasFile('content')) {
                    $material = $request->file('content');
                    $name = hrtime(true) . '.' . $material->getClientOriginalExtension();
                    $path = public_path('/uploads/materialVideo/');

                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }

                    $material->move($path, $name);
                    $data['content'] = $name;

                    // Get video duration
                    $getID3 = new \getID3;
                    $file = $getID3->analyze($path . $name);
                    $duration = $file['playtime_seconds'] / 60;
                    $data['duration'] = floor($duration);
                }
            } else {
                // Reading material
                if ($request->filled('content')) {
                    $data['content'] = $request->content;
                } else {
                    unset($data['content']);
                }
            }
            // Handle PPT upload
            if ($request->hasFile('ppt')) {
                $pptFile = $request->file('ppt');
                $pptName = hrtime(true) . '.' . $pptFile->getClientOriginalExtension();
                $pptPath = public_path('/uploads/PPT/');

                if (!File::exists($pptPath)) {
                    File::makeDirectory($pptPath, 0777, true, true);
                }

                $pptFile->move($pptPath, $pptName);
                $data['ppt'] = $pptName;
            }

            Material::updateOrCreate(['id' => $id], $data);

            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'Saved Successfully',
                'url' => url('course-material'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => 'Error Occurred: ' . $th->getMessage()
            ]);
        }
    }




    public function courseMaterialDelete(Request $request)
    {
        $c_id = base64_decode($request->id);
        DB::beginTransaction();
        try {
            $blog = Material::find($c_id);
            $blog->status = '2';
            $blog->save();


            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function courseMaterialStatus(Request $request)
    {
        $cm_id = base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        if ($type == 'disable') {
            $user = Material::find($cm_id);
            $user->status = '0';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        } elseif ($type == 'enable') {
            $user = Material::find($cm_id);
            $user->status = '1';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        }
    }


    public function materialsIndex(Request $request, $id)
    {
        $id = base64_decode(urldecode($id));
        $subModule = SubModule::with('materials')->find($id);
        // dd($id);
        if ($subModule) {
            $data['subModule'] = $subModule;
        } else {
            return redirect()->to(route('sub-module-list'));
        }
        // dd($data);
        return view('admin.course-material.courseMaterial', $data);
    }

    public function materialDelete(Request $request)
    {
        $id = $request->id;  // Get the ID from the request
        $material = Material::find($id);  // Find the material by ID

        if ($material) {
            $material->delete();  // Delete the material
            return response()->json(['success' => true, 'message' => 'Material deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Material not found.'], 404);
    }


    public function materialsStore(Request $request, $id)
    {
        // dd($request->all());
        $rules = [
            'data.*.name'       => 'required|string|max:255',
            //'data.*.content'    => 'required',
            'data.*.reading'    => 'required',
            //'data.*.duration'   => 'nullable|numeric|min:1|required_if:data.*.reading,1',
        ];

        $msgs = [
            'data.*.name.required'       => 'Material name is required.',
            'data.*.name.max'            => 'Material name cannot exceed 255 characters.',
            'data.*.content.required'    => 'Content is required.',
            'data.*.reading.required'    => 'Material type is required.',
            'data.*.duration.required_if'=> 'Duration is required for reading materials.',
            'data.*.duration.numeric'    => 'Duration must be a numeric value.',
            'data.*.duration.min'        => 'Duration must be at least 1 minute.',
        ];

        $request->validate($rules, $msgs);

        $id = base64_decode($id);

        try {
            DB::beginTransaction();

            // foreach ($request->data as $key => $value) {

            //     // Handle video materials (reading == false)
            //         if ( $value['reading'] == 0  || $value['reading'] == 2 && isset($value['content']) && $value['content'] instanceof \Illuminate\Http\UploadedFile) {
            //             $material = $value['content'];
            //             $extCheck =$material->getClientOriginalExtension();
            //             $arr =['ppt','pptx'];
            //             if(in_array($extCheck,$arr)){
            //                 $name = time() . '.' . $extCheck ;
            //                 $path = public_path('/uploads/PPT/');

            //                 if (!File::exists($path)) {
            //                     File::makeDirectory($path, 0777, true, true);
            //                 }
            //                 $material->move($path, $name);
            //                 $value['ppt']=$name;
            //                 unset($value['content']);
            //             }else{
            //                 $name = time() . '.' .$extCheck ;
            //                 $path = public_path('/uploads/materialVideo/');

            //                 if (!File::exists($path)) {
            //                     File::makeDirectory($path, 0777, true, true);
            //                 }
            //                 $material->move($path, $name);

            //                 $getID3 = new \getID3;
            //                 $fileInfo = $getID3->analyze($path . $name);
            //                 $duration = isset($fileInfo['playtime_seconds']) ? floor($fileInfo['playtime_seconds'] / 60) : 0;
            //                 $value['content'] = $name;

            //             }
            //             // $value['duration'] = $duration;

            //         } else {
            //             //unset($value['content'], $value['duration']);
            //         }


            //     $value['sub_module_id'] = $id;
            //     Material::updateOrCreate(['id' => $key], $value);
            // }
            foreach ($request->data as $key => $value) {

                // Handle video materials (reading == false)
                if (($value['reading'] == 0 || $value['reading'] == 2) && isset($value['content']) && $value['content'] instanceof \Illuminate\Http\UploadedFile) {
                    $material = $value['content'];
                    $extCheck = $material->getClientOriginalExtension();
                    $arr = ['ppt', 'pptx'];

                    if (in_array($extCheck, $arr)) {
                        // Handle PPT or PPTX files
                        $name = time() . '.' . $extCheck;
                        $path = public_path('/uploads/PPT/');

                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true, true);
                        }
                        $material->move($path, $name);
                        $value['ppt'] = $name;  // Save the PPT file name
                    } else {
                        // Handle video files
                        $name = time() . '.' . $extCheck;
                        $path = public_path('/uploads/materialVideo/');

                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true, true);
                        }
                        $material->move($path, $name);

                        $getID3 = new \getID3;
                        $fileInfo = $getID3->analyze($path . $name);
                        $duration = isset($fileInfo['playtime_seconds']) ? floor($fileInfo['playtime_seconds'] / 60) : 0;
                        $value['content'] = $name;  // Save the video file name
                        $value['duration'] = $duration;  // Set the video duration
                    }

                } else {
                    // If content is not a valid file, unset only if it's not set
                    if (!isset($value['content']) || empty($value['content'])) {
                        unset($value['content']);
                        unset($value['duration']);
                    }
                    // Optionally unset duration only when content is not present
                    //unset($value['duration']);
                }

                $value['sub_module_id'] = $id;
                Material::updateOrCreate(['id' => $key], $value);
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'Materials saved successfully.',
                'url' => url('course-material'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'msg' => 'An error occurred: ' . $th->getMessage(),
            ], 500);
        }

    }

}
