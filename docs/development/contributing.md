# Contributing Guidelines

Thank you for your interest in contributing to the Hospital Management System! This guide will help you understand how to contribute effectively and maintain the quality standards of our project.

## Table of Contents

1. [Getting Started](#getting-started)
2. [Development Setup](#development-setup)
3. [Coding Standards](#coding-standards)
4. [Git Workflow](#git-workflow)
5. [Pull Request Process](#pull-request-process)
6. [Issue Reporting](#issue-reporting)
7. [Testing Guidelines](#testing-guidelines)
8. [Documentation Standards](#documentation-standards)
9. [Security Considerations](#security-considerations)
10. [Release Process](#release-process)

## Getting Started

### Before You Start
- Review the [README](../README.md) and [System Architecture](architecture.md)
- Understand the project structure and key components
- Familiarize yourself with Laravel, Filament, and related technologies
- Read through existing issues and discussions

### Types of Contributions
We welcome various types of contributions:
- **Bug Fixes**: Fix existing issues and bugs
- **New Features**: Add new functionality to the system
- **Documentation**: Improve or add documentation
- **Testing**: Add or improve test coverage
- **Code Quality**: Refactor code for better maintainability
- **Security**: Identify and fix security vulnerabilities
- **Performance**: Optimize system performance

## Development Setup

### Prerequisites
- PHP 8.2+
- Composer 2.0+
- Node.js 18+ and NPM
- MySQL 8.0+ or SQLite
- Git

### Local Development Setup

1. **Fork and Clone**
   ```bash
   # Fork the repository on GitHub
   # Clone your fork
   git clone https://github.com/your-username/hospital-management-system.git
   cd hospital-management-system
   
   # Add upstream remote
   git remote add upstream https://github.com/original-repo/hospital-management-system.git
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Node.js dependencies
   npm install
   ```

3. **Environment Configuration**
   ```bash
   # Copy environment file
   cp .env.example .env.local
   
   # Generate application key
   php artisan key:generate
   
   # Configure database (use SQLite for development)
   touch database/database.sqlite
   ```

4. **Database Setup**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Seed with sample data
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   # Development build with hot reload
   npm run dev
   ```

6. **Start Development Server**
   ```bash
   # Start Laravel development server
   php artisan serve
   ```

### Development Environment Configuration

#### `.env.local` Example
```env
APP_NAME="HMS Development"
APP_ENV=local
APP_KEY=base64:your_generated_key
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

## Coding Standards

### PHP Standards
We follow PSR-12 coding standards with some additional conventions:

#### Code Style
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExampleModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * Get the user that owns the example.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

#### Naming Conventions
- **Classes**: PascalCase (e.g., `PatientResource`, `AppointmentPolicy`)
- **Methods**: camelCase (e.g., `getUserAppointments`, `createPayment`)
- **Variables**: camelCase (e.g., `$patientId`, `$appointmentDate`)
- **Constants**: SCREAMING_SNAKE_CASE (e.g., `APPOINTMENT_STATUS_COMPLETED`)
- **Database**: snake_case (e.g., `appointment_date`, `patient_id`)

#### DocBlocks
Always include proper PHPDoc blocks:

```php
/**
 * Create a new appointment for the specified patient.
 *
 * @param  \App\Models\Patient  $patient
 * @param  array  $appointmentData
 * @return \App\Models\Appointment
 * @throws \InvalidArgumentException
 */
public function createAppointment(Patient $patient, array $appointmentData): Appointment
{
    // Method implementation
}
```

### Laravel Conventions

#### Model Relationships
```php
// Use type hints for relationships
public function appointments(): HasMany
{
    return $this->hasMany(Appointment::class);
}

// Use proper foreign key naming
public function doctor(): BelongsTo
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}
```

#### Database Migrations
```php
// Use descriptive migration names
// 2024_01_01_000000_add_emergency_contact_to_patients_table.php

public function up(): void
{
    Schema::table('patients', function (Blueprint $table) {
        $table->string('emergency_contact_name')->nullable();
        $table->string('emergency_contact_phone')->nullable();
    });
}
```

### Filament Resource Standards

#### Resource Organization
```php
class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Patient Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Group related fields in sections
            Section::make('Personal Information')
                ->schema([
                    TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(2),
        ]);
    }
}
```

### JavaScript/CSS Standards

#### Vue.js Components (if applicable)
```javascript
// Use composition API for new components
<script setup>
import { ref, computed } from 'vue'

// Props with proper typing
const props = defineProps({
    patient: {
        type: Object,
        required: true
    }
})

// Reactive data
const isLoading = ref(false)

// Computed properties
const fullName = computed(() => 
    `${props.patient.first_name} ${props.patient.last_name}`
)
</script>
```

#### CSS Organization
```css
/* Use BEM methodology for CSS classes */
.appointment-card {
    /* Base styles */
}

.appointment-card__header {
    /* Header styles */
}

.appointment-card__header--urgent {
    /* Modifier styles */
}
```

## Git Workflow

### Branch Naming
- **Feature**: `feature/appointment-scheduling`
- **Bug Fix**: `bugfix/payment-calculation-error`
- **Hotfix**: `hotfix/security-vulnerability`
- **Documentation**: `docs/api-documentation`
- **Refactor**: `refactor/user-service-cleanup`

### Commit Messages
Follow the Conventional Commits specification:

```
type(scope): description

[optional body]

[optional footer]
```

#### Examples
```bash
# Feature
git commit -m "feat(appointments): add calendar view for appointment scheduling"

# Bug fix
git commit -m "fix(payments): resolve calculation error for insurance claims"

# Documentation
git commit -m "docs(api): add endpoint documentation for patient management"

# Breaking change
git commit -m "feat(auth)!: migrate to new authentication system

BREAKING CHANGE: old authentication tokens are no longer valid"
```

#### Commit Types
- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style changes (formatting, missing semicolons, etc.)
- **refactor**: Code refactoring
- **test**: Adding or updating tests
- **chore**: Maintenance tasks (build, dependencies, etc.)

### Branching Strategy

1. **Main Branch**: `main` (production-ready code)
2. **Development Branch**: `develop` (integration branch)
3. **Feature Branches**: `feature/*` (new features)
4. **Hotfix Branches**: `hotfix/*` (urgent production fixes)

#### Workflow
```bash
# Create feature branch from develop
git checkout develop
git pull upstream develop
git checkout -b feature/new-feature

# Work on your feature
git add .
git commit -m "feat(feature): implement new functionality"

# Push to your fork
git push origin feature/new-feature

# Create pull request to develop branch
```

## Pull Request Process

### Before Submitting
1. **Update your branch**
   ```bash
   git checkout develop
   git pull upstream develop
   git checkout feature/your-feature
   git rebase develop
   ```

2. **Run tests**
   ```bash
   composer test
   npm run test
   ```

3. **Check code style**
   ```bash
   composer pint
   composer phpstan
   ```

4. **Build assets**
   ```bash
   npm run build
   ```

### Pull Request Template

```markdown
## Description
Brief description of changes made.

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update

## How Has This Been Tested?
- [ ] Unit tests
- [ ] Integration tests
- [ ] Manual testing
- [ ] Browser testing

## Checklist
- [ ] Code follows the style guidelines
- [ ] Self-review of code completed
- [ ] Code is commented, particularly in hard-to-understand areas
- [ ] Corresponding changes to documentation made
- [ ] Changes generate no new warnings
- [ ] Tests added that prove fix is effective or feature works
- [ ] New and existing tests pass locally
```

### Review Process
1. **Automated Checks**: CI/CD pipeline runs tests and code quality checks
2. **Peer Review**: At least one team member reviews the code
3. **Testing**: Changes are tested in staging environment
4. **Approval**: Maintainer approves and merges the PR

## Issue Reporting

### Bug Reports
Use the bug report template:

```markdown
**Bug Description**
Clear description of the bug.

**To Reproduce**
Steps to reproduce the behavior:
1. Go to '...'
2. Click on '....'
3. See error

**Expected Behavior**
What you expected to happen.

**Screenshots**
Add screenshots if applicable.

**Environment:**
- Browser: [e.g., Chrome, Safari]
- Version: [e.g., 1.0.0]
- OS: [e.g., Windows 10, macOS]

**Additional Context**
Any other context about the problem.
```

### Feature Requests
Use the feature request template:

```markdown
**Problem Statement**
Clear description of the problem this feature would solve.

**Proposed Solution**
Describe your proposed solution.

**Alternatives Considered**
Alternative solutions you've considered.

**Additional Context**
Any other context, mockups, or examples.
```

## Testing Guidelines

### Test Structure
```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_patient(): void
    {
        // Arrange
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Act
        $response = $this->actingAs($admin)
            ->post('/admin/patients', [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
            ]);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('patients', [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }
}
```

### Test Categories
1. **Unit Tests**: Test individual classes/methods
2. **Feature Tests**: Test application features end-to-end
3. **Browser Tests**: Test UI interactions with Laravel Dusk
4. **API Tests**: Test API endpoints

### Running Tests
```bash
# Run all tests
composer test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter=test_admin_can_create_patient
```

## Documentation Standards

### Code Documentation
- Use PHPDoc for all classes, methods, and properties
- Include parameter types and return types
- Document complex algorithms and business logic
- Keep comments up-to-date with code changes

### API Documentation
- Document all public methods and endpoints
- Include request/response examples
- Specify required parameters and validation rules
- Document error responses and status codes

### User Documentation
- Write clear, step-by-step instructions
- Include screenshots for complex procedures
- Organize content logically with clear headings
- Keep documentation current with feature changes

## Security Considerations

### Security Guidelines
1. **Input Validation**: Always validate and sanitize user input
2. **SQL Injection**: Use Eloquent ORM and parameterized queries
3. **XSS Prevention**: Escape output and use CSP headers
4. **Authentication**: Implement proper authentication and session management
5. **Authorization**: Use policies and gates for access control
6. **Data Protection**: Encrypt sensitive data and use HTTPS

### Security Review Process
- All security-related changes require additional review
- Regular security audits of dependencies
- Automated security scanning in CI/CD
- Report security vulnerabilities privately

### Sensitive Data Handling
```php
// Good: Use Laravel's encryption
$encryptedData = encrypt($sensitiveData);

// Good: Hash passwords properly
$hashedPassword = Hash::make($password);

// Avoid: Logging sensitive information
Log::info('User login', ['email' => $email]); // Don't log passwords!
```

## Release Process

### Version Numbering
We use Semantic Versioning (SemVer):
- **MAJOR**: Incompatible API changes
- **MINOR**: New functionality (backward compatible)
- **PATCH**: Bug fixes (backward compatible)

### Release Checklist
1. **Update version numbers**
2. **Update CHANGELOG.md**
3. **Run full test suite**
4. **Update documentation**
5. **Create release tag**
6. **Deploy to staging**
7. **Deploy to production**
8. **Announce release**

### Deployment
```bash
# Production deployment
git checkout main
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Code Review Guidelines

### For Authors
- Keep PRs small and focused
- Write descriptive commit messages
- Add tests for new functionality
- Update documentation as needed
- Self-review before submitting

### For Reviewers
- Be constructive and respectful
- Focus on code quality and maintainability
- Check for security vulnerabilities
- Verify tests cover new functionality
- Ensure documentation is updated

### Review Checklist
- [ ] Code follows project standards
- [ ] Logic is clear and well-documented
- [ ] Tests are comprehensive
- [ ] No security vulnerabilities
- [ ] Performance considerations addressed
- [ ] Documentation updated
- [ ] Database changes have migrations
- [ ] Backward compatibility maintained

## Getting Help

### Resources
- **Documentation**: Check existing documentation first
- **GitHub Issues**: Search for existing issues
- **Discussions**: Use GitHub Discussions for questions
- **Discord/Slack**: Real-time community chat (if available)

### Mentorship
New contributors are welcome! Maintainers and experienced contributors are available to help with:
- Understanding the codebase
- Choosing appropriate first issues
- Code review feedback
- Best practices guidance

### Communication Guidelines
- Be respectful and inclusive
- Use clear, professional language
- Provide context and details
- Be patient with responses
- Help others when you can

## Recognition

We appreciate all contributions! Contributors are recognized through:
- **Contributors list** in README
- **Changelog acknowledgments**
- **GitHub badges and stats**
- **Community recognition**

Thank you for contributing to the Hospital Management System! Your efforts help improve healthcare technology and patient care worldwide.

---

For questions about contributing, please open an issue or reach out to the maintainers.
