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

<nav id="mainNav">
  <a href="{{ route('welcome') }}" class="nav-logo">Tinda<span>Hub</span></a>
  <div class="nav-links">
    <a href="#features">Features</a>
    <a href="#how">How it works</a>
    <a href="#pricing">Pricing</a>
    <a href="#faq">FAQ</a>
  </div>
  <a href="{{ route('login') }}" class="nav-cta">Get started free →</a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"><div class="hero-grid"></div></div>
  <div class="hero-inner">
    <div class="hero-badge">● Now in Beta — Free for 60 days</div>
    <h1>Run your <em>sari-sari</em><br>store like a pro.</h1>
    <p class="hero-sub">TindaHub gives small Filipino store owners real-time inventory, fast POS checkout, sales reports, and multi-user access — in one simple platform.</p>
    <div class="hero-actions">
      <a href="{{ route('register') }}" class="btn-primary">Start free trial <span>→</span></a>
      <a href="#how" class="btn-outline">See how it works ↓</a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat"><div class="num">2,400+</div><div class="lbl">Stores using TindaHub</div></div>
      <div class="hero-stat"><div class="num">₱1.2B</div><div class="lbl">Sales processed</div></div>
      <div class="hero-stat"><div class="num">4.9★</div><div class="lbl">Average rating</div></div>
    </div>
  </div>
</section>

<!-- DASHBOARD PREVIEW -->
<div class="preview-wrap">
  <div class="preview-frame">
    <div class="preview-toolbar">
      <div class="preview-dots">
        <div class="preview-dot"></div><div class="preview-dot"></div><div class="preview-dot"></div>
      </div>
      <div class="preview-url">tindahub.app/dashboard</div>
    </div>
    <div class="preview-body">
      <div class="preview-sidebar">
        <div class="preview-sidebar-logo">TindaHub</div>
        <div class="preview-nav-item active"><span>▦</span> Dashboard</div>
        <div class="preview-nav-item"><span>📦</span> Inventory</div>
        <div class="preview-nav-item"><span>🧾</span> POS / Sales</div>
        <div class="preview-nav-item"><span>📊</span> Reports</div>
        <div class="preview-nav-item"><span>👥</span> Users</div>
        <div class="preview-nav-item"><span>⚙</span> Settings</div>
      </div>
      <div class="preview-content">
        <div class="preview-kpis">
          <div class="preview-kpi"><div class="k-val">₱8,240</div><div class="k-lbl">Today's sales</div></div>
          <div class="preview-kpi"><div class="k-val">48</div><div class="k-lbl">Products</div></div>
          <div class="preview-kpi"><div class="k-val" style="color:#e8521a">5</div><div class="k-lbl">Low stock</div></div>
          <div class="preview-kpi"><div class="k-val">134</div><div class="k-lbl">Orders today</div></div>
        </div>
        <div class="preview-table">
          <div class="preview-trow">
            <div class="preview-tcell">Product</div>
            <div class="preview-tcell">SKU</div>
            <div class="preview-tcell">Stock</div>
            <div class="preview-tcell">Status</div>
          </div>
          <div class="preview-trow">
            <div class="preview-tcell">Skyflakes Crackers</div>
            <div class="preview-tcell">SKU-001</div>
            <div class="preview-tcell">120</div>
            <div class="preview-tcell"><span class="preview-pill pill-green">In stock</span></div>
          </div>
          <div class="preview-trow">
            <div class="preview-tcell">C2 Green Tea</div>
            <div class="preview-tcell">SKU-002</div>
            <div class="preview-tcell">8</div>
            <div class="preview-tcell"><span class="preview-pill pill-orange">Low stock</span></div>
          </div>
          <div class="preview-trow">
            <div class="preview-tcell">Palmolive Shampoo</div>
            <div class="preview-tcell">SKU-006</div>
            <div class="preview-tcell">0</div>
            <div class="preview-tcell"><span class="preview-pill pill-red">Out of stock</span></div>
          </div>
          <div class="preview-trow">
            <div class="preview-tcell">Lucky Me Canton</div>
            <div class="preview-tcell">SKU-004</div>
            <div class="preview-tcell">3</div>
            <div class="preview-tcell"><span class="preview-pill pill-orange">Low stock</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- PROBLEM / SOLUTION -->
<div class="section" id="features">
  <div class="section-label">The problem</div>
  <div class="section-title">Running a sari-sari store<br>shouldn't be this hard.</div>
  <div class="problem-grid">
    <div class="problem-list">
      <div class="problem-item">
        <div class="problem-icon">📝</div>
        <div><div class="problem-title">Manual notebooks get lost</div><div class="problem-desc">Tracking stock on paper means errors, missing entries, and no way to check history fast.</div></div>
      </div>
      <div class="problem-item">
        <div class="problem-icon">📉</div>
        <div><div class="problem-title">No visibility on slow items</div><div class="problem-desc">You don't know which products are barely selling until you're stuck with expired stock.</div></div>
      </div>
      <div class="problem-item">
        <div class="problem-icon">🤝</div>
        <div><div class="problem-title">Utang (credit) management chaos</div><div class="problem-desc">Tracking who owes you money across multiple customers is a constant headache.</div></div>
      </div>
      <div class="problem-item">
        <div class="problem-icon">🔒</div>
        <div><div class="problem-title">No way to delegate safely</div><div class="problem-desc">You can't trust a helper with access to everything. No roles, no limits.</div></div>
      </div>
    </div>
    <div class="solution-card">
      <div style="font-size:13px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:1.5rem">TindaHub fixes all of this</div>
      <div class="solution-item">
        <div class="solution-check">✓</div>
        <div class="solution-text"><h4>Real-time inventory tracking</h4><p>Every sale auto-deducts stock. Low-stock alerts before you run out.</p></div>
      </div>
      <div class="solution-item">
        <div class="solution-check">✓</div>
        <div class="solution-text"><h4>Smart sales reports</h4><p>Daily, weekly, monthly. Know your best sellers and worst performers instantly.</p></div>
      </div>
      <div class="solution-item">
        <div class="solution-check">✓</div>
        <div class="solution-text"><h4>Utang ledger built-in</h4><p>Record credit per customer, send reminders, track payments.</p></div>
      </div>
      <div class="solution-item">
        <div class="solution-check">✓</div>
        <div class="solution-text"><h4>Role-based access</h4><p>Give helpers cashier access only. You keep full admin control.</p></div>
      </div>
    </div>
  </div>
</div>

<!-- HOW IT WORKS -->
<section class="how-section" id="how">
  <div class="how-inner">
    <div class="section-label" style="text-align:center">Setup in minutes</div>
    <div class="section-title" style="text-align:center">From signup to<br>first sale in 4 steps.</div>
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-icon">🏪</div>
        <div class="step-title">Create your store</div>
        <div class="step-desc">Sign up, name your store, pick your timezone and currency. Takes 60 seconds.</div>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-icon">📦</div>
        <div class="step-title">Add your products</div>
        <div class="step-desc">Import via CSV or add products one-by-one. Set categories, prices, and stock levels.</div>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-icon">🧾</div>
        <div class="step-title">Start selling</div>
        <div class="step-desc">Use the POS screen to ring up sales fast. Stock updates automatically on every transaction.</div>
      </div>
      <div class="step-card">
        <div class="step-num">04</div>
        <div class="step-icon">📊</div>
        <div class="step-title">Track & grow</div>
        <div class="step-desc">Review daily reports, reorder low items, and understand your store's performance at a glance.</div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<div class="section">
  <div class="section-label">Everything you need</div>
  <div class="section-title">Built for Filipino<br>store owners.</div>
  <div class="features-grid">
    <div class="feature-card"><div class="feature-icon">📦</div><div class="feature-title">Inventory Management</div><div class="feature-desc">Track stock in real-time. Auto low-stock alerts. Organize by category. Full product history.</div></div>
    <div class="feature-card"><div class="feature-icon">🧾</div><div class="feature-title">POS / Quick Checkout</div><div class="feature-desc">Tap-to-add items, apply discounts, accept cash or GCash, print or share receipts.</div></div>
    <div class="feature-card"><div class="feature-icon">📊</div><div class="feature-title">Sales Reports</div><div class="feature-desc">Daily, weekly and monthly revenue. Top products. Hours of peak sales. Gross profit.</div></div>
    <div class="feature-card"><div class="feature-icon">🤝</div><div class="feature-title">Utang Ledger</div><div class="feature-desc">Record credit per customer. Track balances. Mark as paid. Send SMS reminders (Pro).</div></div>
    <div class="feature-card"><div class="feature-icon">👥</div><div class="feature-title">Multi-User Access</div><div class="feature-desc">Admin, manager, cashier roles. Each with tailored permissions. Full audit log.</div></div>
    <div class="feature-card"><div class="feature-icon">📱</div><div class="feature-title">Works on Any Device</div><div class="feature-desc">Tablet, phone, laptop. No app to install. Always synced. Works offline too.</div></div>
  </div>
</div>

<!-- SOCIAL PROOF -->
<section class="social-section">
  <div class="social-inner">
    <div class="section-label" style="color:rgba(255,255,255,.4)">Trusted by store owners</div>
    <div class="section-title" style="color:white">What real owners say.</div>
    <div class="testimonials">
      <div class="testimonial">
        <div class="stars">★★★★★</div>
        <div class="testimonial-text">"Noon manual talaga lahat. Ngayon, alam ko na agad kung alin yung kulang bago pa maubusan. Nakatipid ako ng malaki."</div>
        <div class="testimonial-author"><div class="testimonial-avatar">M</div><div><div class="testimonial-name">Maria Santos</div><div class="testimonial-role">Store owner, Quezon City</div></div></div>
      </div>
      <div class="testimonial">
        <div class="stars">★★★★★</div>
        <div class="testimonial-text">"My helper can now handle the counter without me worrying about cash leaks. The cashier role is perfect for my setup."</div>
        <div class="testimonial-author"><div class="testimonial-avatar">R</div><div><div class="testimonial-name">Ronaldo Cruz</div><div class="testimonial-role">Store owner, Cebu City</div></div></div>
      </div>
      <div class="testimonial">
        <div class="stars">★★★★★</div>
        <div class="testimonial-text">"The utang tracker saved my relationships with customers AND my cash flow. Now I actually collect what I'm owed."</div>
        <div class="testimonial-author"><div class="testimonial-avatar">L</div><div><div class="testimonial-name">Liza Reyes</div><div class="testimonial-role">Store owner, Davao City</div></div></div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<div class="section" id="pricing" style="text-align:center">
  <div class="section-label">Pricing</div>
  <div class="section-title">Simple, honest pricing.</div>
  <p style="color:var(--text2);max-width:500px;margin:.75rem auto 0;font-size:15px">No contracts. Cancel anytime. First 60 days free on any plan.</p>
  <div class="pricing-grid" style="text-align:left">
    <div class="pricing-card">
      <div class="pricing-name">Starter</div>
      <div class="pricing-price"><sup>₱</sup>0</div>
      <div class="pricing-period">Free forever</div>
      <ul class="pricing-features">
        <li>Up to 50 products</li>
        <li>1 user account</li>
        <li>Basic sales reports</li>
        <li>Inventory tracking</li>
        <li>Email support</li>
      </ul>
      <a href="{{ route('register') }}" class="btn-pricing outline">Get started free</a>
    </div>
    <div class="pricing-card featured">
      <div class="pricing-badge">Most popular</div>
      <div class="pricing-name" style="color:rgba(255,255,255,.6)">Pro</div>
      <div class="pricing-price"><sup>₱</sup>499</div>
      <div class="pricing-period">per month</div>
      <ul class="pricing-features">
        <li>Unlimited products</li>
        <li>Up to 5 users + roles</li>
        <li>Advanced reports + export</li>
        <li>Utang ledger</li>
        <li>Low-stock alerts (SMS)</li>
        <li>Priority support</li>
      </ul>
      <a href="{{ route('register') }}" class="btn-pricing light">Start 60-day free trial</a>
    </div>
    <div class="pricing-card">
      <div class="pricing-name">Business</div>
      <div class="pricing-price"><sup>₱</sup>999</div>
      <div class="pricing-period">per month</div>
      <ul class="pricing-features">
        <li>Everything in Pro</li>
        <li>Unlimited users</li>
        <li>Multi-branch support</li>
        <li>Custom categories</li>
        <li>API access</li>
        <li>Dedicated onboarding</li>
      </ul>
      <a href="{{ route('register') }}" class="btn-pricing dark">Get started</a>
    </div>
  </div>
</div>

<!-- FAQ -->
<div class="section" id="faq" style="text-align:center;max-width:1100px">
  <div class="section-label">FAQ</div>
  <div class="section-title">Common questions.</div>
  <div class="faq-list" style="text-align:left">
    <div class="faq-item open">
      <div class="faq-q" onclick="toggleFaq(this)">Do I need technical knowledge to use TindaHub? <span class="arrow">+</span></div>
      <div class="faq-a">No. TindaHub is designed for store owners, not IT people. If you can use Facebook, you can use TindaHub. Setup takes less than 5 minutes.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Can I use it on my phone or tablet? <span class="arrow">+</span></div>
      <div class="faq-a">Yes. TindaHub works on any device with a browser — phone, tablet, or laptop. No app download needed. Your data syncs instantly across all devices.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">What happens to my data if I cancel? <span class="arrow">+</span></div>
      <div class="faq-a">You can export all your data as CSV or PDF before cancelling. We retain your data for 30 days after cancellation in case you change your mind.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Is there a free trial? <span class="arrow">+</span></div>
      <div class="faq-a">Yes — all paid plans come with a 60-day free trial. No credit card required to start. You only need to pay when your trial ends.</div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">Can my helper use it without seeing my profits? <span class="arrow">+</span></div>
      <div class="faq-a">Absolutely. The Cashier role lets staff ring up sales and check product availability — but they cannot see reports, revenue data, or manage inventory. You control what they see.</div>
    </div>
  </div>
</div>

<!-- CTA BANNER -->
<div class="cta-banner">
  <h2>Ready to modernize<br>your sari-sari store?</h2>
  <p>Join 2,400+ store owners already using TindaHub. Free for 60 days.</p>
  <a href="{{ route('register') }}" class="btn-white">Create your free account →</a>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div>
        <div class="footer-brand">Tinda<span>Hub</span></div>
        <div class="footer-tagline">The smart inventory and POS system built for Filipino sari-sari store owners.</div>
      </div>
      <div class="footer-col">
        <h4>Product</h4>
        <a href="#">Inventory</a>
        <a href="#">POS</a>
        <a href="#">Reports</a>
        <a href="#">Utang Ledger</a>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <a href="#">About</a>
        <a href="#">Blog</a>
        <a href="#">Careers</a>
        <a href="#">Contact</a>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
        <a href="#">Cookie Policy</a>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-copy">© 2025 TindaHub. Built with ❤️ in the Philippines.</div>
      <div class="footer-copy">Made for sari-sari stores everywhere.</div>
    </div>
  </div>
</footer>

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