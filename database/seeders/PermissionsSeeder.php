<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list evaluations']);
        Permission::create(['name' => 'view evaluations']);
        Permission::create(['name' => 'create evaluations']);
        Permission::create(['name' => 'update evaluations']);
        Permission::create(['name' => 'delete evaluations']);

        Permission::create(['name' => 'list evaluationresults']);
        Permission::create(['name' => 'view evaluationresults']);
        Permission::create(['name' => 'create evaluationresults']);
        Permission::create(['name' => 'update evaluationresults']);
        Permission::create(['name' => 'delete evaluationresults']);

        Permission::create(['name' => 'list evaluators']);
        Permission::create(['name' => 'view evaluators']);
        Permission::create(['name' => 'create evaluators']);
        Permission::create(['name' => 'update evaluators']);
        Permission::create(['name' => 'delete evaluators']);

        Permission::create(['name' => 'list logbooks']);
        Permission::create(['name' => 'view logbooks']);
        Permission::create(['name' => 'create logbooks']);
        Permission::create(['name' => 'update logbooks']);
        Permission::create(['name' => 'delete logbooks']);

        Permission::create(['name' => 'list posts']);
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'update posts']);
        Permission::create(['name' => 'delete posts']);

        Permission::create(['name' => 'list students']);
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'update students']);
        Permission::create(['name' => 'delete students']);

        Permission::create(['name' => 'list studentsubmissions']);
        Permission::create(['name' => 'view studentsubmissions']);
        Permission::create(['name' => 'create studentsubmissions']);
        Permission::create(['name' => 'update studentsubmissions']);
        Permission::create(['name' => 'delete studentsubmissions']);

        Permission::create(['name' => 'list submissions']);
        Permission::create(['name' => 'view submissions']);
        Permission::create(['name' => 'create submissions']);
        Permission::create(['name' => 'update submissions']);
        Permission::create(['name' => 'delete submissions']);

        Permission::create(['name' => 'list supervisors']);
        Permission::create(['name' => 'view supervisors']);
        Permission::create(['name' => 'create supervisors']);
        Permission::create(['name' => 'update supervisors']);
        Permission::create(['name' => 'delete supervisors']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
