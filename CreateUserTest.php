<?php

namespace Tests\Unit;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use File;
use Image;
use Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request;
class CreateUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
   /*************************************
    Function Name:testEmailRequired
    Description: check required parameters
    Created By: Akhilesh Prajapati
    Created On: 06/08/2022 
    Modified By:
    Modified On:
    *****************************************/
 
  public function testCheckRequiredParameters()
    {   
        $payload = ['email'=>'','password'=>'','phone_no'=>'','name'=>'','image'=>''];
        $response = $this->post('api/user-create',$payload);
        $response->assertStatus(422);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        exit();
     
    }


              

      
}
