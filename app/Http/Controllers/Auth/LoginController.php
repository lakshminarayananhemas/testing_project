<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Repositories\Distributor\IDistributorRepository; 
use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IDistributorRepository $distributor_repo)
    {
        $this->middleware('guest')->except('logout');
        $this->distributor_repo = $distributor_repo;

    }

    public function login_valid(Request $request)
    {
 
        $login_credentals=[
            'user_id'=>$request->user_id,
            'password'=>$request->password,
            'status'=>'Active',
        ]; 
 
        if(auth()->attempt( $login_credentals, true )){
            return response()->json( [
                'url'=>url( '/' ), 
                'response' => 'Success', 
                'status' => "400",
                'type' => "Admin", 
            ]); 
        } 
        else{
            $result = $this->distributor_repo->distributor_login( $login_credentals );
            return $result;
        }

    }
    // public function login_valid(Request $request)
    // {
 
    //     $login_credentals=[
    //         'user_id'=>$request->user_id,
    //         'password'=>$request->password,
    //         // 'status'=>'Active',
    //     ]; 
 
    //     if(Auth::guard('web')->attempt( $login_credentals, true )){
    //         return response()->json( [
    //             'url'=>url( '/' ), 
    //             'response' => 'Success', 
    //             'status' => "400",
    //             'type' => "Admin", 
    //         ]); 
    //     }
    //     if(Auth::guard('distributor')->attempt( $login_credentals, true )){
    //         return response()->json( [
    //             'url'=>url( '/' ), 
    //             'response' => 'Success', 
    //             'status' => "400",
    //             'type' => "Distributor", 
    //         ]); 
    //     }
    //     // else{
    //     //     $result = $this->distributor_repo->distributor_login( $login_credentals );
    //     //     return $result;
    //     // }

    // }


    public function fetch(){
        $Distributor = Distributor::all();

        return $Distributor;
        // return response()->json([
        //     'status'=>200,
        //     'students'=>$students,
        // ]);
    }

}
