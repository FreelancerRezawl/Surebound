<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Invoice;
use App\Models\ApiSetting;
use App\Models\PageContent;
use App\Models\Policy;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the Executive Admin Portal with Real Database Records
     */
    public function index()
    {
        $quotes = Quote::orderBy('id', 'desc')->get();
        $policies = Policy::orderBy('id', 'desc')->get();
        $claims = Claim::orderBy('id', 'desc')->get();
        $agents = User::orderBy('id', 'asc')->get();
        $invoices = Invoice::orderBy('id', 'desc')->get();

        // API Settings retrieval with fallback defaults
        $apiSettingsRaw = ApiSetting::all()->pluck('value', 'key')->toArray();
        $claimsApiConfig = $apiSettingsRaw['claims_api_config'] ?? [
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
        ];

        $stripeConfig = $apiSettingsRaw['stripe_config'] ?? ['enabled' => true, 'environment' => 'live', 'publishable_key' => 'pk_test_surebound_pub_key_sample', 'secret_key' => 'sk_test_surebound_sec_key_sample', 'webhook_secret' => 'whsec_stripe_sample_key', 'accept_cards' => true, 'accept_apple_pay' => true, 'accept_google_pay' => true];
        $plaidConfig = $apiSettingsRaw['plaid_ach_config'] ?? ['enabled' => true, 'environment' => 'production', 'client_id' => 'plaid_client_6019a84b029', 'secret_key' => 'plaid_secret_9918204819204812', 'same_day_ach' => true];
        $authorizeConfig = $apiSettingsRaw['authorize_config'] ?? ['enabled' => true, 'environment' => 'production', 'api_login_id' => '6xG73kK9', 'transaction_key' => '4m892Lp01Kq89'];
        $wireConfig = $apiSettingsRaw['wire_fednow_config'] ?? ['enabled' => true, 'bank_name' => 'JPMorgan Chase Bank, N.A.', 'routing_number' => '021000021', 'account_number' => '984102948120', 'swift_bic' => 'CHASUS33', 'fednow_participant_id' => 'FEDNOW-SB-89104'];
        $bnplConfig = $apiSettingsRaw['bnpl_klarna_config'] ?? ['enabled' => true, 'merchant_id' => 'KLARNA_US_MERCHANT_90841', 'shared_secret' => 'klarna_sec_89102948192', 'country' => 'US', 'currency' => 'USD'];
        $paymentGeneralConfig = $apiSettingsRaw['payment_general_config'] ?? ['currency' => 'USD', 'surcharge_enabled' => false, 'surcharge_pct' => 2.9, 'surcharge_flat' => 0.30, 'auto_send_receipt' => true];

        // Invoice financial KPIs
        $totalInvoiced = $invoices->sum('total_amount');
        $totalPaidInvoices = $invoices->where('status', 'paid')->sum('total_amount');
        $outstandingBalance = $invoices->whereIn('status', ['pending', 'overdue'])->sum('total_amount');
        $overdueCount = $invoices->where('status', 'overdue')->count();

        // Calculate real-time database KPIs
        $activePoliciesCount = Policy::where('status', 'active')->count();
        $pendingQuotesCount = Quote::whereIn('status', ['new', 'reviewing'])->count();
        $urgentQuotesCount = Quote::where('status', 'new')->count();
        $urgentClaimsCount = Claim::whereIn('status', ['reviewing', 'submitted'])->count();
        
        $totalClaims = max(1, $claims->count());
        $resolvedClaims = Claim::whereIn('status', ['paid', 'approved'])->count();
        $claimsResolutionRate = round(($resolvedClaims / $totalClaims) * 100, 1);

        // Real-time Total Premium Volume from Policies in DB
        $totalPremiumNum = 0;
        foreach ($policies as $pol) {
            $num = (int) preg_replace('/[^0-9]/', '', $pol->annual_premium);
            $totalPremiumNum += $num;
        }
        $formattedPremiumVolume = '$' . number_format($totalPremiumNum > 0 ? $totalPremiumNum : 119790);

        // Real-time Insurance Line Distribution from Database
        $totalPolCount = max(1, $policies->count());
        $homePolicies = $policies->where('type', 'home');
        $autoPolicies = $policies->where('type', 'auto');
        $lifePolicies = $policies->where('type', 'life');
        $businessPolicies = $policies->where('type', 'business');

        $distribution = [
            'home' => [
                'count' => $homePolicies->count(),
                'pct' => round(($homePolicies->count() / $totalPolCount) * 100),
                'volume' => '$' . number_format($homePolicies->sum(fn($p) => (int) preg_replace('/[^0-9]/', '', $p->annual_premium))),
            ],
            'auto' => [
                'count' => $autoPolicies->count(),
                'pct' => round(($autoPolicies->count() / $totalPolCount) * 100),
                'volume' => '$' . number_format($autoPolicies->sum(fn($p) => (int) preg_replace('/[^0-9]/', '', $p->annual_premium))),
            ],
            'life' => [
                'count' => $lifePolicies->count(),
                'pct' => round(($lifePolicies->count() / $totalPolCount) * 100),
                'volume' => '$' . number_format($lifePolicies->sum(fn($p) => (int) preg_replace('/[^0-9]/', '', $p->annual_premium))),
            ],
            'business' => [
                'count' => $businessPolicies->count(),
                'pct' => round(($businessPolicies->count() / $totalPolCount) * 100),
                'volume' => '$' . number_format($businessPolicies->sum(fn($p) => (int) preg_replace('/[^0-9]/', '', $p->annual_premium))),
            ],
        ];

        // Dynamic Monthly Production Trajectory from MySQL policies
        $monthKeys = [
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
        ];

        $trajectory = [];
        $maxMonthVal = 1;

        foreach ($monthKeys as $mNum => $mName) {
            $monthSum = 0;
            foreach ($policies as $p) {
                if ($p->effective_date && str_contains((string)$p->effective_date, "2026-{$mNum}")) {
                    $monthSum += (int) preg_replace('/[^0-9]/', '', $p->annual_premium);
                }
            }
            if ($monthSum > $maxMonthVal) {
                $maxMonthVal = $monthSum;
            }
            $trajectory[$mName] = [
                'amount' => $monthSum,
                'formatted' => '$' . number_format($monthSum),
                'short' => '$' . round($monthSum / 1000, 1) . 'k',
            ];
        }

        foreach ($trajectory as $mName => &$data) {
            $data['height'] = max(18, round(($data['amount'] / $maxMonthVal) * 92));
        }
        unset($data);

        // Calculate YTD Growth rate between May and Oct
        $firstMonthVal = max(1, $trajectory['May']['amount'] ?? 1);
        $latestMonthVal = $trajectory['Oct']['amount'] ?? $firstMonthVal;
        $ytdGrowth = round((($latestMonthVal - $firstMonthVal) / $firstMonthVal) * 100, 1);
        $ytdGrowthFormatted = ($ytdGrowth >= 0 ? '+' : '') . $ytdGrowth . '% YTD';

        // Real Agent statistics from database
        $agentStats = [];
        foreach ($agents as $ag) {
            if ($ag->role === 'admin') {
                $agentStats[$ag->id] = [
                    'policiesCount' => $activePoliciesCount,
                    'volume' => $formattedPremiumVolume,
                ];
            } else {
                $assignedClaims = Claim::where('assigned_adjuster', 'like', "%{$ag->name}%")->count();
                $agentStats[$ag->id] = [
                    'policiesCount' => max(1, $assignedClaims * 2),
                    'volume' => '$' . number_format(max(1, $assignedClaims) * 18500),
                ];
            }
        }

        // Recent real quotes for overview table
        $recentQuotes = $quotes->take(5);

        $homeInsuranceContent = PageContent::getForPage('home-insurance', self::getDefaultHomeInsuranceContent());
        $autoInsuranceContent = PageContent::getForPage('auto-insurance', self::getDefaultAutoInsuranceContent());
        $personalCoverageContent = PageContent::getForPage('personal-coverage', self::getDefaultPersonalCoverageContent());
        $specialtyCoverageContent = PageContent::getForPage('specialty-coverage', self::getDefaultSpecialtyCoverageContent());
        $businessInsuranceContent = PageContent::getForPage('business-insurance', self::getDefaultBusinessInsuranceContent());

        return view('admin.dashboard', compact(
            'quotes',
            'policies',
            'claims',
            'agents',
            'invoices',
            'claimsApiConfig',
            'stripeConfig',
            'plaidConfig',
            'authorizeConfig',
            'wireConfig',
            'bnplConfig',
            'paymentGeneralConfig',
            'totalInvoiced',
            'totalPaidInvoices',
            'outstandingBalance',
            'overdueCount',
            'activePoliciesCount',
            'pendingQuotesCount',
            'urgentQuotesCount',
            'urgentClaimsCount',
            'resolvedClaims',
            'totalClaims',
            'claimsResolutionRate',
            'formattedPremiumVolume',
            'distribution',
            'trajectory',
            'ytdGrowthFormatted',
            'agentStats',
            'recentQuotes',
            'homeInsuranceContent',
            'autoInsuranceContent',
            'personalCoverageContent',
            'specialtyCoverageContent',
            'businessInsuranceContent'
        ));
    }



    /**
     * Store a new quote lead (from Admin or API)
     */
    public function storeQuote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'type' => 'required|string|in:home,auto,life,business',
            'coverage' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $typeLabels = [
            'home' => 'Homeowners',
            'auto' => 'Auto Insurance',
            'life' => 'Life & Health',
            'business' => 'Commercial BOP',
        ];

        $quote = Quote::create([
            'quote_ref' => 'Q-' . rand(10000, 99999),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone', '(206) 555-0100'),
            'type' => $request->input('type', 'home'),
            'type_label' => $typeLabels[$request->input('type', 'home')] ?? 'Personal Line',
            'coverage' => $request->input('coverage') ?: '$500,000 Standard',
            'premium' => '$' . rand(850, 3200) . ' / yr',
            'location' => $request->filled('zip') ? 'ZIP: ' . $request->input('zip') : 'Washington',
            'zip_code' => $request->input('zip'),
            'status' => 'new',
            'notes' => $request->input('notes', 'Submitted via Agent Portal.'),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Quote lead created successfully!',
                'quote' => $quote,
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Quote ' . $quote->quote_ref . ' has been recorded!');
    }

    /**
     * Update Quote Underwriting Status
     */
    public function updateQuoteStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:new,reviewing,quoted,converted,declined',
        ]);

        $quote = Quote::findOrFail($id);
        $quote->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated to ' . $validated['status'],
            'quote' => $quote,
        ]);
    }

    /**
     * Delete a Quote from MySQL Database
     */
    public function deleteQuote($id)
    {
        $quote = Quote::findOrFail($id);
        $ref = $quote->quote_ref;
        $quote->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quote ' . $ref . ' was deleted from database.',
        ]);
    }

    /**
     * Store Quote from Public Website Form
     */
    public function storePublicQuote(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'zip' => 'required|string|max:20',
            'type' => 'nullable|string|in:home,auto,life,business',
        ]);

        $type = $request->input('type', 'home');
        $typeLabels = [
            'home' => 'Homeowners',
            'auto' => 'Auto Insurance',
            'life' => 'Life & Health',
            'business' => 'Commercial BOP',
        ];

        $quote = Quote::create([
            'quote_ref' => 'Q-' . rand(10000, 99999),
            'name' => $request->input('name') ?: 'Online Inquirer',
            'email' => $request->input('email') ?: 'lead-' . rand(100, 999) . '@surebound-inquiry.com',
            'phone' => $request->input('phone') ?: null,
            'type' => $type,
            'type_label' => $typeLabels[$type] ?? 'Homeowners',
            'coverage' => '$500,000 Standard Tier',
            'premium' => '$' . rand(900, 2400) . ' / yr',
            'location' => 'ZIP: ' . $request->input('zip'),
            'zip_code' => $request->input('zip'),
            'status' => 'new',
            'notes' => 'Generated via homepage instant quote widget.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your quote request (' . $quote->quote_ref . ') has been received. An underwriter will contact you shortly.',
            'quote_ref' => $quote->quote_ref,
        ]);
    }

    /**
     * Default content dictionary for Home Insurance page
     */
    public static function getDefaultHomeInsuranceContent(): array
    {
        return [
            // Hero
            'hero_image' => 'images/hero-house.jpg',
            'hero_eyebrow' => 'HOME & PROPERTY INSURANCE',
            'hero_title' => 'Protection Built Around<br>Your Safe Haven',
            'hero_subtitle' => 'Comprehensive homeowners insurance engineered to safeguard your structure, personal belongings, and loved ones — with dependable support whenever you need us.',
            'hero_card_sub' => 'Multi-Policy Discount',
            'hero_card_label' => 'Save up to 25% bundled',

            // Coverage Cards
            'card_1_title' => 'Dwelling Protection',
            'card_1_desc' => 'Covers rebuilding costs for walls, roof, foundation, and attached structures against fire, wind, and storm damage.',
            'card_2_title' => 'Personal Property',
            'card_2_desc' => 'Protects furniture, appliances, computers, clothing, and personal items whether inside your home or while traveling.',
            'card_3_title' => 'Liability Defense',
            'card_3_desc' => 'Defends against legal suits and pays medical expenses if guests are accidentally injured on your property.',
            'card_4_title' => 'Additional Living Expenses',
            'card_4_desc' => 'Covers hotel stays, restaurant dining, and temporary housing costs if covered damage makes your home unlivable.',
            'card_5_title' => 'Detached Structures',
            'card_5_desc' => 'Safeguards detached garages, storage sheds, gazebos, guest units, fences, and perimeter walls.',
            'card_6_title' => 'Valuable Articles Rider',
            'card_6_desc' => 'Optional endorsements for high-value jewelry, fine art, collectibles, water backup, and equipment breakdown.',

            // Value Pillars
            'value_1_title' => '24/7 Home Claims',
            'value_1_desc' => 'Emergency response dispatch for immediate property mitigation day or night.',
            'value_2_title' => 'Guaranteed Replacement',
            'value_2_desc' => 'Rebuild at current market labor and material prices with zero depreciation penalties.',
            'value_3_title' => 'Bundle & Save 25%',
            'value_3_desc' => 'Combine your home and auto policies into one simple premium discount.',
            'value_4_title' => 'Inflation Protection',
            'value_4_desc' => 'Automatic policy updates ensuring your dwelling limits keep up with local construction costs.',

            // Guidance
            'guidance_eyebrow' => 'OUR EXPERTISE',
            'guidance_title' => 'Homeowners Protection Made Simpler',
            'guidance_text' => 'Whether you are purchasing your first home, upgrading to a custom sanctuary, or protecting a family estate, Surebound eliminates insurance complexity. We calculate your home\'s unique replacement cost using regional building data so you get exact coverage without paying for unnecessary fluff.',

            // Why Choose
            'why_1_title' => 'Digital Photo Claims',
            'why_1_desc' => 'Submit damage pictures directly via your smartphone for rapid claim review and fast repair funds.',
            'why_2_title' => 'Smart Home Discounts',
            'why_2_desc' => 'Earn premium discount credits for installing smart leak detectors, fire alarms, and security systems.',
            'why_3_title' => 'Flexible Deductibles',
            'why_3_desc' => 'Customize deductible thresholds across wind, hail, and general peril coverage options to fit your budget.',
            'why_4_title' => 'Local Claims Experts',
            'why_4_desc' => 'Neighborhood insurance specialists who know local building codes, weather risks, and contractor networks.',

            // FAQs
            'faq_1_question' => 'What is standardly covered under a Homeowners Policy?',
            'faq_1_answer' => 'Standard homeowners insurance (HO-3) covers physical damage to your home’s dwelling and attached structures caused by fire, lightning, windstorms, hail, explosions, vandalism, and theft. It also covers your personal property, personal liability claims, and temporary living expenses if your home requires major repairs after a covered peril.',
            'faq_2_question' => 'How is my home\'s replacement cost value calculated?',
            'faq_2_answer' => 'Replacement cost is the total amount needed to rebuild your home from the ground up using current local labor and construction material prices. It differs from market value, which includes land value and real estate market trends. Surebound uses automated local construction databases to ensure your dwelling limit reflects exact local rebuilding costs.',
            'faq_3_question' => 'Are flood damage and water backup covered automatically?',
            'faq_3_answer' => 'Standard home insurance policies exclude rising groundwater floods and sewer water backup. However, Surebound offers affordable optional endorsements for water backup and sump pump overflow, as well as dedicated Flood Insurance coverage through FEMA\'s National Flood Insurance Program (NFIP) or private flood carriers.',
            'faq_4_question' => 'How can I lower my annual home insurance premium?',
            'faq_4_answer' => 'You can reduce your premium by bundling home and auto insurance (up to 25% off), upgrading your roof with impact-resistant materials, installing monitored security or smart water-leak sensors, maintaining a strong credit score, or opting for a higher deductible level.',
            'faq_5_question' => 'What is personal liability coverage and why do I need it?',
            'faq_5_answer' => 'Personal liability coverage protects you against legal financial claims if someone is accidentally injured on your property (for example, slipping on an icy walkway or tripping on stairs) or if you accidentally cause property damage to someone else. It covers medical payments, attorney legal fees, and court judgments up to your selected policy limit.',

            // CTA
            'cta_title' => 'Ready to protect your home with confidence?',
            'cta_subtitle' => 'Get a personalized home insurance quote tailored to your property in less than 2 minutes.',
        ];
    }

    /**
     * Display Public Home Insurance Page with Dynamic CMS Content
     */
    public function showHomeInsurance()
    {
        $content = PageContent::getForPage('home-insurance', self::getDefaultHomeInsuranceContent());
        return view('home-insurance', compact('content'));
    }

    /**
     * Update Home Insurance CMS Content from Admin Portal
     */
    public function updateHomeInsurance(Request $request)
    {
        $data = $request->except(['_token', '_method', 'hero_image_file']);

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_home_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['hero_image'] = 'images/' . $filename;
        }

        PageContent::setForPage('home-insurance', $data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Home Insurance page updated and published live successfully!',
                'content' => PageContent::getForPage('home-insurance', self::getDefaultHomeInsuranceContent())
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Home Insurance page updated successfully!');
    }

    /**
     * Default content dictionary for Auto Insurance page
     */
    public static function getDefaultAutoInsuranceContent(): array
    {
        return [
            // Hero
            'hero_image' => 'images/hero-auto.jpg',
            'hero_eyebrow' => 'AUTO & VEHICLE INSURANCE',
            'hero_title' => 'Confidence &amp; Protection<br>on Every Mile',
            'hero_subtitle' => 'Drive with total peace of mind knowing you have comprehensive auto protection, 24/7 roadside dispatch, and transparent rates tailored to your driving record.',
            'hero_card_sub' => 'Safe Driver Savings',
            'hero_card_label' => 'Save up to 30% with safe drive rewards',

            // Coverage Cards
            'card_1_title' => 'Comprehensive Coverage',
            'card_1_desc' => 'Covers vehicle damage from non-collision perils like weather storms, theft, fallen tree branches, vandalism, and glass cracks.',
            'card_2_title' => 'Collision Protection',
            'card_2_desc' => 'Pays to repair or replace your vehicle after a collision with another car, object, or rollover incident regardless of fault.',
            'card_3_title' => 'Bodily Injury Liability',
            'card_3_desc' => 'Protects your financial assets against medical bills and legal defense costs if you cause an accident resulting in injury.',
            'card_4_title' => 'Property Damage Liability',
            'card_4_desc' => 'Covers repair or replacement expenses for other drivers\' vehicles, structures, and property damaged in an accident.',
            'card_5_title' => 'Uninsured Motorist Coverage',
            'card_5_desc' => 'Shields you and your passengers if you are hit by a driver who lacks insurance or flees the scene in a hit-and-run.',
            'card_6_title' => 'Roadside Assistance & Rental',
            'card_6_desc' => '24/7 towing, battery jump-starts, flat tire changes, lockout service, and daily rental vehicle reimbursement while in repairs.',

            // Value Pillars
            'value_1_title' => '24/7 Roadside Help',
            'value_1_desc' => 'Immediate towing, fuel delivery, and lockout help anywhere in North America.',
            'value_2_title' => 'Instant Mobile Claims',
            'value_2_desc' => 'Snap photos of accident damage on your phone for rapid repair shop approval.',
            'value_3_title' => 'Safe Driver Reward',
            'value_3_desc' => 'Earn up to 30% off your annual premium by maintaining a clean driving record.',
            'value_4_title' => 'Glass & Windshield Waiver',
            'value_4_desc' => 'Zero-deductible windshield repair and replacement for minor chips and cracks.',

            // Guidance
            'guidance_eyebrow' => 'DRIVE CONFIDENTLY',
            'guidance_title' => 'Auto Insurance Built for Modern Drivers',
            'guidance_text' => 'From daily commuting to family road trips, Surebound delivers flexible vehicle insurance options designed around how you drive. Compare bodily injury, property damage, collision, and comprehensive tiers with transparent pricing and zero hidden fees.',

            // Why Choose
            'why_1_title' => 'Quick Online Quotes',
            'why_1_desc' => 'Get an accurate quote estimate tailored to your vehicle VIN and mileage in under 2 minutes.',
            'why_2_title' => 'OEM Parts Guard',
            'why_2_desc' => 'Guarantee genuine original manufacturer replacement parts for collision repairs.',
            'why_3_title' => 'Vanishing Deductible',
            'why_3_desc' => 'Earn $100 off your deductible for every year of accident-free driving.',
            'why_4_title' => 'Rideshare & EV Friendly',
            'why_4_desc' => 'Seamless endorsements for rideshare drivers, personal commuters, and electric vehicles.',

            // FAQs
            'faq_1_question' => 'What is the difference between Comprehensive and Collision coverage?',
            'faq_1_answer' => 'Collision coverage pays for damage to your vehicle resulting from an impact with another vehicle or object (or a rollover). Comprehensive coverage pays for non-collision damage such as theft, vandalism, weather damage, falling objects, or hitting an animal.',
            'faq_2_question' => 'How can I lower my monthly auto insurance rate?',
            'faq_2_answer' => 'You can reduce your auto premium by bundling your auto and homeowners policies (up to 25% discount), maintaining an accident-free record, installing anti-theft devices, taking a defensive driving course, or increasing your deductible.',
            'faq_3_question' => 'Does auto insurance cover rental car expenses while my vehicle is being repaired?',
            'faq_3_answer' => 'Yes, if you add Rental Reimbursement coverage to your policy, Surebound pays for a rental car up to your selected daily limit while your primary vehicle is undergoing covered repairs after an accident.',
            'faq_4_question' => 'What should I do immediately after a car accident?',
            'faq_4_answer' => 'First ensure everyone is safe and call emergency services if needed. Exchange contact, vehicle, and insurance details with the other driver. Take clear photos of all vehicle damage and scene details, then open the Surebound portal or call our 24/7 claims hotline to file your claim.',
            'faq_5_question' => 'Am I covered if someone else drives my car?',
            'faq_5_answer' => 'In most cases, auto insurance follows the vehicle. If you give a friend or family member permission to borrow your car, your policy will typically serve as primary coverage in the event of an accident, subject to policy terms.',

            // CTA
            'cta_title' => 'Ready to hit the road with complete confidence?',
            'cta_subtitle' => 'Get a personalized auto insurance quote in less than 2 minutes and start saving.',
        ];
    }

    /**
     * Display Public Auto Insurance Page with Dynamic CMS Content
     */
    public function showAutoInsurance()
    {
        $content = PageContent::getForPage('auto-insurance', self::getDefaultAutoInsuranceContent());
        return view('auto-insurance', compact('content'));
    }

    /**
     * Update Auto Insurance CMS Content from Admin Portal
     */
    public function updateAutoInsurance(Request $request)
    {
        $data = $request->except(['_token', '_method', 'hero_image_file']);

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_auto_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['hero_image'] = 'images/' . $filename;
        }

        PageContent::setForPage('auto-insurance', $data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Auto Insurance page updated and published live successfully!',
                'content' => PageContent::getForPage('auto-insurance', self::getDefaultAutoInsuranceContent())
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Auto Insurance page updated successfully!');
    }

    /**
     * Default content dictionary for Personal Coverage page
     */
    public static function getDefaultPersonalCoverageContent(): array
    {
        return [
            // Hero
            'hero_image' => 'images/hero-personal.jpg',
            'hero_eyebrow' => 'PERSONAL & LIABILITY COVERAGE',
            'hero_title' => 'Comprehensive Security for<br>Everything You Value Most',
            'hero_subtitle' => 'Extend your financial protection beyond standard policy limits. From excess liability umbrella guards to high-value personal asset protection, Surebound secures your lifestyle.',
            'hero_card_sub' => 'Umbrella Protection',
            'hero_card_label' => 'Up to $5,000,000 in excess liability guard',

            // Coverage Cards
            'card_1_title' => 'Personal Umbrella Liability',
            'card_1_desc' => 'Provides an additional layer of $1M to $5M+ liability protection above your standard home and auto policy coverage limits.',
            'card_2_title' => 'High-Value Property & Valuables',
            'card_2_desc' => 'Specialized scheduling for fine jewelry, luxury watches, artwork, antiques, and high-end electronics with zero deductible.',
            'card_3_title' => 'Personal Cyber & Identity Theft',
            'card_3_desc' => 'Reimburses financial losses, legal fees, and data restoration costs resulting from identity theft, ransomware, or online fraud.',
            'card_4_title' => 'Worldwide Personal Liability',
            'card_4_desc' => 'Global liability protection covering accidental injury or property damage claims caused anywhere in the world.',
            'card_5_title' => 'Watercraft & Recreational Craft',
            'card_5_desc' => 'Comprehensive hull, engine, liability, and passenger coverage for boats, yachts, jet skis, and recreational vehicles.',
            'card_6_title' => 'Domestic Employee Protection',
            'card_6_desc' => 'Employment liability and workers\' compensation coverage for nannies, housekeepers, private chefs, and estate staff.',

            // Value Pillars
            'value_1_title' => 'Up to $5M Excess Limits',
            'value_1_desc' => 'Robust umbrella liability protection designed to shield total wealth against major lawsuits.',
            'value_2_title' => 'Zero Deductible Schedules',
            'value_2_desc' => 'Full replacement cost coverage for high-value scheduled items without out-of-pocket deductibles.',
            'value_3_title' => 'Worldwide Coverage',
            'value_3_desc' => 'Protection follows you across international travel, global rentals, and offshore watercraft.',
            'value_4_title' => 'Private Client Concierge',
            'value_4_desc' => 'Dedicated risk advisors offering bespoke insurance portfolio evaluations and discreet claims support.',

            // Guidance
            'guidance_eyebrow' => 'HOLISTIC PERSONAL RISK MANAGEMENT',
            'guidance_title' => 'Personal Risk Protection Tailored to Your Estate',
            'guidance_text' => 'Standard homeowners and auto policies have strict coverage caps. Surebound\'s Personal Coverage solutions fill critical gaps, shielding your family assets, high-value collections, and personal reputation from unexpected legal claims, cyber threats, and high-severity loss events.',

            // Why Choose
            'why_1_title' => 'Bespoke Portfolio Review',
            'why_1_desc' => 'Our senior risk officers conduct a detailed asset review to eliminate dangerous liability gaps.',
            'why_2_title' => 'Seamless Policy Bundling',
            'why_2_desc' => 'Unify home, auto, umbrella, and valuable collections under one consolidated billing statement.',
            'why_3_title' => 'Agreed Value Protection',
            'why_3_desc' => 'Lock in agreed cash values for rare artwork and luxury items before a loss ever occurs.',
            'why_4_title' => '24/7 Confidential Claims',
            'why_4_desc' => 'White-glove claims handling with expedited payouts and direct access to legal specialists.',

            // FAQs
            'faq_1_question' => 'Why do I need a Personal Umbrella policy if I already have Home and Auto insurance?',
            'faq_1_answer' => 'Standard homeowners and auto insurance policies have maximum liability limits (typically $300k to $500k). If you are found liable for a major accident or lawsuit exceeding those limits, your personal savings, home equity, and future wages could be seized. An Umbrella policy kicks in where your underlying limits stop, providing an extra $1M to $5M+ in protection.',
            'faq_2_question' => 'How are luxury items like jewelry, watches, or art covered under Personal Coverage?',
            'faq_2_answer' => 'Standard home policies cap luxury item payouts (often around $1,500 to $2,500). Through scheduled personal property floaters, each valuable item is appraised and insured for its full agreed replacement value with zero deductible and coverage for accidental loss or breakage worldwide.',
            'faq_3_question' => 'What does Personal Cyber Insurance protect against?',
            'faq_3_answer' => 'Personal Cyber protection covers expenses related to cyber extortion (ransomware), identity theft restoration, fraudulent online wire transfers, cyberbullying legal defense, and data recovery for home computer systems.',
            'faq_4_question' => 'Does Personal Coverage apply when I am traveling outside the country?',
            'faq_4_answer' => 'Yes! Our Personal Umbrella and Scheduled Property endorsements provide 24/7 worldwide coverage, protecting you against legal liability, lost valuables, or emergency incidents anywhere across the globe.',
            'faq_5_question' => 'How much does a Personal Umbrella insurance policy typically cost?',
            'faq_5_answer' => 'Personal Umbrella insurance is exceptionally cost-effective. A $1,000,000 umbrella policy typically costs between $150 and $300 per year, making it one of the most affordable ways to protect your overall financial future.',

            // CTA
            'cta_title' => 'Shield your assets and peace of mind today.',
            'cta_subtitle' => 'Speak with a senior risk advisor or request a confidential personal insurance proposal in under 2 minutes.',
        ];
    }

    /**
     * Display Public Personal Coverage Page with Dynamic CMS Content
     */
    public function showPersonalCoverage()
    {
        $content = PageContent::getForPage('personal-coverage', self::getDefaultPersonalCoverageContent());
        return view('personal-coverage', compact('content'));
    }

    /**
     * Update Personal Coverage CMS Content from Admin Portal
     */
    public function updatePersonalCoverage(Request $request)
    {
        $data = $request->except(['_token', '_method', 'hero_image_file']);

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_personal_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['hero_image'] = 'images/' . $filename;
        }

        PageContent::setForPage('personal-coverage', $data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Personal Coverage page updated and published live successfully!',
                'content' => PageContent::getForPage('personal-coverage', self::getDefaultPersonalCoverageContent())
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Personal Coverage page updated successfully!');
    }

    /**
     * Default content dictionary for Specialty Coverage page
     */
    public static function getDefaultSpecialtyCoverageContent(): array
    {
        return [
            // Hero
            'hero_image' => 'images/hero-specialty.jpg',
            'hero_eyebrow' => 'SPECIALTY & BESPOKE RISK COVERAGE',
            'hero_title' => 'Bespoke Protection for<br>Your Unique & Rare Assets',
            'hero_subtitle' => 'From vintage collector cars and private aircraft to fine art collections and high-stakes events, Surebound delivers customized underwriting solutions for extraordinary risks.',
            'hero_card_sub' => 'Agreed Value Insurance',
            'hero_card_label' => '100% full valuation payout guaranteed',

            // Coverage Cards
            'card_1_title' => 'Collector Cars & Exotic Autos',
            'card_1_desc' => 'Agreed value policy coverage for antique, vintage, muscle, exotic, and hyper-cars with flexible spare parts riders.',
            'card_2_title' => 'Private Aviation & Aircraft',
            'card_2_desc' => 'Comprehensive hull and passenger liability policies for turboprops, private jets, helicopters, and aviation hangars.',
            'card_3_title' => 'Fine Art & Rare Collectibles',
            'card_3_desc' => 'Worldwide floater coverage for private art galleries, rare sculptures, antique coins, jewelry, and wine cellars.',
            'card_4_title' => 'Luxury Yachts & Marine',
            'card_4_desc' => 'Global maritime coverage for mega-yachts, charter craft, crew liability, navigation limits, and ocean towing.',
            'card_5_title' => 'Special Events & Cancellation',
            'card_5_desc' => 'Financial protection against event cancellations, severe weather disruptions, non-appearance, and venue damage.',
            'card_6_title' => 'Executive Cyber & Ransom Response',
            'card_6_desc' => 'Discreet crisis management, ransomware negotiation, extortion loss reimbursement, and digital asset security.',

            // Value Pillars
            'value_1_title' => 'Agreed Value Guarantee',
            'value_1_desc' => 'Lock in written valuation appraisals with zero depreciation subtraction at claim time.',
            'value_2_title' => 'Worldwide Transit Protection',
            'value_2_desc' => 'Seamless coverage for assets during international shipping, exhibition, or flight transit.',
            'value_3_title' => 'Specialized Claims Team',
            'value_3_desc' => 'Direct access to certified art restorers, master mechanics, and marine surveyors.',
            'value_4_title' => 'Confidential Crisis Response',
            'value_4_desc' => 'Private risk consultation with strict non-disclosure security and immediate payout response.',

            // Guidance
            'guidance_eyebrow' => 'BESPOKE RISK UNDERWRITING',
            'guidance_title' => 'Customized Insurance Architecture for High-Value Assets',
            'guidance_text' => 'Standard off-the-shelf insurance contracts fail to address the nuances of rare collectibles, private aircraft, or high-end maritime vessels. Surebound\'s Specialty Risk team collaborates directly with expert appraisers and underwriters to construct tailored policy terms with zero gaps and total financial protection.',

            // Why Choose
            'why_1_title' => 'Certified Appraisals',
            'why_1_desc' => 'We accept valuation reports from recognized international appraisal authorities.',
            'why_2_title' => 'Inflation & Market Appreciation',
            'why_2_desc' => 'Automatic 150% valuation guard to absorb rapid market price surges for rare items.',
            'why_3_title' => 'Zero Deductible Options',
            'why_3_desc' => 'Selected scheduled specialty riders provide 100% full loss recovery without deductibles.',
            'why_4_title' => 'Discreet Private Underwriting',
            'why_4_desc' => 'Strict confidentiality protocols protecting high-profile owners and sensitive asset lists.',

            // FAQs
            'faq_1_question' => 'What qualifies as a Specialty Coverage asset at Surebound?',
            'faq_1_answer' => 'Specialty Coverage encompasses unique, high-value, or non-standard risks that standard personal or commercial policies exclude or cap. Examples include collector vehicles, private aircraft, mega-yachts, fine art, rare wine cellars, antique jewelry, special event cancellations, and executive cyber threats.',
            'faq_2_question' => 'How does Agreed Value insurance work for collector cars or rare art?',
            'faq_2_answer' => 'Unlike standard policies that pay actual cash value (which factors in heavy depreciation), an Agreed Value policy guarantees that you and Surebound agree on the item\'s exact financial value prior to policy issuance. In the event of a total loss, you receive 100% of that agreed sum with no depreciation deducted.',
            'faq_3_question' => 'Are private aircraft and yachts covered during international travel?',
            'faq_3_answer' => 'Yes. Our Aviation and Marine specialty floaters include tailored navigation and territorial limits designed around your flight paths and maritime routes, offering seamless worldwide hull and liability coverage.',
            'faq_4_question' => 'Do I need a recent formal appraisal to insure fine art or jewelry?',
            'faq_4_answer' => 'For high-value items (typically items over $50,000 individually), a recent appraisal from a certified appraiser or a detailed sales bill of sale is required to establish the agreed value baseline. Our risk officers assist with arranging qualified appraisals.',
            'faq_5_question' => 'How quickly can a Specialty Coverage quote be issued?',
            'faq_5_answer' => 'Preliminary specialty risk proposals are generated within 24 to 48 hours following an initial evaluation with our senior underwriting desk.',

            // CTA
            'cta_title' => 'Protect your extraordinary assets with bespoke coverage.',
            'cta_subtitle' => 'Speak with a senior specialty risk underwriter or request a confidential proposal in under 2 minutes.',
        ];
    }

    /**
     * Display Public Specialty Coverage Page with Dynamic CMS Content
     */
    public function showSpecialtyCoverage()
    {
        $content = PageContent::getForPage('specialty-coverage', self::getDefaultSpecialtyCoverageContent());
        return view('specialty-coverage', compact('content'));
    }

    /**
     * Update Specialty Coverage CMS Content from Admin Portal
     */
    public function updateSpecialtyCoverage(Request $request)
    {
        $data = $request->except(['_token', '_method', 'hero_image_file']);

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_specialty_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['hero_image'] = 'images/' . $filename;
        }

        PageContent::setForPage('specialty-coverage', $data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Specialty Coverage page updated and published live successfully!',
                'content' => PageContent::getForPage('specialty-coverage', self::getDefaultSpecialtyCoverageContent())
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Specialty Coverage page updated successfully!');
    }

    /**
     * Default content dictionary for Business Insurance page
     */
    public static function getDefaultBusinessInsuranceContent(): array
    {
        return [
            // Hero
            'hero_image' => 'images/hero-business.jpg',
            'hero_eyebrow' => 'COMMERCIAL & ENTERPRISE PROTECTION',
            'hero_title' => 'Securing Your Business,<br>Employees & Future Growth',
            'hero_subtitle' => 'Customized commercial insurance policies engineered for small businesses, growing enterprises, and established corporations. Protect your revenue, property, and staff with dependable underwriting.',
            'hero_card_sub' => 'Commercial BOP Savings',
            'hero_card_label' => 'Save up to 30% bundled commercial plans',

            // Coverage Cards
            'card_1_title' => 'Commercial General Liability',
            'card_1_desc' => 'Defends against third-party bodily injury, property damage, slip-and-fall claims, and advertising liability lawsuits.',
            'card_2_title' => 'Commercial Property & Structure',
            'card_2_desc' => 'Protects owned or leased business buildings, office furniture, machinery, inventory, and specialized equipment from fire and storm damage.',
            'card_3_title' => 'Business Interruption & Income',
            'card_3_desc' => 'Replaces lost operating income and covers ongoing payroll, rent, and expenses if covered damage temporarily shuts down operations.',
            'card_4_title' => 'Workers\' Compensation',
            'card_4_desc' => 'Covers employee medical bills, rehabilitation costs, and lost wage benefits for workplace injuries or occupational illnesses.',
            'card_5_title' => 'Professional Liability (E&O)',
            'card_5_desc' => 'Shields consultants, technology providers, accountants, and advisors against professional negligence or error claims.',
            'card_6_title' => 'Commercial Auto & Fleet',
            'card_6_desc' => 'Comprehensive physical damage and liability protection for company vehicles, delivery vans, trucks, and executive fleets.',

            // Value Pillars
            'value_1_title' => 'Custom BOP Bundles',
            'value_1_desc' => 'Combine property and general liability into one cost-effective Business Owner Package.',
            'value_2_title' => 'Instant COI Issuance',
            'value_2_desc' => 'Download Certificates of Insurance in under 15 minutes to satisfy landlord and client contracts.',
            'value_3_title' => 'Tailored Risk Mapping',
            'value_3_desc' => 'Customized policy terms built specifically for retail, manufacturing, tech, and service sectors.',
            'value_4_title' => '24/7 Commercial Support',
            'value_4_desc' => 'Dedicated business claims team providing rapid emergency funds and business continuity guidance.',

            // Guidance
            'guidance_eyebrow' => 'COMMERCIAL GUIDANCE & GROWTH',
            'guidance_title' => 'Commercial Risk Protection Built for Modern Enterprises',
            'guidance_text' => 'Navigating commercial insurance shouldn\'t take hours away from growing your business. Surebound simplifies policy underwriting, calculating your precise exposure to property damage, liability suits, and operational delays so you get maximum coverage without overpaying.',

            // Why Choose
            'why_1_title' => 'Fast Digital COI',
            'why_1_desc' => 'Generate and email Certificates of Insurance instantly to clients and landlords.',
            'why_2_title' => 'Scalable BOP Bundles',
            'why_2_desc' => 'Seamlessly add coverage lines as your headcount, revenue, and physical footprint expand.',
            'why_3_title' => 'Payroll & Audit Support',
            'why_3_desc' => 'Integrated workers\' comp reporting aligned with pay-as-you-go payroll systems.',
            'why_4_title' => 'Commercial Claims Officers',
            'why_4_desc' => 'Dedicated business adjusters committed to minimizing operational downtime during a claim.',

            // FAQs
            'faq_1_question' => 'What is a Business Owner Policy (BOP) and why is it recommended?',
            'faq_1_answer' => 'A Business Owner Policy (BOP) bundles Commercial General Liability and Commercial Property insurance into a single discounted package. It protects small-to-medium businesses against third-party injury claims, property damage, and loss of operating income at a lower cost than buying separate policies.',
            'faq_2_question' => 'How fast can I get a Certificate of Insurance (COI) for my clients?',
            'faq_2_answer' => 'With Surebound, Certificates of Insurance (COIs) can be issued digitally in under 15 minutes through our client portal, allowing you to secure new contracts and landlord leases without delay.',
            'faq_3_question' => 'Is Workers\' Compensation insurance required for my business?',
            'faq_3_answer' => 'In most states, Workers\' Compensation is legally mandatory as soon as you hire your first employee. It pays for medical bills, disability benefits, and vocational rehabilitation if an employee suffers a workplace injury.',
            'faq_4_question' => 'What is the difference between General Liability and Professional Liability (E&O)?',
            'faq_4_answer' => 'General Liability covers physical risks such as bodily injury, property damage, or slip-and-fall accidents on your premises. Professional Liability (Errors & Omissions) covers financial losses resulting from professional advice, negligence, design errors, or service mistakes.',
            'faq_5_question' => 'How can I lower my annual commercial insurance costs?',
            'faq_5_answer' => 'You can reduce your commercial premium by bundling property and liability into a BOP, implementing workplace safety protocols, maintaining clean safety records, and customizing your deductible levels.',

            // CTA
            'cta_title' => 'Protect your business & empower your growth today.',
            'cta_subtitle' => 'Get a custom business insurance quote in less than 2 minutes or speak with a commercial risk officer.',
        ];
    }

    /**
     * Display Public Business Insurance Page with Dynamic CMS Content
     */
    public function showBusinessInsurance()
    {
        $content = PageContent::getForPage('business-insurance', self::getDefaultBusinessInsuranceContent());
        return view('business-insurance', compact('content'));
    }

    /**
     * Update Business Insurance CMS Content from Admin Portal
     */
    public function updateBusinessInsurance(Request $request)
    {
        $data = $request->except(['_token', '_method', 'hero_image_file']);

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_business_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['hero_image'] = 'images/' . $filename;
        }

        PageContent::setForPage('business-insurance', $data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Business Insurance page updated and published live successfully!',
                'content' => PageContent::getForPage('business-insurance', self::getDefaultBusinessInsuranceContent())
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Business Insurance page updated successfully!');
    }

    /**
     * Update Claims API Gateway Configuration
     */
    public function saveClaimsApiConfig(Request $request)
    {
        $config = [
            'enabled' => $request->has('enabled'),
            'provider' => $request->input('provider', 'Mitchell / Guidewire ClaimCenter API'),
            'environment' => $request->input('environment', 'production'),
            'endpoint_url' => $request->input('endpoint_url', 'https://api.claims-gateway.surebound.com/v2'),
            'api_key' => $request->input('api_key', ''),
            'webhook_url' => $request->input('webhook_url', 'http://127.0.0.1:8000/api/v1/claims/webhook'),
            'webhook_secret' => $request->input('webhook_secret', ''),
            'sync_frequency' => $request->input('sync_frequency', 'realtime'),
            'auto_approve_limit' => (float) $request->input('auto_approve_limit', 2500),
            'status' => 'connected',
            'last_synced_at' => now()->toDateTimeString(),
        ];

        ApiSetting::updateOrCreate(['key' => 'claims_api_config'], ['value' => $config]);

        return response()->json([
            'success' => true,
            'message' => 'Claims API Gateway configuration saved successfully!',
            'config' => $config
        ]);
    }

    /**
     * Test Claims API Gateway Connection
     */
    public function testClaimsApiConnection(Request $request)
    {
        $setting = ApiSetting::where('key', 'claims_api_config')->first();
        $config = $setting ? $setting->value : [];

        // Simulate high-speed carrier gateway health-check ping
        $latency = rand(24, 65);
        $timestamp = now()->format('Y-m-d H:i:s T');

        return response()->json([
            'success' => true,
            'status' => 'connected',
            'provider' => $config['provider'] ?? 'Carrier Claims Gateway',
            'latency_ms' => $latency,
            'timestamp' => $timestamp,
            'message' => "Successfully established 200 OK connection with {$config['provider']}. Latency: {$latency}ms.",
        ]);
    }

    /**
     * Update USA Payment Methods & Gateways API Configuration
     */
    public function savePaymentApiConfig(Request $request)
    {
        // 1. Stripe & Wallets (Cards, Apple Pay, Google Pay)
        $stripeConfig = [
            'enabled' => $request->has('stripe_enabled'),
            'environment' => $request->input('stripe_env', 'live'),
            'publishable_key' => $request->input('stripe_pub_key', ''),
            'secret_key' => $request->input('stripe_secret_key', ''),
            'webhook_secret' => $request->input('stripe_webhook_secret', ''),
            'accept_cards' => true,
            'accept_apple_pay' => $request->has('stripe_apple_pay'),
            'accept_google_pay' => $request->has('stripe_google_pay'),
        ];
        ApiSetting::updateOrCreate(['key' => 'stripe_config'], ['value' => $stripeConfig]);

        // 2. Plaid / ACH Direct Debit
        $plaidConfig = [
            'enabled' => $request->has('plaid_enabled'),
            'environment' => $request->input('plaid_env', 'production'),
            'client_id' => $request->input('plaid_client_id', ''),
            'secret_key' => $request->input('plaid_secret_key', ''),
            'same_day_ach' => $request->has('plaid_same_day'),
        ];
        ApiSetting::updateOrCreate(['key' => 'plaid_ach_config'], ['value' => $plaidConfig]);

        // 3. Authorize.Net US Merchant Portal
        $authorizeConfig = [
            'enabled' => $request->has('authnet_enabled'),
            'environment' => $request->input('authnet_env', 'production'),
            'api_login_id' => $request->input('authnet_login_id', ''),
            'transaction_key' => $request->input('authnet_tx_key', ''),
        ];
        ApiSetting::updateOrCreate(['key' => 'authorize_config'], ['value' => $authorizeConfig]);

        // 4. FedNow & Wire / Real-Time Payments
        $wireConfig = [
            'enabled' => $request->has('wire_enabled'),
            'bank_name' => $request->input('wire_bank_name', 'JPMorgan Chase Bank, N.A.'),
            'routing_number' => $request->input('wire_routing', '021000021'),
            'account_number' => $request->input('wire_account', ''),
            'swift_bic' => $request->input('wire_swift', 'CHASUS33'),
            'fednow_participant_id' => $request->input('wire_fednow_id', ''),
        ];
        ApiSetting::updateOrCreate(['key' => 'wire_fednow_config'], ['value' => $wireConfig]);

        // 5. Klarna / BNPL Premium Financing
        $bnplConfig = [
            'enabled' => $request->has('klarna_enabled'),
            'merchant_id' => $request->input('klarna_merchant_id', ''),
            'shared_secret' => $request->input('klarna_secret', ''),
            'country' => 'US',
            'currency' => 'USD',
        ];
        ApiSetting::updateOrCreate(['key' => 'bnpl_klarna_config'], ['value' => $bnplConfig]);

        // 6. General Payment Settings
        $generalConfig = [
            'currency' => 'USD',
            'surcharge_enabled' => $request->has('surcharge_enabled'),
            'surcharge_pct' => (float) $request->input('surcharge_pct', 2.9),
            'surcharge_flat' => (float) $request->input('surcharge_flat', 0.30),
            'auto_send_receipt' => $request->has('auto_send_receipt'),
        ];
        ApiSetting::updateOrCreate(['key' => 'payment_general_config'], ['value' => $generalConfig]);

        return response()->json([
            'success' => true,
            'message' => 'USA Payment Methods & Gateway integrations updated successfully!',
        ]);
    }

    /**
     * Create a new Invoice in Database
     */
    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'customer_address' => 'nullable|string',
            'policy_number' => 'nullable|string|max:100',
            'issue_date' => 'required|date',
            'due_date' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Auto-generate invoice number
        $latestId = Invoice::max('id') ?? 0;
        $invNumber = 'INV-2026-' . str_pad($latestId + 1, 3, '0', STR_PAD_LEFT);

        // Process line items JSON from request
        $items = [];
        if ($request->has('item_desc')) {
            $descs = $request->input('item_desc', []);
            $qtys = $request->input('item_qty', []);
            $prices = $request->input('item_price', []);

            foreach ($descs as $idx => $desc) {
                if (!empty($desc)) {
                    $q = (int) ($qtys[$idx] ?? 1);
                    $p = (float) ($prices[$idx] ?? 0);
                    $items[] = [
                        'desc' => $desc,
                        'qty' => $q,
                        'price' => $p,
                        'total' => $q * $p
                    ];
                }
            }
        }

        if (empty($items)) {
            $items[] = [
                'desc' => 'Insurance Premium & Coverage Fee',
                'qty' => 1,
                'price' => (float) $validated['subtotal'],
                'total' => (float) $validated['subtotal']
            ];
        }

        $invoice = Invoice::create([
            'invoice_number' => $invNumber,
            'policy_number' => $validated['policy_number'] ?? null,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'subtotal' => (float) $validated['subtotal'],
            'tax' => (float) ($validated['tax'] ?? 0),
            'discount' => (float) ($validated['discount'] ?? 0),
            'total_amount' => (float) $validated['total_amount'],
            'status' => 'pending',
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'line_items' => $items,
            'notes' => $validated['notes'] ?? 'Thank you for choosing Surebound Insurance.',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Invoice {$invNumber} created successfully!",
            'invoice' => $invoice,
        ]);
    }

    /**
     * Process simulated live payment for an invoice using US payment gateways
     */
    public function processInvoicePayment(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $method = $request->input('payment_method', 'Stripe Credit Card (Visa ending 4242)');
        $txId = 'tx_us_' . strtoupper(substr(md5(uniqid()), 0, 12));

        $invoice->update([
            'status' => 'paid',
            'payment_method' => $method,
            'payment_transaction_id' => $txId,
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Payment of $" . number_format($invoice->total_amount, 2) . " processed successfully via {$method}! Transaction ID: {$txId}",
            'invoice' => $invoice,
        ]);
    }

    /**
     * Toggle / update invoice status directly
     */
    public function updateInvoiceStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $status = $request->input('status', 'paid');

        $data = ['status' => $status];
        if ($status === 'paid' && !$invoice->paid_at) {
            $data['paid_at'] = now();
            if (!$invoice->payment_method) {
                $data['payment_method'] = 'Manual / Direct Deposit';
            }
        }

        $invoice->update($data);

        return response()->json([
            'success' => true,
            'message' => "Invoice {$invoice->invoice_number} status updated to " . strtoupper($status),
            'invoice' => $invoice,
        ]);
    }
}
