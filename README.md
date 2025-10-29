# Home Budget API

A personal budget management REST API built with Laravel 11. This project was created as a backend solution for tracking income, expenses, and generating financial reports.

## What This API Does

This API helps users manage their personal finances by providing:

- **User authentication** with secure token-based login
- **Income and expense tracking** with automatic balance updates
- **Category management** for organizing spending
- **Financial reporting** with monthly, quarterly, and yearly summaries
- **Advanced filtering** to find specific transactions

## Key Features

### Authentication & Security
- User registration and login using Laravel Sanctum
- API token authentication for secure access
- Rate limiting to prevent abuse (60 requests/minute)
- Security headers for protection against common attacks
- Input validation to ensure data integrity
- CORS configuration for frontend applications

### Financial Management
- Track income from various sources
- Record expenses with category classification
- Predefined categories like Food, Transport, Housing, etc.
- Automatic balance calculations
- Starting balance of $1000 for new users

### Reporting & Analytics
- Overview of total income, expenses, and current balance
- Time-based reports (last 30 days, 3 months, 12 months)
- Filter expenses by category, amount range, date, or search terms
- Financial insights and data aggregation

### Technical Implementation
- RESTful API design with consistent JSON responses
- Complete API documentation using Swagger/OpenAPI
- Database migrations with proper relationships
- Comprehensive testing with 20+ test cases
- Code quality tools (PHPStan, PHPCS)
- Consistent error handling across all endpoints

## Getting Started

### Requirements
- PHP 8.2 or higher
- Composer
- SQLite (included) or MySQL/PostgreSQL

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/home-budget-api.git
   cd home-budget-api
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start the development server**
   ```bash
   php artisan serve
   ```

6. **Access the API**
   - API Base URL: `http://localhost:8000/api`
   - Interactive Documentation: `http://localhost:8000/api/documentation`

## API Endpoints

### Authentication
- `POST /api/register` - Create a new user account
- `POST /api/login` - Login and get access token
- `POST /api/logout` - Logout and invalidate token
- `GET /api/balance` - Get current user balance

### Categories
- `GET /api/categories` - List all available categories
- `POST /api/categories` - Create a new category
- `GET /api/categories/{id}` - Get specific category details
- `PUT /api/categories/{id}` - Update category information
- `DELETE /api/categories/{id}` - Delete a category

### Expenses
- `GET /api/expenses` - List user expenses (supports filtering)
- `POST /api/expenses` - Record a new expense
- `GET /api/expenses/{id}` - Get specific expense details
- `PUT /api/expenses/{id}` - Update expense information
- `DELETE /api/expenses/{id}` - Delete an expense

### Income
- `GET /api/incomes` - List user income records
- `POST /api/incomes` - Record new income
- `GET /api/incomes/{id}` - Get specific income details
- `PUT /api/incomes/{id}` - Update income information
- `DELETE /api/incomes/{id}` - Delete an income record

### Reports
- `GET /api/reports/overview` - Get financial overview
- `GET /api/reports/monthly` - Last 30 days summary
- `GET /api/reports/quarterly` - Last 3 months summary
- `GET /api/reports/yearly` - Last 12 months summary

## Configuration

### Environment Variables

The main configuration options:

```env
# Application settings
APP_NAME="Home Budget API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (SQLite by default)
DB_CONNECTION=sqlite

# Cache (file-based for development)
CACHE_STORE=file
```

### Database Options

The API works with different database systems:
- **SQLite** - Default for development (no setup required)
- **MySQL** - For production environments
- **PostgreSQL** - Alternative production option

## Testing

Run the test suite to verify everything works:

```bash
# Run all tests
php artisan test

# Run specific test groups
php artisan test --filter AuthTest
php artisan test --filter ExpenseTest
```

The test suite includes:
- Authentication flow testing
- CRUD operations for all resources
- Report generation testing
- Error handling verification

## Code Quality

This project follows Laravel best practices and maintains high code quality:

```bash
# Static analysis
composer phpstan

# Code style checking
composer phpcs

# Auto-fix style issues
composer phpcs-fix
```

## API Response Format

All API responses follow a consistent structure:

### Successful Response
```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": { /* actual response data */ },
  "status_code": 200
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error description",
  "errors": [ /* validation errors if any */ ],
  "status_code": 400
}
```

## Security Features

The API includes several security measures:
- **Rate limiting** prevents API abuse
- **Security headers** protect against common web vulnerabilities
- **Input validation** ensures data integrity
- **Token-based authentication** for secure access
- **CORS configuration** for controlled cross-origin access

## Project Structure

```
app/
├── Http/
│   ├── Controllers/     # API endpoint handlers
│   ├── Middleware/      # Security and CORS middleware
│   └── Requests/        # Input validation classes
├── Models/              # Database models
├── Exceptions/          # Custom exception handling
└── Traits/              # Reusable code components

database/
├── migrations/          # Database schema definitions
└── seeders/            # Sample data for development

tests/
└── Feature/            # API endpoint tests
```

## Deployment Considerations

For production deployment, consider:
- Set `APP_ENV=production` and `APP_DEBUG=false`
- Use a production database (MySQL/PostgreSQL)
- Configure Redis for caching
- Set up proper CORS origins
- Enable SSL/TLS
- Configure logging and monitoring

## How to Use Swagger Documentation

Swagger provides an interactive interface to test the API without writing code. Here's how to use it:

### Accessing Swagger
1. Start the server: `php artisan serve`
2. Open your browser and go to: `http://localhost:8000/api/documentation`
3. You'll see a page with all available API endpoints

### Tips for Using Swagger
- **Green responses** (200, 201) mean success
- **Red responses** (400, 401, 404) mean errors
- **Always check the response body** for data or error messages
- **Use the "Authorize" button** for protected endpoints
- **Try different parameter combinations** to test filtering

## Development Notes

This project was built to demonstrate:
- RESTful API design principles
- Laravel framework capabilities
- Security best practices
- Testing methodologies
- Code quality standards
- API documentation

The codebase follows Laravel conventions and includes comprehensive error handling, making it suitable for both learning and production use.
