<?php

namespace Tests\Unit;
use Tests\TestCase;
use DB;
use Hash;
class AuthenticationTest extends TestCase
{
    /*************************************
    Function Name:testEmailRequired
    Description: check the email required
    Created By: Akhilesh Prajapati
    Created On: 06/08/2022 
    Modified By:
    Modified On:
    *****************************************/
 
    public function testEmailRequired()
    {   
        $payload = ['email'=>'','password'=>'Admin@321'];
        $response = $this->post('api/jwt-login',$payload);
        $response->assertStatus(422);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        exit();     
    }
  /*************************************
    Function Name:testPasswordRequired
    Description: check the password required
    Created By: Akhilesh Prajapati
    Created On: 06/08/2022 
    Modified By:
    Modified On:
    *****************************************/
    public function testPasswordRequired()
    {   //check the email required
        $payload = ['password'=>'','email'=>'akhilesh.p@devtrust.biz'];
        $response = $this->post('api/jwt-login',$payload);
        $response->assertStatus(422);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode( $res_array));
        exit();
    }   
  
  /*************************************
    Function Name:testcheckNotExitsEmail
    Description: check not exits email
    Created By: Akhilesh Prajapati
    Created On: 06/08/2022 
    Modified By:
    Modified On:
    *****************************************/
  public function testcheckNotExitsEmail()
    {   //check the email required
        $payload = ['email'=>'example@gmail.com','password'=>'Admin@321'];
        $response = $this->post('api/jwt-login',$payload);
        $response->assertStatus(401);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode( $res_array));
        exit();
    } 


   /*************************************
    Function Name:testSuccessfulLogin
    Description: test successfully login 
    Created By: Akhilesh Prajapati
    Created On: 06/08/2022 
    Modified By:
    Modified On:
    *****************************************/
  public function testSuccessfulLogin()
    {   
        //create dummy data for check test case
        $insertPayload = DB::table('mst_users')->insert(['name'=>'Test Case','email'=>encryptEmailPhone('example@gmail.com'),'phone_no'=>encryptEmailPhone('1234567891'),'comm_email'=>1 ,'password'=>Hash::make('Admin@123')]);
        $id =DB::getPdo()->lastInsertId($insertPayload);
        // get data
        $getpayload = DB::table('mst_users')->select('email','password')->where('id',$id)->first();
        $email =decryptEmail($getpayload->email); 
        //payload array data
        $loginData = ['email' =>$email, 'password' => 'Admin@123'];

        $response=$this->json('POST', 'api/jwt-login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode( $res_array));
        // delete data after run test cases
        $delete = DB::table('mst_users')->where('id',$id)->delete();
        exit();

        $this->assertAuthenticated();
    }


    


}
