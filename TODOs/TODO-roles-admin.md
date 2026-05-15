# Roles & Admin Setup

## Steps

- [x]   1. Update Role model with relationships/belongsToMany User
- [x]   2. Update User model with roles() belongsToMany, hasRole(), isAdmin()
- [ ]   3. Update RoleUser model pivot if needed
- [ ]   4. Update DatabaseSeeder.php with admin user + role_user assignments
- [ ]   5. Run php artisan migrate:fresh --seed (warn user data loss)
- [ ]   6. Add middleware 'role:admin' or 'admin' group in routes/web.php
- [ ]   7. Update sidebar.blade.php: @if(auth()->user()->hasRole('admin')) show admin links collapsible
- [ ]   8. Conditional @if(auth()->user()->hasRole('member')) user links
- [ ]   9. Test routes/sidebar with admin/member login

Progress: Ready to start.
