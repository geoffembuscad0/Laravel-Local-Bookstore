<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */
            'dashboard.view',

            /*
            |--------------------------------------------------------------------------
            | Books
            |--------------------------------------------------------------------------
            */
            'books.view',
            'books.create',
            'books.edit',
            'books.delete',

            'authors.view',
            'authors.create',
            'authors.edit',
            'authors.delete',

            'publisher.view',
            'publisher.create',
            'publisher.edit',
            'publisher.delete',

            /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            */
            'category.view',
            'category.create',
            'category.edit',
            'categories.delete',

            /*
            |--------------------------------------------------------------------------
            | Cart
            |--------------------------------------------------------------------------
            */
            'cart.view',
            'cart.add',
            'cart.update',
            'cart.remove',

            /*
            |--------------------------------------------------------------------------
            | Collections
            |--------------------------------------------------------------------------
            */
            'collections.view',
            'collections.create',
            'collections.edit',
            'collections.delete',
            'collections.bestsellers',

            /*
            |--------------------------------------------------------------------------
            | Customer Categories
            |--------------------------------------------------------------------------
            */
            'customer-category.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Clear cache again after creating permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
