A robust REST API service for managing test entities with comprehensive test coverage. Built with Symfony framework, this API provides endpoints for creating, listing, and managing test cases with active/inactive states.

Key Features:
- RESTful API endpoints
- Test entity management
- Active tests filtering
- Full PHPUnit test coverage
- JSON response format
- Clean architecture

Tech Stack:
- PHP 8+
- Symfony Framework
- PHPUnit
- JSON API

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | /api/tests | Get all tests |
| GET    | /api/tests/active | Get active tests |
| POST   | /api/tests | Create new test |
| DELETE | /api/tests/{id} | Delete test by ID |

## Test Coverage

The test suite covers all API endpoints with the following scenarios:

- List all tests
- Filter active tests
- Create test with valid data
- Create test with missing name
- Create test with missing active status
- Create test with empty request body
- Delete test by ID

## Getting Started

1. Clone the repository
2. Install dependencies:
```bash
composer install
