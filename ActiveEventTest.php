<?php

namespace Tests\Unit;

use Tests\TestCase;

class ActiveEventTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
   /*************************************
    Function Name:testSuccessfullyGetEventData
    Description: check success run active event api
    Created By: Akhilesh Prajapati
    Created On: 15/06/2022 
    Modified By:
    Modified On:
    *****************************************/ 
    public function testSuccessfullyGetEventData()
    {   
        $payload = [];
        $response = $this->post('api/active-event',$payload);
        $response->assertStatus(200);
        $res_array = json_decode($response->content(),true);
        $response->assertJson($res_array);
        print_r(json_encode($res_array));
        exit();
     
    }
}
