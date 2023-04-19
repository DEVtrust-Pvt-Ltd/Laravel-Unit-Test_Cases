<?php

namespace Tests\Unit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;
use JWTAuth;
use DB;
use Hash;

class ChangePasswordTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /*************************************
    Function Name:testRequiredParamChangePassword
    Description: check required parameters
    Created By: Akhilesh Prajapati
    Created On: 06/14/2022 
    Modified By:
    Modified On:
    *****************************************/
    public function testRequiredParamChangePassword()
    {   
        $payload = ['password'=>'','token'=>''];
        $response = $this->post('api/change-password',$payload);
        $response->assertStatus(422);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        exit();
     
    }
     /*************************************
    Function Name:testMissingTokenChangePassword
    Description: check missing token
    Created By: Akhilesh Prajapati
    Created On: 06/14/2022
    Modified By:
    Modified On:
    *****************************************/
    public function testMissingTokenChangePassword()
    {   
        $payload = ['password'=>'Admin@321','token'=>''];
        $response = $this->post('api/change-password',$payload);
        $response->assertStatus(422);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        exit();
     
    }


    /*************************************
    Function Name:testLinkExpiredChangePassword
    Description: check Link Expired
    Created By: Akhilesh Prajapati
    Created On: 06/14/2022 
    Modified By:
    Modified On:
    *****************************************/
    public function testLinkExpiredChangePassword()
    {   $invaildToken ='fvoUaQoPFukK6WwsO5x1ZL081denKjNCfXZ8DkThtfsS6HS9xQlfzK0dk5NpFK5X';
        $payload = ['password'=>'Admin@321','token'=>$invaildToken];
        $response = $this->post('api/change-password',$payload);
        $response->assertStatus(410);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        exit();
     
    }

    /*************************************
    Function Name:testChangePasswordSuccessfully
    Description: check success run change password API
    Created By: Akhilesh Prajapati
    Created On: 06/14/2022 
    Modified By:
    Modified On:
    *****************************************/
    public function testChangePasswordSuccessfully()
    {   //create dummy data for check test case
    	$insertPayload = DB::table('mst_users')->insert(['name'=>'Test Case','email'=>encryptEmailPhone('example@gmail.com'),'phone_no'=>encryptEmailPhone('1234567891'),'comm_email'=>1 ,'password'=>Hash::make('Admin@123')]);
        $id =DB::getPdo()->lastInsertId($insertPayload);
        // get data
        $getpayload = DB::table('mst_users')->where('id',$id)->first();
        $email =decryptEmail($getpayload->email);
    	//store token
        $token = Str::random(64);
			DB::table('password_resets')->insert([
				'email' =>  encryptEmailPhone($email), 
				'token' => $token, 
				'created_at' => Carbon::now()
			]);
        $validToken = DB::table('password_resets')->where('email','=',encryptEmailPhone($email))->first();
    
        $payload = ['password'=>'Admin@321','token'=>$validToken->token];
        $response = $this->post('api/change-password',$payload);
        $response->assertStatus(200);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        // delete data after run test cases
        $deleteUsers = DB::table('mst_users')->where('id',$id)->delete();
        //delete token after run test cases
        $deleteToken = DB::table('password_resets')->where('email','=',encryptEmailPhone($email))->delete();
        exit();
     
    }
}
