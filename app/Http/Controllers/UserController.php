<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Invoice;
use App\Models\Policy;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display the Policyholder Customer Portal Dashboard
     */
    public function dashboard()
    {
        /** @var User|null $user */
        $user = Auth::user();

        // Fallback for static export or preview
        if (! $user) {
            $user = User::where('role', 'user')->first() ?? new User([
                'name' => 'Eleanor Vance',
                'email' => 'eleanor.vance@example.com',
                'role' => 'user',
                'title' => 'Policyholder',
                'phone' => '(888) 555-0199',
            ]);
        }

        // Fetch customer specific policies or fallback to real active policies
        $policies = Policy::where('holder_name', 'like', '%'.$user->name.'%')->get();
        if ($policies->isEmpty()) {
            $policies = Policy::where('status', 'active')->take(3)->get();
        }

        // Fetch customer claims
        $claims = Claim::where('claimant_name', 'like', '%'.$user->name.'%')->get();
        if ($claims->isEmpty()) {
            $claims = Claim::take(2)->get();
        }

        // Fetch customer quotes
        $quotes = Quote::where('email', $user->email)
            ->orWhere('name', 'like', '%'.$user->name.'%')
            ->get();
        if ($quotes->isEmpty()) {
            $quotes = Quote::take(2)->get();
        }

        // Fetch customer invoices
        $invoices = Invoice::where('customer_email', $user->email)
            ->orWhere('customer_name', 'like', '%'.$user->name.'%')
            ->get();
        if ($invoices->isEmpty()) {
            $invoices = Invoice::take(2)->get();
        }

        // Customer KPIs
        $activePoliciesCount = $policies->where('status', 'active')->count();
        $totalCoverage = $policies->sum(function ($p) {
            return (float) preg_replace('/[^0-9.]/', '', $p->coverage_limit ?? '0');
        });
        $pendingClaimsCount = $claims->whereIn('status', ['submitted', 'reviewing'])->count();
        $dueInvoicesAmount = $invoices->whereIn('status', ['pending', 'overdue'])->sum('total_amount');

        return view('user.dashboard', compact(
            'user',
            'policies',
            'claims',
            'quotes',
            'invoices',
            'activePoliciesCount',
            'totalCoverage',
            'pendingClaimsCount',
            'dueInvoicesAmount'
        ));
    }

    public function policies()
    {
        return view('user.policies');
    }

    public function quote()
    {
        return view('user.quote');
    }

    public function claims()
    {
        return view('user.claims');
    }

    public function documents()
    {
        return view('user.documents');
    }

    public function payments()
    {
        $user = Auth::user();
        if (!$user) {
            $user = (object)[
                'name' => 'Demo User',
                'email' => 'demo@example.com'
            ];
        }

        $invoices = \App\Models\Invoice::where('customer_email', $user->email)
            ->orWhere('customer_name', 'like', '%'.$user->name.'%')
            ->orderBy('id', 'desc')
            ->get();
            
        if ($invoices->isEmpty()) {
            $invoices = \App\Models\Invoice::orderBy('id', 'desc')->take(5)->get();
        }

        return view('user.payments', compact('invoices'));
    }

    public function support()
    {
        return view('user.support');
    }

    public function settings()
    {
        return view('user.settings');
    }

    /**
     * Handle Customer Claim Submission from Portal
     */
    public function submitClaim(Request $request)
    {
        $validated = $request->validate([
            'policy_number' => ['required', 'string', 'max:50'],
            'incident_description' => ['required', 'string', 'min:10', 'max:1000'],
            'estimated_loss' => ['required', 'string', 'max:50'],
            'priority' => ['nullable', 'string', 'in:low,normal,urgent'],
        ]);

        $user = Auth::user();
        $claimNumber = 'CLM-'.date('Y').'-'.strtoupper(Str::random(5));

        Claim::create([
            'claim_number' => $claimNumber,
            'policy_number' => $validated['policy_number'],
            'claimant_name' => $user ? $user->name : 'Registered Policyholder',
            'incident_description' => $validated['incident_description'],
            'estimated_loss' => '$'.number_format((float) preg_replace('/[^0-9.]/', '', $validated['estimated_loss']), 2),
            'assigned_adjuster' => 'Unassigned (Pending Review)',
            'priority' => $validated['priority'] ?? 'normal',
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Your claim #'.$claimNumber.' has been submitted successfully! An adjuster will review your documentation within 24 business hours.');
    }

    /**
     * Handle Customer Quick Quote Request from Portal
     */
    public function requestQuote(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:50'],
            'type_label' => ['required', 'string', 'max:100'],
            'coverage' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        $quoteRef = 'SB-Q-'.strtoupper(Str::random(6));

        Quote::create([
            'quote_ref' => $quoteRef,
            'name' => $user ? $user->name : 'Portal Customer',
            'email' => $user ? $user->email : 'customer@example.com',
            'phone' => $user ? $user->phone : null,
            'type' => $validated['type'],
            'type_label' => $validated['type_label'],
            'coverage' => $validated['coverage'],
            'premium' => '$'.number_format(rand(650, 2400), 2).'/yr',
            'location' => 'United States',
            'zip_code' => '90210',
            'status' => 'new',
            'notes' => $validated['notes'] ?? 'Requested via Customer Portal',
        ]);

        return back()->with('success', 'Quote request #'.$quoteRef.' submitted. An underwriter will tailor your custom rate shortly.');
    }

    /**
     * Handle Customer Invoice Payment
     */
    public function payInvoice(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_method' => $request->input('payment_method', 'Credit Card (Online Portal)'),
            'payment_transaction_id' => 'TXN-'.strtoupper(Str::random(10)),
        ]);

        return back()->with('success', 'Payment of $'.number_format($invoice->total_amount, 2).' for Invoice #'.$invoice->invoice_number.' was processed successfully!');
    }
}
