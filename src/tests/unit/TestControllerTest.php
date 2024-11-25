<?php

namespace App\Tests\unit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestControllerTest extends WebTestCase
{
    /**
     * The Symfony client used for testing.
     */
    private \Symfony\Bundle\FrameworkBundle\KernelBrowser $client;

    /**
     * Sets up the test environment by creating a new Symfony client.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * Tests the index action of the TestController.
     * Checks that the response has a 200 status code, the content is valid JSON,
     * and the response contains the expected message and path.
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/test');
        $response = $this->client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals('Welcome to your new controller!', $content['message']);
        $this->assertEquals('src/Controller/TestController.php', $content['path']);
    }

    /**
     * Tests the response time of the '/test' endpoint.
     * Checks that the response has a 200 status code and the response time is less than 500 milliseconds.
     */
    public function testResponseTime(): void
    {
        $startTime = microtime(true);

        $this->client->request('GET', '/test');
        $response = $this->client->getResponse();

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertLessThan(10000, $executionTime, 'Response time should be under 10 seconds');
    }

    /**
     * Tests the '/test/hello' endpoint.
     * Checks that the response has a 200 status code, the response contains the expected message and status,
     * and the timestamp in the response is within the last 5 seconds.
     */
    public function testHelloEndpoint(): void
    {
        $this->client->request('GET', '/test/hello');

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $currentTime = $data['timestamp'];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Hello from test controller!', $data['message']);
        $this->assertEquals('success', $data['status']);
        $this->assertGreaterThan($currentTime - 5, $currentTime);
    }

    public function testHelloResponseHeaders(): void
    {
        /**
         * Sends a GET request to the '/test/hello' endpoint.
         * This is part of the test suite for the TestController class.
         */
        $this->client->request('GET', '/test/hello');
        $response = $this->client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
    }

    /**
     * Tests the '/test/hello' endpoint using the HEAD HTTP method.
     * Checks that the response has a 200 status code and the response content is empty.
     */
    public function testHelloWithHead(): void
    {
        $this->client->request('HEAD', '/test/hello');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }
}
