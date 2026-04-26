# Provident App - Technical Documentation

## Project Overview

The Provident App is a web-based application built with Laravel 12 for managing a provident fund or staff savings scheme. It allows staff members to apply for loans and withdrawals, make contributions via payroll uploads, view statements, and enables administrators to approve/manage requests, track repayments, and handle contributions. Key features include Google OAuth authentication, role-based access (members/admin), interest calculations, audit logging, and comprehensive CRUD operations.

The app supports:
- Member registration/membership forms
- Loan applications and admin approvals/repayments
- Withdrawal requests and approvals
- Payroll-based contributions
- Staff statements and dashboards
- Admin dashboards for oversight

Static HTML pages (e.g., admin-dashboard.html, loan-application.html) suggest hybrid frontend with Blade templates.

## Tech Stack & Dependencies

- **Framework**: Laravel 12.x
- **PHP**: ^8.2
- **Database**: MySQL/PostgreSQL (Eloquent ORM)
- **Frontend**: Blade templates, Vite, Bootstrap JS/CSS, Alpine.js (inferred)
- **Auth**: Laravel Socialite (Google OAuth)
- **Key Packages** (from composer.json):
  - `laravel/framework:^12.0`
  - `laravel/socialite:^5.25`
  - `laravel/tinker:^2.10.1`
  - Dev: Pest testing, Laravel Pint, Sail, etc.
- **Build Tools**: Vite (vite.config.js), NPM (package.json)
- **Testing**: Pest PHP

## Installation & Setup

1. Clone repo or navigate to project directory.
2. Run setup script:
   ```
   composer setup
   ```
   This installs deps, copies .env, generates key, migrates DB, installs NPM, builds assets.

3. Configure `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=provident_app
   DB_USERNAME=root
   DB_PASSWORD=

   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

4. Run migrations & seeders:
   ```
   php artisan migrate --seed
   ```

5. Start dev server:
   ```
   php artisan serve
   npm run dev
   ```

6. Access:
   - Login: `http://localhost:8000` (Google OAuth)
   - Member Dashboard: `/dashboard`
   - Admin Dashboard: `/admin-dashboard`

## Database Schema Summary

From migrations (22+ tables):

| Table | Purpose | Key Fields |
|-------|---------|------------|
| `users` | Auth users (Google ID added) | id, name, email, google_id, email_verified_at |
| `members` | Staff profiles | staff_no, name, bank_name, account_number, next_of_kin_*, monthly_contribution |
| `loan_types` | Loan categories | name, interest_rate, max_amount, max_term_months |
| `loans` | Loan apps/records | member_id, loan_type_id, amount, interest_rate, term_months, status (pending/approved/rejected/disbursed), application_ref |
| `loan_repayments` | Repayment records | loan_id, amount, payment_date, payment_method |
| `contributions` | Member contributions (payroll fields added) | member_id, amount, payroll_upload_id, date |
| `withdrawals` | Withdrawal requests | member_id, amount, reason, status |
| `opening_balances` | Initial balances | member_id, balance_type, amount |
| `payroll_uploads` | Bulk payroll CSV uploads | uploaded_by, file_path, total_records |
| `interest_rates` | Configurable rates | type (savings/loan), rate, effective_date |
| `interest_earnings` | Calculated interest | member_id, period, amount |
| `transactions` | All fund movements | type, member_id, amount, description |
| `roles` / `role_users` | RBAC | name (admin/member), user_id |
| `audit_logs` | Change tracking | user_id, action, model_type, model_id |
| Laravel std: sessions, jobs, cache, etc. | - | - |

Run `php artisan migrate` to create.

## Key Models & Relationships

- **Member**: fillable staff/bank/NOK details, `hasMany` Contributions
- **Loan** (HasFactory): fillable amount/status/purpose, belongsTo Member/LoanType, hasMany LoanRepayment. Auto-sets member_id/status/ref on create. Status colors: pending=yellow, approved=green, etc.
- **LoanRepayment**: loan_id, amount, payment_date, etc.
- **Contribution**: belongsTo Member/PayrollUpload
- **Withdrawal**: similar to Loan
- Others: Role, Transaction, AuditLog (logging), etc.

## Controllers & Routes

All routes under `auth` middleware except login/register.

### Authentication
```
GET /auth/google → GoogleController@redirectToGoogle
GET /auth/google/callback → GoogleController@handleGoogleCallback
POST /logout → GoogleController@logout
```

### Member Routes (MemberController)
```
GET/POST /loans → storeLoan
GET /loan-application → loanApplication form
GET /withdrawal-request → withdrawalRequest form
POST /withdrawals → storeWithdrawal
GET /dashboard → index
GET /membership-form → membershipform
Resource /members
```

### Contributions (ContributionController)
```
Resource /contributions
GET/POST /payroll-contribution → create/edit
Resource /payroll-uploads (PayrollUploadController)
```

### Admin Routes (prefix: admin)
**Loans (LoanController)**:
```
GET /loans → index (paginated)
GET /loans/{loan} → show
PATCH /loans/{loan}/status → approve/reject (w/ notes/amount)
GET/POST /loans/{loan}/repayment → create/store repayment
```

**Withdrawals (WithdrawalController)**:
```
GET /withdrawals → index
GET /withdrawals/{withdrawal} → show
PATCH /withdrawals/{withdrawal}/status → updateStatus
```

**AdminDashboardController@index** → /admin-dashboard

Static views: staff-statement, staff-contribution.

## Views (Blade)

- **Layouts**: `layouts/app.blade.php`, partials header/sidebar/footer
- **Auth**: login.blade.php, register.blade.php
- **Members**: dashboard.blade.php, loan-application.blade.php, staff-statement.blade.php, withdrawal-request.blade.php, membership-form.blade.php
- **Admin**: admin-dashboard.blade.php, loans/index/show, withdrawals/index/show, loan-repayments/create, payroll-contribution.blade.php, staff-contribution.blade.php

Hybrid with static HTML (e.g., admin-dashboard.html).

## Authentication Flow

1. Visit `/` → login view → redirects to Google OAuth
2. Callback handles user creation/link via Socialite
3. Session-based auth for members/admins (roles via role_users)

## Features

1. **Loans**: Apply (amount/type/purpose), admin approve/reject/disbursed, record repayments, track balance.
2. **Withdrawals**: Request/approve similar to loans.
3. **Contributions**: Individual or bulk payroll upload (CSV?), edit.
4. **Statements**: Staff statement view.
5. **Dashboards**: Member overview, Admin analytics (loans/withdrawals).
6. **Interest**: Rates config, earnings calc.
7. **Audit**: Logs changes.
8. **Opening Balances**: Initial setup.

## TODOs & Open Items

From TODO*.md files:
- Complete withdrawal form/approval impl.
- Admin loans/withdrawals full mgmt.
- File upload forms (payroll/docs).
- Membership form fully functional.
- Staff contribution/payroll polish.
- Potential: Email notifications, reports/PDFs, SMS alerts.

See TODO.md, TODO-loans.md, etc. for details.

## Architecture

```
┌─────────────────┐    ┌──────────────────┐
│   Google OAuth  │───▶│   Laravel Auth   │
└─────────────────┘    └────────┬─────────┘
                               │
                    ┌──────────▼──────────┐
                    │   Blade Views       │
                    │ (Member/Admin)      │
                    └────────┬────────────┘
                             │ HTTP Routes
                    ┌────────▼────────────┐
                    │   Controllers       │
                    │ (Member/AdminLoan)  │ ──→ Eloquent
                    └────────┬────────────┘      │
                             │                  ▼
                    ┌────────▼────────────┐ ┌─────────────┐
                    │   Models (Loan/     │ │   MySQL     │
                    │   Member/Contrib)   │ │ DB Tables   │
                    └─────────────────────┘ └─────────────┘
```

## Deployment

- Use Forge/Vapor or standard PHP server (Apache/Nginx + PHP-FPM).
- Set env vars for DB/Google.
- `php artisan config:cache`, `npm run build`, migrate.
- Queue workers: `php artisan queue:work` for emails/jobs.

## Testing

Pest tests in `tests/`. Run `php artisan test`.

## Contributing

Follow Laravel standards. Use Pint for code style: `php artisan pint`.

---

*Generated automatically based on codebase analysis. Last updated: $(date). Contact maintainer for questions.*

