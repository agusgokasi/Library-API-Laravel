# Design Choices and Performance Tuning

## Design Choices

1. **Service-Oriented Architecture**:
   - The application adopts a **service layer** to separate business logic from the controllers, making it more maintainable and modular. This allows us to easily mock services in unit tests and apply different logic changes without affecting the controller logic.
   - Each service class (e.g., `AuthorService`, `BookService`) handles the core business logic like creating, updating, deleting, and retrieving authors and books.

2. **Form Request Validation**:
   - We use **Laravel Form Requests** (e.g., `AuthorRequest`, `BookRequest`) to handle validation in a clean and reusable way. This ensures the controllers only deal with valid data, making the controller actions more concise.

3. **Eager Loading**:
   - To optimize the database queries, **eager loading** is used when fetching authors with their related books. This prevents the N+1 problem where the application would otherwise make multiple database queries to fetch the related data (e.g., books for each author).

## Performance Tuning Techniques

1. **Caching**:
   - **Frequent read operations** like retrieving the list of authors or books are cached using Laravel’s caching system. Caching is implemented in the `AuthorService` and `BookService` layers, using the `Cache::remember` method to cache data for 60 minutes.
   - Example: The list of authors (`getAllAuthors`) and an individual author’s books (`getBooksByAuthor`) are cached to avoid repeated queries to the database.

2. **Database Indexing**:
   - Indexes were added on key fields like `author_id` in the `books` table to speed up lookups. This ensures that large datasets can be queried efficiently.
   
3. **Pagination**:
   - To avoid retrieving too many records at once (which can lead to performance bottlenecks), pagination is implemented for large datasets. This limits the number of results per request, reducing the memory and time required to process large lists of records.
   
4. **Scaling for Millions of Records**:
   - The caching system is designed to support **Redis**, which is highly scalable and can handle millions of cached records across multiple nodes. This ensures that the application remains performant even when the dataset grows significantly.
   - **Read replicas** can be used to distribute the load on the database, separating read and write operations to maintain database performance under heavy load.

5. **Optimizing Queries**:
   - Eager loading reduces the number of database queries for related data, while pagination and indexing ensure efficient data retrieval. These techniques combined allow the system to handle large volumes of data while maintaining fast response times.

## Folder Structure
Here's how your repository should be structured:

/library-api<br>
├── /app<br>
│   ├── /Services<br>
│   │   ├── AuthorService.php<br>
│   │   └── BookService.php<br>
│   └── /Http<br>
│       ├── /Controllers<br>
│       │   ├── AuthorController.php<br>
│       │   └── BookController.php<br>
│       ├── /Requests<br>
│       │   ├── AuthorRequest.php<br>
│       │   └── BookRequest.php<br>
├── /database<br>
│   ├── /factories<br>
│   │   ├── AuthorFactory.php<br>
│   │   └── BookFactory.php<br>
├── /tests<br>
│   ├── /Unit<br>
│   │   ├── AuthorServiceTest.php<br>
│   │   ├── BookServiceTest.php<br>
│   │   ├── AuthorControllerTest.php<br>
│   │   └── BookControllerTest.php<br>
├── README.md<br>
├── Design and Performance Tuning Write-Up<br>
└── .env.example
