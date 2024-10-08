<?php

namespace App\Http\Controllers\Student;

use App\Models\UserAssignment;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\Question;
use App\Models\User;
use App\Models\UserMaterial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentMaterialController extends Controller
{

    public function show($id)
    {
        $auth = Auth::user();
        $id = base64_decode($id);
        $material = Material::find($id);
        $pptUrl = asset('uploads/PPT/' . $material->ppt);
        return view('student.materials.material', compact('material', 'auth'));
    }


    public function markAsCompleted(Request $request, $id)
    {
        $data = $request->all();
        $auth = Auth::user();
        $id = base64_decode($id);
        try {
            $UserMaterial = UserMaterial::updateOrCreate([
                'material_id' => $id,
                'user_id' => $auth->id
            ], [
                'progress' => 100,
                'completed' => true
            ]);
            $subModuleMaterials = $UserMaterial->material->sub_module->materials;
            $userMaterialsCount = $auth->userMaterials->whereIn('id', $subModuleMaterials->pluck('id'))->count();

            if ($subModuleMaterials->count() == $userMaterialsCount) {

            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('student.material.show', urlencode(base64_encode($id)));
    }


    public function start(Request $request, $id)
    {
        $id = base64_decode($id);
        $assignment = Assignment::find($id);
        $userAssignment = UserAssignment::create([
            'assignment_id' => $assignment->id,
            'user_id' => Auth::user()->id,
            'start_time' => date('Y-m-d H:i:s'),
        ]);
        $uaid = $userAssignment->id;
        return response()->json([
            'success' => true,
            'time' => $assignment->duration,
            'parent' => '#addParent_' . config('addPages.assignmentTest.id'),
            'html' => view('student.components.assignmentTest', compact('assignment', 'uaid'))->render()
        ]);
    }


    public function saveProgress(Request $request) {}
}
