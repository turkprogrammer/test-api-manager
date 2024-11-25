<?php

namespace App\Tests\unit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test suite for the API Controller endpoints
 */
class TestApiControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser HTTP client for making requests
     */
    private \Symfony\Bundle\FrameworkBundle\KernelBrowser $client;

    /**
     * Set up method that runs before each test
     * Initializes the test client
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Tests the GET /api/tests endpoint
     * Verifies that the endpoint returns a 200 status code and valid JSON response
     */
    public function testList(): void
    {
        $this->client->request('GET', '/api/tests');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /**
     * Tests the GET /api/tests/active endpoint
     * Verifies that the endpoint returns a 200 status code and valid JSON response for active tests
     */
    public function testActive(): void
    {
        $this->client->request('GET', '/api/tests/active');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /**
     * Tests the POST /api/tests endpoint with valid data
     * Verifies that:
     * - A new test entity can be created successfully
     * - Response has 201 status code
     * - Response contains correct name and isActive values
     * - Response is in valid JSON format
     */
    public function testCreateWithValidData(): void
    {
        $testData = [
            'name' => 'TEST_' . substr(md5(rand()), 0, 7) . '_Test Name',
            'isActive' => true
        ];

        $this->client->request(
            'POST',
            '/api/tests',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($testData)
        );

        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('name', $responseData);
        $this->assertArrayHasKey('isActive', $responseData);
        $this->assertEquals($testData['name'], $responseData['name']);
        $this->assertEquals($testData['isActive'], $responseData['isActive']);
    }

    /**
     * Tests the POST /api/tests endpoint with missing name field
     * Verifies that:
     * - Entity is created with empty name
     * - Response has 201 status code
     * - Response contains empty name value
     * - Response is in valid JSON format
     */
    public function testCreateWithMissingName(): void
    {
        $testData = [
            'isActive' => true
        ];

        $this->client->request(
            'POST',
            '/api/tests',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($testData)
        );

        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('name', $responseData);
        $this->assertEquals('', $responseData['name']);
    }

    /**
     * Tests the POST /api/tests endpoint with missing isActive field
     * Verifies that:
     * - Entity is created with default isActive=true
     * - Response has 201 status code
     * - Response contains correct isActive value
     * - Response is in valid JSON format
     */
    public function testCreateWithMissingIsActive(): void
    {
        $testData = [
            'name' => 'Test Name'
        ];

        $this->client->request(
            'POST',
            '/api/tests',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($testData)
        );

        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('isActive', $responseData);
        $this->assertTrue($responseData['isActive']);
    }

    /**
     * Tests the POST /api/tests endpoint with empty request body
     * Verifies that:
     * - Entity is created with default values (empty name and isActive=true)
     * - Response has 201 status code
     * - Response contains default values
     * - Response is in valid JSON format
     */
    public function testCreateWithEmptyRequestBody(): void
    {
        $this->client->request(
            'POST',
            '/api/tests',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );

        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('name', $responseData);
        $this->assertArrayHasKey('isActive', $responseData);
        $this->assertEquals('', $responseData['name']);
        $this->assertTrue($responseData['isActive']);
    }

    /**
     * Tests the DELETE /api/tests/{id} endpoint
     * Verifies that:
     * - Test entity can be deleted
     * - Response has 204 status code (No Content)
     */
    public function testDelete(): void
    {
        $this->client->request('DELETE', '/api/tests/10');

        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode());
    }
}
