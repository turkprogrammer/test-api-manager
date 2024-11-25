<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Provides a simple test endpoint that returns a JSON response.
 *
 * This controller action is mapped to the '/test' route and returns a JSON
 * response with a 'message' and 'path' key-value pair.
 */
class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }

    /**
     * Provides a simple test endpoint that returns a JSON response with a 'message', 'timestamp', and 'status' key-value pair.
     *
     * This controller action is mapped to the '/test/hello' route and returns a JSON response.
     */
    #[Route('/test/hello', name: 'app_test_hello')]
    public function hello(): JsonResponse
    {
        return $this->json([
            'message' => 'Hello from test controller!',
            'timestamp' => time(),
            'status' => 'success'
        ]);
    }

}
