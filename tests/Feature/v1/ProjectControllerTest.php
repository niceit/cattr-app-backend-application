<?php

use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    public function test_Create_ExpectPass()
    {
        $headers = [
            "Authorization" => "Bearer " . $this->getAdminToken()
        ];

        $data = [
            "name"         => "SampleOriginalProjectName",
            "description"  => "Code-monkey development group presents"
        ];

        $expectedFields = [
            "res" => [
                "id", "name", "description", "created_at", "updated_at"
            ]
        ];

        $expectedJson = [
            "res" => [
                "name"        => "SampleOriginalProjectName",
                "description" => "Code-monkey development group presents"
            ]
        ];

        $response = $this->postJson("/v1/projects/create", $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure($expectedFields);
        $response->assertJson($expectedJson);
    }

    public function test_Destroy_ExpectPass()
    {
        $headers = [
            "Authorization" => "Bearer " . $this->getAdminToken()
        ];

        $createData = [
            "name"         => "SampleOriginalProjectName",
            "description"  => "Code-monkey development group presents"
        ];

        $createResponse = $this->postJson("/v1/projects/create", $createData, $headers);

        $data = [
            "id" => $createResponse->json("res.id")
        ];

        $expectedFields = [
            "message"
        ];

        $expectedJson = [
            "message" => "Item has been removed"
        ];

        $response = $this->postJson("/v1/projects/remove", $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure($expectedFields);
        $response->assertJson($expectedJson);
    }

    public function test_Edit_ExpectPass()
    {
        $headers = [
            'Authorization' => "Bearer " . $this->getAdminToken()
        ];

        $createData = [
            "name"         => "SampleOriginalProjectName",
            "description"  => "Code-monkey development group presents"
        ];

        $createResponse = $this->postJson('/v1/projects/create', $createData, $headers);

        $data = [
            "id"           => $createResponse->json("res.id"),
            "name"         => "SampleOriginalProjectNameButEdited",
            "description"  => "Code-monkey development group presents with new description"
        ];

        $expectedFields = [
            "res" => [
                "id", "name", "description", 'created_at', 'updated_at', 'deleted_at'
            ]
        ];

        $expectedJson = [
            "res" => [
                "company_id"  => null,
                "name"        => "SampleOriginalProjectNameButEdited",
                "description" => "Code-monkey development group presents with new description",
                "deleted_at"  => null
            ]
        ];

        $response = $this->postJson("/v1/projects/edit", $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure($expectedFields);
        $response->assertJson($expectedJson);
    }

    public function test_List_ExpectPass()
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->getAdminToken()
        ];

        $expectedFields = [
            "*" => [
                "id", "company_id", "name", "description", "deleted_at", "created_at", "updated_at"
            ]
        ];

        $response = $this->getJson("/v1/projects/list", $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure($expectedFields);
    }

    public function test_Show_ExpectPass()
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->getAdminToken()
        ];

        $createData = [
            "name"         => "SampleOriginalProjectName",
            "description"  => "Code-monkey development group presents"
        ];

        $createResponse = $this->postJson("/v1/projects/create", $createData, $headers);

        $data = [
            "id" => $createResponse->json("res.id")
        ];

        $expectedFields = [
            "id", "company_id", "name", "description", 'created_at', 'updated_at'
        ];

        $response = $this->postJson("/v1/projects/show", $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure($expectedFields);
    }
}
