<?php

namespace Database\Seeders;

use App\Models\ApiSetting;
use App\Models\Claim;
use App\Models\Invoice;
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
            ['email' => 'help.rezawl71@gmail.com'],
            [
                'name' => 'Md Rezawl',
                'password' => Hash::make('@Freelancer#71%'),
                'role' => 'admin',
                'title' => 'Chief Underwriter & Super Admin',
                'phone' => '(206) 555-0142',
            ]
        );

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

        User::updateOrCreate(
            ['email' => 'eleanor.vance@gmail.com'],
            [
                'name' => 'Eleanor Vance',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'title' => 'Policyholder',
                'phone' => '(206) 555-8901',
            ]
        );

        User::updateOrCreate(
            ['email' => 'michael.chen@apexlogistics.com'],
            [
                'name' => 'Michael Chen',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'title' => 'Commercial Client',
                'phone' => '(509) 555-3412',
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
                'effective_date' => '2026-05-12',
                'renewal_date' => '2027-05-12',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-84920',
                'holder_name' => 'Samantha Ray',
                'type' => 'auto',
                'type_label' => 'Auto Total Shield',
                'coverage_limit' => '$150,000 / $300,000',
                'annual_premium' => '$1,180 / yr',
                'effective_date' => '2026-06-15',
                'renewal_date' => '2027-06-15',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-73104',
                'holder_name' => 'Marcus Sterling',
                'type' => 'life',
                'type_label' => 'Term Life 20-Yr',
                'coverage_limit' => '$1,000,000',
                'annual_premium' => '$960 / yr',
                'effective_date' => '2026-06-25',
                'renewal_date' => '2027-06-25',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-91024',
                'holder_name' => 'Apex Cargo Logistics',
                'type' => 'business',
                'type_label' => 'Commercial Fleet & BOP',
                'coverage_limit' => '$3,000,000',
                'annual_premium' => '$18,400 / yr',
                'effective_date' => '2026-07-10',
                'renewal_date' => '2027-07-10',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-82194',
                'holder_name' => 'Eleanor Vance',
                'type' => 'home',
                'type_label' => 'Luxury Estate Umbrella',
                'coverage_limit' => '$1,200,000',
                'annual_premium' => '$4,850 / yr',
                'effective_date' => '2026-08-14',
                'renewal_date' => '2027-08-14',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-73910',
                'holder_name' => 'Pacific Auto Express',
                'type' => 'auto',
                'type_label' => 'Commercial Auto',
                'coverage_limit' => '$500,000 / $1,000,000',
                'annual_premium' => '$14,600 / yr',
                'effective_date' => '2026-08-28',
                'renewal_date' => '2027-08-28',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-62019',
                'holder_name' => 'TechWave Studios',
                'type' => 'business',
                'type_label' => 'Commercial Package & Cyber',
                'coverage_limit' => '$2,500,000',
                'annual_premium' => '$16,200 / yr',
                'effective_date' => '2026-09-05',
                'renewal_date' => '2027-09-05',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-55912',
                'holder_name' => 'Cascades Timber Co.',
                'type' => 'business',
                'type_label' => 'Commercial Property & BOP',
                'coverage_limit' => '$4,000,000',
                'annual_premium' => '$28,500 / yr',
                'effective_date' => '2026-09-22',
                'renewal_date' => '2027-09-22',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-46830',
                'holder_name' => 'Olympic Harbor Marina',
                'type' => 'business',
                'type_label' => 'Marine & Property BOP',
                'coverage_limit' => '$5,000,000',
                'annual_premium' => '$32,000 / yr',
                'effective_date' => '2026-10-02',
                'renewal_date' => '2027-10-02',
                'status' => 'active',
            ],
            [
                'policy_number' => 'SB-POL-51928',
                'holder_name' => 'Linda Croft',
                'type' => 'auto',
                'type_label' => 'Standard Auto',
                'coverage_limit' => '$75,000 / $150,000',
                'annual_premium' => '$850 / yr',
                'effective_date' => '2026-10-04',
                'renewal_date' => '2027-10-04',
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

        // 5. Realistic Invoices (US Billing)
        $invoices = [
            [
                'invoice_number' => 'INV-2026-001',
                'policy_number' => 'SB-POL-98412',
                'customer_name' => 'Jonathan Harris',
                'customer_email' => 'jharris@example.com',
                'customer_phone' => '(206) 555-0142',
                'customer_address' => '742 Evergreen Terrace, Seattle, WA 98101',
                'subtotal' => 2250.00,
                'tax' => 180.00,
                'discount' => 0.00,
                'total_amount' => 2430.00,
                'status' => 'paid',
                'issue_date' => '2026-05-12',
                'due_date' => '2026-06-12',
                'payment_method' => 'Stripe Credit Card (Visa ending 4242)',
                'payment_transaction_id' => 'ch_3Mtw2eLkdIwHu7ix0HqZ9yP1',
                'paid_at' => '2026-05-14 10:30:00',
                'line_items' => [
                    ['desc' => 'Homeowners Deluxe Annual Premium (Policy #SB-POL-98412)', 'qty' => 1, 'price' => 2250.00, 'tax_pct' => 8.0, 'total' => 2430.00],
                ],
                'notes' => 'Thank you for choosing Surebound Insurance. Payment processed successfully via Stripe US gateway.',
            ],
            [
                'invoice_number' => 'INV-2026-002',
                'policy_number' => 'SB-POL-91024',
                'customer_name' => 'Apex Cargo Logistics LLC',
                'customer_email' => 'billing@apexlogistics.io',
                'customer_phone' => '(425) 555-0399',
                'customer_address' => '1200 Commerce Blvd, Suite 400, Bellevue, WA 98004',
                'subtotal' => 18400.00,
                'tax' => 0.00,
                'discount' => 500.00,
                'total_amount' => 17900.00,
                'status' => 'paid',
                'issue_date' => '2026-07-10',
                'due_date' => '2026-08-10',
                'payment_method' => 'Plaid ACH Direct Debit (JPMorgan Chase ****8819)',
                'payment_transaction_id' => 'ach_tx_90184712093',
                'paid_at' => '2026-07-11 14:15:00',
                'line_items' => [
                    ['desc' => 'Commercial Fleet & BOP Annual Premium (8 Vehicles + Liability)', 'qty' => 1, 'price' => 18400.00, 'tax_pct' => 0, 'total' => 18400.00],
                    ['desc' => 'Fleet Safety Bundle Discount', 'qty' => 1, 'price' => -500.00, 'tax_pct' => 0, 'total' => -500.00],
                ],
                'notes' => 'ACH Transfer settled via FedNow / NACHA Direct Debit. COI dispatched to carrier.',
            ],
            [
                'invoice_number' => 'INV-2026-003',
                'policy_number' => 'SB-POL-55912',
                'customer_name' => 'Cascades Timber Co.',
                'customer_email' => 'finance@cascadestimber.com',
                'customer_phone' => '(206) 555-0915',
                'customer_address' => '890 Industrial Pkwy, Tacoma, WA 98402',
                'subtotal' => 28500.00,
                'tax' => 0.00,
                'discount' => 0.00,
                'total_amount' => 28500.00,
                'status' => 'pending',
                'issue_date' => '2026-09-22',
                'due_date' => '2026-10-22',
                'payment_method' => 'FedNow / US Bank Wire Transfer',
                'payment_transaction_id' => null,
                'paid_at' => null,
                'line_items' => [
                    ['desc' => 'Commercial Property & BOP Annual Coverage Premium', 'qty' => 1, 'price' => 28500.00, 'tax_pct' => 0, 'total' => 28500.00],
                ],
                'notes' => 'Invoice issued. Please remit wire payment using ABA Routing #021000021.',
            ],
            [
                'invoice_number' => 'INV-2026-004',
                'policy_number' => 'SB-POL-46830',
                'customer_name' => 'Olympic Harbor Marina',
                'customer_email' => 'accounts@olympickharbor.org',
                'customer_phone' => '(360) 555-0814',
                'customer_address' => '400 Harbor Drive, Port Angeles, WA 98362',
                'subtotal' => 32000.00,
                'tax' => 0.00,
                'discount' => 0.00,
                'total_amount' => 32000.00,
                'status' => 'overdue',
                'issue_date' => '2026-08-01',
                'due_date' => '2026-09-01',
                'payment_method' => null,
                'payment_transaction_id' => null,
                'paid_at' => null,
                'line_items' => [
                    ['desc' => 'Marine & Property BOP Annual Premium', 'qty' => 1, 'price' => 32000.00, 'tax_pct' => 0, 'total' => 32000.00],
                ],
                'notes' => 'OVERDUE: Payment past due. Notice of cancellation pending unless paid within 10 days.',
            ],
        ];

        foreach ($invoices as $inv) {
            Invoice::updateOrCreate(['invoice_number' => $inv['invoice_number']], $inv);
        }

        // 6. Default API Integrations (Claims API & US Payment Gateways)
        $defaultApiSettings = [
            'claims_api_config' => [
                'enabled' => true,
                'provider' => 'Mitchell / Guidewire ClaimCenter API',
                'environment' => 'production',
                'endpoint_url' => 'https://api.claims-gateway.surebound.com/v2',
                'api_key' => 'sb_claims_live_981a4b7f9204812d8a',
                'webhook_url' => 'http://127.0.0.1:8000/api/v1/claims/webhook',
                'webhook_secret' => 'whsec_claims_84920194810294',
                'sync_frequency' => 'realtime',
                'auto_approve_limit' => 2500,
                'status' => 'connected',
                'last_synced_at' => '2026-10-07 02:30:00',
            ],
            'stripe_config' => [
                'enabled' => true,
                'environment' => 'live',
                'publishable_key' => 'pk_test_surebound_pub_key_sample',
                'secret_key' => 'sk_test_surebound_sec_key_sample',
                'webhook_secret' => 'whsec_stripe_sample_key',
                'accept_cards' => true,
                'accept_apple_pay' => true,
                'accept_google_pay' => true,
            ],
            'plaid_ach_config' => [
                'enabled' => true,
                'environment' => 'production',
                'client_id' => 'plaid_client_6019a84b029',
                'secret_key' => 'plaid_secret_9918204819204812',
                'same_day_ach' => true,
            ],
            'authorize_config' => [
                'enabled' => true,
                'environment' => 'production',
                'api_login_id' => '6xG73kK9',
                'transaction_key' => '4m892Lp01Kq89',
            ],
            'wire_fednow_config' => [
                'enabled' => true,
                'bank_name' => 'JPMorgan Chase Bank, N.A.',
                'routing_number' => '021000021',
                'account_number' => '984102948120',
                'swift_bic' => 'CHASUS33',
                'fednow_participant_id' => 'FEDNOW-SB-89104',
            ],
            'bnpl_klarna_config' => [
                'enabled' => true,
                'merchant_id' => 'KLARNA_US_MERCHANT_90841',
                'shared_secret' => 'klarna_sec_89102948192',
                'country' => 'US',
                'currency' => 'USD',
            ],
            'payment_general_config' => [
                'currency' => 'USD',
                'surcharge_enabled' => false,
                'surcharge_pct' => 2.9,
                'surcharge_flat' => 0.30,
                'auto_send_receipt' => true,
            ],
        ];

        foreach ($defaultApiSettings as $key => $val) {
            ApiSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }
    }
}
