# Loan Repayment Bulk Upload Implementation

## Steps (1/10 complete)

1. [x] Update `app/Models/LoanRepayment.php` - add fillable, casts, relations, boot.
2. [x] Created `database/migrations/2024_10_01_120000_create_loan_repayment_uploads_table.php`.
3. [x] Created `database/migrations/2024_10_01_120100_add_fields_to_loan_repayments_table.php`.
4. [x] Created `app/Models/LoanRepaymentUpload.php`.
5. [x] Created `app/Exports/LoanRepaymentTemplateExport.php`.

6. [x] Created `app/Http/Controllers/Admin/LoanRepaymentUploadController.php` with index, show, downloadTemplate, store.
7. [x] Added resource routes for 'loan-repayment-uploads' and template download in `routes/web.php` (admin.loan-repayment-uploads.\*).
8. [x] Created views `resources/views/admin/loan-repayments/index.blade.php`, `upload.blade.php`, `show.blade.php`.
9. [ ] Run `php artisan migrate`.
10. [ ] Add link to admin sidebar `resources/views/partials/sidebar.blade.php`, test upload.

## Notes

- Excel columns: staff_no, payroll_month, payroll_year, amount, payment_method, reference.
- Find active loan via member.staff_no, matching month/year.
- Update loan.outstanding_balance after each repayment.
- Mirror payroll upload pattern.

2. [ ] Create migration `database/migrations/{timestamp}_create_loan_repayment_uploads_table.php`.
3. [ ] Create migration `database/migrations/{timestamp}_add_upload_fields_to_loan_repayments_table.php`.
4. [ ] Generate & fill `app/Models/LoanRepaymentUpload.php`.
5. [ ] Create `app/Exports/LoanRepaymentTemplateExport.php`.
6. [ ] Update `app/Http/Controllers/Admin/LoanController.php` - add indexRepayments, uploadRepayments, storeBulkRepayment.
7. [ ] Update `routes/web.php` - add loan-repayments routes.
8. [x] Created views: `resources/views/admin/loan-repayments/index.blade.php`, `upload.blade.php`, `show.blade.php`.
9. [x] Ran `php artisan migrate` - tables created/updated.

10. [ ] Add link to admin sidebar `resources/views/partials/sidebar.blade.php`, test upload.

## Notes

- Excel columns: staff_no, payroll_month, payroll_year, amount, payment_method, reference.
- Find active loan via member.staff_no, matching month/year.
- Update loan.outstanding_balance after each repayment.
- Mirror payroll upload pattern.
