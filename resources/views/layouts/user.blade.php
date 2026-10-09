<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Surebound</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/user-panel.css') }}">
</head>
<body>

<div class="user-layout">
    
    <!-- LEFT SIDEBAR -->
    <aside class="user-sidebar">
        <div class="sidebar-logo">
            <svg viewBox="0 0 40 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 32px; width: auto;">
                <path d="M19.4 1.2a1.8 1.8 0 0 1 1.2 0L37.2 7c.5.3.8.8.8 1.3v15c0 10.7-7 20.6-17.1 24.3a2.5 2.5 0 0 1-1.8 0C9 43.9 2 34 2 23.3v-15c0-.5.3-1 .8-1.3L19.4 1.2Z" fill="#1D4ED8"/>
                <path d="M14 16.5h7c2 0 3.5 1.5 3.5 3.5s-1.5 3.5-3.5 3.5h-5.5v5h-1.5v-12Zm1.5 1.5v4h5.5c1.1 0 2-.9 2-2s-.9-2-2-2h-5.5Z" fill="#fff"/>
                <path d="M21 21.5h4c2 0 3.5 1.5 3.5 3.5s-1.5 3.5-3.5 3.5h-5.5v-7h1.5v5.5h4c1.1 0 2-.9 2-2s-.9-2-2-2Z" fill="#fff"/>
            </svg>
            SUREBOUND
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('user.policies') }}" class="nav-item {{ request()->routeIs('user.policies') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                My Policies
            </a>
            <a href="{{ route('user.quote') }}" class="nav-item {{ request()->routeIs('user.quote') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Get a Quote
            </a>
            <a href="{{ route('user.claims') }}" class="nav-item {{ request()->routeIs('user.claims') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Claims
            </a>
            <a href="{{ route('user.documents') }}" class="nav-item {{ request()->routeIs('user.documents') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                Documents
            </a>
            <a href="{{ route('user.payments') }}" class="nav-item {{ request()->routeIs('user.payments') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Payments
            </a>
            <a href="{{ route('user.support') }}" class="nav-item {{ request()->routeIs('user.support') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Support
            </a>
            <a href="{{ route('user.settings') }}" class="nav-item {{ request()->routeIs('user.settings') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>
        </nav>
        
        <div class="sidebar-promo">
            <svg viewBox="0 0 40 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 28px; width: auto; margin-bottom: 12px;">
                <path d="M19.4 1.2a1.8 1.8 0 0 1 1.2 0L37.2 7c.5.3.8.8.8 1.3v15c0 10.7-7 20.6-17.1 24.3a2.5 2.5 0 0 1-1.8 0C9 43.9 2 34 2 23.3v-15c0-.5.3-1 .8-1.3L19.4 1.2Z" fill="#3B82F6"/>
            </svg>
            <h4>Your Protection<br>Our Priority</h4>
            <p>Stay covered, stay confident. We're here for you.</p>
            <a href="#" class="promo-btn">Get Support &rarr;</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="user-main">
        
        <!-- HEADER -->
        <header class="user-header">
            <div class="header-search">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Search policies, claims, or anything...">
            </div>
            
            <div class="header-actions">
                <div class="header-notify">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <div class="notify-dot"></div>
                </div>
                
                <div class="header-profile" id="profileDropdownBtn">
                    <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Profile avatar">
                    <div class="header-profile-info">
                        <span class="header-profile-name">{{ Auth::user()->name ?? 'Md Rejawl' }}</span>
                        <span class="header-profile-role">Policy Holder</span>
                    </div>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; color: #64748b;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    
                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown-menu" id="profileDropdownMenu">
                        <a href="{{ route('user.settings') }}" class="dropdown-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        @yield('content')
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileBtn = document.getElementById('profileDropdownBtn');
        const dropdownMenu = document.getElementById('profileDropdownMenu');

        if (profileBtn && dropdownMenu) {
            profileBtn.addEventListener('click', function(e) {
                dropdownMenu.classList.toggle('show');
                e.stopPropagation();
            });

            document.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }
    });
</script>
</body>
</html>
