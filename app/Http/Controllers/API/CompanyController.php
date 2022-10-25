<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Repositories\Company\ICompanyRepository; 

class CompanyController extends Controller
{
    
    public function __construct(ICompanyRepository $company) 
    {
        $this->company = $company;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies_result = $this->company->getCompanies(  );

        return $companies_result;
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
    public function store(Request $request){

        $data = array(
                'company_name' => $request->company_name,
                'company_code' => $request->company_code,
                'company_address' => $request->company_address,
                'company_address1' => $request->company_address1,
                'company_address2' => $request->company_address2,
                'company_country' => $request->company_country,
                'company_state' => $request->company_state,
                'company_city' => $request->company_city,
                'business_vertical' => $request->business_vertical,
                'default_status' => $request->default_status,
                'company_postal_code' => $request->company_postal_code,
            );
        $count = Company::where('company_name',$request->company_name)
                    ->where('company_code',$request->company_code)->count();
        if($count == 0){
            $companies_result = $this->company->storeCompany( $data );
            if($companies_result == 200){
                $message = 'Company Added Successfully';
            }else{
                $message = 'Request Failed';
            }
        }else{
            $companies_result = 500;
            $message = 'Company details already exists !!!';
        }

        return response()->json([
            'status'=>$companies_result,
            'message'=>$message ,
        ]);
    }

    public function get_company_list(){
        $company = Company::all();
        return $company;
    }
    
    public function get_companyList(){
        $company = Company::all();

        return response()->json([
            'result'=>$company,
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */

    public function edit($id){
        $company_result = $this->company->find($id);
        return response()->json([
            'status'=>200,
            'company'=>$company_result,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){
        $data = array(
            'id' => $id,
            'company_name' => $request->input( 'company_name' ),
            'company_code' => $request->input( 'company_code' ),
            'company_address' => $request->input( 'company_address' ),
            'company_address1' => $request->input( 'company_address1' ),
            'company_address2' => $request->input( 'company_address2' ),
            'company_postal_code' => $request->input( 'company_postal_code' ),
            'company_country' => $request->input( 'company_country' ),
            'company_state' => $request->input( 'company_state' ),
            'company_city' => $request->input( 'company_city' ),
            'business_vertical' => $request->input('business_vertical'),
            'default_status' => $request->input('default_status'),
        ); 
        $count = Company::where('company_name',$request->company_name)
                    ->where('company_code',$request->company_code)->count();
        if($count < 2){
            $company_result = $this->company->updateCompany( $data );
            if($company_result != 500){
                $company_result = 200;
                $message = 'Company Updated Successfully';
            }else{
                $company_result = 500;
                $message = 'Request Failed';
            }
        }else{ 
            $company_result = 500;
            $message = 'Company details already exists !!!';
        }

        return response()->json([
            'status'=>$company_result,
            'message'=>$message ,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
