/**
 * Surebound Insurance - Enterprise Admin Portal
 * Dynamic State Management, Client Persistence & Interactivity
 */

(function () {
    'use strict';

    // --------------------------------------------------------------------------
    // DEFAULT SEED DATA (Used if localStorage is empty)
    // --------------------------------------------------------------------------
    const DEFAULT_QUOTES = [
        {
            id: 'Q-10492',
            name: 'Sarah Jenkins',
            email: 'sarah.j@example.com',
            phone: '(206) 555-0142',
            type: 'auto',
            typeLabel: 'Auto Insurance',
            coverage: '$250,000 / $500,000',
            premium: '$1,450 / yr',
            location: 'Seattle, WA 98101',
            status: 'quoted',
            date: 'Today, 10:45 AM',
            notes: '2024 Honda CR-V Hybrid. Clean driving record. Looking for comprehensive and collision coverage.'
        },
        {
            id: 'Q-10491',
            name: 'Michael Chang',
            email: 'm.chang@example.com',
            phone: '(503) 555-0189',
            type: 'home',
            typeLabel: 'Homeowners',
            coverage: '$650,000 Dwelling',
            premium: '$2,180 / yr',
            location: 'Portland, OR 97201',
            status: 'new',
            date: 'Today, 09:15 AM',
            notes: 'Single family residence, built 2018. New roof in 2022. Bundling with auto potential.'
        },
        {
            id: 'Q-10490',
            name: 'Emma Watson',
            email: 'emma.w@example.com',
            phone: '(415) 555-0211',
            type: 'life',
            typeLabel: 'Term Life',
            coverage: '$1,000,000 (20-Yr)',
            premium: '$840 / yr',
            location: 'San Francisco, CA 94102',
            status: 'reviewing',
            date: 'Yesterday',
            notes: 'Non-smoker, 34 years old. Requesting preferred plus rating underwriting review.'
        },
        {
            id: 'Q-10489',
            name: 'Apex Logistics LLC',
            email: 'fleet@apexlogistics.io',
            phone: '(425) 555-0399',
            type: 'business',
            typeLabel: 'Commercial Liability',
            coverage: '$2,000,000 Aggregate',
            premium: '$5,800 / yr',
            location: 'Bellevue, WA 98004',
            status: 'converted',
            date: 'Oct 3, 2026',
            notes: 'Fleet of 8 cargo vans and warehouse liability. Policy bound and active.'
        },
        {
            id: 'Q-10488',
            name: 'David Miller',
            email: 'dmiller@example.com',
            phone: '(509) 555-0724',
            type: 'auto',
            typeLabel: 'Auto Comprehensive',
            coverage: '$100,000 / $300,000',
            premium: '$920 / yr',
            location: 'Spokane, WA 99201',
            status: 'declined',
            date: 'Oct 2, 2026',
            notes: 'Multiple moving violations in past 18 months, outside target risk tier.'
        },
        {
            id: 'Q-10487',
            name: 'Jessica Alba',
            email: 'jessica.a@example.com',
            phone: '(253) 555-0633',
            type: 'home',
            typeLabel: 'Home & Flood',
            coverage: '$820,000 Dwelling',
            premium: '$3,400 / yr',
            location: 'Tacoma, WA 98402',
            status: 'new',
            date: 'Oct 1, 2026',
            notes: 'Coastal property requires private flood endorsement. Fast quotation needed.'
        },
        {
            id: 'Q-10486',
            name: 'Cascade Roasters Co.',
            email: 'admin@cascaderoasters.com',
            phone: '(206) 555-0915',
            type: 'business',
            typeLabel: 'Business BOP',
            coverage: '$1,500,000',
            premium: '$4,600 / yr',
            location: 'Seattle, WA 98103',
            status: 'reviewing',
            date: 'Sep 29, 2026',
            notes: 'Coffee roasting facility and retail cafe storefront.'
        }
    ];

    const DEFAULT_POLICIES = [
        {
            id: 'SB-POL-98412',
            holder: 'Jonathan Harris',
            type: 'home',
            typeLabel: 'Homeowners Deluxe',
            coverage: '$750,000',
            premium: '$2,250 / yr',
            effective: 'Nov 12, 2025',
            renewal: 'Nov 12, 2026',
            status: 'active'
        },
        {
            id: 'SB-POL-84920',
            holder: 'Samantha Ray',
            type: 'auto',
            typeLabel: 'Auto Total Shield',
            coverage: '$150,000 / $300,000',
            premium: '$1,180 / yr',
            effective: 'Jan 15, 2026',
            renewal: 'Jan 15, 2027',
            status: 'active'
        },
        {
            id: 'SB-POL-73104',
            holder: 'Marcus Sterling',
            type: 'life',
            typeLabel: 'Term Life 20-Yr',
            coverage: '$1,000,000',
            premium: '$960 / yr',
            effective: 'Mar 01, 2026',
            renewal: 'Mar 01, 2027',
            status: 'active'
        },
        {
            id: 'SB-POL-62019',
            holder: 'TechWave Studios',
            type: 'business',
            typeLabel: 'Commercial Package',
            coverage: '$2,500,000',
            premium: '$6,200 / yr',
            effective: 'Dec 05, 2025',
            renewal: 'Dec 05, 2026',
            status: 'active'
        },
        {
            id: 'SB-POL-51928',
            holder: 'Linda Croft',
            type: 'auto',
            typeLabel: 'Standard Auto',
            coverage: '$75,000 / $150,000',
            premium: '$850 / yr',
            effective: 'Oct 20, 2025',
            renewal: 'Oct 20, 2026',
            status: 'pending'
        }
    ];

    const DEFAULT_CLAIMS = [
        {
            id: 'CLM-2026-081',
            holder: 'Jonathan Harris',
            policyId: 'SB-POL-98412',
            incident: 'Severe hailstorm roof damage & exterior guttering',
            estimate: '$8,400',
            adjuster: 'David Miller',
            priority: 'High',
            status: 'reviewing',
            date: 'Oct 03, 2026'
        },
        {
            id: 'CLM-2026-064',
            holder: 'Samantha Ray',
            policyId: 'SB-POL-84920',
            incident: 'Low-speed parking lot scrape & bumper crack',
            estimate: '$1,250',
            adjuster: 'Sarah Jenkins',
            priority: 'Normal',
            status: 'approved',
            date: 'Sep 28, 2026'
        },
        {
            id: 'CLM-2026-052',
            holder: 'TechWave Studios',
            policyId: 'SB-POL-62019',
            incident: 'Server room water pipe leakage & equipment repair',
            estimate: '$14,200',
            adjuster: 'Alex Vance',
            priority: 'High',
            status: 'paid',
            date: 'Sep 15, 2026'
        }
    ];

    // --------------------------------------------------------------------------
    // STORAGE HELPERS
    // --------------------------------------------------------------------------
    function getQuotes() {
        const stored = localStorage.getItem('sb_admin_quotes');
        if (!stored) {
            localStorage.setItem('sb_admin_quotes', JSON.stringify(DEFAULT_QUOTES));
            return DEFAULT_QUOTES;
        }
        return JSON.parse(stored);
    }

    function saveQuotes(quotes) {
        localStorage.setItem('sb_admin_quotes', JSON.stringify(quotes));
        updateDashboardKPIs();
    }

    function getPolicies() {
        const stored = localStorage.getItem('sb_admin_policies');
        if (!stored) {
            localStorage.setItem('sb_admin_policies', JSON.stringify(DEFAULT_POLICIES));
            return DEFAULT_POLICIES;
        }
        return JSON.parse(stored);
    }

    function getClaims() {
        const stored = localStorage.getItem('sb_admin_claims');
        if (!stored) {
            localStorage.setItem('sb_admin_claims', JSON.stringify(DEFAULT_CLAIMS));
            return DEFAULT_CLAIMS;
        }
        return JSON.parse(stored);
    }

    // --------------------------------------------------------------------------
    // DOM REFERENCES
    // --------------------------------------------------------------------------
    const quotesTableBody = document.getElementById('quotesTableBody');
    const policiesTableBody = document.getElementById('policiesTableBody');
    const claimsTableBody = document.getElementById('claimsTableBody');
    const quotesCountBadge = document.getElementById('quotesCountBadge');
    
    // Filters & Search
    let currentQuoteFilter = 'all';
    let currentQuoteSearch = '';

    // --------------------------------------------------------------------------
    // RENDER FUNCTIONS
    // --------------------------------------------------------------------------
    function renderQuotes() {
        if (!quotesTableBody) return;
        const quotes = getQuotes();
        
        let filtered = quotes.filter(q => {
            const matchesFilter = (currentQuoteFilter === 'all') || (q.status.toLowerCase() === currentQuoteFilter.toLowerCase());
            const term = currentQuoteSearch.toLowerCase().trim();
            const matchesSearch = !term || 
                q.name.toLowerCase().includes(term) ||
                q.email.toLowerCase().includes(term) ||
                q.id.toLowerCase().includes(term) ||
                q.typeLabel.toLowerCase().includes(term) ||
                q.location.toLowerCase().includes(term);
            return matchesFilter && matchesSearch;
        });

        if (quotesCountBadge) {
            const newCount = quotes.filter(q => q.status === 'new').length;
            quotesCountBadge.textContent = newCount > 0 ? newCount : quotes.length;
        }

        if (filtered.length === 0) {
            quotesTableBody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 48px; color: var(--text-muted);">
                        <svg style="width: 40px; height: 40px; margin: 0 auto 12px; display: block; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                        </svg>
                        <strong>No matching quote requests found</strong>
                        <p style="font-size: 0.75rem; margin-top: 4px;">Try adjusting your filter or search query.</p>
                    </td>
                </tr>
            `;
            return;
        }

        quotesTableBody.innerHTML = filtered.map(q => {
            const initials = q.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            return `
                <tr data-id="${q.id}">
                    <td>
                        <div class="user-cell">
                            <div class="user-cell-avatar">${initials}</div>
                            <div>
                                <div class="user-cell-name">${q.name}</div>
                                <div class="user-cell-email">${q.email} • ${q.phone}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="category-badge ${q.type}">
                            ${q.typeLabel}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--text-primary);">${q.coverage}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">${q.premium}</div>
                    </td>
                    <td>
                        <span>${q.location}</span>
                    </td>
                    <td>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">${q.date}</span>
                    </td>
                    <td>
                        <select class="status-select" data-id="${q.id}" style="
                            padding: 3px 8px; 
                            border-radius: var(--radius-full); 
                            font-size: 0.75rem; 
                            font-weight: 700; 
                            cursor: pointer;
                            border: 1px solid var(--border-subtle);
                            background: var(--bg-surface-secondary);
                        ">
                            <option value="new" ${q.status === 'new' ? 'selected' : ''}>New</option>
                            <option value="reviewing" ${q.status === 'reviewing' ? 'selected' : ''}>Reviewing</option>
                            <option value="quoted" ${q.status === 'quoted' ? 'selected' : ''}>Quoted</option>
                            <option value="converted" ${q.status === 'converted' ? 'selected' : ''}>Converted</option>
                            <option value="declined" ${q.status === 'declined' ? 'selected' : ''}>Declined</option>
                        </select>
                    </td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-icon-sm view-quote" data-id="${q.id}" title="View Details">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </button>
                            <button class="btn-icon-sm delete delete-quote" data-id="${q.id}" title="Delete">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        // Attach event listeners for status change & delete
        quotesTableBody.querySelectorAll('.status-select').forEach(sel => {
            sel.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const newStatus = this.value;
                const quotes = getQuotes();
                const target = quotes.find(q => q.id === id);
                if (target) {
                    target.status = newStatus;
                    saveQuotes(quotes);
                    renderQuotes();
                    showNotification(`Quote ${id} status updated to "${newStatus}"`);
                }
            });
        });

        quotesTableBody.querySelectorAll('.delete-quote').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                if (confirm(`Are you sure you want to remove quote request ${id}?`)) {
                    let quotes = getQuotes();
                    quotes = quotes.filter(q => q.id !== id);
                    saveQuotes(quotes);
                    renderQuotes();
                    showNotification(`Quote ${id} has been removed.`);
                }
            });
        });

        quotesTableBody.querySelectorAll('.view-quote').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const quotes = getQuotes();
                const q = quotes.find(item => item.id === id);
                if (q) openQuoteDetailModal(q);
            });
        });
    }

    function renderPolicies() {
        if (!policiesTableBody) return;
        const policies = getPolicies();
        policiesTableBody.innerHTML = policies.map(p => `
            <tr>
                <td><code style="font-family: var(--font-mono); font-weight: 700; color: var(--sb-blue-600);">${p.id}</code></td>
                <td><strong style="color: var(--text-primary);">${p.holder}</strong></td>
                <td><span class="category-badge ${p.type}">${p.typeLabel}</span></td>
                <td><strong>${p.coverage}</strong></td>
                <td>${p.premium}</td>
                <td><span style="font-size: 0.75rem; color: var(--text-muted);">${p.renewal}</span></td>
                <td><span class="status-pill ${p.status}">${p.status}</span></td>
            </tr>
        `).join('');
    }

    function renderClaims() {
        if (!claimsTableBody) return;
        const claims = getClaims();
        claimsTableBody.innerHTML = claims.map(c => `
            <tr>
                <td><code style="font-family: var(--font-mono); font-weight: 700; color: var(--sb-rose-600);">${c.id}</code></td>
                <td>
                    <div style="font-weight: 700; color: var(--text-primary);">${c.holder}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); font-family: var(--font-mono);">${c.policyId}</div>
                </td>
                <td style="max-width: 280px;">${c.incident}</td>
                <td><strong style="color: var(--text-primary); font-size: 0.9375rem;">${c.estimate}</strong></td>
                <td><span style="font-weight: 600;">${c.adjuster}</span></td>
                <td><span class="status-pill ${c.status}">${c.status}</span></td>
                <td>
                    <button class="btn-secondary" style="height: 30px; padding: 0 10px; font-size: 0.75rem;" onclick="alert('Claim ${c.id} details opened for adjuster review.')">
                        Review
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function updateDashboardKPIs() {
        const quotes = getQuotes();
        const pendingCount = quotes.filter(q => q.status === 'new' || q.status === 'reviewing').length;
        const kpiQuotes = document.getElementById('kpiPendingQuotes');
        if (kpiQuotes) kpiQuotes.textContent = pendingCount;
    }

    // --------------------------------------------------------------------------
    // MODAL HANDLERS
    // --------------------------------------------------------------------------
    const quoteModal = document.getElementById('quoteModal');
    const quoteDetailModal = document.getElementById('quoteDetailModal');
    const quoteForm = document.getElementById('newQuoteForm');

    window.openNewQuoteModal = function () {
        if (quoteModal) {
            quoteModal.classList.add('active');
            if (quoteForm) quoteForm.reset();
        }
    };

    window.closeModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('active');
    };

    function openQuoteDetailModal(q) {
        const detailBody = document.getElementById('quoteDetailBody');
        if (!detailBody) return;
        detailBody.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border-subtle);">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-primary);">${q.name}</h3>
                    <p style="font-size: 0.8125rem; color: var(--text-muted);">${q.email} • ${q.phone}</p>
                </div>
                <span class="status-pill ${q.status}" style="font-size: 0.8125rem; padding: 4px 12px;">${q.status}</span>
            </div>
            <div class="form-grid" style="row-gap: 16px; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 0.6875rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Insurance Type</div>
                    <div style="font-weight: 700; color: var(--text-primary); margin-top: 2px;">${q.typeLabel}</div>
                </div>
                <div>
                    <div style="font-size: 0.6875rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Coverage Desired</div>
                    <div style="font-weight: 700; color: var(--text-primary); margin-top: 2px;">${q.coverage}</div>
                </div>
                <div>
                    <div style="font-size: 0.6875rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Location</div>
                    <div style="font-weight: 700; color: var(--text-primary); margin-top: 2px;">${q.location}</div>
                </div>
                <div>
                    <div style="font-size: 0.6875rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Submitted Time</div>
                    <div style="font-weight: 700; color: var(--text-primary); margin-top: 2px;">${q.date}</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 0.6875rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Underwriter Notes & Details</div>
                    <div style="margin-top: 6px; padding: 12px; background: var(--bg-surface-secondary); border-radius: var(--radius-md); font-size: 0.875rem; line-height: 1.5;">
                        ${q.notes || 'No extra notes provided by applicant.'}
                    </div>
                </div>
            </div>
        `;
        if (quoteDetailModal) quoteDetailModal.classList.add('active');
    }

    if (quoteForm) {
        quoteForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const type = formData.get('type') || 'home';
            const typeLabels = {
                home: 'Homeowners',
                auto: 'Auto Insurance',
                life: 'Life & Health',
                business: 'Business BOP'
            };

            const newQuote = {
                id: 'Q-' + Math.floor(10000 + Math.random() * 90000),
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone') || '(206) 555-0100',
                type: type,
                typeLabel: typeLabels[type] || 'Personal Line',
                coverage: formData.get('coverage') || '$500,000 Standard',
                premium: '$' + Math.floor(800 + Math.random() * 2200) + ' / yr',
                location: formData.get('zip') ? `ZIP: ${formData.get('zip')}` : 'Washington',
                status: 'new',
                date: 'Just now',
                notes: formData.get('notes') || 'Created manually via Agent Portal.'
            };

            const quotes = getQuotes();
            quotes.unshift(newQuote);
            saveQuotes(quotes);
            renderQuotes();
            closeModal('quoteModal');
            showNotification(`New quote request ${newQuote.id} created for ${newQuote.name}!`);
        });
    }

    // --------------------------------------------------------------------------
    // CSV EXPORT (Real browser download)
    // --------------------------------------------------------------------------
    window.exportQuotesCSV = function () {
        const quotes = getQuotes();
        const headers = ['ID', 'Name', 'Email', 'Phone', 'Type', 'Coverage', 'Premium', 'Location', 'Status', 'Date', 'Notes'];
        const csvRows = [headers.join(',')];

        quotes.forEach(q => {
            const row = [
                `"${q.id}"`,
                `"${q.name.replace(/"/g, '""')}"`,
                `"${q.email}"`,
                `"${q.phone}"`,
                `"${q.typeLabel}"`,
                `"${q.coverage.replace(/"/g, '""')}"`,
                `"${q.premium}"`,
                `"${q.location}"`,
                `"${q.status}"`,
                `"${q.date}"`,
                `"${(q.notes || '').replace(/"/g, '""')}"`
            ];
            csvRows.push(row.join(','));
        });

        const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', `surebound-quotes-export-${new Date().toISOString().slice(0, 10)}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showNotification('Quotes exported successfully to CSV.');
    };

    // --------------------------------------------------------------------------
    // TOAST NOTIFICATION
    // --------------------------------------------------------------------------
    function showNotification(msg) {
        let toast = document.getElementById('sbAdminToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'sbAdminToast';
            toast.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                background: #0b1524;
                color: #ffffff;
                padding: 12px 20px;
                border-radius: 10px;
                font-size: 0.8125rem;
                font-weight: 600;
                box-shadow: 0 10px 25px rgba(0,0,0,0.25);
                border: 1px solid rgba(16, 185, 129, 0.4);
                display: flex;
                align-items: center;
                gap: 10px;
                z-index: 999;
                transform: translateY(100px);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            `;
            document.body.appendChild(toast);
        }
        toast.innerHTML = `
            <svg style="width: 18px; height: 18px; color: #10b981; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <span>${msg}</span>
        `;
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';

        clearTimeout(toast.hideTimeout);
        toast.hideTimeout = setTimeout(() => {
            toast.style.transform = 'translateY(100px)';
            toast.style.opacity = '0';
        }, 3200);
    }

    // --------------------------------------------------------------------------
    // NAVIGATION TABS & SIDEBAR
    // --------------------------------------------------------------------------
    function initTabs() {
        const navLinks = document.querySelectorAll('.sidebar-link[data-tab]');
        const panes = document.querySelectorAll('.tab-pane');
        const breadcrumbCurrent = document.getElementById('breadcrumbCurrent');

        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                const targetTab = this.getAttribute('data-tab');
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                panes.forEach(pane => {
                    pane.classList.remove('active');
                    if (pane.id === 'tab-' + targetTab) {
                        pane.classList.add('active');
                    }
                });

                if (breadcrumbCurrent) {
                    const label = this.querySelector('span:not(.nav-badge)')?.textContent || 'Overview';
                    breadcrumbCurrent.textContent = label;
                }

                // Close mobile sidebar if open
                const sidebar = document.getElementById('adminSidebar');
                if (sidebar) sidebar.classList.remove('open');
            });
        });
    }

    function initFilterButtons() {
        const filterBtns = document.querySelectorAll('.filter-tab-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentQuoteFilter = this.getAttribute('data-filter') || 'all';
                renderQuotes();
            });
        });

        const searchInput = document.getElementById('quotesTableSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                currentQuoteSearch = this.value;
                renderQuotes();
            });
        }

        const globalSearch = document.getElementById('globalSearchInput');
        if (globalSearch) {
            globalSearch.addEventListener('input', function () {
                const qTab = document.querySelector('.sidebar-link[data-tab="quotes"]');
                if (qTab && !qTab.classList.contains('active')) {
                    qTab.click();
                }
                currentQuoteSearch = this.value;
                if (searchInput) searchInput.value = this.value;
                renderQuotes();
            });
        }
    }

    function initMobileSidebar() {
        const menuBtn = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('adminSidebar');
        if (menuBtn && sidebar) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }
    }

    // --------------------------------------------------------------------------
    // INITIALIZATION
    // --------------------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {
        initTabs();
        initFilterButtons();
        initMobileSidebar();
        renderQuotes();
        renderPolicies();
        renderClaims();
        updateDashboardKPIs();
    });

})();
