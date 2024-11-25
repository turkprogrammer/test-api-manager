<?php

namespace App\Service;

use App\Entity\Test;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;

class TestService
{
    public function __construct(
        private readonly TestRepository $testRepository,
        private readonly EntityManagerInterface $entityManager
    ) {}

    /**
     * Retrieves all available tests.
     *
     * @return Test[] An array of all tests.
     */
    public function getAllTests(): array
    {
        return $this->testRepository->findAll();
    }

    /**
     * Retrieves all active tests.
     *
     * @return Test[] An array of all active tests.
     */
    public function getActiveTests(): array
    {
        return $this->testRepository->findActiveTests();
    }

    /**
     * Creates a new test.
     *
     * @param string $name The name of the test.
     * @param bool $isActive Whether the test is active or not.
     * @return Test The created test.
     */
    public function createTest(string $name, bool $isActive = true): Test
    {
        $test = new Test();
        $test->setName($name)
            ->setIsActive($isActive)
            ->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        return $test;
    }

    /**
     * Deletes a test by its ID.
     *
     * @param int $id The ID of the test to delete.
     */
    public function deleteTest(int $id): void
    {
        $test = $this->testRepository->find($id);
        if ($test) {
            $this->entityManager->remove($test);
            $this->entityManager->flush();
        }
    }
}
