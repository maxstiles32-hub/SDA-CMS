<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Seventh-day Adventist Church Management System — streamline member records, finance, and ministry operations.">
    <title>SDA Church Management System</title>

    <!-- Fonts: Inter for body, Playfair Display for headings -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy: #0f172a;
            --navy-mid: #1e293b;
            --indigo: #4f46e5;
            --indigo-light: #6366f1;
            --gold: #c9a84c;
            --gold-light: #f0c96b;
            --cream: #faf9f7;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: var(--cream);
            color: var(--navy);
            margin: 0;
        }

        /* ─── Background ──────────────────────────────────── */
        .page-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 50% at 50% -10%, rgba(79,70,229,0.09) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 100% 100%, rgba(201,168,76,0.06) 0%, transparent 60%),
                var(--cream);
        }

        /* ─── Noise texture overlay ───────────────────────── */
        .page-bg::after {
            content: '';
            position: fixed;
            inset: 0;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* ─── Layout ──────────────────────────────────────── */
        .page-wrap {
            position: relative;
            z-index: 1;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ─── Navigation ──────────────────────────────────── */
        .nav {
            padding: 1.5rem 0;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--indigo) 0%, #7c3aed 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
            flex-shrink: 0;
        }

        .logo-text {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--navy);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .logo-text span {
            display: block;
            font-weight: 400;
            font-size: 0.7rem;
            color: #64748b;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            border-radius: 8px;
            text-decoration: none;
            transition: color 0.2s, background 0.2s;
        }

        .btn-ghost:hover {
            color: var(--navy);
            background: rgba(15,23,42,0.05);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.375rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            border-radius: 9px;
            text-decoration: none;
            background: linear-gradient(135deg, var(--indigo) 0%, #7c3aed 100%);
            box-shadow: 0 2px 8px rgba(79,70,229,0.35), 0 1px 2px rgba(79,70,229,0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.4), 0 2px 6px rgba(79,70,229,0.25);
        }

        /* ─── Hero ────────────────────────────────────────── */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 5rem 0 3rem;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 1rem;
            background: rgba(79,70,229,0.07);
            border: 1px solid rgba(79,70,229,0.15);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--indigo-light);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 2rem;

            animation: fadeUp 0.6s ease both;
        }

        .eyebrow-dot {
            width: 6px;
            height: 6px;
            background: var(--indigo-light);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 7vw, 5.5rem);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.02em;
            color: var(--navy);
            margin: 0 0 1.75rem;
            max-width: 820px;

            animation: fadeUp 0.6s 0.1s ease both;
        }

        .hero-title .accent {
            background: linear-gradient(120deg, var(--indigo) 0%, #7c3aed 50%, var(--indigo-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.1rem;
            line-height: 1.75;
            color: #64748b;
            max-width: 560px;
            margin: 0 0 2.75rem;
            font-weight: 400;

            animation: fadeUp 0.6s 0.2s ease both;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;

            animation: fadeUp 0.6s 0.3s ease both;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.875rem 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            background: linear-gradient(135deg, var(--indigo) 0%, #7c3aed 100%);
            box-shadow: 0 4px 16px rgba(79,70,229,0.4), 0 2px 4px rgba(79,70,229,0.2);
            transition: transform 0.22s cubic-bezier(.34,1.56,.64,1), box-shadow 0.22s;
            letter-spacing: -0.01em;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 28px rgba(79,70,229,0.45), 0 3px 8px rgba(79,70,229,0.25);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--navy);
            border-radius: 12px;
            text-decoration: none;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.22s cubic-bezier(.34,1.56,.64,1), border-color 0.2s, box-shadow 0.2s;
            letter-spacing: -0.01em;
        }

        .btn-hero-secondary:hover {
            transform: translateY(-2px) scale(1.02);
            border-color: #c7d2fe;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        /* ─── Divider line ────────────────────────────────── */
        .divider {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0 20%, #e2e8f0 80%, transparent);
            margin: 2rem 0 0;

            animation: fadeUp 0.6s 0.5s ease both;
        }

        /* ─── Features strip ──────────────────────────────── */
        .features {
            padding: 3.5rem 0 4rem;
            animation: fadeUp 0.6s 0.5s ease both;
        }

        .features-label {
            text-align: center;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .features-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 14px;
            padding: 1.375rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            border-color: #c7d2fe;
            box-shadow: 0 8px 24px rgba(79,70,229,0.1);
        }

        .feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-indigo { background: rgba(79,70,229,0.1); color: var(--indigo); }
        .icon-emerald { background: rgba(5,150,105,0.1); color: #059669; }
        .icon-amber { background: rgba(217,119,6,0.1); color: #d97706; }
        .icon-violet { background: rgba(124,58,237,0.1); color: #7c3aed; }

        .feature-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: -0.01em;
        }

        .feature-desc {
            font-size: 0.75rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        /* ─── Footer ──────────────────────────────────────── */
        .footer {
            border-top: 1px solid #f1f5f9;
            padding: 1.5rem 0;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .footer-copy {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: 0.78rem;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--indigo);
        }

        /* ─── Animation keyframes ─────────────────────────── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <!-- Decorative background -->
    <div class="page-bg" aria-hidden="true"></div>

    <div class="page-wrap">

        <!-- ── Navigation ─────────────────────────────────── -->
        <nav class="nav">
            <div class="container">
                <div class="nav-inner">

                    <!-- Logo -->
                    <a href="/" class="logo">
                        <div class="logo-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div class="logo-text">
                            SDA Church CMS
                            <span>Management Portal</span>
                        </div>
                    </a>

                    <!-- Nav actions -->
                    <div class="nav-links">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-ghost">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                    </svg>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-ghost">Sign In</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-primary">
                                        Get Started
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>

                </div>
            </div>
        </nav>

        <!-- ── Hero ───────────────────────────────────────── -->
        <main class="hero">
            <div class="container" style="display:flex;flex-direction:column;align-items:center;">

                <!-- Eyebrow label -->
                <div class="hero-eyebrow">
                    <span class="eyebrow-dot"></span>
                    Official Church Administration System
                </div>

                <!-- Main heading -->
                <h1 class="hero-title">
                    Serving the community,<br>
                    <span class="accent">one record at a time.</span>
                </h1>

                <!-- Sub-description -->
                <p class="hero-desc">
                    A secure and simple portal for managing members, finances, baptisms, and departmental activities across the Seventh-day Adventist community.
                </p>

                <!-- CTA buttons -->
                <div class="hero-cta">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-hero-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                                </svg>
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-hero-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                    <polyline points="10 17 15 12 10 7"/>
                                    <line x1="15" y1="12" x2="3" y2="12"/>
                                </svg>
                                Sign In to Portal
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-hero-secondary">
                                    Create an Account
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div class="divider" style="max-width:700px;"></div>

                <!-- Feature Cards -->
                <div class="features" style="width:100%;max-width:780px;">
                    <p class="features-label">What's inside the portal</p>
                    <div class="features-grid">

                        <div class="feature-card">
                            <div class="feature-icon icon-indigo">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <div>
                                <div class="feature-name">Membership</div>
                                <div class="feature-desc">Register, view and manage all church members and departments.</div>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon icon-emerald">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 6v6l4 2"/>
                                    <path d="M9 12h.01M12 9h.01M15 12h.01"/>
                                    <line x1="12" y1="8" x2="12" y2="16"/>
                                    <line x1="8" y1="12" x2="16" y2="12"/>
                                </svg>
                            </div>
                            <div>
                                <div class="feature-name">Finance</div>
                                <div class="feature-desc">Track tithes, offerings, donations, and expenditures with full reports.</div>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon icon-amber">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                                </svg>
                            </div>
                            <div>
                                <div class="feature-name">Documents</div>
                                <div class="feature-desc">Store and retrieve important church documents and records securely.</div>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon icon-violet">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div>
                                <div class="feature-name">Baptisms</div>
                                <div class="feature-desc">Log and track baptism records and member transfers.</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>

        <!-- ── Footer ─────────────────────────────────────── -->
        <footer class="footer">
            <div class="container">
                <div class="footer-inner">
                    <p class="footer-copy">&copy; {{ date('Y') }} SDA Church Management System. All rights reserved.</p>
                    <div class="footer-links">
                        <a href="#">Privacy</a>
                        <a href="#">Support</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>

</body>
</html>
