# Task Management System

## Setup

### Prerequisites

- Laravel 11
- PHP 8.2
- MySql 5.7+
- Nginx

### Installation

1. **Clone the repository:**
   ```bash
   git clone git@github.com:ahsmaker/bg-task-manager.git <your-repository-directory>
   cd <your-repository-directory>
   ```

2. **Setup your Laravel environment:**

Follow [Laravel documentation](https://laravel.com/docs/11.x/installation) to setup your environment and initialize the project

3. **Copy the environment file and configure the project:**
   ```bash
   cp .env.example .env
   ```
Create database and configure your database connection in the .env file

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

## Project Description

<p>This project is a demonstrative and simplified implementation of a typical Task Manager. It is implemented as a REST API, with simplified usage documentation provided below. This project is developed as a MVP, where I have showcased my basic principles and approaches to task solving. The project is not intended for commercial use and is not designed to handle large volumes of data and high load.</p>

## Usage

### User Registration and Login

- **Register:**
  ```bash
  POST /api/register
  {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password"
  }
  ```

- **Login:**
  ```bash
  POST /api/login
  {
      "email": "john@example.com",
      "password": "password"
  }
  ```

### Task Management
- **Create Task Category:**
  ```bash
  POST /api/task-categories/
  {
      "name": "Category 1"
  }
  ```

- **Update Task Category:**
  ```bash
  PUT /api/task-categories/{id}
  {
      "name": "Updated Category 1",
  }
  ```

- **Delete Task Category:**
  ```bash
  DELETE /api/task-categories/{id}
  ```

- **Create Task:**
  ```bash
  POST /api/tasks
  {
      "title": "New Task",
      "description": "Task description",
      "due_date": "2025-06-18",
      "status": 0,
      "category_id": 1,
      "priority": 1
  }
  ```
  
where:
````
Task Status Constants
STATUS_PENDING (0): The task is pending.
STATUS_IN_PROGRESS (1): The task is in progress.
STATUS_COMPLETED (2): The task is completed.
````
````
Task Priority Constants
PRIORITY_NORMAL (0): The task has normal priority.
PRIORITY_HIGH (1): The task has high priority.
````

- **Update Task:**
  ```bash
  PUT /api/tasks/{id}
  {
      "title": "Updated Task",
      "description": "Updated description",
      "due_date": "2025-06-18",
      "status": 0,
      "category_id": 1,
      "priority": 1
  }
  ```

- **Delete Task:**
  ```bash
  DELETE /api/tasks/{id}
  ```

- **List Tasks:**
  ```bash
  GET /api/tasks
  ```

- **Filter Tasks:**
  ```bash
  GET /api/tasks?status=pending&category_id=1&priority=1
  ```

## Explanation of Design Decisions and Patterns

The project follows the SOLID principles to ensure a clean, maintainable, and scalable codebase. The use of the Service Pattern and Repository Pattern helps in separating concerns and maintaining a clear structure.
Custom exceptions and form requests are used for error handling and validation, ensuring robust and user-friendly API responses.
Token-based authentication using Laravel Sanctum ensures the security of the API, making sure only authenticated users can access the endpoints.

### SOLID Principles

- **Single Responsibility Principle (SRP):** Each class has a single responsibility. For example, the `TaskService` handles the business logic for tasks, while the `TaskController` handles HTTP requests.
- **Open/Closed Principle (OCP):** The system is designed to be extendable without modifying existing code. For instance, new features can be added to services or repositories without changing the core logic.
- **Liskov Substitution Principle (LSP):** Derived classes (e.g., specific service implementations) can replace their base classes without affecting the functionality.
- **Interface Segregation Principle (ISP):** Clients are not forced to depend on methods they do not use. The interfaces are specific and relevant to the functionalities they represent.
- **Dependency Inversion Principle (DIP):** High-level modules do not depend on low-level modules; both depend on abstractions (e.g., interfaces).

### Design Patterns

- **Service Pattern:** Business logic is encapsulated in service classes (e.g., `TaskService`). This decouples the business logic from controllers, making the code more modular and easier to maintain.
- **Repository Pattern:** Data access logic is encapsulated in repository classes (e.g., `TaskRepository`). This provides a clean API for data operations and separates data access from business logic.

### Error Handling

- **Custom Exceptions:** Custom exceptions like `InvalidCredentialsException`, `TaskNotFoundException`, `TaskCategoryNotFoundException`, `ValidationException` are used to handle specific error cases, providing clear and consistent error responses.

### Validation

- **Form Requests:** Laravel’s form request classes are used for validation, ensuring that all incoming data is validated before processing.

### Security

- **Token-based Authentication:** The API uses Laravel Sanctum for token-based authentication, ensuring that all API endpoints are secure and can only be accessed by authenticated users.

## Test Coverage Reports

Tests cover the part of the application's functionality that I deemed sufficient.

Unit tests and feature tests runs automatically on GitHub result coverage report is available here:
[coverage report](https://app.codecov.io/gh/ahsmaker/bg-task-manager/tree/master/app)
Also the coverage reports can be generated manually.

 ```bash
   php artisan test --coverage
   ```