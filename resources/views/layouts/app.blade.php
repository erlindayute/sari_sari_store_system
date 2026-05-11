<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'TindaHub') — @auth{{ auth()->user()->store->name ?? 'TindaHub' }}@endauth</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
<style>
/* ════ RESET & TOKENS ════ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#0e0d0b;--paper:#faf8f4;--warm:#f5f0e8;
  --accent:#e8521a;--accent-dk:#b53d10;
  --green:#1d9e75;--green-bg:#e1f5ee;--green-txt:#0f6e56;
  --amber:#ef9f27;--amber-bg:#faeeda;--amber-txt:#854f0b;
  --red:#e24b4a;--red-bg:#fcebeb;--red-txt:#a32d2d;
  --blue:#3b82f6;--blue-bg:#eff6ff;--blue-txt:#1d4ed8;
  --border:rgba(14,13,11,.09);--border-md:rgba(14,13,11,.16);
  --text2:#5c5852;--text3:#9c9890;
  --sw:220px;--th:56px;--r:10px;--r-lg:14px;
  --shadow:0 2px 12px rgba(14,13,11,.07);
  --shadow-lg:0 8px 32px rgba(14,13,11,.12);
}
html,body{height:100%;font-family:'DM Sans',sans-serif;background:var(--paper);color:var(--ink);font-size:14px;line-height:1.5}
 
/* ════ LAYOUT ════ */
.app{display:flex;height:100vh;overflow:hidden}
 
/* Sidebar */
.sidebar{width:var(--sw);background:var(--ink);display:flex;flex-direction:column;flex-shrink:0;overflow-y:auto;z-index:50;transition:transform .25s}
.s-logo{padding:1.2rem 1.1rem 1rem;font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:white;border-bottom:1px solid rgba(255,255,255,.07);display:flex;align-items:center;gap:8px}
.s-logo-mark{width:28px;height:28px;background:var(--accent);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.s-logo span{color:var(--accent)}
.s-store{padding:.55rem 1.1rem;font-size:11px;color:rgba(255,255,255,.3);border-bottom:1px solid rgba(255,255,255,.05);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.s-nav{padding:.75rem .6rem;flex:1}
.s-section{font-size:10px;text-transform:uppercase;letter-spacing:.8px;color:rgba(255,255,255,.2);padding:.55rem .6rem .2rem;margin-top:.35rem}
.s-item{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:8px;cursor:pointer;transition:all .15s;color:rgba(255,255,255,.45);font-size:13px;text-decoration:none;user-select:none}
.s-item:hover{background:rgba(255,255,255,.07);color:rgba(255,255,255,.85)}
.s-item.active{background:var(--accent);color:white}
.s-icon{width:18px;text-align:center;font-size:15px;flex-shrink:0}
.s-badge{margin-left:auto;font-size:9px;padding:2px 6px;border-radius:10px;font-weight:700;min-width:18px;text-align:center;background:var(--amber);color:white}
.s-badge.red{background:var(--red)}
.s-divider{height:1px;background:rgba(255,255,255,.06);margin:.4rem .6rem}
.s-bottom{padding:.75rem .6rem 1rem;border-top:1px solid rgba(255,255,255,.07)}
.s-user{display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:8px;cursor:pointer;transition:all .15s;text-decoration:none}
.s-user:hover{background:rgba(255,255,255,.07)}
.s-avatar{width:30px;height:30px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:white;flex-shrink:0}
.s-uname{font-size:12px;font-weight:500;color:rgba(255,255,255,.85);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.s-urole{font-size:10px;color:rgba(255,255,255,.3);text-transform:capitalize}
 
/* Mobile sidebar */
.s-overlay{display:none;position:fixed;inset:0;background:rgba(14,13,11,.5);z-index:49;backdrop-filter:blur(2px)}
@media(max-width:768px){
  .sidebar{position:fixed;top:0;left:0;bottom:0;transform:translateX(-100%)}
  .sidebar.open{transform:none}
  .s-overlay.open{display:block}
  .mob-menu{display:flex!important}
}
 
/* Main */
.main{flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0}
.topbar{height:var(--th);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 1.5rem;gap:.75rem;flex-shrink:0;background:white}
.mob-menu{display:none;width:34px;height:34px;border-radius:8px;border:1px solid var(--border);background:transparent;cursor:pointer;align-items:center;justify-content:center;font-size:18px;color:var(--ink)}
.tb-title{font-size:15px;font-weight:500;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.tb-actions{display:flex;align-items:center;gap:.5rem;flex-shrink:0}
.icon-btn{width:34px;height:34px;border-radius:8px;border:1px solid var(--border);background:white;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;transition:all .15s;position:relative;text-decoration:none}
.icon-btn:hover{background:var(--paper);border-color:var(--border-md)}
.notif-dot{position:absolute;top:5px;right:5px;width:7px;height:7px;background:var(--red);border-radius:50%;border:1.5px solid white}
.content{flex:1;overflow-y:auto;padding:1.5rem;scroll-behavior:smooth}
 
/* ════ COMPONENTS ════ */
/* Buttons */
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;font-size:13px;font-weight:500;font-family:'DM Sans',sans-serif;cursor:pointer;border:none;text-decoration:none;transition:all .15s;line-height:1}
.btn-primary{background:var(--ink);color:white}.btn-primary:hover{background:var(--accent)}
.btn-secondary{background:white;color:var(--text2);border:1px solid var(--border)}.btn-secondary:hover{border-color:var(--ink);color:var(--ink)}
.btn-success{background:var(--green);color:white}.btn-success:hover{background:var(--green-txt)}
.btn-danger{background:var(--red-bg);color:var(--red-txt);border:1px solid #f0b4b4}.btn-danger:hover{background:#f0b4b4}
.btn-ghost{background:transparent;color:var(--text2);border:1px solid transparent}.btn-ghost:hover{background:var(--paper);border-color:var(--border)}
.btn-sm{padding:6px 11px;font-size:12px}.btn-xs{padding:4px 9px;font-size:11px;border-radius:6px}
.btn-icon{padding:7px;width:30px;height:30px;justify-content:center;border-radius:7px}
.btn:disabled{opacity:.5;cursor:not-allowed;pointer-events:none}
 
/* Cards */
.card{background:white;border:1px solid var(--border);border-radius:var(--r);overflow:hidden}
.card-hd{display:flex;align-items:center;justify-content:space-between;padding:.85rem 1.25rem;border-bottom:1px solid var(--border)}
.card-title{font-size:13px;font-weight:600}
.card-body{padding:1.25rem}
.pill{font-size:12px;color:var(--text2);background:var(--paper);padding:3px 9px;border-radius:20px;border:1px solid var(--border)}
 
/* KPI Cards */
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem}
.kpi{background:white;border:1px solid var(--border);border-radius:var(--r);padding:1.1rem 1.25rem;position:relative;overflow:hidden;transition:all .2s;cursor:default}
.kpi:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg)}
.kpi-bar{position:absolute;bottom:0;left:0;right:0;height:3px}
.kpi-g .kpi-bar{background:var(--green)}.kpi-a .kpi-bar{background:var(--amber)}
.kpi-r .kpi-bar{background:var(--red)}.kpi-b .kpi-bar{background:var(--blue)}
.kpi-ico{position:absolute;top:.85rem;right:1rem;font-size:22px;opacity:.12}
.kpi-lbl{font-size:11px;text-transform:uppercase;letter-spacing:.6px;color:var(--text3);margin-bottom:.4rem}
.kpi-val{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;line-height:1;margin-bottom:.25rem}
.kpi-sub{font-size:12px;color:var(--text3)}
.kpi-sub.up{color:var(--green)}.kpi-sub.dn{color:var(--red)}
 
/* Tables */
.tbl-scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse}
thead th{padding:9px 12px;text-align:left;font-size:11px;font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:.6px;background:var(--paper);border-bottom:1px solid var(--border);white-space:nowrap}
.th-c{text-align:center}
tbody tr{border-bottom:1px solid var(--border);transition:background .1s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:#fafaf6}
td{padding:10px 12px;font-size:13px;vertical-align:middle}
.td-c{text-align:center}.td-mut{color:var(--text2)}.td-mono{font-family:'Courier New',monospace;font-size:11px}
 
/* Badges */
.badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:500;white-space:nowrap}
.b-in {background:var(--green-bg);color:var(--green-txt)}
.b-low{background:var(--amber-bg);color:var(--amber-txt)}
.b-out{background:var(--red-bg);color:var(--red-txt)}
.b-cat{background:var(--paper);color:var(--text2);border:1px solid var(--border)}
.b-paid{background:var(--green-bg);color:var(--green-txt)}
.b-part{background:var(--amber-bg);color:var(--amber-txt)}
.b-owed{background:var(--red-bg);color:var(--red-txt)}
.b-owner{background:#fef3c7;color:#92400e}
.b-admin{background:#ede9fe;color:#5b21b6}
.b-mgr{background:#dcfce7;color:#166534}
.b-cash{background:#e0f2fe;color:#075985}
.b-pend{background:var(--paper);color:var(--text3);border:1px solid var(--border)}
.b-active{background:var(--green-bg);color:var(--green-txt)}
 
/* Stock bar */
.stock-cell{display:flex;align-items:center;gap:7px}
.stock-bar{width:42px;height:5px;background:var(--paper);border-radius:3px;overflow:hidden;flex-shrink:0;border:1px solid var(--border)}
.stock-fill{height:100%;border-radius:3px}
 
/* Filters */
.filter-bar{display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.25rem;align-items:center}
.fi{padding:7px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;background:white;color:var(--ink);font-family:'DM Sans',sans-serif;outline:none;transition:border-color .15s}
.fi:focus{border-color:var(--ink)}
.fi-search{padding-left:32px;background-image:url("data:image/svg+xml,%3Csvg width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239c9890' stroke-width='2.5' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:10px center}
.toggle-lbl{display:flex;align-items:center;gap:7px;font-size:13px;color:var(--text2);cursor:pointer;user-select:none}
.toggle-cb{display:none}
.toggle-track{width:34px;height:18px;background:var(--border-md);border-radius:9px;position:relative;transition:background .2s;flex-shrink:0}
.toggle-cb:checked+.toggle-track{background:var(--green)}
.toggle-track::after{content:'';position:absolute;width:14px;height:14px;background:white;border-radius:50%;top:2px;left:2px;transition:left .18s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
.toggle-cb:checked+.toggle-track::after{left:18px}
 
/* Modal */
.overlay{position:fixed;inset:0;background:rgba(14,13,11,.45);z-index:200;display:none;align-items:flex-end;justify-content:center;backdrop-filter:blur(3px)}
.overlay.open{display:flex;animation:fadeIn .2s}
@media(min-width:600px){.overlay{align-items:center}}
.modal{background:white;border-radius:var(--r-lg) var(--r-lg) 0 0;width:100%;max-width:520px;max-height:92vh;overflow-y:auto;padding:1.75rem;animation:slideUp .22s ease}
@media(min-width:600px){.modal{border-radius:var(--r-lg)}}
.modal-wide{max-width:680px}
.modal-hd{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.modal-title{font-size:15px;font-weight:600}
.modal-close{background:none;border:none;font-size:22px;cursor:pointer;color:var(--text3);line-height:1;padding:2px 4px;border-radius:6px;transition:all .15s}
.modal-close:hover{background:var(--paper);color:var(--ink)}
.modal-footer{display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid var(--border)}
@keyframes slideUp{from{transform:translateY(18px);opacity:0}to{transform:none;opacity:1}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
 
/* Form */
.fg{margin-bottom:1.1rem}
.fl{display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--text2);margin-bottom:5px}
.fc{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--ink);background:var(--paper);font-family:'DM Sans',sans-serif;outline:none;transition:border-color .15s,box-shadow .15s}
.fc:focus{border-color:var(--ink);box-shadow:0 0 0 3px rgba(14,13,11,.05);background:white}
.fc.err{border-color:var(--red)!important}
.fhelp{font-size:11px;color:var(--text3);margin-top:4px}
.frow{display:grid;grid-template-columns:1fr 1fr;gap:.9rem}
.frow.f3{grid-template-columns:1fr 1fr 1fr}
.ferr-msg{font-size:12px;color:var(--red-txt);margin-top:4px}
 
/* Page header */
.pg-hd{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.5rem;gap:1rem;flex-wrap:wrap}
.pg-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;letter-spacing:-.5px;line-height:1.2}
.pg-sub{font-size:13px;color:var(--text2);margin-top:3px}
.pg-actions{display:flex;gap:.6rem;align-items:center;flex-shrink:0}
 
/* Flash alerts */
.flash{display:flex;align-items:flex-start;gap:.6rem;padding:.75rem 1rem;border-radius:8px;font-size:13px;margin-bottom:1.25rem}
.flash-success{background:var(--green-bg);border:1px solid #9fe1cb;color:var(--green-txt)}
.flash-error{background:var(--red-bg);border:1px solid #f0b4b4;color:var(--red-txt)}
.flash-warn{background:var(--amber-bg);border:1px solid #f0d08e;color:var(--amber-txt)}
 
/* Empty state */
.empty{text-align:center;padding:3rem 2rem}
.empty-ico{font-size:44px;margin-bottom:.9rem;opacity:.4;display:block}
.empty-title{font-size:15px;font-weight:500;margin-bottom:.4rem}
.empty-desc{font-size:13px;color:var(--text2);max-width:280px;margin:0 auto 1.5rem;line-height:1.7}
 
/* Charts */
.chart-wrap{padding:1rem 1.25rem .75rem}
.chart-bars{display:flex;align-items:flex-end;gap:6px}
.c-bar{flex:1;border-radius:5px 5px 0 0;min-height:4px;transition:opacity .15s;position:relative;cursor:pointer}
.c-bar:hover{opacity:.75}
.c-bar .tip{position:absolute;bottom:calc(100% + 4px);left:50%;transform:translateX(-50%);background:var(--ink);color:white;font-size:10px;padding:3px 7px;border-radius:5px;white-space:nowrap;display:none;pointer-events:none;z-index:10}
.c-bar:hover .tip{display:block}
.c-labels{display:flex;gap:6px;padding:5px 0 .25rem;border-top:1px solid var(--border);margin-top:2px}
.c-labels span{flex:1;text-align:center;font-size:10px;color:var(--text3)}
 
/* Activity */
.act-item{display:flex;gap:.9rem;align-items:flex-start;padding:.65rem 0;border-bottom:1px solid var(--border)}
.act-item:last-child{border:none}
.act-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px}
.act-text{flex:1;font-size:12px;line-height:1.5}
.act-time{font-size:11px;color:var(--text3);white-space:nowrap;flex-shrink:0;margin-top:3px}
 
/* Responsive */
@media(max-width:1100px){.kpi-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){.kpi-grid{grid-template-columns:repeat(2,1fr)}.content{padding:1rem}.frow{grid-template-columns:1fr}}
</style>
@stack('styles')
</head>
<body>
 
<div class="s-overlay" id="sOverlay" onclick="closeSidebar()"></div>
 
<div class="app">
  <!-- ══ SIDEBAR ══ -->
  <aside class="sidebar" id="sidebar">
    <div class="s-logo">
      <div class="s-logo-mark">🏪</div>
      Tinda<span>Hub</span>
    </div>
    <div class="s-store">{{ auth()->user()->store->name ?? 'My Store' }}</div>
    <nav class="s-nav">
      <div class="s-section">Overview</div>
      <a class="s-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <span class="s-icon">▦</span> Dashboard
      </a>
 
      @if(auth()->user()->can_access('inventory'))
      <div class="s-section">Store</div>
      <a class="s-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
        <span class="s-icon">📦</span> Inventory
        @php $lowCount = \App\Models\Product::forStore(auth()->user()->store_id)->whereIn('status',['low','out'])->count() @endphp
        @if($lowCount > 0)
          <span class="s-badge red">{{ $lowCount }}</span>
        @endif
      </a>
      @endif
 
      <a class="s-item {{ request()->routeIs('pos.*') ? 'active' : '' }}" href="{{ route('pos.index') }}">
        <span class="s-icon">🧾</span> POS / Sales
      </a>
 
      @if(auth()->user()->can_access('reports'))
      <div class="s-section">Analytics</div>
      <a class="s-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
        <span class="s-icon">📊</span> Reports
      </a>
      @endif
 
      @if(auth()->user()->can_access('utang'))
      <a class="s-item {{ request()->routeIs('utang.*') ? 'active' : '' }}" href="{{ route('utang.index') }}">
        <span class="s-icon">🤝</span> Utang
        @php $utangOwed = \App\Models\UtangEntry::where('store_id',auth()->user()->store_id)->where('status','!=','paid')->count() @endphp
        @if($utangOwed > 0)<span class="s-badge">{{ $utangOwed }}</span>@endif
      </a>
      @endif
 
      <div class="s-divider"></div>
 
      @if(auth()->user()->can_access('users'))
      <a class="s-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
        <span class="s-icon">👥</span> Team
      </a>
      @endif
 
      @if(auth()->user()->can_access('settings'))
      <a class="s-item {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
        <span class="s-icon">⚙</span> Settings
      </a>
      @endif
    </nav>
    <div class="s-bottom">
      <a class="s-user" href="{{ route('settings.index') }}">
        <div class="s-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
        <div style="overflow:hidden">
          <div class="s-uname">{{ auth()->user()->name }}</div>
          <div class="s-urole">{{ auth()->user()->role }}</div>
        </div>
      </a>
    </div>
  </aside>
 
  <!-- ══ MAIN ══ -->
  <div class="main">
    <div class="topbar">
      <button class="mob-menu" onclick="openSidebar()">☰</button>
      <div class="tb-title">@yield('topbar-title', 'Dashboard')</div>
      <div class="tb-actions">
        <a href="{{ route('pos.index') }}" class="btn btn-secondary btn-sm" style="gap:5px">
          <span>🧾</span><span>New sale</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
          @csrf
          <button type="submit" class="icon-btn" title="Sign out">🚪</button>
        </form>
      </div>
    </div>
 
    <div class="content">
      {{-- Flash messages --}}
      @if(session('success'))
        <div class="flash flash-success">✓ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="flash flash-error">⚠ {{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="flash flash-error">
          <div>
            @foreach($errors->all() as $error)
              <div>⚠ {{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif
 
      @yield('content')
    </div>
  </div>
</div>
 
{{-- Modals slot --}}
@stack('modals')
 
<script>
function openSidebar(){document.getElementById('sidebar').classList.add('open');document.getElementById('sOverlay').classList.add('open')}
function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sOverlay').classList.remove('open')}
function openModal(id){document.getElementById(id).classList.add('open')}
function closeModal(id){document.getElementById(id).classList.remove('open')}
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.querySelectorAll('.overlay.open').forEach(m=>m.classList.remove('open'))});
 
// Chart helper
function buildChart(id, data, labels, color='#1d9e75', height='160px'){
  const el=document.getElementById(id); if(!el)return;
  const max=Math.max(...data,1);
  el.style.height=height;
  el.innerHTML=data.map((v,i)=>{
    const h=Math.round(v/max*100);
    const c=Array.isArray(color)?color[i]:color;
    const lbl=labels?labels[i]:'';
    return `<div class="c-bar" style="height:${h}%;background:${c};opacity:${.5+i*(.5/Math.max(data.length-1,1))}" title="${lbl}: ${v}"><span class="tip">${lbl}: ₱${Number(v).toLocaleString()}</span></div>`;
  }).join('');
}
</script>
@stack('scripts')
</body>
</html>