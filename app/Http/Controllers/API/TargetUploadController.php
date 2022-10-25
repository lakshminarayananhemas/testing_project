<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Target_upload;
use Illuminate\Http\Request;

use App\Imports\SalesmanTargetImport; 
use App\Imports\CustomerTargetImport;
use App\Imports\DistributorTargetImport;
use DB;

class TargetUploadController extends Controller
{
    public function upload_dsc_target_upload(Request $request) 
    {
        $document_type = $request->document_type;
        if($document_type == "Salesman_target_upload"){
            \Excel::import(new SalesmanTargetImport,$request->import_file);
            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);
        }elseif($document_type == "Customer_target_upload") {
            \Excel::import(new CustomerTargetImport,$request->import_file);
            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);
        }elseif($document_type == "Distributor_target_upload") {
            \Excel::import(new DistributorTargetImport,$request->import_file);
            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);
        }
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Target_upload  $target_upload
     * @return \Illuminate\Http\Response
     */
    public function show(Target_upload $target_upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Target_upload  $target_upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Target_upload $target_upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Target_upload  $target_upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Target_upload $target_upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Target_upload  $target_upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target_upload $target_upload)
    {
        //
    }

    public function get_dist_salesman_target_list(Request $request)
    {
        $salesman = DB::table('salesman_infos')
                        ->where('distributor_code',$request->distributor_id)
                        ->pluck('salesman_code');
        $target_list = DB::table('target_uploads')->whereIn('employee_code',$salesman)->get();
        return $target_list;
    }

}
