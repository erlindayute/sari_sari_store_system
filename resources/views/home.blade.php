<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TindaHub — The Smart Sari-Sari Store System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#0e0d0b;
  --paper:#faf8f4;
  --warm:#f5f0e8;
  --accent:#e8521a;
  --accent2:#2d6a4f;
  --gold:#c9a84c;
  --border:rgba(14,13,11,0.12);
  --text2:#5c5852;
  --text3:#9c9890;
  --r:12px;
}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--paper);color:var(--ink);overflow-x:hidden}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:100;padding:0 2rem;height:64px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid transparent;transition:all .3s;backdrop-filter:blur(0)}
nav.scrolled{background:rgba(250,248,244,.92);border-color:var(--border);backdrop-filter:blur(12px)}
.nav-logo{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--ink);text-decoration:none;display:flex;align-items:center;gap:8px}
.nav-logo span{color:var(--accent)}
.nav-links{display:flex;align-items:center;gap:2rem}
.nav-links a{font-size:14px;color:var(--text2);text-decoration:none;transition:color .2s}
.nav-links a:hover{color:var(--ink)}
.nav-cta{background:var(--ink);color:var(--paper);padding:9px 20px;border-radius:8px;font-size:14px;font-weight:500;text-decoration:none;transition:all .2s}
.nav-cta:hover{background:var(--accent);transform:translateY(-1px)}

/* HERO */
.hero{min-height:100vh;display:flex;flex-direction:column;justify-content:center;padding:6rem 2rem 4rem;position:relative;overflow:hidden}
.hero-bg{position:absolute;inset:0;z-index:0}
.hero-bg::before{content:'';position:absolute;top:-200px;right:-200px;width:700px;height:700px;background:radial-gradient(circle, rgba(232,82,26,.08) 0%, transparent 70%)}
.hero-bg::after{content:'';position:absolute;bottom:-100px;left:-100px;width:500px;height:500px;background:radial-gradient(circle, rgba(45,106,79,.06) 0%, transparent 70%)}
.hero-grid{position:absolute;inset:0;background-image:linear-gradient(var(--border) 1px,transparent 1px),linear-gradient(90deg,var(--border) 1px,transparent 1px);background-size:60px 60px;opacity:.4}
.hero-inner{max-width:1100px;margin:0 auto;width:100%;position:relative;z-index:1}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(232,82,26,.1);border:1px solid rgba(232,82,26,.2);padding:6px 14px;border-radius:20px;font-size:12px;font-weight:500;color:var(--accent);margin-bottom:2rem;animation:fadeUp .6s ease both}
.hero-badge::before{content:'●';font-size:8px;animation:pulse 2s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}
h1{font-family:'Playfair Display',serif;font-size:clamp(3rem,7vw,6rem);font-weight:900;line-height:1.0;letter-spacing:-2px;margin-bottom:1.5rem;animation:fadeUp .7s .1s ease both}
h1 em{color:var(--accent);font-style:italic}
.hero-sub{font-size:1.15rem;color:var(--text2);max-width:540px;line-height:1.7;margin-bottom:2.5rem;font-weight:300;animation:fadeUp .7s .2s ease both}
.hero-actions{display:flex;align-items:center;gap:1rem;animation:fadeUp .7s .3s ease both;flex-wrap:wrap}
.btn-primary{background:var(--ink);color:var(--paper);padding:14px 28px;border-radius:10px;font-size:15px;font-weight:500;text-decoration:none;transition:all .2s;display:inline-flex;align-items:center;gap:8px}
.btn-primary:hover{background:var(--accent);transform:translateY(-2px);box-shadow:0 8px 24px rgba(232,82,26,.3)}
.btn-outline{border:1.5px solid var(--border);color:var(--ink);padding:13px 24px;border-radius:10px;font-size:15px;text-decoration:none;transition:all .2s;display:inline-flex;align-items:center;gap:6px}
.btn-outline:hover{border-color:var(--ink);background:var(--warm)}
.hero-stats{display:flex;gap:2.5rem;margin-top:3.5rem;animation:fadeUp .7s .4s ease both;padding-top:2.5rem;border-top:1px solid var(--border)}
.hero-stat .num{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--ink)}
.hero-stat .lbl{font-size:12px;color:var(--text3);text-transform:uppercase;letter-spacing:.8px}

/* DASHBOARD PREVIEW */
.preview-wrap{max-width:1100px;margin:0 auto 6rem;padding:0 2rem;animation:fadeUp .8s .5s ease both}
.preview-frame{background:var(--warm);border:1px solid var(--border);border-radius:16px;padding:1.5rem;position:relative;overflow:hidden}
.preview-frame::before{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 60%,var(--paper) 100%);z-index:2;pointer-events:none}
.preview-toolbar{display:flex;align-items:center;gap:6px;margin-bottom:1rem}
.preview-dot{width:10px;height:10px;border-radius:50%}
.preview-dots .preview-dot:nth-child(1){background:#ff5f57}
.preview-dots .preview-dot:nth-child(2){background:#ffbd2e}
.preview-dots .preview-dot:nth-child(3){background:#28c840}
.preview-dots{display:flex;gap:6px}
.preview-url{flex:1;background:rgba(255,255,255,.6);border-radius:6px;padding:5px 12px;font-size:11px;color:var(--text3);margin-left:8px}
.preview-body{display:grid;grid-template-columns:200px 1fr;gap:12px;height:340px}
.preview-sidebar{background:var(--ink);border-radius:10px;padding:16px;display:flex;flex-direction:column;gap:4px}
.preview-sidebar-logo{font-family:'Playfair Display',serif;font-size:14px;color:white;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid rgba(255,255,255,.1)}
.preview-nav-item{padding:8px 10px;border-radius:7px;font-size:11px;color:rgba(255,255,255,.5);display:flex;align-items:center;gap:8px}
.preview-nav-item.active{background:var(--accent);color:white}
.preview-nav-item span{width:14px;text-align:center}
.preview-content{display:flex;flex-direction:column;gap:10px}
.preview-kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
.preview-kpi{background:white;border-radius:8px;padding:12px;border:1px solid var(--border)}
.preview-kpi .k-val{font-size:18px;font-weight:600;color:var(--ink)}
.preview-kpi .k-lbl{font-size:10px;color:var(--text3);text-transform:uppercase;letter-spacing:.5px}
.preview-table{background:white;border-radius:8px;border:1px solid var(--border);flex:1;overflow:hidden}
.preview-trow{display:flex;align-items:center;padding:8px 12px;border-bottom:1px solid var(--border);gap:8px;font-size:10px}
.preview-trow:first-child{background:var(--warm);font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:.5px}
.preview-tcell{flex:1}
.preview-pill{padding:2px 7px;border-radius:10px;font-size:9px;font-weight:500}
.pill-green{background:#e1f5ee;color:#0f6e56}
.pill-orange{background:#faeeda;color:#854f0b}
.pill-red{background:#fcebeb;color:#a32d2d}

/* PROBLEM/SOLUTION */
.section{padding:6rem 2rem;max-width:1100px;margin:0 auto}
.section-label{font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:var(--accent);font-weight:500;margin-bottom:1rem}
.section-title{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;line-height:1.15;margin-bottom:1.5rem;letter-spacing:-1px}
.problem-grid{display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;margin-top:3rem}
.problem-list{display:flex;flex-direction:column;gap:1.25rem}
.problem-item{display:flex;gap:1rem;padding:1.25rem;border-radius:var(--r);border:1px solid var(--border);background:var(--warm)}
.problem-icon{font-size:24px;flex-shrink:0;width:44px;height:44px;display:flex;align-items:center;justify-content:center;background:white;border-radius:8px;border:1px solid var(--border)}
.problem-title{font-weight:500;font-size:15px;margin-bottom:4px}
.problem-desc{font-size:13px;color:var(--text2);line-height:1.6}
.solution-card{background:var(--ink);color:white;border-radius:16px;padding:2.5rem;position:relative;overflow:hidden}
.solution-card::before{content:'';position:absolute;top:-80px;right:-80px;width:250px;height:250px;background:radial-gradient(circle,rgba(232,82,26,.3),transparent 70%)}
.solution-item{display:flex;gap:1rem;align-items:flex-start;margin-bottom:1.75rem}
.solution-item:last-child{margin-bottom:0}
.solution-check{width:28px;height:28px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:13px;margin-top:2px}
.solution-text h4{font-weight:500;font-size:15px;margin-bottom:3px}
.solution-text p{font-size:13px;color:rgba(255,255,255,.6);line-height:1.6}

/* HOW IT WORKS */
.how-section{background:var(--warm);padding:6rem 2rem}
.how-inner{max-width:1100px;margin:0 auto;text-align:center}
.steps-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;margin-top:3.5rem;text-align:left}
.step-card{position:relative}
.step-num{font-family:'Playfair Display',serif;font-size:3.5rem;font-weight:900;color:rgba(14,13,11,.06);line-height:1;margin-bottom:-.5rem}
.step-icon{width:48px;height:48px;background:var(--ink);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:1rem}
.step-title{font-weight:500;font-size:15px;margin-bottom:.5rem}
.step-desc{font-size:13px;color:var(--text2);line-height:1.7}
.step-connector{position:absolute;top:24px;right:-1rem;width:2rem;height:1px;background:var(--border);display:none}

/* FEATURES */
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-top:3rem}
.feature-card{padding:1.75rem;border-radius:var(--r);border:1px solid var(--border);background:white;transition:all .2s}
.feature-card:hover{transform:translateY(-3px);box-shadow:0 12px 40px rgba(14,13,11,.08);border-color:var(--ink)}
.feature-icon{font-size:28px;margin-bottom:1rem}
.feature-title{font-weight:500;font-size:15px;margin-bottom:.5rem}
.feature-desc{font-size:13px;color:var(--text2);line-height:1.7}

/* SOCIAL PROOF */
.social-section{background:var(--ink);color:white;padding:6rem 2rem}
.social-inner{max-width:1100px;margin:0 auto}
.testimonials{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-top:3rem}
.testimonial{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:var(--r);padding:1.75rem}
.testimonial-text{font-size:14px;line-height:1.8;color:rgba(255,255,255,.8);margin-bottom:1.5rem;font-style:italic}
.testimonial-author{display:flex;align-items:center;gap:12px}
.testimonial-avatar{width:38px;height:38px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:14px}
.testimonial-name{font-size:14px;font-weight:500}
.testimonial-role{font-size:12px;color:rgba(255,255,255,.4)}
.stars{color:var(--gold);font-size:13px;margin-bottom:.75rem}

/* PRICING */
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-top:3rem}
.pricing-card{border:1.5px solid var(--border);border-radius:16px;padding:2rem;background:white;position:relative;transition:all .2s}
.pricing-card.featured{border-color:var(--ink);background:var(--ink);color:white}
.pricing-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:var(--accent);color:white;font-size:11px;padding:4px 14px;border-radius:20px;font-weight:600;white-space:nowrap}
.pricing-name{font-size:14px;font-weight:500;margin-bottom:.5rem}
.pricing-price{font-family:'Playfair Display',serif;font-size:3rem;font-weight:700;line-height:1;margin-bottom:.25rem}
.pricing-price sup{font-size:1.2rem;vertical-align:top;margin-top:.5rem;font-family:'DM Sans',sans-serif;font-weight:400}
.pricing-period{font-size:13px;color:var(--text3);margin-bottom:1.5rem}
.pricing-card.featured .pricing-period{color:rgba(255,255,255,.5)}
.pricing-features{list-style:none;display:flex;flex-direction:column;gap:.75rem;margin-bottom:2rem}
.pricing-features li{font-size:13px;display:flex;align-items:center;gap:8px;color:var(--text2)}
.pricing-card.featured .pricing-features li{color:rgba(255,255,255,.75)}
.pricing-features li::before{content:'✓';color:var(--accent2);font-weight:700;width:16px}
.pricing-card.featured .pricing-features li::before{color:var(--gold)}
.btn-pricing{width:100%;padding:12px;border-radius:8px;font-size:14px;font-weight:500;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s;text-align:center;text-decoration:none;display:block}
.btn-pricing.dark{background:var(--ink);color:white}
.btn-pricing.dark:hover{background:var(--accent)}
.btn-pricing.light{background:rgba(255,255,255,.12);color:white;border:1px solid rgba(255,255,255,.2)}
.btn-pricing.light:hover{background:rgba(255,255,255,.2)}
.btn-pricing.outline{background:white;color:var(--ink);border:1.5px solid var(--border)}
.btn-pricing.outline:hover{border-color:var(--ink)}

/* FAQ */
.faq-list{max-width:720px;margin:3rem auto 0;display:flex;flex-direction:column;gap:1px}
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;margin-bottom:.5rem}
.faq-q{padding:1.25rem 1.5rem;font-size:15px;font-weight:500;cursor:pointer;display:flex;justify-content:space-between;align-items:center;background:white;user-select:none;transition:background .15s}
.faq-q:hover{background:var(--warm)}
.faq-q .arrow{font-size:18px;color:var(--text3);transition:transform .3s}
.faq-item.open .faq-q .arrow{transform:rotate(45deg)}
.faq-a{display:none;padding:0 1.5rem 1.25rem;font-size:14px;color:var(--text2);line-height:1.8;background:white}
.faq-item.open .faq-a{display:block}

/* CTA BANNER */
.cta-banner{background:var(--accent);padding:5rem 2rem;text-align:center;position:relative;overflow:hidden}
.cta-banner::before{content:'';position:absolute;top:-60px;right:-60px;width:300px;height:300px;background:rgba(255,255,255,.08);border-radius:50%}
.cta-banner::after{content:'';position:absolute;bottom:-80px;left:-40px;width:250px;height:250px;background:rgba(0,0,0,.06);border-radius:50%}
.cta-banner h2{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);font-weight:700;color:white;margin-bottom:1rem;position:relative;z-index:1}
.cta-banner p{font-size:1rem;color:rgba(255,255,255,.85);margin-bottom:2rem;position:relative;z-index:1}
.btn-white{background:white;color:var(--accent);padding:14px 32px;border-radius:10px;font-size:15px;font-weight:600;text-decoration:none;display:inline-block;transition:all .2s;position:relative;z-index:1}
.btn-white:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(0,0,0,.2)}

/* FOOTER */
footer{background:var(--ink);color:white;padding:4rem 2rem 2rem}
.footer-inner{max-width:1100px;margin:0 auto}
.footer-top{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem}
.footer-brand{font-family:'Playfair Display',serif;font-size:20px;margin-bottom:.75rem}
.footer-brand span{color:var(--accent)}
.footer-tagline{font-size:13px;color:rgba(255,255,255,.4);line-height:1.7}
.footer-col h4{font-size:12px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:1rem}
.footer-col a{display:block;font-size:13px;color:rgba(255,255,255,.6);text-decoration:none;margin-bottom:.6rem;transition:color .2s}
.footer-col a:hover{color:white}
.footer-bottom{border-top:1px solid rgba(255,255,255,.08);padding-top:1.5rem;display:flex;justify-content:space-between;align-items:center}
.footer-copy{font-size:12px;color:rgba(255,255,255,.3)}

@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

@media(max-width:768px){
  .problem-grid,.testimonials,.pricing-grid,.features-grid,.steps-grid,.footer-top{grid-template-columns:1fr}
  .hero-stats{gap:1.5rem}
  .preview-body{grid-template-columns:1fr;height:auto}
  .preview-sidebar{display:none}
  nav .nav-links{display:none}
}
</style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-inner">
            <div class="nav-logo">
                <div class="logo-icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M4 11 L14 3 L24 11" stroke="white" stroke-width="2" stroke-linejoin="round" fill="none"/>
                        <rect x="6" y="11" width="16" height="13" rx="1.5" fill="white" fill-opacity="0.25" stroke="white" stroke-width="1.5"/>
                        <rect x="11" y="17" width="6" height="7" rx="1" fill="white"/>
                        <rect x="7.5" y="13" width="4" height="3.5" rx="0.8" fill="white" fill-opacity="0.7"/>
                        <rect x="16.5" y="13" width="4" height="3.5" rx="0.8" fill="white" fill-opacity="0.7"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <span class="logo-primary">SariSari</span>
                    <span class="logo-secondary">Store System</span>
                </div>
            </div>
            <div class="nav-actions">
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-solid">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="welcome-card">
            <div class="welcome-header">
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Here's your store dashboard overview</p>
            </div>

            @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
            @endif
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon">📦</div>
                <div class="card-title">Inventory</div>
                <div class="card-desc">Track every item in real-time</div>
                <div class="card-action">
                    <a href="{{ route('inventory.index') }}">Manage</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">🧾</div>
                <div class="card-title">Sales & POS</div>
                <div class="card-desc">Fast checkout, clear receipts</div>
                <div class="card-action">
                  <!--  <a href="">Process</a> -->
                    <a href="/sales">Process</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">📊</div>
                <div class="card-title">Reports</div>
                <div class="card-desc">Daily, weekly & monthly insights</div>
                <div class="card-action">
                  <!--  <a href="">View</a> -->
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">👥</div>
                <div class="card-title">Accounts</div>
                <div class="card-desc">Multi-user with role control</div>
                <div class="card-action">
                  <!--  <a href="">Configure</a> -->
                </div>
            </div>
        </div>
    </div>
    <script>
// Sticky nav
window.addEventListener('scroll',()=>{
  document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 20);
});

// FAQ toggle
function toggleFaq(el){
  const item = el.parentElement;
  item.classList.toggle('open');
}
</script>
</body>
</html>
