@extends('layouts.user')

@section('content')
<div class="section-header">
    <div>
        <h2 class="section-title">Payments</h2>
        <p class="section-subtitle">Manage your Payments here.</p>
    </div>
</div>

<div class="table-card">
    <table class="policies-table">
        <thead>
            <tr>
                <th>Invoice No.</th>
                <th>Policy No.</th>
                <th>Due Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $inv)
            <tr>
                <td>
                    <div class="policy-id-cell">
                        <div class="policy-icon-small">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        {{ $inv->invoice_number }}
                    </div>
                </td>
                <td>
                    @if($inv->policy_number)
                        <span style="background: var(--bg-surface-secondary); color: var(--text-secondary); border: 1px solid var(--border-subtle); padding: 2px 8px; border-radius: var(--radius-sm); font-family: var(--font-mono); font-size: 0.875rem;">
                            {{ $inv->policy_number }}
                        </span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($inv->due_date)->format('M d, Y') }}</td>
                <td><strong>${{ number_format($inv->total_amount, 2) }}</strong></td>
                <td>
                    @if($inv->status === 'paid')
                        <span class="status-badge" style="background: rgba(34, 197, 94, 0.1); color: #166534;">Paid</span>
                    @elseif($inv->status === 'overdue')
                        <span class="status-badge" style="background: rgba(225, 29, 72, 0.1); color: #9f1239;">Overdue</span>
                    @else
                        <span class="status-badge" style="background: rgba(245, 158, 11, 0.1); color: #b45309;">Pending</span>
                    @endif
                </td>
                <td>
                    @if($inv->status !== 'paid')
                        <a href="#" class="btn-primary-action" style="font-size: 0.875rem; padding: 6px 12px;">Pay Now</a>
                    @else
                        <a href="#" class="action-link">View Receipt &rarr;</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                    No payments found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
