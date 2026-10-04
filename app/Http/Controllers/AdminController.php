<?php

namespace App\Http\Controllers;

use App\Models\Claim;
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

        // Calculate real-time database KPIs
        $activePoliciesCount = Policy::where('status', 'active')->count();
        $pendingQuotesCount = Quote::whereIn('status', ['new', 'reviewing'])->count();
        $urgentQuotesCount = Quote::where('status', 'new')->count();
        
        $totalClaims = max(1, $claims->count());
        $resolvedClaims = Claim::whereIn('status', ['paid', 'approved'])->count();
        $claimsResolutionRate = round(($resolvedClaims / $totalClaims) * 100, 1);

        return view('admin.dashboard', compact(
            'quotes',
            'policies',
            'claims',
            'agents',
            'activePoliciesCount',
            'pendingQuotesCount',
            'urgentQuotesCount',
            'claimsResolutionRate'
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
}
