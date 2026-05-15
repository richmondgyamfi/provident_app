# TODO

- [ ] Create admin Reports module (UI + controller)
- [x] Add routes for /admin/reports, /admin/reports/export/excel, /admin/reports/export/pdf, /admin/reports/data

- [ ] Create reports index blade with filters (date range), report type selection, graph section, and export buttons
- [ ] Implement ReportsController: query + graph dataset + Excel/PDF export endpoints
- [ ] Implement Excel export classes for Loans, Contributions, Withdrawals
- [ ] Implement PDF blade templates for Loans, Contributions, Withdrawals and wire controller export
- [ ] Add sidebar link to Reports
- [ ] Install missing dependencies (laravel-excel and PDF dompdf wrappers) if required
- [ ] Manual testing: browser navigation + exporting to Excel/PDF + graph rendering

