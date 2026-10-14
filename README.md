# Jajal Medical — Medical Case Management System

> **Software Developer Intern Practical Assignment**  
> **Jajal Medical (October 8, 2026)**  
> **Role:** Full-Stack Laravel Developer  

A production-grade, secure, and modern Medical Case Management Web Application engineered with **Laravel 11**, **MySQL 8**, **Tailwind CSS**, **Blade**, **Laravel Sanctum**, and automated **PHPUnit** testing. Built to streamline custom surgical planning, patient-specific implants (PSI), and clinical coordination.

---

## 1. System Architecture & Tech Stack

| Layer | Technology | Version / Specification |
|---|---|---|
| **Backend Framework** | Laravel | 11.57.0 (PHP ^8.2) |
| **Database** | MySQL | Community Server 8.0 (InnoDB, utf8mb4) |
| **Frontend Templates** | Laravel Blade | Component-driven architecture |
| **Styling & Design** | Tailwind CSS & Vite | Responsive Healthcare SaaS aesthetic |
| **Session Auth** | Laravel Breeze | Secure password hashing, CSRF protection |
| **API Auth** | Laravel Sanctum | Bearer token authentication |
| **ORM & Database** | Laravel Eloquent | Relations, Scopes, Accessors, Auto-audit |
| **Test Suite** | PHPUnit | 54 automated feature & unit tests |
| **API Client Specs** | Postman 2.1 | Pre-configured collection with RBAC test suite |

---

## 2. Default Seeded Credentials

The database seeder automatically provisions test accounts for evaluation:

| Role | Name | Email | Password | Permissions |
|---|---|---|---|---|
| **Admin** | Dr. Alexander Wright | `admin@jajalmedical.com` | `Password123!` | Full CRUD, Dashboard, Case Status transitions, Delete |
| **Viewer** | Clara Oswald | `viewer@jajalmedical.com` | `Password123!` | Read-only access: View Dashboard, List Cases, Search & Filter, View Details. Write/Delete attempts return `403 Forbidden`. |

> [!NOTE]  
> The login interface provides **one-click Quick-Fill credential buttons** for effortless switching between Admin and Viewer roles during evaluation.

---

## 3. Database Design & Relationships

The database is structured cleanly using Laravel migrations:

### `users` Table
- `id` (BigIncrements, Primary Key)
- `name` (VARCHAR)
- `email` (VARCHAR, Unique)
- `password` (VARCHAR, Bcrypt hashed)
- `role` (ENUM: `'Admin'`, `'Viewer'`)
- `remember_token`, `email_verified_at`
- `created_at`, `updated_at` (Timestamps)

### `cases` Table
- `id` (BigIncrements, Primary Key)
- `case_number` (VARCHAR, Unique Index) — e.g. `CAS-2026-1001`
- `patient_reference` (VARCHAR) — Anonymized de-identified code (e.g. `PT-JM-4819`)
- `surgeon_name` (VARCHAR) — Operating surgeon or clinician
- `implant_type` (VARCHAR) — Surgical device (e.g., PEEK Cranial Implant, Acetabular Cup)
- `status` (ENUM, Indexed) — `Draft`, `Planning`, `In Review`, `Approved`, `Completed`, `Cancelled`
- `priority` (ENUM) — `Low`, `Medium`, `High`
- `surgery_date` (DATE, Nullable) — Scheduled surgical procedure date
- `created_by` (Foreign Key referencing `users.id` with `cascadeOnDelete`)
- `created_at`, `updated_at` (Timestamps)

### Eloquent Relationships
- `User` **hasMany** `MedicalCase` (`cases()`)
- `MedicalCase` **belongsTo** `User` (`creator()`, `createdBy()`)
- `MedicalCase` automatically assigns `created_by = Auth::id()` on record creation via Eloquent model events.

---

## 4. Features & Key Modules

### A. Clinical Dashboard
- **5 Dynamic Metric Cards** computed directly from MySQL:
  1. **Total Cases**
  2. **Planning Cases**
  3. **In Review Cases**
  4. **Approved Cases**
  5. **Completed Cases**
- **Recent Medical Cases Table** with rapid view shortcuts and status indicators.
- **RBAC Summary & API Integration Overview** for administrators and clinicians.

### B. Case Management
- **Responsive Table** displaying:
  - Case Number (mono font, linked to details)
  - Patient Reference
  - Surgeon Name
  - Implant Architecture Type
  - Status Badge (color-coded with status dots)
  - Priority Badge (Low, Medium, High with alert icons)
  - Scheduled Surgery Date
  - Action buttons: View, Edit (Admin only), Delete (Admin only with confirmation)
- **Server-Side Pagination:** 10 records per page.
- **Search & Filters:**
  - Search by Case Number
  - Search by Surgeon Name
  - Filter by Case Status (`Draft`, `Planning`, `In Review`, etc.)
  - Filter by Priority (`Low`, `Medium`, `High`)
  - Filters are strictly preserved across pagination links (`withQueryString()`).
- **Unified Reusable Blade Form:** Shared `_form.blade.php` for both Create and Edit workflows.
  - Field-level validation error highlights.
  - Preserves user input upon validation errors (`old(...)`).
  - Uniqueness validation that correctly ignores the current record on update.
- **Case Details Screen:** Displays all required clinical and audit fields (`id`, `case_number`, `patient_reference`, `surgeon_name`, `implant_type`, `status`, `priority`, `surgery_date`, `created_by` user, `created_at`, `updated_at`).

### C. Role-Based Authorization & Security
- **Laravel Policies:** `MedicalCasePolicy` enforces that only users with `role === 'Admin'` can create, update, or delete cases.
- **Backend Enforced:** Backend checks return `HTTP 403 Forbidden` if a Viewer attempts to POST, PUT, or DELETE. The application never relies solely on hiding UI buttons.
- **Form Request Authorization:** Both `StoreCaseRequest` and `UpdateCaseRequest` perform gate authorization checks.

---

## 5. REST API Documentation (Laravel Sanctum)

All API responses strictly adhere to the unified JSON envelope:

```json
{
  "success": true,
  "data": {},
  "message": "Operation successful"
}
```

### Endpoints Specification

| Method | Endpoint | Access | Description |
|---|---|---|---|
| `POST` | `/api/login` | Public | Authenticates credentials and returns Bearer token. |
| `POST` | `/api/logout` | Authenticated | Revokes current access token. |
| `GET` | `/api/cases` | Admin & Viewer | Paginated list of cases (`?page=1&per_page=10&status=Planning&search=Patel`). |
| `POST` | `/api/cases` | **Admin Only** | Creates a new medical case. Returns 403 for Viewer. |
| `GET` | `/api/cases/{id}` | Admin & Viewer | Retrieves full details of a single case. Returns 404 if not found. |
| `PUT` | `/api/cases/{id}` | **Admin Only** | Updates an existing case. Returns 403 for Viewer. |
| `DELETE` | `/api/cases/{id}` | **Admin Only** | Deletes a case. Returns 403 for Viewer. |

### HTTP Status Codes
- `200 OK` — Successful retrieval or modification
- `201 Created` — Resource successfully created
- `401 Unauthorized` — Missing, invalid, or expired Sanctum Bearer token
- `403 Forbidden` — Viewer attempting an Admin mutation
- `404 Not Found` — Case ID does not exist
- `422 Unprocessable Content` — Field validation failure with field-specific errors

### Postman Collection
The file `Medical_Case_Management_API.postman_collection.json` is included in the project root. It contains 14 pre-built requests, automated variable extraction for `{{token}}` and `{{case_id}}`, and explicit test scripts verifying role permissions.

---

## 6. Installation & Local Setup

### Step 1: Clone Repository & Navigate
```bash
git clone <repository_url> medical-case-management
cd medical-case-management
```

### Step 2: Install PHP & Composer Dependencies
```bash
composer install
```

### Step 3: Install Node Dependencies & Build Assets
```bash
npm install
npm run build
```

### Step 4: Environment Configuration
Copy `.env.example` to `.env` (if not already present):
```bash
cp .env.example .env
php artisan key:generate
```

Configure your MySQL connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_case_management
DB_USERNAME=root
DB_PASSWORD=root
```

### Step 5: Run Migrations & Seeders
This builds all tables and populates the 2 test users and 25 realistic dummy cases:
```bash
php artisan migrate:fresh --seed
```

### Step 6: Start the Development Server
```bash
php artisan serve
```
Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your web browser.

---

## 7. Running the Automated Test Suite

Run the full automated test suite containing 54 tests:
```bash
php artisan test
```

Expected output:
```
PASS  Tests\Unit\ExampleTest
PASS  Tests\Feature\Auth\AuthenticationTest
PASS  Tests\Feature\Auth\EmailVerificationTest
PASS  Tests\Feature\Auth\PasswordConfirmationTest
PASS  Tests\Feature\Auth\PasswordResetTest
PASS  Tests\Feature\Auth\PasswordUpdateTest
PASS  Tests\Feature\Auth\RegistrationTest
PASS  Tests\Feature\CaseManagementApiTest
PASS  Tests\Feature\CaseManagementWebTest
PASS  Tests\Feature\ExampleTest
PASS  Tests\Feature\ProfileTest

Tests:    54 passed (164 assertions)
Duration: ~6s
```
