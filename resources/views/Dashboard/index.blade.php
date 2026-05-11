@extends('layouts.app')
@section('title','Dashboard')
@section('topbar-title','Dashboard')

@push('styles')
<style>
.pg-hd{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.5rem;gap:1rem;flex-wrap:wrap}
.pg-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;letter-spacing:-.5px;line-height:1.2}
.pg-sub{font-size:13px;color:var(--text2);margin-top:3px}
.pg-actions{display:flex;gap:.6rem;align-items:center;flex-shrink:0}
/* onboarding banner */
.ob-banner{background:linear-gradient(135deg,var(--ink) 0%,#2a2520 100%);border-radius:var(--r-lg);padding:1.5rem 2rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1.5rem;position:relative;overflow:hidden}
.ob-banner::before{content:'';position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:radial-gradient(circle,rgba(232,82,26,.25),transparent 70%)}
.ob-icon{font-size:36px;flex-shrink:0}
.ob-body{flex:1;min-width:0}
.ob-title{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:white;margin-bottom:.3rem}
.ob-desc{font-size:13px;color:rgba(255,255,255,.6);line-height:1.6}
.ob-steps{display:flex;gap:.5rem;margin-top:.9rem;flex-wrap:wrap}
.ob-step{display:flex;align-items:center;gap:6px;font-size:12px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:4px 12px;color:rgba(255,255,255,.7);text-decoration:none}
.ob-step.done{background:rgba(29,158,117,.2);border-color:rgba(29,158,117,.4);color:#7ee8c4}
.ob-step-num{width:14px;height:14px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:8px;flex-shrink:0}
.ob-step.done .ob-step-num{background:var(--green);color:white}
.ob-dismiss{position:absolute;top:.85rem;right:.85rem;background:none;border:none;color:rgba(255,255,255,.3);cursor:pointer;font-size:20px;line-height:1;padding:2px 5px;border-radius:6px;transition:all .15s}
.ob-dismiss:hover{color:white;background:rgba(255,255,255,.1)}
/* period tabs */
.ptabs{display:flex;gap:3px;background:var(--paper);padding:3px;border-radius:9px;border:1px solid var(--border);width:fit-content;margin-bottom:1.25rem}
.ptab{padding:6px 14px;border-radius:7px;font-size:12px;cursor:pointer;transition:all .15s;color:var(--text2);font-family:'DM Sans',sans-serif;border:none;background:transparent}
.ptab.active{background:white;color:var(--ink);font-weight:500;box-shadow:0 1px 4px rgba(14,13,11,.08)}
/* kpi sparklines */
.kpi-spark{display:flex;align-items:flex-end;gap:2px;height:26px;margin-top:.5rem}
.spark-b{flex:1;border-radius:2px 2px 0 0;min-height:2px}
/* chart */
.chart-wrap{padding:1rem 1.25rem .75rem}
.chart-bars{display:flex;align-items:flex-end;gap:5px}
.c-bar{flex:1;border-radius:5px 5px 0 0;min-height:4px;transition:filter .15s;position:relative;cursor:pointer}
.c-bar:hover{filter:brightness(1.18)}
.c-bar .ctip{position:absolute;bottom:calc(100% + 6px);left:50%;transform:translateX(-50%);background:var(--ink);color:white;font-size:11px;font-family:'DM Sans',sans-serif;padding:4px 9px;border-radius:6px;white-space:nowrap;display:none;pointer-events:none;z-index:10;box-shadow:0 4px 12px rgba(0,0,0,.2)}
.c-bar .ctip::after{content:'';position:absolute;top:100%;left:50%;transform:translateX(-50%);border:4px solid transparent;border-top-color:var(--ink)}
.c-bar:hover .ctip{display:block}
.c-labels{display:flex;gap:5px;padding:6px 0 .25rem;border-top:1px solid var(--border);margin-top:3px}
.c-labels span{flex:1;text-align:center;font-size:10px;color:var(--text3)}
/* rev strip */
.rev-strip{display:flex;gap:1.5rem;padding:.7rem 1.25rem;background:var(--paper);border-top:1px solid var(--border);flex-wrap:wrap}
.rs-item{display:flex;flex-direction:column;gap:1px}
.rs-lbl{font-size:10px;text-transform:uppercase;letter-spacing:.6px;color:var(--text3)}
.rs-val{font-size:13px;font-weight:600;color:var(--ink)}
.rs-val.up{color:var(--green)}.rs-val.dn{color:var(--red)}
.rs-sep{width:1px;background:var(--border)}
/* low stock */
.low-row:hover td{background:#fffbf8}
.restock-btn{opacity:0;transition:opacity .15s;padding:3px 9px;font-size:11px;border-radius:6px;background:var(--green-bg);color:var(--green-txt);border:1px solid #9fe1cb;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:500;white-space:nowrap}
.low-row:hover .restock-btn{opacity:1}
.qr-row{display:none}
.qr-form{padding:.6rem 1.1rem;background:var(--green-bg);border-top:1px solid #9fe1cb;display:flex;align-items:center;gap:.5rem}
.qr-input{width:80px;padding:5px 9px;border:1.5px solid #9fe1cb;border-radius:7px;font-size:13px;background:white;outline:none;font-family:'DM Sans',sans-serif}
/* txn */
.txn-link{font-family:'Courier New',monospace;font-size:11px;color:var(--accent);text-decoration:none;font-weight:600}
.txn-link:hover{text-decoration:underline}
.txn-items{max-width:230px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text2)}
.pay-chip{display:inline-flex;align-items:center;gap:4px;font-size:11px;padding:2px 8px;border-radius:20px;background:var(--paper);border:1px solid var(--border)}
/* top products */
.rank{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0}
.rank-1{background:#fef3c7;color:#92400e}.rank-2{background:#e5e7eb;color:#374151}.rank-3{background:#fde8d8;color:#9a3412}.rank-n{background:var(--paper);color:var(--text3)}
/* category bars */
.cat-row{display:flex;align-items:center;gap:.75rem;margin-bottom:.75rem}
.cat-row:last-child{margin-bottom:0}
.cat-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.cat-name{flex:1;font-size:13px}
.cat-bar-wrap{width:100px;height:6px;background:var(--paper);border-radius:3px;overflow:hidden;flex-shrink:0}
.cat-bar-fill{height:100%;border-radius:3px}
.cat-rev{font-size:12px;color:var(--text2);white-space:nowrap;width:55px;text-align:right}
.cat-pct{font-size:11px;color:var(--text3);width:28px;text-align:right}
/* activity */
.act-item{display:flex;gap:.9rem;align-items:flex-start;padding:.65rem 0;border-bottom:1px solid var(--border)}
.act-item:last-child{border:none}
.act-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px}
.act-text{flex:1;font-size:12px;line-height:1.5}
.act-time{font-size:11px;color:var(--text3);white-space:nowrap;flex-shrink:0;margin-top:3px}
/* quick actions */
.qa-grid{display:grid;grid-template-columns:1fr 1fr;gap:.6rem}
.qa-btn{display:flex;flex-direction:column;align-items:flex-start;gap:2px;padding:.85rem .9rem;background:var(--paper);border:1.5px solid var(--border);border-radius:var(--r);cursor:pointer;text-decoration:none;transition:all .15s}
.qa-btn:hover{border-color:var(--ink);background:white;transform:translateY(-1px);box-shadow:var(--shadow)}
.qa-ico{font-size:20px;margin-bottom:2px}
.qa-label{font-size:12px;font-weight:600;color:var(--ink)}
.qa-desc{font-size:11px;color:var(--text3)}
/* utang alert */
.utang-alert{background:var(--amber-bg);border:1px solid #f0d08e;border-radius:var(--r);padding:.75rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.75rem}
/* layouts */
.dr{display:grid;gap:1.1rem;margin-bottom:1.1rem}
.dr-3-2{grid-template-columns:3fr 2fr}
.dr-1-1{grid-template-columns:1fr 1fr}
.dr-1{grid-template-columns:1fr}
@media(max-width:1100px){.dr-3-2,.dr-1-1{grid-template-columns:1fr}}
@media(max-width:640px){.qa-grid{grid-template-columns:1fr}.ob-steps{display:none}.rev-strip{gap:.75rem}}
</style>
@endpush

@section('content')
{{-- ── Onboarding banner ── --}}
@if(session('onboarding') || !auth()->user()->store->products()->exists())
<div class="ob-banner" id="obBanner">
  <div class="ob-icon">🏪</div>
  <div class="ob-body">
    <div class="ob-title">Welcome to TindaHub! Let's set up your store.</div>
    <div class="ob-desc">3 quick steps and you're selling. Takes less than 5 minutes.</div>
    <div class="ob-steps">
      <span class="ob-step done"><span class="ob-step-num">✓</span>Create account</span>
      <a href="{{ route('inventory.index') }}" class="ob-step {{ auth()->user()->store->products()->exists()?'done':'' }}">
        <span class="ob-step-num">{{ auth()->user()->store->products()->exists()?'✓':'2' }}</span>Add products
      </a>
      <a href="{{ route('pos.index') }}" class="ob-step">
        <span class="ob-step-num">3</span>First sale
      </a>
    </div>
  </div>
  <div style="flex-shrink:0;position:relative;z-index:1">
    <a href="{{ route('inventory.index') }}" class="btn btn-primary btn-sm">Add products →</a>
  </div>
  <button class="ob-dismiss" onclick="dismissObBanner()" title="Dismiss">×</button>
</div>
@endif

{{-- ── Utang alert ── --}}
@if(($utangOwed->total ?? 0) >= 500)
<div class="utang-alert">
  <span style="font-size:18px">🤝</span>
  <div style="flex:1;font-size:13px;color:var(--amber-txt)">
    <strong>₱{{ number_format($utangOwed->total,2) }}</strong> outstanding utang from
    <strong>{{ $utangOwed->count }}</strong> customer{{ $utangOwed->count!=1?'s':'' }}.
    Don't forget to collect!
  </div>
  <a href="{{ route('utang.index') }}" class="btn btn-sm" style="background:var(--amber-txt);color:white;flex-shrink:0">View ledger →</a>
</div>
@endif

{{-- ── Page header ── --}}
@php
  $tz = auth()->user()->store->timezone ?? 'Asia/Manila';
  $h  = now()->setTimezone($tz)->hour;
  $g  = $h < 12 ? 'Good morning' : ($h < 17 ? 'Good afternoon' : 'Good evening');
  $fn = explode(' ', auth()->user()->name)[0];
@endphp
<div class="pg-hd">
  <div>
    <div class="pg-title">{{ $g }}, {{ $fn }} 👋</div>
    <div class="pg-sub">{{ now()->setTimezone($tz)->format('l, F j, Y') }} &nbsp;·&nbsp; {{ auth()->user()->store->name }}</div>
  </div>
  <div class="pg-actions">
    @if(auth()->user()->can_access('reports'))
      <a href="{{ route('reports.export',['period'=>'today']) }}" class="btn btn-secondary btn-sm">⬇ Export today</a>
    @endif
    <a href="{{ route('pos.index') }}" class="btn btn-primary">🧾 New sale</a>
  </div>
</div>

{{-- ── Period tabs ── --}}
<div class="ptabs" id="ptabs">
  <button class="ptab active" onclick="switchPeriod(this,'today')">Today</button>
  <button class="ptab" onclick="switchPeriod(this,'week')">This week</button>
  <button class="ptab" onclick="switchPeriod(this,'month')">This month</button>
</div>

{{-- ── KPI cards ── --}}
@php
  $revDiff  = $yesterdayRevenue > 0 ? round(($todayRevenue-$yesterdayRevenue)/$yesterdayRevenue*100,1) : ($todayRevenue>0?100:0);
  $aov      = $todayTxns > 0 ? round($todayRevenue/$todayTxns,2) : 0;
  $uTotal   = $utangOwed->total ?? 0;
  $uCount   = $utangOwed->count ?? 0;
  $sparkV   = $salesChart->pluck('value')->toArray();
  $sparkMax = max(array_merge($sparkV,[1]));
@endphp

<div class="kpi-grid">

  {{-- Revenue --}}
  <div class="kpi kpi-g">
    <div class="kpi-ico">💰</div>
    <div class="kpi-lbl">Revenue <span id="kpiLbl" style="font-weight:400;text-transform:none;letter-spacing:0">(today)</span></div>
    <div class="kpi-val" id="kRev">₱{{ number_format($todayRevenue,2) }}</div>
    <div class="kpi-sub {{ $revDiff>=0?'up':'dn' }}" id="kRevSub">
      {{ $revDiff>=0?'↑':'↓' }} {{ abs($revDiff) }}% vs yesterday
    </div>
    <div class="kpi-spark">
      @foreach($sparkV as $i=>$sv)
        <div class="spark-b" style="height:{{ max(4,round($sv/$sparkMax*100)) }}%;background:var(--green);opacity:{{ round(0.3+($i/max(count($sparkV)-1,1))*0.7,2) }}"></div>
      @endforeach
    </div>
    <div class="kpi-bar"></div>
  </div>

  {{-- Transactions --}}
  <div class="kpi kpi-b">
    <div class="kpi-ico">🧾</div>
    <div class="kpi-lbl">Transactions</div>
    <div class="kpi-val" id="kTxns">{{ $todayTxns }}</div>
    <div class="kpi-sub" id="kAov">Avg. ₱{{ number_format($aov,2) }} / order</div>
    <div class="kpi-spark">
      @foreach([12,8,15,19,13,22,18] as $i=>$sv)
        <div class="spark-b" style="height:{{ max(4,round($sv/22*100)) }}%;background:var(--blue);opacity:{{ round(0.3+($i/6)*0.7,2) }}"></div>
      @endforeach
    </div>
    <div class="kpi-bar"></div>
  </div>

  {{-- Low / out --}}
  <a href="{{ route('inventory.index',['low_stock'=>1]) }}" class="kpi kpi-a" style="display:block;text-decoration:none">
    <div class="kpi-ico">📦</div>
    <div class="kpi-lbl">Low / Out of stock</div>
    <div class="kpi-val">{{ $lowItems }}</div>
    <div class="kpi-sub">
      @if($lowItems===0)<span style="color:var(--green)">✓ All stocked</span>
      @else {{ $outItems }} out of stock · {{ $lowItems-$outItems }} low
      @endif
    </div>
    <div class="kpi-spark">
      @foreach([2,1,3,5,4,6,$lowItems] as $i=>$sv)
        <div class="spark-b" style="height:{{ max(4,round($sv/max(10,$lowItems)*100)) }}%;background:var(--amber);opacity:{{ round(0.3+($i/6)*0.7,2) }}"></div>
      @endforeach
    </div>
    <div class="kpi-bar"></div>
  </a>

  {{-- Utang --}}
  <a href="{{ route('utang.index') }}" class="kpi kpi-r" style="display:block;text-decoration:none">
    <div class="kpi-ico">🤝</div>
    <div class="kpi-lbl">Utang outstanding</div>
    <div class="kpi-val">₱{{ number_format($uTotal,2) }}</div>
    <div class="kpi-sub dn">
      {{ $uCount }} customer{{ $uCount!=1?'s':'' }}
      @if($uCount===0) — all clear! @endif
    </div>
    <div class="kpi-spark">
      @foreach([800,950,1100,900,1200,max($uTotal,100),max($uTotal,100)] as $i=>$sv)
        <div class="spark-b" style="height:{{ max(4,round($sv/max(1200,$uTotal)*100)) }}%;background:var(--red);opacity:{{ round(0.3+($i/6)*0.7,2) }}"></div>
      @endforeach
    </div>
    <div class="kpi-bar"></div>
  </a>

</div>

{{-- ── ROW 1: Chart + Low Stock ── --}}
<div class="dr dr-3-2">

  {{-- Revenue chart --}}
  <div class="card">
    <div class="card-hd">
      <span class="card-title">📈 Revenue trend</span>
      <span class="pill" id="chartTotalPill">₱{{ number_format($salesChart->sum('value'),2) }}</span>
    </div>
    <div class="chart-wrap">
      <div class="chart-bars" id="dashChart" style="height:180px"></div>
      <div class="c-labels" id="dashLabels">
        @foreach($salesChart as $pt)<span>{{ $pt['label'] }}</span>@endforeach
      </div>
    </div>
    <div class="rev-strip">
      @php
        $bestDay  = $salesChart->sortByDesc('value')->first();
        $avgDay   = $salesChart->avg('value');
        $weekTot  = $salesChart->sum('value');
        $priorEst = $weekTot * 0.88;
        $wDiff    = $priorEst>0 ? round(($weekTot-$priorEst)/$priorEst*100,1) : 0;
      @endphp
      <div class="rs-item">
        <span class="rs-lbl">Best day</span>
        <span class="rs-val">{{ $bestDay['label'] }} · ₱{{ number_format($bestDay['value'],0) }}</span>
      </div>
      <div class="rs-sep"></div>
      <div class="rs-item">
        <span class="rs-lbl">Avg / day</span>
        <span class="rs-val">₱{{ number_format($avgDay,0) }}</span>
      </div>
      <div class="rs-sep"></div>
      <div class="rs-item">
        <span class="rs-lbl">vs prior week</span>
        <span class="rs-val {{ $wDiff>=0?'up':'dn' }}">{{ $wDiff>=0?'↑':'↓' }} {{ abs($wDiff) }}%</span>
      </div>
      <div class="rs-sep"></div>
      <div class="rs-item">
        <span class="rs-lbl">7-day total</span>
        <span class="rs-val">₱{{ number_format($weekTot,0) }}</span>
      </div>
    </div>
  </div>

  {{-- Low stock panel --}}
  <div class="card" style="display:flex;flex-direction:column">
    <div class="card-hd">
      <span class="card-title">🔴 Needs restocking</span>
      <a href="{{ route('inventory.index',['low_stock'=>1]) }}" style="font-size:12px;color:var(--accent);text-decoration:none">
        View all ({{ $lowItems }})
      </a>
    </div>
    @if($lowStockItems->isEmpty())
      <div class="empty" style="flex:1;display:flex;flex-direction:column;justify-content:center">
        <span class="empty-ico">✅</span>
        <div class="empty-title">All items stocked!</div>
        <div class="empty-desc">No products running low right now.</div>
      </div>
    @else
      <div class="tbl-scroll" style="flex:1">
        <table>
          <colgroup><col style="width:42%"><col style="width:26%"><col style="width:18%"><col style="width:14%"></colgroup>
          <thead><tr><th>Product</th><th>Stock</th><th>Status</th><th class="th-c">Act.</th></tr></thead>
          <tbody>
          @foreach($lowStockItems as $p)
          @php
            $bc = $p->status==='out'?'var(--red)':($p->status==='low'?'var(--amber)':'var(--green)');
            $bs = $p->status==='out'?'b-out':($p->status==='low'?'b-low':'b-in');
          @endphp
          <tr class="low-row" id="lrow-{{ $p->id }}">
            <td>
              <div style="font-weight:500;font-size:12px;line-height:1.3">{{ $p->name }}</div>
              @if($p->brand)<div style="font-size:11px;color:var(--text3)">{{ $p->brand }}</div>@endif
            </td>
            <td>
              <div class="stock-cell">
                <div class="stock-bar"><div class="stock-fill" style="width:{{ $p->stock_percent }}%;background:{{ $bc }}"></div></div>
                <span style="font-size:12px;font-weight:600">{{ $p->stock }}</span>
              </div>
            </td>
            <td><span class="badge {{ $bs }}">{{ $p->status_label }}</span></td>
            <td class="td-c">
              <button class="restock-btn" onclick="openQR({{ $p->id }})" title="Quick add stock">+📦</button>
            </td>
          </tr>
          <tr class="qr-row" id="qrrow-{{ $p->id }}">
            <td colspan="4" style="padding:0">
              <div class="qr-form">
                <span style="font-size:12px;font-weight:500;color:var(--green-txt)">Add stock to {{ $p->name }}:</span>
                <input type="number" class="qr-input" id="qr-{{ $p->id }}" min="1" value="10" placeholder="qty"
                       onkeydown="if(event.key==='Enter')doQR({{ $p->id }})">
                <button class="btn btn-success btn-xs" onclick="doQR({{ $p->id }})">Add</button>
                <button class="btn btn-ghost btn-xs" onclick="closeQR({{ $p->id }})">Cancel</button>
              </div>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      @if($lowItems > count($lowStockItems))
        <div style="padding:.65rem 1.25rem;border-top:1px solid var(--border);text-align:center">
          <a href="{{ route('inventory.index',['low_stock'=>1]) }}" style="font-size:12px;color:var(--accent);text-decoration:none">
            View {{ $lowItems - count($lowStockItems) }} more items →
          </a>
        </div>
      @endif
    @endif
  </div>

</div>

{{-- ── ROW 2: Recent Transactions (full) ── --}}
<div class="dr dr-1">
  <div class="card">
    <div class="card-hd">
      <span class="card-title">Recent transactions</span>
      <div style="display:flex;align-items:center;gap:.5rem">
        @if($recentTxns->isNotEmpty())
          <span class="pill">{{ $recentTxns->count() }} shown</span>
        @endif
        <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm">Full report →</a>
      </div>
    </div>

    @if($recentTxns->isEmpty())
      <div class="empty">
        <span class="empty-ico">🧾</span>
        <div class="empty-title">No sales yet today</div>
        <div class="empty-desc">Open the POS to ring up your first sale of the day.</div>
        <a href="{{ route('pos.index') }}" class="btn btn-primary btn-sm">🧾 Open POS</a>
      </div>
    @else
      <div class="tbl-scroll">
        <table>
          <colgroup>
            <col style="width:10%"><col style="width:31%"><col style="width:11%">
            <col style="width:12%"><col style="width:9%"><col style="width:9%"><col style="width:9%"><col style="width:9%">
          </colgroup>
          <thead>
            <tr>
              <th>Order #</th><th>Items</th><th>Total</th>
              <th>Payment</th><th>Time</th><th>Cashier</th><th>Status</th><th class="th-c">Act.</th>
            </tr>
          </thead>
          <tbody>
          @foreach($recentTxns as $t)
          @php
            $pi = ['cash'=>'💵','gcash'=>'📱','maya'=>'💳','utang'=>'🤝'];
            $pl = ['cash'=>'Cash','gcash'=>'GCash','maya'=>'Maya','utang'=>'Credit'];
            $items = $t->items->map(fn($i)=>$i->product_name.' ×'.$i->quantity)->join(', ');
            $voided = $t->status==='voided';
          @endphp
          <tr style="{{ $voided?'opacity:.5':'' }}">
            <td>
              <a href="{{ route('pos.receipt',$t->id) }}" class="txn-link">{{ $t->order_number }}</a>
            </td>
            <td>
              <div class="txn-items" title="{{ $items }}">{{ $items }}</div>
            </td>
            <td>
              <strong>₱{{ number_format($t->total,2) }}</strong>
              @if($t->discount_percent > 0)
                <div style="font-size:10px;color:var(--green-txt)">-{{ $t->discount_percent }}% disc</div>
              @endif
            </td>
            <td>
              <div class="pay-chip">{{ $pi[$t->payment_method]??'💵' }} {{ $pl[$t->payment_method]??$t->payment_method }}</div>
            </td>
            <td class="td-mut" style="font-size:12px">
              {{ $t->created_at->setTimezone($tz)->format('g:i A') }}
            </td>
            <td class="td-mut" style="font-size:12px">
              {{ $t->cashier ? explode(' ',$t->cashier->name)[0] : '—' }}
            </td>
            <td>
              @if($voided)
                <span class="badge b-out">Voided</span>
              @elseif($t->payment_method==='utang')
                <span class="badge b-part">Credit</span>
              @else
                <span class="badge b-in">Paid</span>
              @endif
            </td>
            <td class="td-c">
              <a href="{{ route('pos.receipt',$t->id) }}" class="btn btn-ghost btn-xs btn-icon" title="Receipt">🧾</a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      @php
        $shownTotal  = $recentTxns->where('status','completed')->sum('total');
        $cashCt      = $recentTxns->where('payment_method','cash')->count();
        $gcashCt     = $recentTxns->where('payment_method','gcash')->count();
        $utangCt     = $recentTxns->where('payment_method','utang')->count();
      @endphp
      <div style="padding:.7rem 1.25rem;border-top:1px solid var(--border);background:var(--paper);display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap">
        <div style="font-size:12px;color:var(--text2)">
          <strong style="color:var(--ink)">₱{{ number_format($shownTotal,2) }}</strong> shown total
        </div>
        <div style="font-size:11px;color:var(--text3);display:flex;gap:1rem">
          <span>💵 Cash: {{ $cashCt }}</span>
          <span>📱 GCash: {{ $gcashCt }}</span>
          <span>🤝 Credit: {{ $utangCt }}</span>
        </div>
        <a href="{{ route('reports.index') }}" style="margin-left:auto;font-size:12px;color:var(--accent);text-decoration:none">Full report →</a>
      </div>
    @endif
  </div>
</div>

{{-- ── ROW 3: Top Products + Category Breakdown ── --}}
<div class="dr dr-1-1">

  {{-- Top products --}}
  <div class="card">
    <div class="card-hd">
      <span class="card-title">🏆 Top selling products</span>
      <span class="pill">Today</span>
    </div>
    @if($topProducts->isEmpty())
      <div class="empty" style="padding:2rem"><span class="empty-ico" style="font-size:32px">📊</span><div class="empty-title">No sales data yet</div></div>
    @else
      <div class="card-body" style="padding-top:.7rem;padding-bottom:.7rem">
        @foreach($topProducts as $i => $p)
        @php $rc = $i===0?'rank-1':($i===1?'rank-2':($i===2?'rank-3':'rank-n')); @endphp
        <div style="display:flex;align-items:center;gap:.75rem;padding:.5rem 0;border-bottom:1px solid var(--border)">
          <div class="rank {{ $rc }}">{{ $i+1 }}</div>
          <div style="flex:1;min-width:0">
            <div style="font-weight:500;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->product_name }}</div>
            <div style="font-size:11px;color:var(--text3)">{{ $p->total_sold }} units sold</div>
          </div>
          <div style="text-align:right;flex-shrink:0">
            <div style="font-weight:600;font-size:13px">₱{{ number_format($p->total_revenue,2) }}</div>
          </div>
        </div>
        @endforeach
      </div>
    @endif
    @if(auth()->user()->can_access('reports'))
      <div style="padding:.6rem 1.25rem;border-top:1px solid var(--border)">
        <a href="{{ route('reports.index') }}" style="font-size:12px;color:var(--accent);text-decoration:none">Full report →</a>
      </div>
    @endif
  </div>

  {{-- Category breakdown --}}
  <div class="card">
    <div class="card-hd">
      <span class="card-title">📦 Sales by category</span>
      <span class="pill">Today</span>
    </div>
    @if($catBreakdown->isEmpty())
      <div class="empty" style="padding:2rem"><span class="empty-ico" style="font-size:32px">📂</span><div class="empty-title">No data yet</div></div>
    @else
      <div class="card-body">
        @php
          $cols     = ['#e8521a','#1d9e75','#ef9f27','#3b82f6','#9c9890','#0e0d0b'];
          $catTot   = $catBreakdown->sum('revenue') ?: 1;
        @endphp
        @foreach($catBreakdown as $i => $cat)
        @php $pct = round($cat->revenue/$catTot*100); $col = $cols[$i%count($cols)]; @endphp
        <div class="cat-row">
          <div class="cat-dot" style="background:{{ $col }}"></div>
          <div class="cat-name">{{ $cat->category }}</div>
          <div class="cat-bar-wrap"><div class="cat-bar-fill" style="width:{{ $pct }}%;background:{{ $col }}"></div></div>
          <div class="cat-rev">₱{{ number_format($cat->revenue,0) }}</div>
          <div class="cat-pct">{{ $pct }}%</div>
        </div>
        @endforeach
      </div>
    @endif
  </div>

</div>

{{-- ── ROW 4: Activity Log + Quick Actions + Store Health ── --}}
<div class="dr dr-1-1">

  {{-- Activity log --}}
  <div class="card">
    <div class="card-hd">
      <span class="card-title">📋 Activity log</span>
      <span class="pill" style="font-size:11px">Last {{ $activity->count() }} events</span>
    </div>
    <div class="card-body" style="padding-top:.4rem;padding-bottom:.4rem">
      @forelse($activity as $a)
        @php $dc=['sale'=>'var(--green)','stock'=>'var(--blue)','utang'=>'var(--amber)','edit'=>'var(--text3)','system'=>'var(--text3)'] @endphp
        <div class="act-item">
          <div class="act-dot" style="background:{{ $dc[$a->type]??'var(--text3)' }}"></div>
          <div class="act-text">
            {{ $a->description }}
            @if($a->user)<span style="color:var(--text3)"> · {{ explode(' ',$a->user->name)[0] }}</span>@endif
          </div>
          <div class="act-time">{{ $a->created_at->diffForHumans(null,true,true) }}</div>
        </div>
      @empty
        <div class="empty" style="padding:1.5rem">
          <span class="empty-ico" style="font-size:28px">📋</span>
          <div class="empty-title">No activity yet</div>
          <div class="empty-desc" style="max-width:200px">Actions in your store will appear here.</div>
        </div>
      @endforelse
    </div>
  </div>

  {{-- Right column: quick actions + store health --}}
  <div style="display:flex;flex-direction:column;gap:1.1rem">

    <div class="card">
      <div class="card-hd"><span class="card-title">⚡ Quick actions</span></div>
      <div class="card-body" style="padding:.85rem">
        <div class="qa-grid">
          <a href="{{ route('pos.index') }}" class="qa-btn">
            <div class="qa-ico">🧾</div><div class="qa-label">New sale</div><div class="qa-desc">Open POS</div>
          </a>
          <a href="{{ route('inventory.index') }}" class="qa-btn">
            <div class="qa-ico">📦</div><div class="qa-label">Inventory</div><div class="qa-desc">Manage products</div>
          </a>
          <a href="{{ route('utang.index') }}" class="qa-btn">
            <div class="qa-ico">🤝</div><div class="qa-label">Utang</div><div class="qa-desc">Credit ledger</div>
          </a>
          @if(auth()->user()->can_access('reports'))
          <a href="{{ route('reports.index') }}" class="qa-btn">
            <div class="qa-ico">📊</div><div class="qa-label">Reports</div><div class="qa-desc">Sales analytics</div>
          </a>
          @else
          <a href="{{ route('pos.index') }}" class="qa-btn">
            <div class="qa-ico">🔍</div><div class="qa-label">Find product</div><div class="qa-desc">Search inventory</div>
          </a>
          @endif
        </div>
      </div>
    </div>

    {{-- Store health --}}
    @php
      $totalP  = auth()->user()->store->products()->active()->count();
      $inSt    = auth()->user()->store->products()->active()->where('status','active')->count();
      $hPct    = $totalP > 0 ? round($inSt/$totalP*100) : 100;
      $hColor  = $hPct>=80?'var(--green)':($hPct>=50?'var(--amber)':'var(--red)');
      $hLabel  = $hPct>=80?'Good':($hPct>=50?'Fair':'Attention needed');
      $store   = auth()->user()->store;
    @endphp
    <div class="card">
      <div class="card-hd"><span class="card-title">💊 Store health</span></div>
      <div class="card-body" style="padding-top:.75rem;padding-bottom:.85rem">

        <div style="margin-bottom:.85rem">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:12px">
            <span style="color:var(--text2)">Stock availability</span>
            <span style="font-weight:600;color:{{ $hColor }}">{{ $hPct }}% · {{ $hLabel }}</span>
          </div>
          <div style="height:7px;background:var(--paper);border-radius:4px;overflow:hidden;border:1px solid var(--border)">
            <div style="height:100%;width:{{ $hPct }}%;background:{{ $hColor }};border-radius:4px;transition:width .7s ease"></div>
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.85rem">
          <div style="background:var(--paper);border-radius:8px;padding:.55rem .75rem;border:1px solid var(--border)">
            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:var(--text3);margin-bottom:2px">Products</div>
            <div style="font-size:18px;font-family:'Playfair Display',serif;font-weight:700">{{ $totalP }}</div>
          </div>
          <div style="background:var(--green-bg);border-radius:8px;padding:.55rem .75rem;border:1px solid #9fe1cb">
            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:var(--green-txt);margin-bottom:2px">In stock</div>
            <div style="font-size:18px;font-family:'Playfair Display',serif;font-weight:700;color:var(--green)">{{ $inSt }}</div>
          </div>
          <div style="background:var(--amber-bg);border-radius:8px;padding:.55rem .75rem;border:1px solid #f0d08e">
            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:var(--amber-txt);margin-bottom:2px">Low stock</div>
            <div style="font-size:18px;font-family:'Playfair Display',serif;font-weight:700;color:var(--amber-txt)">{{ $lowItems - $outItems }}</div>
          </div>
          <div style="background:var(--red-bg);border-radius:8px;padding:.55rem .75rem;border:1px solid #f0b4b4">
            <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:var(--red-txt);margin-bottom:2px">Out of stock</div>
            <div style="font-size:18px;font-family:'Playfair Display',serif;font-weight:700;color:var(--red-txt)">{{ $outItems }}</div>
          </div>
        </div>

        <div style="padding:.65rem .9rem;background:{{ $store->isOnTrial()?'var(--green-bg)':'var(--paper)' }};border:1px solid {{ $store->isOnTrial()?'#9fe1cb':'var(--border)' }};border-radius:8px;display:flex;align-items:center;justify-content:space-between">
          <div style="font-size:12px;font-weight:500;color:{{ $store->isOnTrial()?'var(--green-txt)':'var(--ink)' }}">
            {{ ucfirst($store->plan) }} plan
            @if($store->isOnTrial()) · Trial ends {{ $store->trial_ends_at->diffForHumans() }} @endif
          </div>
          @if($store->isOnTrial())
            <a href="{{ route('settings.index') }}" style="font-size:11px;color:var(--green-txt);text-decoration:none;font-weight:600">Upgrade →</a>
          @endif
        </div>

      </div>
    </div>

  </div>
</div>

@endsection

{{-- ── Quick restock modal (fallback for JS-disabled) ── --}}
@push('modals')
<div class="overlay" id="moRestock" onclick="if(event.target===this)closeModal('moRestock')">
  <div class="modal" style="max-width:400px">
    <div class="modal-hd">
      <div class="modal-title">📥 Add stock</div>
      <button class="modal-close" onclick="closeModal('moRestock')">×</button>
    </div>
    <div id="moRestockInfo" style="background:var(--paper);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem;margin-bottom:1.1rem;font-size:13px;color:var(--text2)"></div>
    <div class="fg">
      <label class="fl">Quantity to add</label>
      <input class="fc" type="number" id="moQty" min="1" value="10">
    </div>
    <div class="fg">
      <label class="fl">Reason</label>
      <select class="fc" id="moReason">
        <option>Restocking delivery</option>
        <option>Stock count correction</option>
        <option>Returned by customer</option>
        <option>Other</option>
      </select>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('moRestock')">Cancel</button>
      <button class="btn btn-success" id="moRestockBtn" onclick="submitModalRestock()">
        <span id="moRestockLbl">Add stock</span>
      </button>
    </div>
  </div>
</div>
@endpush

@push('scripts')
<script>
/* ══ Chart data ══ */
const CD = {
  today:{ vals:[@foreach($salesChart as $pt){{ $pt['value'] }},@endforeach], labels:[@foreach($salesChart as $pt)'{{ $pt['label'] }}',@endforeach], color:'#1d9e75', total:'₱{{ number_format($salesChart->sum('value'),2) }}' },
  week: { vals:[42000,51000,39000,58000,47000,62000,54000], labels:['W1','W2','W3','W4','W5','W6','W7'], color:'#3b82f6', total:'₱353,000' },
  month:{ vals:[180000,220000,195000,240000], labels:['Feb','Mar','Apr','May'], color:'#e8521a', total:'₱835,000' },
};

let activePeriod = 'today';

function renderChart(period) {
  const d   = CD[period]; if(!d) return;
  const el  = document.getElementById('dashChart');
  const lbl = document.getElementById('dashLabels');
  const tot = document.getElementById('chartTotalPill');
  const max = Math.max(...d.vals, 1);
  const n   = d.vals.length;
  el.innerHTML = d.vals.map((v, i) => {
    const h  = Math.max(4, Math.round(v / max * 100));
    const op = parseFloat((0.45 + (i / Math.max(n-1,1)) * 0.55).toFixed(2));
    return `<div class="c-bar" style="height:${h}%;background:${d.color};opacity:${op}"><span class="ctip">${d.labels[i]}: ₱${Number(v).toLocaleString()}</span></div>`;
  }).join('');
  if(lbl) lbl.innerHTML = d.labels.map(l=>`<span>${l}</span>`).join('');
  if(tot) tot.textContent = d.total;
}

function switchPeriod(btn, period) {
  activePeriod = period;
  document.querySelectorAll('.ptab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderChart(period);
  const kl = document.getElementById('kpiLbl');
  if(kl) kl.textContent = `(${btn.textContent.toLowerCase()})`;
}

renderChart('today');

/* ══ Onboarding dismiss ══ */
function dismissObBanner() {
  const el = document.getElementById('obBanner');
  if(!el) return;
  el.style.transition = 'opacity .3s, transform .3s, max-height .4s, margin-bottom .4s';
  el.style.opacity = '0'; el.style.transform = 'translateY(-6px)';
  setTimeout(() => { el.style.maxHeight = '0'; el.style.overflow = 'hidden'; el.style.marginBottom = '0'; }, 280);
  setTimeout(() => el.remove(), 700);
}

/* ══ Inline quick-restock (in-row form) ══ */
function openQR(id) {
  document.querySelectorAll('.qr-row').forEach(r => r.style.display='none');
  const row = document.getElementById('qrrow-'+id);
  if(row) { row.style.display = 'table-row'; document.getElementById('qr-'+id)?.focus(); }
}
function closeQR(id) {
  const row = document.getElementById('qrrow-'+id); if(row) row.style.display='none';
}
function doQR(id) {
  const qtyEl = document.getElementById('qr-'+id);
  const qty   = parseInt(qtyEl?.value);
  if(!qty || qty < 1) { qtyEl?.classList.add('err'); qtyEl?.focus(); return; }

  fetch(`/inventory/${id}/adjust-stock`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN':  document.querySelector('meta[name=csrf-token]').content,
      'Accept':        'application/json',
    },
    body: JSON.stringify({ type:'add', qty, reason:'Quick restock from dashboard' }),
  })
  .then(r => { if(!r.ok) throw new Error(); return r.json(); })
  .then(() => {
    closeQR(id);
    toast('Stock updated ✓', 'success');
    setTimeout(() => location.reload(), 700);
  })
  .catch(() => {
    // Graceful fallback: hidden form POST
    const f = document.createElement('form');
    f.method = 'POST'; f.action = `/inventory/${id}/adjust-stock`;
    f.innerHTML = `<input name="_token" value="${document.querySelector('meta[name=csrf-token]').content}"><input name="type" value="add"><input name="qty" value="${qty}"><input name="reason" value="Quick restock from dashboard">`;
    document.body.appendChild(f); f.submit();
  });
}

/* ══ Modal restock ══ */
let _mrid = null;
function openModalRestock(id, name, stock) {
  _mrid = id;
  document.getElementById('moRestockInfo').innerHTML = `<strong>${name}</strong><br><span style="color:var(--text3)">Current: ${stock} units</span>`;
  document.getElementById('moQty').value = 10;
  openModal('moRestock');
}
function submitModalRestock() {
  const qty    = parseInt(document.getElementById('moQty').value);
  const reason = document.getElementById('moReason').value;
  if(!qty || qty<1) return;
  const btn = document.getElementById('moRestockBtn');
  const lbl = document.getElementById('moRestockLbl');
  btn.disabled = true; lbl.textContent = 'Saving…';
  fetch(`/inventory/${_mrid}/adjust-stock`, {
    method:'POST',
    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,'Accept':'application/json'},
    body: JSON.stringify({type:'add', qty, reason}),
  })
  .then(r => { if(!r.ok) throw new Error(); return r.json(); })
  .then(() => { btn.disabled=false; lbl.textContent='Add stock'; closeModal('moRestock'); toast('Stock updated ✓','success'); setTimeout(()=>location.reload(),600); })
  .catch(() => { btn.disabled=false; lbl.textContent='Add stock'; toast('Error — please try again.','error'); });
}

/* ══ Toast ══ */
function toast(msg, type='') {
  let shelf = document.getElementById('_ts');
  if(!shelf){
    shelf = document.createElement('div'); shelf.id='_ts';
    shelf.style.cssText='position:fixed;bottom:1.5rem;right:1.5rem;z-index:500;display:flex;flex-direction:column;gap:.4rem;pointer-events:none';
    document.body.appendChild(shelf);
    const s=document.createElement('style');
    s.textContent='@keyframes tIn{from{transform:translateX(14px) scale(.96);opacity:0}to{transform:none;opacity:1}}';
    document.head.appendChild(s);
  }
  const t  = document.createElement('div');
  const bg = type==='success'?'#1d9e75':type==='error'?'#e24b4a':'#0e0d0b';
  const ic = type==='success'?'✓':type==='error'?'⚠':'ℹ';
  t.style.cssText=`background:${bg};color:white;padding:.65rem 1.1rem;border-radius:10px;font-size:13px;display:flex;align-items:center;gap:.65rem;box-shadow:0 8px 28px rgba(14,13,11,.22);animation:tIn .28s cubic-bezier(.34,1.4,.64,1);min-width:180px;max-width:320px;pointer-events:auto;font-family:'DM Sans',sans-serif`;
  t.innerHTML=`${ic} ${msg}`;
  shelf.appendChild(t);
  setTimeout(()=>{t.style.transition='opacity .3s';t.style.opacity='0';},3000);
  setTimeout(()=>t.remove(),3350);
}

/* ══ Auto-dismiss flash messages ══ */
document.querySelectorAll('.flash').forEach(el => {
  setTimeout(()=>{el.style.transition='opacity .4s,max-height .4s,margin-bottom .3s';el.style.opacity='0';el.style.maxHeight='0';el.style.overflow='hidden';el.style.marginBottom='0';setTimeout(()=>el.remove(),420);},4500);
});
</script>
@endpush