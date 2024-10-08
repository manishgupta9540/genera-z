<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\khdaCertificate;
use Carbon\Carbon;

class KhdaCertificateController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $certificates = khdaCertificate::latest()->get();

        return DataTables::of($certificates)
        ->addIndexColumn()
        ->editColumn('created_at', function ($certificate) {
            return Carbon::parse($certificate->created_at)->format('d-M-Y ');
        })
        ->addColumn('action', function($row){
            $editUrl = ' <a href="javascript:void(0)" data-bs-toggle="modal" Title="Show" onclick="getModalCertificate('.$row->id.')" data-bs-target="#exampleModal" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>';
            if($row->approved !=1){
                $approve = '<a href="javascript:void(0)"data-id='.$row->id.' Title="Approve" class="btn btn-sm btn-primary status"><i class="fas fa-check"></i></a>';

            }else{
                $approve ='';
            }
            return $editUrl .' '. $approve;
        })
        ->addColumn('status', function($row){
            if ($row->approved == 1) {
                return '
                    <span class="badge bg-success text-light">Approved</span>
                ';
            } else {
                return '
                    <span class="badge bg-warning text-dark">Pending</span>
                ';
            }
        })

        ->rawColumns(['action','status'])
        ->make(true);
        }
        return view('admin.khda-certificate.index');
    }
    public function getData(Request $request){
        $certificates = khdaCertificate::where('id',$request->id)->first();
        return view('admin.khda-certificate.form',compact('certificates'));
    }
    public function approvedStatus(Request $request){
        try {
            $certificates = khdaCertificate::where('id',$request->id)->update(['approved'=>1]);
            if($certificates){
                return response()->json(['success'=>true,'msg'=>'Approved successfully done']);
            }else{
                return response()->json(['success'=>false,'msg'=>'Not approved']);
            }
        } catch (\Throwable $th) {
        return response()->json(['success'=>false,'msg'=>$th->getMessage()]);
        }
    }
}
