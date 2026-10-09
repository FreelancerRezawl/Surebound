@extends('layouts.app')

@section('title', 'Make a Payment | Surebound')

@section('content')

    <!-- ==========================================
         HERO SECTION (DYNAMIC CMS REPLICA)
         ========================================== -->
    <section class="hero-section">
        <div class="hero-photo-bleed">
            <img 
                src="{{ asset($content['hero_image'] ?? 'images/hero-business.jpg') }}" 
                alt="Make a Payment" 
                class="hero-photo-img"
            >
            <div class="hero-photo-fade-right"></div>
            <div class="hero-photo-tint"></div>
        </div>

        <div class="container hero-container">
            <div class="hero-content">
                <p class="hero-eyebrow">{!! $content['hero_eyebrow'] ?? 'Make a Payment' !!}</p>
                <h1 class="hero-title">{!! $content['hero_title'] ?? 'Secure & Easy Payments' !!}</h1>
                <p class="hero-subtitle">
                    {{ $content['hero_subtitle'] ?? 'Pay your premium quickly and securely online.' }}
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('user.payments') }}" class="btn-primary-hero">
                        <span>Pay Now</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="17" height="17">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT SECTION -->
    <section style="padding: 80px 0; background: var(--bg-primary);">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <h2 style="font-size: 34px; margin-bottom: 24px; color: var(--text-dark);">Flexible payment options for your convenience.</h2>
                <p style="font-size: 20px; line-height: 1.6; color: var(--text-medium); margin-bottom: 40px;">
                    We offer a variety of payment methods to make managing your insurance policy as easy as possible. Choose the option that works best for you and your budget.
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; text-align: left;">
                    <div style="background: var(--bg-secondary); padding: 32px; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 12px; color: var(--text-dark);">Online Bill Pay</h3>
                        <p style="color: var(--text-medium); font-size: 17px; line-height: 1.6;">Pay your bill instantly using your bank account, credit card, or digital wallet through our secure portal.</p>
                    </div>
                    <div style="background: var(--bg-secondary); padding: 32px; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 12px; color: var(--text-dark);">AutoPay</h3>
                        <p style="color: var(--text-medium); font-size: 17px; line-height: 1.6;">Set it and forget it. Enroll in AutoPay to have your premium automatically deducted on your due date.</p>
                    </div>
                    <div style="background: var(--bg-secondary); padding: 32px; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 12px; color: var(--text-dark);">Pay by Phone</h3>
                        <p style="color: var(--text-medium); font-size: 17px; line-height: 1.6;">Call our automated payment line 24/7 to make a payment over the phone securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
