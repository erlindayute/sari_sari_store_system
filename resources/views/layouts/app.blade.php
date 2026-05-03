<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory') — Sari-sari Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&family=Syne:wght@500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f5f3ee;
            --surface:   #ffffff;
            --surface-2: #f5f3ee;
            --border:    rgba(0,0,0,0.1);
            --border-md: rgba(0,0,0,0.18);
            --text:      #1a1a18;
            --text-2:    #6b6b66;
            --text-3:    #9a9a94;
            --green:     #1D9E75;
            --green-dk:  #0F6E56;
            --green-bg:  #E1F5EE;
            --green-txt: #0F6E56;
            --amber:     #EF9F27;
            --amber-bg:  #FAEEDA;
            --amber-txt: #854F0B;
            --red:       #E24B4A;
            --red-bg:    #FCEBEB;
            --red-txt:   #A32D2D;
            --radius:    10px;
            --radius-sm: 6px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.5;
            min-height: 100vh;
        }

        .page { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* Flash messages */
        .flash {
            padding: .75rem 1.25rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.25rem;
            font-size: 13px;
        }
        .flash.success { background: var(--green-bg); color: var(--green-txt); border: 1px solid #9FE1CB; }
        .flash.error   { background: var(--red-bg);   color: var(--red-txt);   border: 1px solid #F7C1C1; }
    </style>
    @stack('styles')
</head>
<body>
<div class="page">
    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>
@stack('scripts')
</body>
</html>
