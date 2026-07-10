<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // CMS content management
            'manage-posts',
            'view-posts',
            'edit-posts',
            'delete-posts',
            'publish-posts',

            'manage-announcements',
            'view-announcements',
            'edit-announcements',
            'delete-announcements',
            'publish-announcements',

            'manage-agendas',
            'view-agendas',
            'edit-agendas',
            'delete-agendas',

            'manage-downloads',
            'view-downloads',
            'edit-downloads',
            'delete-downloads',

            'manage-faqs',
            'view-faqs',
            'edit-faqs',
            'delete-faqs',

            'manage-profile-sections',
            'view-profile-sections',
            'edit-profile-sections',
            'delete-profile-sections',

            'manage-teachers',
            'view-teachers',
            'edit-teachers',
            'delete-teachers',

            'manage-gallery',
            'view-gallery',
            'edit-gallery',
            'delete-gallery',

            'manage-contact-messages',
            'view-contact-messages',
            'reply-contact-messages',

            'manage-settings',
            'view-settings',

            'manage-users',
            'view-users',
            'edit-users',
            'delete-users',

            // Filament resource access
            'access-admin-panel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Editor gets content permissions only
        $editorPermissions = Permission::whereIn('name', [
            'manage-posts', 'view-posts', 'edit-posts', 'publish-posts',
            'manage-announcements', 'view-announcements', 'edit-announcements', 'publish-announcements',
            'manage-agendas', 'view-agendas', 'edit-agendas',
            'manage-downloads', 'view-downloads', 'edit-downloads',
            'manage-faqs', 'view-faqs', 'edit-faqs',
            'manage-profile-sections', 'view-profile-sections', 'edit-profile-sections',
            'manage-teachers', 'view-teachers', 'edit-teachers',
            'manage-gallery', 'view-gallery', 'edit-gallery',
            'manage-contact-messages', 'view-contact-messages', 'reply-contact-messages',
            'view-settings',
        ])->get();
        $editorRole->givePermissionTo($editorPermissions);

        // Make the existing admin user an admin role
        $superAdmin = User::where('email', 'admin@mt.sn')->first();
        if ($superAdmin && !$superAdmin->hasRole('admin')) {
            $superAdmin->assignRole('admin');
        }
    }
}
