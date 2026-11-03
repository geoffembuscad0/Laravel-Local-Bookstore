<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SuppliersSeeder extends Seeder
{
    /**
     * Seed representative suppliers for testing supplier and purchasing screens.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Northstar Book Distribution',
                'code' => 'SUP-001',
                'email' => 'orders@northstar.example',
                'phone' => '+1-555-0101',
                'contact_person' => 'Maya Chen',
                'address' => '125 Market Street',
                'city' => 'Portland',
                'postal_code' => '97204',
                'country' => 'United States',
                'website' => 'https://northstar.example',
                'payment_terms' => 'Net 30',
                'notes' => 'Primary distributor for general and academic titles.',
                'is_active' => true,
            ],
            [
                'name' => 'Cedar House Publishing Supply',
                'code' => 'SUP-002',
                'email' => 'wholesale@cedarhouse.example',
                'phone' => '+1-555-0102',
                'contact_person' => 'Luis Romero',
                'address' => '48 Oak Avenue',
                'city' => 'Madison',
                'postal_code' => '53703',
                'country' => 'United States',
                'website' => 'https://cedarhouse.example',
                'payment_terms' => 'Net 15',
                'notes' => 'Specializes in literature and independent publishers.',
                'is_active' => true,
            ],
            [
                'name' => 'Old Town Book Wholesalers',
                'code' => 'SUP-003',
                'email' => 'contact@oldtown.example',
                'phone' => '+1-555-0103',
                'contact_person' => 'Avery Brooks',
                'address' => '9 Station Road',
                'city' => 'Salem',
                'postal_code' => '97301',
                'country' => 'United States',
                'website' => null,
                'payment_terms' => 'Due on receipt',
                'notes' => 'Inactive sample supplier retained for historical records.',
                'is_active' => false,
            ],
        ];

        foreach ($suppliers as $supplierData) {
            $supplier = Supplier::withTrashed()->updateOrCreate(
                ['code' => $supplierData['code']],
                $supplierData
            );

            if ($supplier->trashed()) {
                $supplier->restore();
            }
        }
    }
}
