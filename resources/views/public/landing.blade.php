<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Wisata Gatra Kencana — Bojongnangka</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream:   '#F9F9F5',
                        emerald: { DEFAULT: '#2A9D6F', light: '#3ab882', dark: '#1e7352' },
                        gold:    { DEFAULT: '#EAA83A', light: '#f2bc5e', dark: '#c8891f' },
                        forest:  '#1E2522',
                        charcoal:'#2D312E',
                        muted:   '#707771',
                    },
                    fontFamily: {
                        serif: ['"DM Serif Display"', 'Georgia', 'serif'],
                        sans:  ['"DM Sans"', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
   <style>
        :root {
            --eg: #2A9D6F;
            --eg-dk: #1e7352;
            --gold: #EAA83A;
            --forest: #1E2522;
            --body: #2D312E;
            --muted: #707771;
            --alt: #F9F9F5;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            color: var(--body);
            background: #fff;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        .font-serif { font-family: 'DM Serif Display', Georgia, serif; }
        
        /* ── FIX HERO BACKGROUND (KUNCI KOTAK GAIB BIAR ILANG) ── */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(42,157,111,0.05) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(42,157,111,0.05) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
            z-index: 1;
        }
        .hero-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 2;
        }

        /* ── Navbar ── */
        #navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            transition: background 0.3s, box-shadow 0.3s, padding 0.3s;
            padding: 14px 0;
        }
        #navbar.scrolled {
            background: rgba(249,249,245,0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 24px rgba(30,37,34,0.08);
            padding: 10px 0;
            border-bottom: 1px solid rgba(42,157,111,0.1);
        }
        
        /* ── Mobile menu ── */
        #mobile-menu {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: var(--forest);
            z-index: 200;
            padding: 24px;
            flex-direction: column;
            gap: 0;
        }
        #mobile-menu.open { display: flex; }
        .mobile-nav-link {
            display: block;
            padding: 18px 4px;
            font-size: 1.5rem;
            font-family: 'DM Serif Display', serif;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            transition: color 0.2s;
        }
        .mobile-nav-link:hover { color: #2A9D6F; }
        
        /* ── Section label ── */
        .sec-label {
            display: flex; align-items: center; gap: 10px;
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--eg); margin-bottom: 12px;
        }
        .sec-label::before {
            content: ''; display: block; width: 28px; height: 1.5px;
            background: var(--eg); flex-shrink: 0;
        }
        
        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--eg); color: #fff;
            padding: 14px 24px; border-radius: 100px;
            font-weight: 700; font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.25s; cursor: pointer;
            box-shadow: 0 4px 20px rgba(42,157,111,0.3);
            border: none; touch-action: manipulation;
        }
        .btn-primary:active { transform: scale(0.97); }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.1); color: #fff;
            padding: 14px 24px; border-radius: 100px;
            font-weight: 600; font-size: 0.9rem;
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.2);
            transition: all 0.25s; cursor: pointer;
            touch-action: manipulation;
        }
        .btn-ghost:active { background: rgba(255,255,255,0.18); }
        
        /* ── Gallery card ── */
        .gal-card {
            border-radius: 16px; overflow: hidden;
            position: relative; background: #1a3a2a;
        }
        .gal-card-inner {
            width: 100%; aspect-ratio: 4/3;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 8px;
        }
        .gal-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(30,37,34,0.9) 0%, transparent 55%);
        }
        .gal-text {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 16px; z-index: 2;
        }
        
        /* ── News card ── */
        .news-card {
            background: #fff; border: 1px solid rgba(112,119,113,0.15);
            border-radius: 16px; overflow: hidden;
            transition: box-shadow 0.25s, transform 0.25s;
        }
        .news-card:active { transform: scale(0.98); }
        
        /* ── Ticket card ── */
        .ticket-card {
            border-radius: 20px; overflow: hidden;
            position: relative;
        }
        .ticket-card::before {
            content: ''; position: absolute; top: 0; left: 50%;
            transform: translateX(-50%); width: 36px; height: 3px;
            background: var(--gold); border-radius: 0 0 4px 4px;
        }
        
        /* ── Marquee ── */
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .marquee-inner { animation: marquee 26s linear infinite; white-space: nowrap; display: inline-block; }
    </style>
</head>
<body>

<!-- ══════════════════ MOBILE MENU ══════════════════ -->
<div id="mobile-menu" role="dialog" aria-modal="true">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-2.5">
            <div style="width:36px; height:36px; border-radius:10px; overflow:hidden; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" alt="Logo Gatra Kencana" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <span class="font-serif" style="color:white;font-size:1rem;">Gatra Kencana</span>
        </div>
        <button onclick="toggleMenu()" style="background:rgba(255,255,255,0.08);border:none;border-radius:10px;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:white;font-size:1.4rem;">✕</button>
    </div>
    <nav>
        <a href="#tentang" class="mobile-nav-link" onclick="toggleMenu()">Tentang</a>
        <a href="#galeri"  class="mobile-nav-link" onclick="toggleMenu()">Galeri</a>
        <a href="#harga"   class="mobile-nav-link" onclick="toggleMenu()">Tiket</a>
        <a href="#kabar"   class="mobile-nav-link" onclick="toggleMenu()">Kabar</a>
        <a href="#lokasi"  class="mobile-nav-link" onclick="toggleMenu()">Lokasi</a>
    </nav>
    <div class="mt-auto pt-8 flex flex-col gap-3">
        <a href="#harga" onclick="toggleMenu()" class="btn-ghost justify-center">🎟️ Harga Tiket</a>
    </div>
</div>

<!-- ══════════════════ NAVBAR ══════════════════ -->
<nav id="navbar">
    <div class="w-full px-4 flex items-center justify-between" style="max-width:1024px;margin:0 auto;">
       <a href="#" class="flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg shadow-emerald-DEFAULT/20 group-hover:scale-105 transition-transform">
                <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" alt="Logo Gatra Kencana" class="w-full h-full object-cover">
            </div>
           <div>
                <p class="font-serif text-sm leading-none text-white [.scrolled_&]:text-forest transition-colors duration-300">Gatra Kencana</p>
                <p class="text-xs leading-none mt-0.5 text-white/60 [.scrolled_&]:text-muted transition-colors duration-300">Bojongnangka</p>
            </div>
        </a>
        <div class="hidden md:flex items-center gap-6">
            @foreach(['#tentang'=>'Tentang','#galeri'=>'Galeri','#harga'=>'Tiket','#kabar'=>'Kabar','#lokasi'=>'Lokasi'] as $href => $label)
            <a href="{{ $href }}" style="font-size:0.85rem;font-weight:500;color:var(--muted);text-decoration:none;transition:color 0.2s;"
               onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--muted)'">{{ $label }}</a>
            @endforeach
        </div>
        <button onclick="toggleMenu()" class="md:hidden" style="background:rgba(42,157,111,0.1);border:none;border-radius:10px;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;">
            <svg width="20" height="20" fill="none" stroke="var(--eg)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</nav>

<!-- ══════════════════ HERO ══════════════════ -->
<section id="hero" style="background:var(--forest);min-height:100svh;display:flex;align-items:center;position:relative;overflow:hidden;padding-top:70px;">
    <div class="hero-grid"></div>
    <div class="hero-glow" style="width:400px;height:400px;background:rgba(42,157,111,0.2);top:-120px;right:-100px;"></div>
    <div class="hero-glow" style="width:280px;height:280px;background:rgba(234,168,58,0.1);bottom:-60px;left:-60px;"></div>
    <div class="w-full px-4 py-12 relative z-10" style="max-width:1024px;margin:0 auto;">
        <!-- Gold badge -->
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(234,168,58,0.13);border:1px solid rgba(234,168,58,0.3);color:#c8891f;padding:6px 14px;border-radius:100px;font-size:0.72rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:20px;"
             data-aos="fade-up" data-aos-duration="600">
            <span style="width:6px;height:6px;border-radius:50%;background:#EAA83A;display:inline-block;"></span>
            Buka Setiap Hari · Bojongnangka, Jawa Tengah
        </div>
        <!-- Headline — mobile-first font sizes -->
        <h1 class="font-serif" style="color:white;line-height:1.05;font-size:clamp(2.4rem,8vw,4.5rem);margin-bottom:18px;"
            data-aos="fade-up" data-aos-delay="80" data-aos-duration="700">
            Alam Segar,<br>
            <span style="color:var(--eg);">Kenangan</span><br>
            <em>Abadi.</em>
        </h1>
        <p style="color:rgba(255,255,255,0.6);font-size:clamp(0.9rem,3vw,1.05rem);line-height:1.75;max-width:480px;margin-bottom:28px;"
           data-aos="fade-up" data-aos-delay="160" data-aos-duration="700">
            Wisata Gatra Kencana — pelarian sempurna dari hiruk-pikuk kota. Kolam renang, taman kelinci, dan hamparan hijau yang menenangkan jiwa.
        </p>
        <!-- CTA row -->
        <div class="flex flex-wrap gap-3" data-aos="fade-up" data-aos-delay="240" data-aos-duration="700">
            <a href="#galeri" class="btn-primary">
                Jelajahi Sekarang
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="#lokasi" class="btn-ghost">
                📍 Temukan Rute
            </a>
        </div>
        <!-- Stat strip -->
        <div style="display:flex;flex-wrap:wrap;gap:24px;margin-top:40px;padding-top:32px;border-top:1px solid rgba(255,255,255,0.08);"
             data-aos="fade-up" data-aos-delay="320">
            @foreach([['3+','Wahana'],['07:00','Buka'],['Rp 5rb','Mulai dari']] as $s)
            <div>
                <p class="font-serif" style="font-size:1.6rem;color:white;line-height:1;">{{ $s[0] }}</p>
                <p style="font-size:0.65rem;color:rgba(255,255,255,0.4);letter-spacing:0.08em;text-transform:uppercase;margin-top:3px;">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════════════ TICKER ══════════════════ -->
<div style="background:var(--eg);padding:11px 0;overflow:hidden;">
    <div class="marquee-inner">
        @php $items = ['🌿 Buka Setiap Hari', '🎟️ Tiket Mulai Rp 5.000', '🏊 Kolam Renang Keluarga', '🐰 Taman Kelinci Interaktif', '🐟 Terapi Ikan', '📍 Bojongnangka, Jawa Tengah', '⭐ Destinasi Wisata Terfavorit Di Pemalang', '🎪 Cocok untuk Semua Usia', '🌳 Alam Terbuka nan Asri']; @endphp
        @foreach(array_merge($items,$items) as $item)
        <span style="display:inline-block;padding:0 28px;color:white;font-size:0.78rem;font-weight:500;letter-spacing:0.04em;">{{ $item }}</span>
        @endforeach
    </div>
</div>

<!-- ── TOMBOL LAYANG WHATSAPP ── -->
<a href="https://wa.me/6285327100908?text=Halo%20Admin%20Gatra%20Kencana,%20saya%20ingin%20bertanya%20mengenai%20informasi%20wisata." 
   target="_blank" 
   class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-3.5 rounded-full shadow-2xl hover:bg-[#20ba5a] hover:scale-110 active:scale-95 transition-all duration-300 flex items-center justify-center group"
   aria-label="Chat Admin">
    <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.003 5.37 5.373 0 12.022 0h.008c6.646 0 12.016 5.37 12.019 11.942a11.9 11.9 0 0 1-3.6 8.46c-2.235 2.234-5.209 3.465-8.371 3.465h-.012c-1.996-.001-3.957-.542-5.69-1.566L0 24zm6.59-4.846c1.6.95 3.488 1.449 5.417 1.451h.009c5.466 0 9.913-4.45 9.916-9.917a9.85 9.85 0 0 0-2.907-7.01 9.84 9.84 0 0 0-7.01-2.906h-.011c-5.467 0-9.913 4.453-9.917 9.921a9.86 9.86 0 0 0 1.404 5.063L2.57 20.31l3.077-.807.001.001zm11.454-7.443c-.305-.153-1.805-.89-2.083-.992-.279-.101-.482-.153-.684.153-.203.305-.787.992-.965 1.194-.177.202-.355.228-.66.076-.304-.153-1.287-.475-2.451-1.514-.906-.08-1.517-.184-1.796-.336-.279-.153-.301-.235-.15-.387.135-.136.305-.355.457-.533.151-.177.202-.304.304-.507.102-.203.05-.38-.025-.533-.076-.153-.685-1.65-.938-2.261-.247-.594-.497-.514-.684-.523-.177-.008-.38-.009-.583-.009-.203 0-.533.076-.813.38-.28.305-1.066 1.042-1.066 2.541 0 1.498 1.09 2.946 1.242 3.149.153.203 2.146 3.277 5.198 4.593.726.313 1.293.5 1.734.64.73.232 1.393.199 1.917.12.584-.087 1.805-.737 2.058-1.449.253-.713.253-1.32.177-1.449-.076-.127-.279-.203-.584-.356z"/>
    </svg>
    <span class="absolute right-14 bg-forest text-white text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-md whitespace-nowrap">Hubungi Admin</span>
</a>

<!-- ══════════════════ TENTANG ══════════════════ -->
<section id="tentang" style="background:#fff;padding:64px 0;">
    <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
        <div data-aos="fade-up" style="margin-bottom:32px;">
            <div class="sec-label">Tentang Destinasi</div>
            <h2 class="font-serif" style="font-size:clamp(1.8rem,6vw,2.8rem);color:var(--forest);line-height:1.15;max-width:480px;">Surga Hijau di<br>Tengah Desa</h2>
        </div>
        <p style="font-size:0.95rem;line-height:1.8;color:var(--muted);margin-bottom:14px;max-width:600px;" data-aos="fade-up" data-aos-delay="60">
            Wisata Gatra Kencana adalah destinasi keluarga yang memadukan keasrian alam pedesaan Bojongnangka dengan fasilitas wahana yang menyenangkan untuk seluruh anggota keluarga.
        </p>
        <p style="font-size:0.95rem;line-height:1.8;color:var(--muted);margin-bottom:32px;max-width:600px;" data-aos="fade-up" data-aos-delay="100">
            Tiga area utama — Kolam Renang, Taman Kelinci, dan Area Alam Terbuka — dirancang untuk menciptakan kenangan tak terlupakan.
        </p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;background:var(--alt);border-radius:16px;padding:20px;margin-bottom:36px;" data-aos="fade-up" data-aos-delay="140">
            <div>
                <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);">Jam Buka</p>
                <p class="font-serif" style="font-size:1.4rem;color:var(--forest);margin-top:4px;">07.00–18.00</p>
                <p style="font-size:0.78rem;color:var(--muted);margin-top:2px;">Setiap Hari</p>
            </div>
            <div style="border-left:1px solid rgba(112,119,113,0.18);padding-left:16px;">
                <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--muted);">Lokasi</p>
                <p class="font-serif" style="font-size:1.4rem;color:var(--forest);margin-top:4px;">Bojongnangka</p>
                <p style="font-size:0.78rem;color:var(--muted);margin-top:2px;">Jawa Tengah</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                ['🏊‍♂️','#EAF5F0','Kolam Renang','Kolam bersih dan terawat, cocok untuk semua usia'],
                ['🐰','#FEF6E4','Taman Kelinci','Area interaktif bersama kelinci yang menggemaskan'],
                ['🌳','#EDF5EE','Alam Terbuka','Udara segar dan pemandangan hijau menenangkan'],
                ['🎪','#FEF6E4','Area Keluarga','Ruang santai dan area bermain untuk si kecil'],
            ] as $idx => $f)
            <div style="background:{{ $f[1] }};border-radius:16px;padding:20px;" data-aos="fade-up" data-aos-delay="{{ $idx * 60 }}">
                <span style="font-size:1.8rem;display:block;margin-bottom:10px;">{{ $f[0] }}</span>
                <h3 style="font-weight:700;font-size:0.95rem;color:var(--forest);margin-bottom:5px;">{{ $f[2] }}</h3>
                <p style="font-size:0.82rem;color:var(--muted);line-height:1.6;">{{ $f[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════════════ GALERI ══════════════════ -->
<section id="galeri" style="background:var(--alt);padding:64px 0;">
    <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
        <div style="margin-bottom:28px;" data-aos="fade-up">
            <div class="sec-label">Galeri Wisata</div>
            <h2 class="font-serif" style="font-size:clamp(1.8rem,6vw,2.8rem);color:var(--forest);line-height:1.15;">Sorot Keindahan<br>Gatra Kencana</h2>
        </div>
        <div class="gal-card w-full mb-4 relative group overflow-hidden rounded-2xl h-64 md:h-80 shadow-md border border-white/5" data-aos="fade-up" data-aos-delay="60">
            <img src="{{ asset('assets/spot-foto.jpeg') }}" alt="Jembatan Sawah Gatra Kencana" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="gal-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="gal-text absolute bottom-4 left-4 right-4 z-10">
                <p class="font-serif text-white text-lg md:text-xl content-target opacity-0 transition-all duration-300 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0">Spot Foto Menarik</p>
                <p style="font-size:0.78rem;color:rgba(255,255,255,0.65);margin-top:2px;" class="content-target opacity-0 transition-all duration-300 delay-75 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0">Latar belakang hamparan sawah hijau Pemalang yang memukau</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            @foreach([['Kolam Renang Anak-anak', 'galeri-kolam.jpeg'], ['Wahana Interaktif Kelinci', 'galeri-kelinci.jpeg']] as $g)
            <div class="gal-card relative group overflow-hidden rounded-2xl h-40 md:h-48 shadow-md border border-white/5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <img src="{{ asset('assets/' . $g[1]) }}" alt="{{ $g[0] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="gal-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="gal-text absolute bottom-3 left-3 right-3 z-10">
                    <p class="font-serif text-white content-target opacity-0 transition-all duration-300 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0" style="font-size:0.85rem;">{{ $g[0] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach([
                ['Jembatan Sawah', 'galeri-jembatan.jpeg', 'Latar belakang hamparan sawah hijau Pemalang yang memukau'],
                ['Jalur Hijau', 'galeri-trekking.jpeg', 'Trekking santai di pinggiran sawah asri'],
                ['Terapi Ikan', 'galeri-terapi-ikan.jpeg', 'Relaksasi kaki yang luas dan menyehatkan'],
            ] as $g)
            <div class="gal-card relative group overflow-hidden rounded-2xl h-44 shadow-md border border-white/5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 70 }}">
                <img src="{{ asset('assets/' . $g[1]) }}" alt="{{ $g[0] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="gal-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="gal-text absolute bottom-3 left-3 right-3 z-10">
                    <p class="font-serif text-white content-target opacity-0 transition-all duration-300 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0" style="font-size:0.85rem;">{{ $g[0] }}</p>
                    <p style="font-size:0.72rem;color:rgba(255,255,255,0.6);margin-top:2px;" class="content-target opacity-0 transition-all duration-300 delay-75 transform translate-y-2 group-hover:opacity-100 group-hover:translate-y-0">{{ $g[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════════════ HARGA TIKET ══════════════════ -->
<section id="harga" style="background:#fff;padding:64px 0;">
    <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
        <div class="text-center" style="margin-bottom:36px;" data-aos="fade-up">
            <div class="sec-label" style="justify-content:center;">Harga Tiket Masuk</div>
            <h2 class="font-serif" style="font-size:clamp(1.8rem,6vw,2.8rem);color:var(--forest);line-height:1.15;margin-top:8px;">Terjangkau untuk<br><em>Seluruh Keluarga</em></h2>
            <p style="font-size:0.88rem;color:var(--muted);line-height:1.75;margin-top:10px;max-width:400px;margin-left:auto;margin-right:auto;">Harga disesuaikan otomatis berdasarkan hari kunjungan — lebih hemat di hari kerja.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="ticket-card" style="background:var(--alt);border:1px solid rgba(112,119,113,0.12);" data-aos="fade-up" data-aos-delay="0">
                <div style="padding:24px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <div style="width:44px;height:44px;background:rgba(42,157,111,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">🌿</div>
                        <span style="background:rgba(42,157,111,0.1);color:var(--eg);font-size:0.65rem;font-weight:700;letter-spacing:0.07em;padding:4px 10px;border-radius:100px;text-transform:uppercase;">Hari Kerja</span>
                    </div>
                    <h3 style="font-weight:700;font-size:1rem;color:var(--forest);margin-bottom:3px;">Loket Masuk</h3>
                    <p style="font-size:0.78rem;color:var(--muted);margin-bottom:16px;">Senin – Jumat (bukan libur)</p>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        @foreach([['👨 Dewasa',$ticketInfo['weekday']['adult']],['👦 Anak-Anak',$ticketInfo['weekday']['child']]] as $t)
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.875rem;color:var(--body);">{{ $t[0] }}</span>
                            <span style="font-weight:700;color:var(--eg);font-size:0.95rem;">Rp {{ number_format($t[1],0,',','.') }}</span>
                        </div>
                        @endforeach
                        <div style="border-top:1px dashed rgba(112,119,113,0.2);padding-top:10px;display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.875rem;color:var(--body);">🎫 Terusan</span>
                            <span style="font-weight:700;color:var(--eg);font-size:0.95rem;">Rp {{ number_format($ticketInfo['weekday']['terusan'],0,',','.') }}</span>
                        </div>
                        <!-- ══════════════════ Tombol pesen wa ══════════════════ -->
                        <div class="mt-4">
                            <a href="{{ route('public.booking', ['mode' => 'weekday']) }}" class="btn-primary w-full justify-center text-center py-2.5 text-xs shadow-none">📅 Booking Tiket Weekday</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="ticket-card" style="background:var(--forest);border:1px solid rgba(42,157,111,0.25);position:relative;" data-aos="fade-up" data-aos-delay="80">
                <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);background:var(--gold);color:var(--forest);font-size:0.65rem;font-weight:700;padding:4px 14px;border-radius:0 0 8px 8px;letter-spacing:0.07em;text-transform:uppercase;">Weekend & Libur</div>
                <div style="padding:24px;padding-top:40px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <div style="width:44px;height:44px;background:rgba(234,168,58,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">🌟</div>
                        <span style="background:rgba(234,168,58,0.15);color:var(--gold);font-size:0.65rem;font-weight:700;letter-spacing:0.07em;padding:4px 10px;border-radius:100px;text-transform:uppercase;">Akhir Pekan</span>
                    </div>
                    <h3 style="font-weight:700;font-size:1rem;color:white;margin-bottom:3px;">Loket Masuk</h3>
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.4);margin-bottom:16px;">Sabtu, Minggu & hari libur</p>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        @foreach([['👨 Dewasa',$ticketInfo['weekend']['adult']],['👦 Anak-Anak',$ticketInfo['weekend']['child']]] as $t)
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.875rem;color:rgba(255,255,255,0.7);">{{ $t[0] }}</span>
                            <span style="font-weight:700;color:var(--gold);font-size:0.95rem;">Rp {{ number_format($t[1],0,',','.') }}</span>
                        </div>
                        @endforeach
                        <div style="border-top:1px dashed rgba(255,255,255,0.1);padding-top:10px;display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.875rem;color:rgba(255,255,255,0.7);">🎫 Terusan</span>
                            <span style="font-weight:700;color:var(--gold);font-size:0.95rem;">Rp {{ number_format($ticketInfo['weekend']['terusan'],0,',','.') }}</span>
                        </div>
                        
                        <!-- ══════════════════ Tombol pesen wa ══════════════════ -->
                        <div class="mt-4">
                            <a href="{{ route('public.booking', ['mode' => 'weekend']) }}" class="btn-primary w-full justify-center text-center py-2.5 text-xs bg-gold hover:bg-gold-dark text-forest shadow-none">🌟 Booking Tiket Weekend</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ticket-card" style="background:var(--alt);border:1px solid rgba(112,119,113,0.12);" data-aos="fade-up" data-aos-delay="160">
                <div style="padding:24px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <div style="width:44px;height:44px;background:rgba(234,168,58,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">🎯</div>
                        <span style="background:rgba(234,168,58,0.12);color:var(--gold);font-size:0.65rem;font-weight:700;letter-spacing:0.07em;padding:4px 10px;border-radius:100px;text-transform:uppercase;">Harga Tetap</span>
                    </div>
                    <h3 style="font-weight:700;font-size:1rem;color:var(--forest);margin-bottom:3px;">Kolam & Kelinci</h3>
                    <p style="font-size:0.78rem;color:var(--muted);margin-bottom:20px;">Berlaku setiap hari</p>
                    <div style="text-align:center;padding:18px;background:white;border-radius:12px;border:1px solid rgba(234,168,58,0.2);">
                        <p class="font-serif" style="font-size:2.4rem;color:var(--forest);line-height:1;">Rp {{ number_format($ticketInfo['flat'],0,',','.') }}</p>
                        <p style="font-size:0.78rem;color:var(--muted);margin-top:5px;">per orang</p>
                    </div>
                    <p style="font-size:0.72rem;color:var(--muted);margin-top:12px;text-align:center;line-height:1.5;">Loket Kolam Renang &<br>Loket Taman Kelinci</p>                
                </div>
            </div>
        </div>
        <div style="margin-top:20px;background:#FFFBF0;border:1px solid rgba(234,168,58,0.25);border-radius:14px;padding:14px 16px;display:flex;align-items:flex-start;gap:10px;" data-aos="fade-up">
            <span style="font-size:1.1rem;flex-shrink:0;margin-top:2px;">💡</span>
            <div>
                <p style="font-size:0.85rem;font-weight:700;color:var(--forest);">Tiket Terusan — Akses Lengkap Hemat!</p>
                <p style="font-size:0.78rem;color:var(--muted);margin-top:4px;line-height:1.6;">Dengan Rp 12.000 setiap hari, nikmati akses masuk + kolam renang + taman kelinci sekaligus. Paket terbaik untuk kunjungan keluarga penuh!</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════ KABAR (Grid 2 Baris + Auto Horizontal Scroll) ══════════════════ -->
<section id="kabar" style="background:var(--alt);padding:64px 0;">
    <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
        
        <div style="margin-bottom:28px;" data-aos="fade-up">
            <div class="sec-label">Kabar Terkini</div>
            <h2 class="font-serif" style="font-size:clamp(1.8rem,6vw,2.8rem);color:var(--forest);line-height:1.15;">Kabar <em>Gatra Kencana</em></h2>
            <p class="text-xs text-gray-400 mt-1 sm:hidden">👉 Geser ke kanan untuk melihat kabar lainnya</p>
        </div>

       @php
            // 1. DATA MOCKUP BAWAAN ASLI (KITA KUNCI IS_DB = FALSE)
            $staticNews = [
                ['img'=>'news-panen.jpeg', 'tag'=>'Event', 'date'=>'Jun 2025', 'title'=>'Edukasi Penanaman Padi', 'desc'=>'Kenalkan generasi muda pada dunia pertanian lewat kegiatan seru belajar menanam padi langsung di sawah yang penuh edukasi dan keceriaan.', 'color'=>'var(--eg)', 'bg'=>'rgba(42,157,111,0.1)', 'is_db'=>false],
                ['img'=>'news-gazebo.jpeg', 'tag'=>'Fasilitas', 'date'=>'Mei 2025', 'title'=>'Fasilitas Gazebo Baru', 'desc'=>'Kami menambahkan 4 unit gazebo dengan pemandangan sawah langsung — tempat sempurna untuk bersantai dan bercengkrama.', 'color'=>'var(--gold)', 'bg'=>'rgba(234,168,58,0.12)', 'is_db'=>false],
                ['img'=>'news-bermain.jpeg', 'tag'=>'Wahana', 'date'=>'Apr 2025', 'title'=>'Area Bermain Diperluas', 'desc'=>'Area bermain anak kini 2x lebih luas dengan wahana baru yang aman dan menyenangkan untuk semua usia.', 'color'=>'var(--eg)', 'bg'=>'rgba(42,157,111,0.1)', 'is_db'=>false],
                ['img'=>'spot-foto.jpeg', 'tag'=>'Spot Foto', 'date'=>'Mar 2025', 'title'=>'Spot Foto Instagramable', 'desc'=>'Spot-spot foto baru dengan pemandangan sawah pedesaan Pemalang — wajib dikunjungi pencinta fotografi.', 'color'=>'var(--gold)', 'bg'=>'rgba(234,168,58,0.12)', 'is_db'=>false],
                ['img'=>'news-lomba.jpeg', 'tag'=>'Lomba', 'date'=>'Agu 2025', 'title'=>'Lomba Mewarnai Anak-anak', 'desc'=>'Ekspresikan kreativitas dan keceriaan si kecil melalui coretan warna-warni indah dalam kompetisi seni yang seru dan penuh inspirasi.', 'color'=>'var(--eg)', 'bg'=>'rgba(42,157,111,0.1)', 'is_db'=>false],
                ['img'=>'news-wisata-sekolah.jpeg', 'tag'=>'Wisata Sekolah', 'date'=>'April 2026', 'title'=>'Wisata Anak Sekolah', 'desc'=>'Ciptakan momen belajar yang seru dan tak terlupakan bagi anak-anak melalui petualangan wisata edukatif yang penuh keceriaan di luar kelas.', 'color'=>'var(--gold)', 'bg'=>'rgba(234,168,58,0.12)', 'is_db'=>false],
            ];

            // 2. WADAH UTAMA
            $allNews = collect();
            
            // 3. PAKSA MASUKKAN DATA DATABASE TEJO (KITA KUNCI IS_DB = TRUE)
            if (isset($newsArticles) && $newsArticles->count() > 0) {
                foreach($newsArticles as $dbItem) {
                    $allNews->push([
                        'img'   => $dbItem->image,
                        'tag'   => $dbItem->tag ?? 'KABAR',
                        'date'  => $dbItem->published_date ? \Carbon\Carbon::parse($dbItem->published_date)->translatedFormat('M Y') : \Carbon\Carbon::parse($dbItem->created_at)->translatedFormat('M Y'),
                        'title' => $dbItem->title,
                        'desc'  => $dbItem->content,
                        'color' => 'var(--eg)',
                        'bg'    => 'rgba(42,157,111,0.1)',
                        'is_db' => true // Kunci status dari database
                    ]);
                }
            } elseif (isset($news) && $news->count() > 0) {
                // Jaga-jaga kalau variabel di controller lo namanya $news
                foreach($news as $dbItem) {
                    $allNews->push([
                        'img'   => $dbItem->image,
                        'tag'   => $dbItem->tag ?? 'KABAR',
                        'date'  => $dbItem->published_date ? \Carbon\Carbon::parse($dbItem->published_date)->translatedFormat('M Y') : \Carbon\Carbon::parse($dbItem->created_at)->translatedFormat('M Y'),
                        'title' => $dbItem->title,
                        'desc'  => $dbItem->content,
                        'color' => 'var(--eg)',
                        'bg'    => 'rgba(42,157,111,0.1)',
                        'is_db' => true
                    ]);
                }
            }
            
            // 4. GABUNGKAN DATA BAWAAN DI BELAKANGNYA
            foreach($staticNews as $staticItem) {
                $allNews->push($staticItem);
            }
        @endphp
        
        {{-- CONTAINER SLIDE HORIZONTAL --}}
        <div class="w-full overflow-x-auto scroll-smooth pb-4 -mx-4 px-4 sm:mx-0 sm:px-0" style="scrollbar-width: thin; -webkit-overflow-scrolling: touch;">
            
            {{-- ENGINE LAYOUT 2 BARIS --}}
            <div class="grid grid-rows-2 grid-flow-col gap-5 auto-cols-[85%] md:auto-cols-[31.5%]">
                
                @foreach($allNews as $i => $item)
                <article class="news-card group overflow-hidden rounded-2xl border border-gray-100 shadow-sm bg-white flex flex-col h-full min-w-0" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 60 }}" data-aos-duration="600">
                    
                   {{-- AREA GAMBAR KONTEN --}}
                    <div class="w-full h-44 overflow-hidden relative bg-gray-100 flex-shrink-0 flex items-center justify-center text-xs text-gray-400">
                        @if($item['is_db'] && !empty($item['img']))
                            {{-- Jika dari DB dan teks path gambarnya ada --}}
                            <img src="{{ asset('storage/' . $item['img']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @elseif(!$item['is_db'])
                            {{-- Jika data bawaan static --}}
                            <img src="{{ asset('assets/' . $item['img']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            {{-- Kalau variabel img dari DB kebaca kosong/null --}}
                            <div class="text-center p-4">
                                <p class="text-lg">🖼️</p>
                                <p class="font-semibold text-[10px] text-gray-400 uppercase">Nama File Di DB Kosong</p>
                            </div>
                        @endif
                    </div>

                    {{-- AREA TEKS KONTEN --}}
                    <div class="p-4 flex flex-col flex-grow justify-between bg-white">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span style="background: {{ $item['bg'] }}; color: {{ $item['color'] }};" class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                    {{ $item['tag'] }}
                                </span>
                                <span class="text-[11px] text-muted font-medium">
                                    {{ $item['date'] }}
                                </span>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 text-[0.95rem] leading-snug mb-1.5 group-hover:text-green-700 transition-colors line-clamp-2">
                                {{ $item['title'] }}
                            </h3>
                            
                            <p class="text-xs text-muted leading-relaxed line-clamp-3">
                                {{ strip_tags($item['desc']) }}
                            </p>
                        </div>
                    </div>
                </article>
                @endforeach

            </div>
        </div>
    </div>
</section>

<!-- ══════════════════ LOKASI ══════════════════ -->
<section id="lokasi" style="background:#fff;padding:64px 0;">
    <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
        <div style="margin-bottom:28px;" data-aos="fade-up">
            <div class="sec-label">Temukan Kami</div>
            <h2 class="font-serif" style="font-size:clamp(1.8rem,6vw,2.8rem);color:var(--forest);line-height:1.15;">Mudah Dijangkau,<br>Tak Ingin<br><em>Beranjak Pulang</em></h2>
        </div>
        <div class="grid grid-cols-1 gap-3 mb-6" data-aos="fade-up" data-aos-delay="60">
            @foreach([
                ['📍','Alamat','Bojongnangka, Pemalang, Jawa Tengah, Indonesia'],
                ['⏰','Jam Buka','Setiap Hari, 07.00 – 18.00 WIB'],
                ['🚗','Parkir','Area parkir luas untuk motor dan mobil'],
            ] as $d)
            <div style="display:flex;align-items:flex-start;gap:12px;padding:14px 16px;background:var(--alt);border-radius:12px;">
                <span style="font-size:1.1rem;flex-shrink:0;margin-top:1px;">{{ $d[0] }}</span>
                <div>
                    <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--muted);">{{ $d[1] }}</p>
                    <p style="font-size:0.875rem;color:var(--forest);font-weight:600;margin-top:2px;">{{ $d[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div style="border-radius:20px;overflow:hidden;box-shadow:0 8px 40px rgba(30,37,34,0.1);margin-bottom:20px;" data-aos="fade-up" data-aos-delay="100">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.796494670229!2d109.36867417399752!3d-6.914918093084629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fc5b177ecb2d1%3A0x8071a0d794db9bb7!2sGatra%20Kencana%20Bojongnangka!5e0!3m2!1sen!2sid!4v1780742720825!5m2!1sen!2sid" width="100%" height="300" style="border:0;display:block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <a href="https://maps.app.goo.gl/pvUC7XiLy6sm3qgs8" target="_blank" class="btn-primary" style="display:inline-flex;">🗺️ Buka di Google Maps</a>
    </div>
</section>

<!-- ══════════════════ CTA BANNER ══════════════════ -->
<section style="background:var(--eg);padding:64px 0;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
    <div class="w-full px-4 text-center relative" style="max-width:600px;margin:0 auto;" data-aos="fade-up">
        <p style="font-size:0.7rem;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:rgba(255,255,255,0.55);margin-bottom:14px;">Rencanakan Kunjungan Anda</p>
        <h2 class="font-serif text-white" style="font-size:clamp(1.8rem,6vw,2.8rem);line-height:1.15;margin-bottom:16px;">Siap Rasakan Kesegaran<br>Gatra Kencana?</h2>
        <p style="font-size:0.875rem;color:rgba(255,255,255,0.7);line-height:1.75;margin-bottom:28px;">Ajak keluarga berlibur ke destinasi wisata kami. Tiket terjangkau, kenangan tak ternilai.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="#harga" style="display:inline-flex;align-items:center;gap:8px;background:white;color:var(--eg);padding:14px 24px;border-radius:100px;font-weight:700;font-size:0.875rem;text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,0.15);">🎟️ Lihat Harga Tiket</a>
        </div>
    </div>
</section>

<!-- ══════════════════ FOOTER ══════════════════ -->
<footer style="background:var(--forest);color:rgba(255,255,255,0.45);padding:48px 0 28px;">
    <div class="w-full px-4" style="max-width:1024px;margin:0 auto;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div style="width:34px; height:34px; border-radius:9px; overflow:hidden; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" alt="Logo Gatra Kencana" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div>
                        <p class="font-serif" style="color:white;font-size:0.875rem;">Gatra Kencana</p>
                        <p style="font-size:0.65rem;color:rgba(255,255,255,0.3);">Wisata Keluarga</p>
                    </div>
                </div>
                <p style="font-size:0.82rem;line-height:1.7;max-width:220px;">Destinasi wisata keluarga terfavorit di Bojongnangka, Jawa Tengah.</p>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:12px;">Navigasi</p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach(['#tentang'=>'Tentang Kami','#galeri'=>'Galeri','#harga'=>'Harga Tiket','#kabar'=>'Kabar Terkini','#lokasi'=>'Lokasi'] as $href=>$label)
                    <a href="{{ $href }}" style="font-size:0.85rem;color:rgba(255,255,255,0.45);text-decoration:none;">{{ $label }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:12px;">Info</p>
                <div style="display:flex;flex-direction:column;gap:8px;font-size:0.85rem;">
                    <p>📍 Bojongnangka, Jawa Tengah</p>
                    <p>⏰ Setiap Hari, 07.00 – 18.00</p>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.07);padding-top:20px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:8px;">
            <p style="font-size:0.75rem;">© {{ date('Y') }} Wisata Gatra Kencana Bojongnangka.</p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true, easing: 'ease-out-quart', offset: 50, duration: 650 });
    
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
    }, { passive: true });
    
    function toggleMenu() {
        const m = document.getElementById('mobile-menu');
        m.classList.toggle('open');
        document.body.style.overflow = m.classList.contains('open') ? 'hidden' : '';
    }
    
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const el = document.querySelector(a.getAttribute('href'));
            if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
        });
    });
</script>
</body>
</html>