<?php

namespace Feature;

use Tests\TestCase;

class PetsTest extends TestCase
{
    public function testSendRequestShowOnePetExpectedJsonData()
    {
        $response = $this->get('/api/pets/4');

        $response->assertStatus(200);

        $response->assertJson([
            'id' => 4
        ]);
    }

    public function testSendRequestShowOnePetWhenNotExistsExpectedNotFound()
    {
        $response = $this->get('/api/pets/123123123123');

        $response->assertStatus(500)
            ->assertJson([
                'error' => 'The requested URL returned error: 404'
            ]);
    }

    public function testSendRequestStorePetWithCorrectDataExpectsStatusOkAndJsonData()
    {
        $data = [
            'name' => 'Piesek',
            'photoUrls' => ['url1', 'url2'],
            'status' => 'available',
        ];

        $response = $this->json('POST', '/api/pets/store', $data);

        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals('Piesek', $responseData['name']);
        $this->assertEquals('available', $responseData['status']);
    }

    public function testSendRequestStorePetWithBadStatusExpectsStatusIsUnprocessable()
    {
        $data = [
            'name' => 'Piesek',
            'photoUrls' => ['url1', 'url2'],
            'status' => 'availa',
        ];

        $response = $this->json('POST', '/api/pets/store', $data);
        $response->assertStatus(422);

        $responseData = $response->json();

        $this->assertArrayHasKey('errors', $responseData);
        $this->assertArrayHasKey('status', $responseData['errors']);
        $this->assertEquals('The selected status is invalid.', $responseData['errors']['status'][0]);
    }

    public function testSendRequestStorePetWithoutExpectedFieldsExpectsStatusIsUnprocessable()
    {
        $data = [
            'photoUrls' => ['url1', 'url2'],
        ];

        $response = $this->json('POST', '/api/pets/store', $data);
        $response->assertStatus(422);

        $responseData = $response->json();

        $this->assertArrayHasKey('errors', $responseData);
        $this->assertArrayHasKey('name', $responseData['errors']);
        $this->assertEquals('The name field is required.', $responseData['errors']['name'][0]);
        $this->assertArrayHasKey('status', $responseData['errors']);
        $this->assertEquals('The status field is required.', $responseData['errors']['status'][0]);
    }

    public function testWhenSendRequestFindByStatusWithValidStatusExpectsStatusIsOk()
    {
        $validStatus = 'available';

        $response = $this->json('GET', "/api/pets/find-by-status/$validStatus");

        $response->assertStatus(200);
    }

    public function testWhenSendRequestFindByStatusWithInvalidStatusExpectsStatusIsUnprocessable()
    {
        $validStatus = 'availe';

        $response = $this->json('GET', "/api/pets/find-by-status/$validStatus");

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'status'
        ]);
    }

    public function testWhenSendRequestFindByStatusWithInvalidTypeStatusExpectsStatusIsUnprocessable()
    {
        $validStatus = 24;

        $response = $this->json('GET', "/api/pets/find-by-status/$validStatus");

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'status'
        ]);
    }

    public function testWhenSendRequestUpdatePetWithValidDataExpectsStatusIsOkAndJsonData()
    {
        $requestData = [
            'id' => 1,
            'name' => 'Pet',
            'photoUrls' => ['url1', 'url2'],
            'category' => [
                'id' => 1,
                'name' => 'category name'
            ],
            'tags' => [
                [
                    'id' => 1,
                    'name' => 'tag name'
                ]
            ],
            'status' => 'available',
        ];

        $response = $this->json('PUT', '/api/pets', $requestData);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => 1,
            'name' => 'Pet',
            'status' => 'available',
            'category' => [
                'id' => 1,
                'name' => 'category name'
            ],
            'tags' => [
                [
                    'id' => 1,
                    'name' => 'tag name'
                ]
            ],
        ]);
    }

    public function testWhenSendRequestUpdatePetWithInvalidIdTypeExpectsValidationError()
    {
        $requestData = [
            'id' => 'string',
        ];

        $response = $this->json('PUT', '/api/pets', $requestData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['id']);
    }

    public function testWhenSendRequestDestroyPetWithValidIdExpectsStatusIsOk()
    {
        $response = $this->json('DELETE', '/api/pets/5');

        $response->assertStatus(200);
    }
}

