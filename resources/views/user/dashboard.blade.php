@extends('layouts.user')

@section('content')
<!-- DASHBOARD BODY -->
        <div class="dashboard-content">
            
            <!-- LEFT PANEL -->
            <div class="dashboard-left">
                
                <!-- HERO -->
                <div class="hero-banner">
                    <div class="hero-content">
                        <div class="hero-greeting">Hello, {{ explode(' ', Auth::user()->name ?? 'Md Rejawl')[0] }} 👋</div>
                        <h1 class="hero-title">Welcome back!</h1>
                        <p class="hero-subtitle">Here's an overview of your insurance journey. Manage your policies, make payments, and get the support you need &mdash; all in one place.</p>
                        
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <div class="hero-stat-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="hero-stat-info">
                                    <span class="hero-stat-val">2</span>
                                    <span class="hero-stat-label">Active Policies</span>
                                </div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div class="hero-stat-info">
                                    <span class="hero-stat-val">1</span>
                                    <span class="hero-stat-label">Claims (In Progress)</span>
                                </div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="hero-stat-info">
                                    <span class="hero-stat-val">0</span>
                                    <span class="hero-stat-label">Upcoming Payments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FIND RIGHT COVERAGE -->
                <div>
                    <div class="section-header">
                        <div>
                            <h2 class="section-title">Find the Right Coverage</h2>
                            <p class="section-subtitle">Explore our insurance solutions designed for your needs.</p>
                        </div>
                        <a href="#" class="view-all">View All Categories &rarr;</a>
                    </div>
                    
                    <div class="coverage-grid">
                        <div class="coverage-card">
                            <div class="coverage-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <h4>Health Insurance</h4>
                            <p>Stay healthy, live better.</p>
                            <div class="coverage-arrow">&rarr;</div>
                        </div>
                        
                        <div class="coverage-card">
                            <div class="coverage-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h4>Life Insurance</h4>
                            <p>Protect what matters most.</p>
                            <div class="coverage-arrow">&rarr;</div>
                        </div>
                        
                        <div class="coverage-card">
                            <div class="coverage-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            <h4>Auto Insurance</h4>
                            <p>Drive with confidence.</p>
                            <div class="coverage-arrow">&rarr;</div>
                        </div>
                        
                        <div class="coverage-card">
                            <div class="coverage-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <h4>Home Insurance</h4>
                            <p>Secure your home.</p>
                            <div class="coverage-arrow">&rarr;</div>
                        </div>
                        
                        <div class="coverage-card">
                            <div class="coverage-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <h4>Business Insurance</h4>
                            <p>Grow with confidence.</p>
                            <div class="coverage-arrow">&rarr;</div>
                        </div>
                    </div>
                </div>
                
                <!-- MY POLICIES -->
                <div>
                    <div class="section-header">
                        <div>
                            <h2 class="section-title">My Policies</h2>
                            <p class="section-subtitle">View and manage your active and past insurance policies.</p>
                        </div>
                        <a href="#" class="view-all">View All Policies &rarr;</a>
                    </div>
                    
                    <div class="table-card">
                        <table class="policies-table">
                            <thead>
                                <tr>
                                    <th>Policy No.</th>
                                    <th>Type</th>
                                    <th>Coverage</th>
                                    <th>Status</th>
                                    <th>Renewal Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="policy-id-cell">
                                            <div class="policy-icon-small">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            </div>
                                            SB-HE-2024-001
                                        </div>
                                    </td>
                                    <td>Health Insurance</td>
                                    <td>
                                        <div class="coverage-details">
                                            <span>Family Floater</span>
                                            <span>(Up to 5 Members)</span>
                                        </div>
                                    </td>
                                    <td><span class="status-badge active">Active</span></td>
                                    <td>Dec 15, 2025</td>
                                    <td><a href="#" class="action-link">View Details &rarr;</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="policy-id-cell">
                                            <div class="policy-icon-small">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                            </div>
                                            SB-AU-2024-002
                                        </div>
                                    </td>
                                    <td>Auto Insurance</td>
                                    <td>
                                        <div class="coverage-details">
                                            <span>Toyota Corolla</span>
                                            <span>(Comprehensive)</span>
                                        </div>
                                    </td>
                                    <td><span class="status-badge active">Active</span></td>
                                    <td>Jan 10, 2026</td>
                                    <td><a href="#" class="action-link">View Details &rarr;</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BOTTOM WIDGETS -->
                <div class="bottom-widgets">
                    
                    <!-- Recent Claims -->
                    <div class="widget-card">
                        <div class="widget-header">
                            <h3>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Recent Claims
                            </h3>
                            <a href="#" class="view-all" style="font-size: 0.875rem;">View All &rarr;</a>
                        </div>
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Claim No.</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CL-2024-003</td>
                                    <td>Health</td>
                                    <td>Oct 12, 2024</td>
                                    <td><span class="status-badge pending" style="background:#eff6ff; color:#2563eb;">In Progress</span></td>
                                </tr>
                                <tr>
                                    <td>CL-2024-002</td>
                                    <td>Auto</td>
                                    <td>Aug 03, 2024</td>
                                    <td><span class="status-badge active">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>CL-2024-001</td>
                                    <td>Life</td>
                                    <td>Jun 18, 2024</td>
                                    <td><span class="status-badge closed">Closed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Recent Activity -->
                    <div class="widget-card">
                        <div class="widget-header">
                            <h3>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Recent Activity
                            </h3>
                            <a href="#" class="view-all" style="font-size: 0.875rem;">View All &rarr;</a>
                        </div>
                        <div class="timeline-list">
                            <div class="timeline-item">
                                <div class="timeline-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Policy renewal reminder</div>
                                    <div class="timeline-desc">Your health policy renews on Dec 15, 2025.</div>
                                </div>
                                <div class="timeline-date">Nov 12, 2024</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon green"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Claim updated</div>
                                    <div class="timeline-desc">Your claim CL-2024-003 is now in progress.</div>
                                </div>
                                <div class="timeline-date">Oct 12, 2024</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon purple"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Payment successful</div>
                                    <div class="timeline-desc">BDT 12,500.00 paid for policy SB-HE-2024-001.</div>
                                </div>
                                <div class="timeline-date">Sep 28, 2024</div>
                            </div>
                        </div>
                    </div>

                    <!-- Helpful Resources -->
                    <div class="widget-card">
                        <div class="widget-header">
                            <h3>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                Helpful Resources
                            </h3>
                            <a href="#" class="view-all" style="font-size: 0.875rem;">View All &rarr;</a>
                        </div>
                        <div class="resource-list">
                            <div class="resource-item">
                                <div class="resource-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                                <div class="resource-info">
                                    <h4>Insurance Guide</h4>
                                    <p>Learn the basics and how it works.</p>
                                </div>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                            <div class="resource-item">
                                <div class="resource-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                <div class="resource-info">
                                    <h4>FAQs</h4>
                                    <p>Find quick answers to common questions.</p>
                                </div>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                            <div class="resource-item">
                                <div class="resource-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                                <div class="resource-info">
                                    <h4>Need Assistance?</h4>
                                    <p>Contact our support team.</p>
                                </div>
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- RIGHT PANEL -->
            <aside class="dashboard-right">
                
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-header-bg"></div>
                    <div class="profile-content">
                        <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Profile" class="profile-avatar">
                        <h2 class="profile-name">{{ Auth::user()->name ?? 'Md Rejawl' }}</h2>
                        <span class="profile-role">Policy Holder</span>
                        
                        <div class="profile-details">
                            <div class="profile-detail-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>{{ Auth::user()->email ?? 'rejawl15-4510@diu.edu.bd' }}</span>
                            </div>
                            <div class="profile-detail-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>+880 1XXX-XXXX</span>
                            </div>
                            <div class="profile-detail-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Dhaka, Bangladesh</span>
                            </div>
                        </div>
                        
                        <button class="btn-outline">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Edit Profile
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions-card">
                    <h3>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Quick Actions
                    </h3>
                    <div class="action-list">
                        <div class="action-item">
                            <div class="action-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div class="action-text">
                                <h4>Get a Quote</h4>
                                <p>Find the right coverage</p>
                            </div>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        
                        <div class="action-item">
                            <div class="action-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg></div>
                            <div class="action-text">
                                <h4>Make a Payment</h4>
                                <p>Pay your premium</p>
                            </div>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        
                        <div class="action-item">
                            <div class="action-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div class="action-text">
                                <h4>File a Claim</h4>
                                <p>Start your claim process</p>
                            </div>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        
                        <div class="action-item">
                            <div class="action-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                            <div class="action-text">
                                <h4>Contact Support</h4>
                                <p>Chat or call us</p>
                            </div>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Need Help -->
                <div class="support-card">
                    <h3>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Need Help?
                    </h3>
                    <p>Our support team is available 24/7 to assist you.</p>
                    <button class="btn-primary">Chat Now</button>
                    <button class="btn-call">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Call +880 9612 345678
                    </button>
                </div>
                
            </aside>
            
        </div>
    @endsection
