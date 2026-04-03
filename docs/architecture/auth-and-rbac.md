# Authentication & Authorization (RBAC)

## Overview

The system uses Yii's RBAC framework via the `rights` module for role-based access control. All controllers inherit RBAC enforcement automatically through the base controller chain.

## Key Files

| File | Role |
|------|------|
| `protected/components/Controller.php` | Base controller, extends `RController` |
| `protected/components/UserIdentity.php` | Login credential validation |
| `protected/components/UsersProfile.php` | User profile model for auth |
| `protected/components/views/UserMenu.php` | Nav menu with permission-gated items |
| `protected/modules/rights/RightsModule.php` | RBAC module configuration |
| `protected/modules/rights/components/RController.php` | Rights-aware base controller |
| `protected/modules/user/UserModule.php` | User management module |
| `protected/models/Users.php` | User model |

## Controller Inheritance Chain

```
YourController
  → Controller (protected/components/Controller.php)
    → RController (rights module)
      → CController (Yii framework)
```

Every controller automatically gets RBAC enforcement via `filters() => array('rights')`.

## Authentication Flow

```
Login Form → LoginController
  → UserIdentity::authenticate()
    → queries UsersProfile model
    → validates MD5 password hash
    → sets user ID, username in session
    → stores business_id, branch_id in session state
  → redirect to /site/dashBoard
```

- Session timeout: 60 days
- Auto-renew cookie enabled
- Login history tracked in `login_history` table via `LoginHistory` model

## RBAC Configuration

| Setting | Value |
|---------|-------|
| Superuser role | `Admin` |
| Default authenticated role | `Authenticated` |
| Auth manager | `RDbAuthManager` (DB-backed) |
| Business rules | Enabled (`enableBizRule=true`) |

## Permission System in Navigation

The `UserMenu.php` widget gates every menu item with permission checks:

```php
// Permission closure (cached in session under '_nav_perms')
$ca = function($key) { return Yii::app()->user->checkAccess($key); };

// Usage
if ($ca('SellOrder.Create')) {
    // render menu item
}
```

### Permission Caching
- Permissions are batch-checked and cached in `$_SESSION['_nav_perms']`
- Cache is refreshed on logout
- Avoids per-request DB queries for permission checks

### Developer-Only Items
- `$isDev` flag is set by hardcoded user ID list at top of `UserMenu.php`
- Developer-only menu items are wrapped in `if ($isDev)` checks

## Adding a New Permission-Gated Feature

1. Create the controller action (inherits RBAC automatically)
2. In `UserMenu.php`:
   - Add permission key to `array_fill_keys` list
   - Wrap menu item in `if ($ca('Controller.Action'))`
   - Update `$showXxx` flags if new section needed
3. In Rights module admin UI (`/rights`):
   - Generate auth items for the new controller
   - Assign to appropriate roles

## User Status Constants

```php
User::STATUS_NOACTIVE  // Not activated
User::STATUS_ACTIVE    // Active
User::STATUS_BANNED    // Banned
```
