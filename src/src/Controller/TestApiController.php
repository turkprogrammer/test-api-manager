<?php

namespace App\Controller;

use App\Service\TestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/tests', name: 'api_tests_')]
class TestApiController extends AbstractController
{
    /**
     * Constructs a new instance of the TestApiController class.
     *
     * @param TestService $testService The test service to be used by the controller.
     */
    public function __construct(
        private readonly TestService $testService
    ) {}

    /**
     * Retrieves all tests.
     *
     * This action endpoint returns a JSON response containing all tests.
     *
     * @return JsonResponse A JSON response with the list of all tests.
     */
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $tests = $this->testService->getAllTests();
        return $this->json($tests);
    }

    /**
     * Retrieves all active tests.
     *
     * This action endpoint returns a JSON response containing all active tests.
     *
     * @return JsonResponse A JSON response with the list of active tests.
     */
    #[Route('/active', name: 'active', methods: ['GET'])]
    public function active(): JsonResponse
    {
        $tests = $this->testService->getActiveTests();
        return $this->json($tests);
    }

    /**
     * Creates a new test.
     *
     * This action endpoint creates a new test based on the data provided in the request body.
     *
     * @param Request $request The HTTP request containing the test data.
     * @return JsonResponse A JSON response with the details of the created test.
     */
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $test = $this->testService->createTest(
            $data['name'] ?? '',
            $data['isActive'] ?? true
        );

        return $this->json([
            'id' => $test->getId(),
            'name' => $test->getName(),
            'isActive' => $test->isActive(),
            'createdAt' => $test->getCreatedAt()->format('Y-m-d H:i:s')
        ], 201);
    }

    /**
     * Deletes a test.
     *
     * This action endpoint deletes the test with the specified ID.
     *
     * @param int $id The ID of the test to delete.
     * @return JsonResponse A JSON response indicating the successful deletion of the test.
     */
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->testService->deleteTest($id);
        return $this->json(null, 204);
    }
}
