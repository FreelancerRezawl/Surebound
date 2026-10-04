<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Policy;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Users
        User::updateOrCreate(
            ['email' => 'admin@surebound.com'],
            [
                'name' => 'Sarah Jenkins',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'title' => 'Principal Underwriter',
                'phone' => '(206) 555-0142',
            ]
        );

        User::updateOrCreate(
            ['email' => 'dmiller@surebound.com'],
            [
                'name' => 'David Miller',
                'password' => Hash::make('password123'),
                'role' => 'agent',
                'title' => 'Commercial Lines Broker',
                'phone' => '(509) 555-0724',
            ]
        );

        // 2. Realistic Quotes
        $quotes = [
            [
                'quote_ref' => 'Q-10492',
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.j@example.com',
                'phone' => '(206) 555-0142',
                'type' => 'auto',
                'type_label' => 'Auto Insurance',
                'coverage' => '$250,000 / $500,000',
                'premium' => '$1,450 / yr',
                'location' => 'Seattle, WA',
                'zip_code' => '98101',
                'status' => 'quoted',
                'notes' => '2024 Honda CR-V Hybrid. Clean driving record. Looking for comprehensive and collision coverage.',
            ],
            [
                'quote_ref' => 'Q-10491',
                'name' => 'Michael Chang',
                'email' => 'm.chang@example.com',
                'phone' => '(503) 555-0189',
                'type' => 'home',
                'type_label' => 'Homeowners',
                'coverage' => '$650,000 Dwelling',
                'premium' => '$2,180 / yr',
                'location' => 'Portland, OR',
                'zip_code' => '97201',
                'status' => 'new',
                'notes' => 'Single family residence, built 2018. New roof in 2022. Bundling with auto potential.',
            ],
            [
                'quote_ref' => 'Q-10490',
                'name' => 'Emma Watson',
                'email' => 'emma.w@example.com',
                'phone' => '(415) 555-0211',
                'type' => 'life',
                'type_label' => 'Term Life',
                'coverage' => '$1,000,000 (20-Yr)',
                'premium' => '$840 / yr',
                'location' => 'San Francisco, CA',
                'zip_code' => '94102',
                'status' => 'reviewing',
                'notes' => 'Non-smoker, 34 years old. Requesting preferred plus rating underwriting review.',
            ],
            [
                'quote_ref' => 'Q-10489',
                'name' => 'Apex Logistics LLC',
                'email' => 'fleet@apexlogistics.io',
                'phone' => '(425) 555-0399',
                'type' => 'business',
                'type_label' => 'Commercial Liability',
                'coverage' => '$2,000,000 Aggregate',
                'premium' => '$5,800 / yr',
                'location' => 'Bellevue, WA',
                'zip_code' => '98004',
                'status' => 'converted',
                'notes' => 'Fleet of 8 cargo vans and warehouse liability. Policy bound and active.',
            ],
            [
                'quote_ref' => 'Q-10488',
                'name' => 'David Miller',
                'email' => 'dmiller@example.com',
                'phone' => '(509) 555-0724',
                'type' => 'auto',
                'type_label' => 'Auto Comprehensive',
                'coverage' => '$100,000 / $300,000',
                'premium' => '$920 / yr',
                'location' => 'Spokane, WA',
                'zip_code' => '99201',
                'status' => 'declined',
                'notes' => 'Multiple moving violations in past 18 months, outside target risk tier.',
            ],
            [
                'quote_ref' => 'Q-10487',
                'name' => 'Jessica Alba',
                'email' => 'jessica.a@example.com',
                'phone' => '(253) 555-0633',
                'type' => 'home',
                'type_label' => 'Home & Flood',
                'coverage' => '$820,000 Dwelling',
                'premium' => '$3,400 / yr',
                'location' => 'Tacoma, WA',
                'zip_code' => '98402',
                'status' => 'new',
                'notes' => 'Coastal property requires private flood endorsement. Fast quotation needed.',
            ],
            [
                'quote_ref' => 'Q-10486',
                'name' => 'Cascade Roasters Co.',
                'email' => 'admin@cascaderoasters.com',
                'phone' => '(206) 555-0915',
                'type' => 'business',
                'type_label' => 'Business BOP',
                'coverage' => '$1,500,000',
                'premium' => '$4,600 / yr',
                'location' => 'Seattle, WA',
                'zip_code' => '98103',
                'status' => 'reviewing',
                'notes' => 'Coffee roasting facility and retail cafe storefront.',
            ],
        ];

        foreach ($quotes as $q) {
            Quote::updateOrCreate(['quote_ref' => $q['quote_ref']], $q);
        }

        // 3. Real Policies
        $policies = [
            [
                'policy_number' => 'SB-POL-98412',
                'holder_name' => 'Jonathan Harris',
                'type' => 'home',
                'type_label' => 'Homeowners Deluxe',
                'coverage_limit' => '$750,000',
                'annual_premium' => '$2,250 / yr',
                'effective_date' => '2025-11-12',
                'renewal_date' => '2026-11-12',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-84920',
                'holder_name' => 'Samantha Ray',
                'type' => 'auto',
                'type_label' => 'Auto Total Shield',
                'coverage_limit' => '$150,000 / $300,000',
                'annual_premium' => '$1,180 / yr',
                'effective_date' => '2026-01-15',
                'renewal_date' => '2027-01-15',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-73104',
                'holder_name' => 'Marcus Sterling',
                'type' => 'life',
                'type_label' => 'Term Life 20-Yr',
                'coverage_limit' => '$1,000,000',
                'annual_premium' => '$960 / yr',
                'effective_date' => '2026-03-01',
                'renewal_date' => '2027-03-01',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-62019',
                'holder_name' => 'TechWave Studios',
                'type' => 'business',
                'type_label' => 'Commercial Package',
                'coverage_limit' => '$2,500,000',
                'annual_premium' => '$6,200 / yr',
                'effective_date' => '2025-12-05',
                'renewal_date' => '2026-12-05',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-51928',
                'holder_name' => 'Linda Croft',
                'type' => 'auto',
                'type_label' => 'Standard Auto',
                'coverage_limit' => '$75,000 / $150,000',
                'annual_premium' => '$850 / yr',
                'effective_date' => '2025-10-20',
                'renewal_date' => '2026-10-20',
                'status' => 'pending',
            ],
        ];

        foreach ($policies as $p) {
            Policy::updateOrCreate(['policy_number' => $p['policy_number']], $p);
        }

        // 4. Real Claims
        $claims = [
            [
                'claim_number' => 'CLM-2026-081',
                'policy_number' => 'SB-POL-98412',
                'claimant_name' => 'Jonathan Harris',
                'incident_description' => 'Severe hailstorm roof damage & exterior guttering',
                'estimated_loss' => '$8,400',
                'assigned_adjuster' => 'David Miller',
                'priority' => 'High',
                'status' => 'reviewing',
            ],
            [
                'claim_number' => 'CLM-2026-064',
                'policy_number' => 'SB-POL-84920',
                'claimant_name' => 'Samantha Ray',
                'incident_description' => 'Low-speed parking lot scrape & bumper crack',
                'estimated_loss' => '$1,250',
                'assigned_adjuster' => 'Sarah Jenkins',
                'priority' => 'Normal',
                'status' => 'approved',
            ],
            [
                'claim_number' => 'CLM-2026-052',
                'policy_number' => 'SB-POL-62019',
                'claimant_name' => 'TechWave Studios',
                'incident_description' => 'Server room water pipe leakage & equipment repair',
                'estimated_loss' => '$14,200',
                'assigned_adjuster' => 'Alex Vance',
                'priority' => 'High',
                'status' => 'paid',
            ],
        ];

        foreach ($claims as $c) {
            Claim::updateOrCreate(['claim_number' => $c['claim_number']], $c);
        }
    }
}
