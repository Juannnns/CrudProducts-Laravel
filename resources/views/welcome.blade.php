<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Gestión de Productos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <style>
*{margin:0;padding:0;box-sizing:border-box;}
:root{--c1:#d9a05b;--c2:#a67c52;--c3:#734f32;--c4:#8c6b4a;}
html{scroll-behavior:smooth;}
body{font-family:'Inter',sans-serif;background:#0f0b08;color:#fff;overflow-x:hidden;}

/* CANVAS */
#bg-canvas{position:fixed;inset:0;z-index:0;pointer-events:none;}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:200;padding:.9rem 2rem;display:flex;justify-content:space-between;align-items:center;transition:all .5s cubic-bezier(.4,0,.2,1);}
nav.solid{background:rgba(15,11,8,.85);backdrop-filter:blur(24px);border-bottom:1px solid rgba(217,160,91,.2);box-shadow:0 8px 40px rgba(0,0,0,.4);}
.logo{font-size:1.35rem;font-weight:900;background:linear-gradient(135deg,#e6b877,#bf956b,#8c6444);-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:-.5px;}
.nav-links{display:flex;gap:.75rem;align-items:center;}
.nav-a{padding:.4rem 1rem;border-radius:8px;font-size:.875rem;font-weight:500;color:rgba(255,255,255,.65);text-decoration:none;transition:all .25s;}
.nav-a:hover{color:#fff;background:rgba(255,255,255,.08);}
.nav-btn{padding:.45rem 1.2rem;border-radius:9px;font-size:.875rem;font-weight:700;color:#fff;text-decoration:none;background:linear-gradient(135deg,var(--c1),var(--c2));box-shadow:0 0 20px rgba(217,160,91,.45);transition:all .3s;}
.nav-btn:hover{transform:translateY(-2px);box-shadow:0 0 35px rgba(166,124,82,.7);}

/* HERO */
.hero{position:relative;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:5rem 2rem 3rem;z-index:1;overflow:hidden;}
.hero-mesh{position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 50% 30%,rgba(217,160,91,.16) 0%,transparent 70%);transition:background 1s ease;}
.hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(217,160,91,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(217,160,91,.04) 1px,transparent 1px);background-size:70px 70px;mask-image:radial-gradient(ellipse 75% 75% at 50% 40%,black 0%,transparent 80%);}
.hero-content{position:relative;z-index:2;max-width:880px;}
.hero-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.35rem 1rem;border-radius:100px;font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;background:rgba(217,160,91,.12);border:1px solid rgba(217,160,91,.3);color:#d9ba9c;margin-bottom:1.75rem;opacity:0;}
.pulse-dot{width:7px;height:7px;border-radius:50%;background:#dbb27f;box-shadow:0 0 10px #dbb27f;animation:pulseDot 2s ease-in-out infinite;}
.hero-title{font-size:clamp(2.6rem,7vw,5.5rem);font-weight:900;line-height:1.04;letter-spacing:-2px;margin-bottom:1.5rem;opacity:0;}
.hero-title .grad{background:linear-gradient(135deg,#e6b877 0%,#bf956b 45%,#8c6444 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
.typewriter{display:inline-block;border-right:3px solid #e6b877;padding-right:25px;box-sizing:content-box;white-space:nowrap;overflow:hidden;width:0;animation:typeReveal 1s steps(20,end) 1.4s forwards,blinkCursor .7s step-end 2.4s infinite;}@keyframes typeReveal{from{width:0}to{width:100%}}
.hero-sub{font-size:1.1rem;color:rgba(255,255,255,.5);line-height:1.75;max-width:580px;margin:0 auto 2.5rem;opacity:0;}
.cta-row{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;opacity:0;}
.btn-p{display:inline-flex;align-items:center;gap:.5rem;padding:.85rem 2rem;border-radius:12px;font-weight:700;font-size:.95rem;color:#fff;text-decoration:none;background:linear-gradient(135deg,var(--c1),var(--c2));box-shadow:0 0 30px rgba(217,160,91,.5),0 8px 30px rgba(217,160,91,.3);transition:all .35s cubic-bezier(.4,0,.2,1);position:relative;overflow:hidden;}
.btn-p::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--c2),var(--c3));opacity:0;transition:opacity .35s;}
.btn-p:hover::after{opacity:1;}
.btn-p:hover{transform:translateY(-4px) scale(1.03);box-shadow:0 0 55px rgba(166,124,82,.75),0 16px 40px rgba(217,160,91,.4);}
.btn-p span{position:relative;z-index:1;}
.btn-s{display:inline-flex;align-items:center;gap:.5rem;padding:.85rem 2rem;border-radius:12px;font-weight:600;font-size:.95rem;color:rgba(255,255,255,.8);text-decoration:none;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.14);transition:all .35s cubic-bezier(.4,0,.2,1);backdrop-filter:blur(12px);}
.btn-s:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.28);transform:translateY(-4px);color:#fff;}

/* FLOATING CARDS */
.float-cards{position:absolute;inset:0;pointer-events:none;z-index:1;}
.fcard{position:absolute;border-radius:16px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.09);backdrop-filter:blur(14px);padding:.85rem 1.25rem;display:flex;align-items:center;gap:.7rem;font-size:.82rem;font-weight:500;color:rgba(255,255,255,.8);box-shadow:0 20px 60px rgba(0,0,0,.4);opacity:0;}
.fcard-icon{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;}
.fcard-label{font-size:.65rem;color:rgba(255,255,255,.35);margin-bottom:1px;}
.fc1{top:22%;left:4%;}
.fc2{top:28%;right:5%;}
.fc3{bottom:28%;left:6%;}
.fc4{bottom:32%;right:6%;}

/* SCROLL CUE */
.scroll-cue{position:absolute;bottom:2.5rem;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:.45rem;color:rgba(255,255,255,.25);font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;opacity:0;}
.scroll-line{width:1px;height:48px;background:linear-gradient(180deg,rgba(217,160,91,.8),transparent);animation:scrollLine 1.8s ease-in-out infinite;}

/* SECTION SHARED */
.section{position:relative;z-index:1;padding:9rem 2rem;}
.sec-label{display:inline-block;font-size:.72rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#e6b877;margin-bottom:.9rem;padding:.3rem 1rem;border-radius:100px;background:rgba(217,160,91,.1);border:1px solid rgba(217,160,91,.22);}
.sec-title{font-size:clamp(1.9rem,4vw,3.2rem);font-weight:900;letter-spacing:-1px;line-height:1.08;margin-bottom:.9rem;}
.sec-sub{color:rgba(255,255,255,.4);font-size:1rem;max-width:480px;margin:0 auto;line-height:1.7;}
.sec-head{text-align:center;margin-bottom:5rem;}

/* STATS */
.stats-wrap{background:linear-gradient(135deg,rgba(217,160,91,.07),rgba(166,124,82,.04));border-top:1px solid rgba(217,160,91,.14);border-bottom:1px solid rgba(217,160,91,.14);}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:2rem;max-width:900px;margin:0 auto;text-align:center;}
.stat-num{font-size:3.4rem;font-weight:900;letter-spacing:-2px;background:linear-gradient(135deg,#e6b877,#bf956b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block;line-height:1;}
.stat-lbl{color:rgba(255,255,255,.4);font-size:.85rem;margin-top:.45rem;}

/* FEATURES */
.feat-section{background:linear-gradient(180deg,#0f0b08 0%,#1c1510 100%);}
.feat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(290px,1fr));gap:1.4rem;max-width:1080px;margin:0 auto;}
.feat-card{padding:2rem;border-radius:20px;background:rgba(255,255,255,.025);border:1px solid rgba(255,255,255,.065);transition:border-color .3s,box-shadow .3s;position:relative;overflow:hidden;transform-style:preserve-3d;cursor:default;}
.feat-card-inner{position:relative;z-index:1;}
.feat-glow{position:absolute;width:160px;height:160px;border-radius:50%;filter:blur(50px);top:-40px;left:-40px;opacity:0;transition:opacity .5s;}
.feat-card:hover .feat-glow{opacity:.18;}
.feat-card:hover{border-color:rgba(255,255,255,.14);box-shadow:0 30px 80px rgba(0,0,0,.5);}
.feat-ico{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.35rem;margin-bottom:1.2rem;}
.feat-name{font-size:1.05rem;font-weight:700;margin-bottom:.5rem;}
.feat-desc{font-size:.875rem;color:rgba(255,255,255,.42);line-height:1.65;}
.feat-tag{display:inline-block;margin-top:.9rem;padding:.22rem .75rem;border-radius:100px;font-size:.7rem;font-weight:700;letter-spacing:.05em;}

/* 3D CUBE */
.cube-section{display:flex;align-items:center;justify-content:center;gap:5rem;flex-wrap:wrap;background:#1c1510;}
.scene{width:190px;height:190px;perspective:700px;flex-shrink:0;}
.cube{width:100%;height:100%;position:relative;transform-style:preserve-3d;animation:spinCube 12s linear infinite;}
.face{position:absolute;width:190px;height:190px;display:flex;align-items:center;justify-content:center;font-size:2.4rem;border-radius:14px;border:1.5px solid rgba(217,160,91,.35);}
.face-f{background:rgba(217,160,91,.1);transform:translateZ(95px);}
.face-b{background:rgba(166,124,82,.1);transform:rotateY(180deg) translateZ(95px);}
.face-r{background:rgba(115,79,50,.1);transform:rotateY(90deg) translateZ(95px);}
.face-l{background:rgba(140,107,74,.1);transform:rotateY(-90deg) translateZ(95px);}
.face-t{background:rgba(92,58,33,.1);transform:rotateX(90deg) translateZ(95px);}
.face-bo{background:rgba(196,139,82,.1);transform:rotateX(-90deg) translateZ(95px);}
.cube-txt{max-width:460px;}
.cube-txt h2{font-size:clamp(1.9rem,4vw,3rem);font-weight:900;letter-spacing:-1px;margin-bottom:1rem;}
.cube-txt p{color:rgba(255,255,255,.45);line-height:1.75;font-size:.97rem;}

/* TECH */
.tech-section{background:linear-gradient(180deg,#1c1510 0%,#0f0b08 100%);}
.tech-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:1.2rem;max-width:980px;margin:0 auto;}
.tech-card{padding:2rem;border-radius:18px;background:rgba(255,255,255,.025);border:1px solid rgba(255,255,255,.065);text-align:center;transition:all .4s cubic-bezier(.4,0,.2,1);position:relative;overflow:hidden;}
.tech-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--ac),transparent);opacity:0;transition:opacity .4s;}
.tech-card:hover{transform:translateY(-8px) scale(1.02);border-color:rgba(255,255,255,.13);box-shadow:0 30px 60px rgba(0,0,0,.5);}
.tech-card:hover::after{opacity:1;}
.tech-emoji{font-size:2.7rem;margin-bottom:.7rem;display:block;filter:drop-shadow(0 0 14px rgba(255,255,255,.25));}
.tech-name{font-size:1.05rem;font-weight:700;margin-bottom:.25rem;}
.tech-desc{font-size:.8rem;color:rgba(255,255,255,.38);}

/* CTA */
.cta-section{text-align:center;overflow:hidden;background:#0f0b08;}
.cta-orb{position:absolute;border-radius:50%;filter:blur(90px);}
.cta-o1{width:450px;height:450px;background:rgba(217,160,91,.14);top:-120px;left:-80px;}
.cta-o2{width:350px;height:350px;background:rgba(115,79,50,.09);bottom:-100px;right:-60px;}
.cta-inner{position:relative;z-index:1;max-width:640px;margin:0 auto;}
.cta-title{font-size:clamp(2.2rem,5vw,3.8rem);font-weight:900;letter-spacing:-1.5px;margin-bottom:1.2rem;}
.cta-sub{color:rgba(255,255,255,.44);font-size:1.05rem;margin-bottom:2.5rem;line-height:1.75;}

/* FOOTER */
footer{padding:2.5rem 2rem;text-align:center;border-top:1px solid rgba(255,255,255,.05);background:#0f0b08;color:rgba(255,255,255,.28);font-size:.85rem;position:relative;z-index:1;}

/* ANIMATIONS */
@keyframes pulseDot{0%,100%{box-shadow:0 0 10px #dbb27f;opacity:1;}50%{box-shadow:0 0 4px #dbb27f;opacity:.5;}}
@keyframes typeReveal{from{width:0;}to{width:100%;}}
@keyframes blinkCursor{0%,100%{border-color:#e6b877;}50%{border-color:transparent;}}
@keyframes scrollLine{0%,100%{opacity:1;transform:scaleY(1);}50%{opacity:.25;transform:scaleY(.5);}}
@keyframes spinCube{from{transform:rotateX(14deg) rotateY(0);}to{transform:rotateX(14deg) rotateY(360deg);}}
@keyframes orbFloat{0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(30px,-40px) scale(1.08);}66%{transform:translate(-20px,20px) scale(.93);}}

/* BG ORBS */
.bg-orb{position:fixed;border-radius:50%;filter:blur(100px);pointer-events:none;z-index:0;will-change:transform;}
.o1{width:600px;height:600px;background:rgba(217,160,91,.08);top:-80px;left:-120px;animation:orbFloat 12s ease-in-out infinite;}
.o2{width:500px;height:500px;background:rgba(166,124,82,.06);bottom:-80px;right:-80px;animation:orbFloat 15s ease-in-out infinite reverse;}
.o3{width:400px;height:400px;background:rgba(140,107,74,.05);top:40%;left:40%;animation:orbFloat 10s ease-in-out infinite 3s;}

/* RESPONSIVE MEDIA QUERIES */
@media(max-width: 991px){
    .fcard{display:none;}
    .hero-title{font-size:clamp(2.4rem, 6vw, 4rem);}
    .stats-grid{grid-template-columns:repeat(2, 1fr);}
    .cube-section{flex-direction:column;text-align:center;gap:3rem;}
    .cube-txt{text-align:center;}
}

@media(max-width: 768px){
    nav { flex-direction: column; padding: 1rem; gap: 0.8rem; background: rgba(15,11,8,.95); border-bottom: 1px solid rgba(217,160,91,.2); }
    nav.solid { padding: 1rem; }
    .nav-links { flex-wrap: wrap; justify-content: center; width: 100%; gap: 0.5rem; }
    .hero { padding: 8rem 1.5rem 3rem; }
    .hero-title { font-size: 2.5rem; letter-spacing: -1px; }
    .section { padding: 6rem 1.5rem !important; }
    
    .cta-row { display: flex; flex-direction: column; align-items: stretch; margin: 0 auto; max-width: 320px; width: 100%; }
    .cta-row a { width: 100%; justify-content: center; }
    
    .feat-grid { grid-template-columns: minmax(240px, 1fr); gap: 1.2rem; }
    .tech-grid { grid-template-columns: minmax(200px, 1fr) !important; gap: 1rem !important; }
    
    .cta-section > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 3rem !important; }
    .cta-inner { text-align: center !important; }
    .cta-feats li { justify-content: center; }
    .cta-inner > div { flex-direction: column !important; justify-content: center !important; align-items: stretch !important; max-width: 320px; margin-left: auto; margin-right: auto; }
    .cta-inner > div > a { justify-content: center !important; width: 100%; }
    .cta-preview { display: none; }
    .cta-title { font-size: 2.2rem !important; }
    
    .sec-head { margin-bottom: 3.5rem; }
}

@media(max-width: 480px){
    .stats-grid { grid-template-columns: 1fr; gap: 2rem; }
    .hero-title { font-size: 2.1rem; }
    .hero-sub { font-size: 0.95rem; line-height: 1.6; }
    .stat-num { font-size: 2.8rem; }
    .sec-title { font-size: 1.8rem; }
    footer { padding: 2rem 1.5rem; }
    .logo { font-size: 1.2rem; }
    
    .btn-p, .btn-s { padding: .75rem 1.5rem !important; font-size: .9rem !important; }
}
    </style>
</head>
<body>

<!-- Background orbs -->
<div class="bg-orb o1"></div>
<div class="bg-orb o2"></div>
<div class="bg-orb o3"></div>
<canvas id="bg-canvas"></canvas>

<!-- NAV -->
<nav id="nav">
    <div class="logo">{{ config('app.name', 'CrudProducts') }}</div>
    <div class="nav-links">
        @if(Route::has('login'))
        @auth
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-a" style="background:none;border:none;cursor:pointer;font-family:inherit;font-size:inherit;padding:.4rem 1rem;border-radius:8px;transition:all .25s;display:inline-flex;align-items:center;gap:.4rem;color:rgba(255,255,255,.65);" onmouseover="this.style.color='#8c6444';this.style.background='rgba(115,79,50,.1)'" onmouseout="this.style.color='rgba(255,255,255,.65)';this.style.background='none'">
                    <svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Cerrar Sesión
                </button>
            </form>
        @else
            @if(Route::has('register'))
                <a href="{{ route('login') }}" class="nav-a">Iniciar Sesión</a>
            @endif
        @endauth
    </div>
    @endif
</nav>

<!-- HERO -->
<section class="hero" id="hero">
    <div class="hero-mesh" id="heroBg"></div>
    <div class="hero-grid"></div>

    <div class="float-cards" aria-hidden="true">
        <div class="fcard fc1">
            <div class="fcard-icon" style="background:rgba(217,160,91,.2)">📦</div>
            <div><div class="fcard-label">Nuevo producto</div>{{ $ultimoProducto ? Str::limit($ultimoProducto->nombre, 18) : 'Sin productos aún' }}</div>
        </div>
        <div class="fcard fc2">
            <div class="fcard-icon" style="background:rgba(92,58,33,.2)">✅</div>
            <div><div class="fcard-label">Venta completada</div><span style="color:#dbb27f">+$1,240</span></div>
        </div>
        <div class="fcard fc3">
            <div class="fcard-icon" style="background:rgba(115,79,50,.2)">📊</div>
            <div><div class="fcard-label">Inventario activo</div>{{ $totalProductos }} {{ $totalProductos === 1 ? 'producto' : 'productos' }}</div>
        </div>
        <div class="fcard fc4">
            <div class="fcard-icon" style="background:rgba(140,107,74,.2)">⚡</div>
            <div><div class="fcard-label">API Status</div>99.9% uptime</div>
        </div>
    </div>

    <div class="hero-content" id="heroContent">
        <div class="hero-badge" id="badge">
            <span class="pulse-dot"></span>
            Plataforma Empresarial
        </div>
        <h1 class="hero-title" id="heroTitle">
            Sistema de<br>
            <span class="grad"><span class="typewriter" id="tw">Gestión de Productos</span></span>
        </h1>
        <p class="hero-sub" id="heroSub">
            Una plataforma moderna y potente para administrar tu catálogo de productos.
            Desarrollada con Laravel y las mejores prácticas del desarrollo web.
        </p>
        <div class="cta-row" id="heroCtaRow">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-p"><span>🚀</span><span>Ir al Dashboard</span></a>
            @else
                <a href="{{ route('productos.index') }}" class="btn-p"><span>🍽️</span><span>Ver Menú</span></a>
                <a href="{{ route('login') }}" class="btn-s">Iniciar Sesión →</a>
            @endauth
        </div>
    </div>

    <div class="scroll-cue" id="scrollCue">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>

<!-- STATS -->
<section class="section stats-wrap" style="padding:5rem 2rem;">
    <div class="stats-grid">
        @php
            // Extraer números y sufijos de las strings (ej: de "300+" sacar "300" y "+")
            $prodNum = (int) filter_var($steppedProductos, FILTER_SANITIZE_NUMBER_INT);
            $prodSuf = str_replace($prodNum, '', $steppedProductos);
            
            $catNum = (int) filter_var($steppedCategorias, FILTER_SANITIZE_NUMBER_INT);
            $catSuf = str_replace($catNum, '', $steppedCategorias);
        @endphp
        <div class="stat-item"><span class="stat-num" data-val="{{ $prodNum }}" data-suf="{{ $prodSuf }}">0</span><div class="stat-lbl">Productos Activos</div></div>
        <div class="stat-item"><span class="stat-num" data-val="99" data-suf="%">0</span><div class="stat-lbl">Uptime Garantizado</div></div>
        <div class="stat-item"><span class="stat-num" data-val="{{ $catNum }}" data-suf="{{ $catSuf }}">0</span><div class="stat-lbl">Categorías Disponibles</div></div>
        <div class="stat-item"><span class="stat-num" data-val="24" data-suf="/7">0</span><div class="stat-lbl">Soporte Continuo</div></div>
    </div>
</section>

<!-- FEATURES -->
<section class="section feat-section" id="features">
    <div class="sec-head">
        <div class="sec-label">Características</div>
        <h2 class="sec-title">Todo lo que necesitas,<br>en un solo lugar</h2>
        <p class="sec-sub">Gestión completa de productos con las herramientas más modernas del mercado</p>
    </div>
    <div class="feat-grid">
        <div class="feat-card" data-color="#d9a05b">
            <div class="feat-glow" style="background:#d9a05b"></div>
            <div class="feat-card-inner">
                <div class="feat-ico" style="background:rgba(217,160,91,.15)">📦</div>
                <div class="feat-name">Gestión Completa</div>
                <div class="feat-desc">Crea, edita, elimina y administra todos tus productos desde una interfaz intuitiva y rápida.</div>
                <span class="feat-tag" style="background:rgba(217,160,91,.12);color:#e6b877">CRUD</span>
            </div>
        </div>
        <div class="feat-card" data-color="#a67c52">
            <div class="feat-glow" style="background:#a67c52"></div>
            <div class="feat-card-inner">
                <div class="feat-ico" style="background:rgba(166,124,82,.15)">🏷️</div>
                <div class="feat-name">Categorías</div>
                <div class="feat-desc">Organiza tus productos por categorías para una mejor administración y búsqueda eficiente.</div>
                <span class="feat-tag" style="background:rgba(166,124,82,.12);color:#bf956b">Filtros</span>
            </div>
        </div>
        <div class="feat-card" data-color="#5c3a21">
            <div class="feat-glow" style="background:#5c3a21"></div>
            <div class="feat-card-inner">
                <div class="feat-ico" style="background:rgba(92,58,33,.15)">🖼️</div>
                <div class="feat-name">Imágenes Múltiples</div>
                <div class="feat-desc">Sube múltiples imágenes para cada producto y crea galerías visuales atractivas.</div>
                <span class="feat-tag" style="background:rgba(92,58,33,.12);color:#dbb27f">Galería</span>
            </div>
        </div>
        <div class="feat-card" data-color="#c48b52">
            <div class="feat-glow" style="background:#c48b52"></div>
            <div class="feat-card-inner">
                <div class="feat-ico" style="background:rgba(196,139,82,.15)">🔐</div>
                <div class="feat-name">Seguridad</div>
                <div class="feat-desc">Autenticación robusta y gestión de permisos con Laravel Jetstream y Sanctum.</div>
                <span class="feat-tag" style="background:rgba(196,139,82,.12);color:#e6b877">Auth</span>
            </div>
        </div>
        <div class="feat-card" data-color="#734f32">
            <div class="feat-glow" style="background:#734f32"></div>
            <div class="feat-card-inner">
                <div class="feat-ico" style="background:rgba(115,79,50,.15)">⚡</div>
                <div class="feat-name">API REST</div>
                <div class="feat-desc">API completa para integración con aplicaciones externas, móviles y de terceros.</div>
                <span class="feat-tag" style="background:rgba(115,79,50,.12);color:#8c6444">REST</span>
            </div>
        </div>
        <div class="feat-card" data-color="#8c6b4a">
            <div class="feat-glow" style="background:#8c6b4a"></div>
            <div class="feat-card-inner">
                <div class="feat-ico" style="background:rgba(140,107,74,.15)">📱</div>
                <div class="feat-name">Responsive</div>
                <div class="feat-desc">Diseño completamente adaptable para desktop, tablet y dispositivos móviles.</div>
                <span class="feat-tag" style="background:rgba(140,107,74,.12);color:#a6835d">Mobile</span>
            </div>
        </div>
    </div>
</section>

<!-- CUBE SECTION -->
<section class="section cube-section" id="cubeSection">
    <div class="scene" id="cubeScene">
        <div class="cube">
            <div class="face face-f">🚀</div>
            <div class="face face-b">⚡</div>
            <div class="face face-r">🎨</div>
            <div class="face face-l">🔐</div>
            <div class="face face-t">📦</div>
            <div class="face face-bo">🌐</div>
        </div>
    </div>
    <div class="cube-txt">
        <div class="sec-label" style="text-align:left;display:inline-block;">Tecnología de Punta</div>
        <h2>Construido con las<br>mejores herramientas</h2>
        <p style="margin-top:1rem;">Cada tecnología fue elegida para garantizar rendimiento, escalabilidad y una experiencia de desarrollo excepcional.</p>
    </div>
</section>

<!-- TECH -->
<section class="section tech-section">
    <div class="sec-head">
        <div class="sec-label">Stack Tecnológico</div>
        <h2 class="sec-title">Tecnologías Utilizadas</h2>
        <p class="sec-sub">Las herramientas más modernas y confiables del ecosistema web actual</p>
    </div>
    <div class="tech-grid" style="grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.4rem;">

        <!-- Laravel -->
        <div class="tech-card" style="--ac:#ff2d20">
            <div class="tech-logo-wrap">
                <svg viewBox="0 0 50 52" class="tech-svg" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302-.032.018v10.509a.8.8 0 0 1-.402.694L20.56 51.576a.798.798 0 0 1-.055.028c-.02.01-.04.017-.06.024a.835.835 0 0 1-.46.008.798.798 0 0 1-.064-.024.717.717 0 0 1-.054-.028L.467 40.502A.8.8 0 0 1 .065 39.808V6.812c0-.07.01-.14.028-.208.006-.02.015-.04.023-.06.01-.026.02-.052.033-.077a.8.8 0 0 1 .138-.18c.017-.017.036-.032.054-.047.02-.016.04-.03.062-.043L10.285.288A.8.8 0 0 1 11.085.288L20.987 5.976l.062.043c.019.015.038.03.054.047a.8.8 0 0 1 .138.18.81.81 0 0 1 .033.077c.008.02.017.04.023.06a.82.82 0 0 1 .028.208v20.941l8.005-4.61V11.773a.82.82 0 0 1 .028-.208c.006-.02.015-.04.023-.06.01-.026.02-.052.033-.077a.8.8 0 0 1 .138-.18c.017-.017.036-.032.054-.047.02-.016.04-.03.062-.043l9.902-5.688a.8.8 0 0 1 .8 0l9.903 5.688c.022.013.043.027.062.043.018.015.037.03.054.047a.8.8 0 0 1 .139.18c.012.025.022.051.033.077.008.02.017.04.023.06zm-1.574 10.455V13.12l-3.363 1.936-4.643 2.674v8.899l8.006-4.61zm-9.606 16.943v-8.906l-4.57 2.62-13.05 7.467v8.99l17.62-10.171zM1.664 7.413v32.195L19.284 49.8v-8.99l-9.201-5.248-.02-.013-.019-.013c-.018-.013-.036-.026-.053-.04a.767.767 0 0 1-.05-.044.8.8 0 0 1-.145-.189.84.84 0 0 1-.031-.076c-.008-.02-.016-.04-.021-.062a.822.822 0 0 1-.021-.207v-21.62L1.664 7.413zm9.02-5.867L2.68 6.156l8 4.608 8.005-4.608-8-4.61zm4.32 28.89 4.642-2.674V7.413l-3.363 1.936-4.643 2.674v20.75l3.364-1.937zM39.243 7.164l-8 4.609 8 4.609 7.999-4.61-7.999-4.608zm-.8 10.173-4.643-2.674-3.363-1.936v8.899l4.642 2.674 3.364 1.937v-8.9zM20.083 48.01l11.974-6.852 5.989-3.428-8-4.609-9.963 5.712v8.99z" fill="#FF2D20"/></svg>
                <span class="tech-version">v11</span>
            </div>
            <div class="tech-name">Laravel</div>
            <div class="tech-desc">Framework PHP elegante y expresivo para desarrollo web de alto rendimiento.</div>
            <div class="tech-pills"><span>PHP 8.3</span><span>MVC</span><span>Eloquent</span></div>
        </div>

        <!-- Livewire -->
        <div class="tech-card" style="--ac:#fb70a9">
            <div class="tech-logo-wrap">
                <svg viewBox="0 0 60 60" class="tech-svg" xmlns="http://www.w3.org/2000/svg"><circle cx="30" cy="30" r="28" fill="none" stroke="#fb70a9" stroke-width="2.5"/><path d="M20 38 C20 28 24 22 30 22 C36 22 40 28 40 38" stroke="#fb70a9" stroke-width="3" fill="none" stroke-linecap="round"/><circle cx="30" cy="19" r="4" fill="#fb70a9"/><path d="M16 42 L44 42" stroke="#fb70a9" stroke-width="2.5" stroke-linecap="round"/></svg>
                <span class="tech-version">v3</span>
            </div>
            <div class="tech-name">Livewire</div>
            <div class="tech-desc">Componentes dinámicos en tiempo real sin escribir JavaScript complejo.</div>
            <div class="tech-pills"><span>Reactive</span><span>SPA-like</span><span>AlpineJS</span></div>
        </div>

        <!-- Tailwind -->
        <div class="tech-card" style="--ac:#38bdf8">
            <div class="tech-logo-wrap">
                <svg viewBox="0 0 54 33" class="tech-svg" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M27 0C19.8 0 15.3 3.6 13.5 10.8c2.7-3.6 5.85-4.95 9.45-4.05 2.054.513 3.522 2.004 5.147 3.653C30.744 13.09 33.808 16.2 40.5 16.2c7.2 0 11.7-3.6 13.5-10.8-2.7 3.6-5.85 4.95-9.45 4.05-2.054-.513-3.522-2.004-5.147-3.653C36.756 3.11 33.692 0 27 0zM13.5 16.2C6.3 16.2 1.8 19.8 0 27c2.7-3.6 5.85-4.95 9.45-4.05 2.054.514 3.522 2.004 5.147 3.653C17.244 29.29 20.308 32.4 27 32.4c7.2 0 11.7-3.6 13.5-10.8-2.7 3.6-5.85 4.95-9.45 4.05-2.054-.513-3.522-2.004-5.147-3.653C23.256 19.31 20.192 16.2 13.5 16.2z" fill="#38bdf8"/></svg>
                <span class="tech-version">v4</span>
            </div>
            <div class="tech-name">Tailwind CSS</div>
            <div class="tech-desc">Framework CSS utility-first para interfaces modernas y responsivas.</div>
            <div class="tech-pills"><span>Utility-first</span><span>Dark Mode</span><span>JIT</span></div>
        </div>

        <!-- Jetstream -->
        <div class="tech-card" style="--ac:#e6b877">
            <div class="tech-logo-wrap">
                <svg viewBox="0 0 60 60" class="tech-svg" xmlns="http://www.w3.org/2000/svg"><polygon points="30,5 55,20 55,40 30,55 5,40 5,20" fill="none" stroke="#e6b877" stroke-width="2.5"/><circle cx="30" cy="30" r="9" fill="#e6b877" opacity=".8"/><line x1="30" y1="5" x2="30" y2="21" stroke="#e6b877" stroke-width="2"/><line x1="55" y1="20" x2="41" y2="25" stroke="#e6b877" stroke-width="2"/><line x1="55" y1="40" x2="41" y2="35" stroke="#e6b877" stroke-width="2"/><line x1="30" y1="55" x2="30" y2="39" stroke="#e6b877" stroke-width="2"/><line x1="5" y1="40" x2="19" y2="35" stroke="#e6b877" stroke-width="2"/><line x1="5" y1="20" x2="19" y2="25" stroke="#e6b877" stroke-width="2"/></svg>
                <span class="tech-version">v5</span>
            </div>
            <div class="tech-name">Jetstream</div>
            <div class="tech-desc">Autenticación completa con 2FA, equipos, perfiles y sesiones seguras.</div>
            <div class="tech-pills"><span>Auth</span><span>2FA</span><span>Teams</span></div>
        </div>

        <!-- MySQL -->
        <div class="tech-card" style="--ac:#4479a1">
            <div class="tech-logo-wrap">
                <svg viewBox="0 0 60 60" class="tech-svg" xmlns="http://www.w3.org/2000/svg"><ellipse cx="30" cy="15" rx="22" ry="8" fill="none" stroke="#4479a1" stroke-width="2.5"/><path d="M8 15 L8 45 Q8 53 30 53 Q52 53 52 45 L52 15" fill="none" stroke="#4479a1" stroke-width="2.5"/><path d="M8 28 Q8 36 30 36 Q52 36 52 28" fill="none" stroke="#4479a1" stroke-width="2"/></svg>
                <span class="tech-version">8.0</span>
            </div>
            <div class="tech-name">MySQL</div>
            <div class="tech-desc">Base de datos relacional robusta con soporte completo para transacciones.</div>
            <div class="tech-pills"><span>Migrations</span><span>Seeds</span><span>Eloquent</span></div>
        </div>

        <!-- Vite -->
        <div class="tech-card" style="--ac:#646cff">
            <div class="tech-logo-wrap">
                <svg viewBox="0 0 60 60" class="tech-svg" xmlns="http://www.w3.org/2000/svg"><polygon points="30,6 54,48 6,48" fill="none" stroke="#646cff" stroke-width="2.5"/><polygon points="30,18 46,48 14,48" fill="#646cff" opacity=".25"/><line x1="30" y1="6" x2="30" y2="30" stroke="#646cff" stroke-width="2.5"/></svg>
                <span class="tech-version">v6</span>
            </div>
            <div class="tech-name">Vite</div>
            <div class="tech-desc">Bundler ultrarrápido para activos frontend con Hot Module Replacement.</div>
            <div class="tech-pills"><span>HMR</span><span>ESM</span><span>Fast</span></div>
        </div>

    </div>
</section>

<style>
.tech-logo-wrap{display:flex;align-items:center;gap:.6rem;margin-bottom:1rem;}
.tech-svg{width:36px;height:36px;flex-shrink:0;}
.tech-version{font-size:.68rem;font-weight:700;padding:.18rem .55rem;border-radius:100px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.5);letter-spacing:.04em;}
.tech-pills{display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.85rem;}
.tech-pills span{font-size:.68rem;font-weight:600;padding:.2rem .6rem;border-radius:100px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.45);}
</style>

<!-- CTA -->
<section class="section cta-section" id="cta" style="padding-top:8rem;padding-bottom:8rem;">
    <div class="cta-orb cta-o1"></div>
    <div class="cta-orb cta-o2"></div>
    <div style="position:relative;z-index:1;max-width:1000px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;">

        <!-- Left: text + buttons -->
        <div class="cta-inner" style="text-align:left;max-width:none;margin:0;">
            <div class="sec-label" style="display:inline-block;margin-bottom:1rem;">Empieza Hoy</div>
            <h2 class="cta-title" style="font-size:clamp(2rem,4vw,3.2rem);">¿Quieres realizar<br><span class="grad">una reserva?</span></h2>
            <p class="cta-sub" style="text-align:left;margin:1.2rem 0 2rem;">Únete y gestiona tus productos de forma profesional. Sin complicaciones, sin límites.</p>

            <ul class="cta-feats">
                <li><span class="cta-check">✓</span> Cuenta gratuita, sin tarjeta de crédito</li>
                <li><span class="cta-check">✓</span> Acceso completo a todas las funciones</li>
                <li><span class="cta-check">✓</span> API REST lista para producción</li>
                <li><span class="cta-check">✓</span> Soporte técnico 24/7</li>
                <li><span class="cta-check">✓</span> Actualizaciones automáticas incluidas</li>
            </ul>

            <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:2rem;">
                @guest
                    <a href="{{ route('productos.index') }}" class="btn-p" style="font-size:.95rem;padding:.9rem 2rem;"><span>🍽️</span><span>Ver Menú Completo</span></a>
                    <a href="{{ route('login') }}" class="btn-s" style="font-size:.95rem;padding:.9rem 2rem;">Iniciar Sesión →</a>
                @else
                    <a href="{{ url('/dashboard') }}" class="btn-p" style="font-size:.95rem;padding:.9rem 2rem;"><span>🚀</span><span>Ir al Dashboard</span></a>
                    <a href="{{ url('/productos') }}" class="btn-s" style="font-size:.95rem;padding:.9rem 2rem;">Ver Productos →</a>
                @endguest
            </div>
        </div>

        <!-- Right: CTA Stats -->
        <div class="cta-preview" aria-hidden="true" style="display:flex; flex-direction:column; justify-content:center;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
                <div class="mini-stat" style="padding:2rem 1.5rem; text-align:center;">
                    <span style="font-size:2.4rem;font-weight:900;background:linear-gradient(135deg,#e6b877,#bf956b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block;line-height:1;">{{ $totalProductos }}</span>
                    <span style="font-size:.9rem;color:rgba(255,255,255,.45);margin-top:0.6rem;display:block;text-transform:uppercase;letter-spacing:.05em;font-weight:700;">Productos</span>
                </div>
                <div class="mini-stat" style="padding:2rem 1.5rem; text-align:center;">
                    <span style="font-size:2.4rem;font-weight:900;background:linear-gradient(135deg,#dbb27f,#a6835d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block;line-height:1;">{{ $totalCategorias }}</span>
                    <span style="font-size:.9rem;color:rgba(255,255,255,.45);margin-top:0.6rem;display:block;text-transform:uppercase;letter-spacing:.05em;font-weight:700;">Categorías</span>
                </div>
                <div class="mini-stat" style="padding:2rem 1.5rem; text-align:center; grid-column: 1 / -1;">
                    <span style="font-size:2.4rem;font-weight:900;background:linear-gradient(135deg,#e6b877,#c48b52);-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block;line-height:1;">99%</span>
                    <span style="font-size:.9rem;color:rgba(255,255,255,.45);margin-top:0.6rem;display:block;text-transform:uppercase;letter-spacing:.05em;font-weight:700;">Uptime Garantizado</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.cta-feats{list-style:none;display:flex;flex-direction:column;gap:.6rem;}
.cta-feats li{font-size:.9rem;color:rgba(255,255,255,.6);display:flex;align-items:center;gap:.6rem;}
.cta-check{color:#dbb27f;font-weight:900;font-size:.9rem;}
.preview-card{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.09);border-radius:20px;overflow:hidden;backdrop-filter:blur(20px);animation:ctaFloat 6s ease-in-out infinite;}
@keyframes ctaFloat{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}
.preview-header{display:flex;justify-content:space-between;align-items:center;padding:1.1rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.06);}
.preview-body{padding:1rem 1.25rem;display:flex;flex-direction:column;gap:.6rem;}
.prev-row{display:flex;justify-content:space-between;font-size:.82rem;}
.prev-row span{color:rgba(255,255,255,.38);}
.prev-row strong{color:rgba(255,255,255,.8);font-weight:600;}
.preview-footer{display:flex;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid rgba(255,255,255,.06);}
.prev-btn{flex:1;text-align:center;padding:.4rem;border-radius:8px;font-size:.72rem;font-weight:600;border:1px solid;cursor:pointer;transition:opacity .2s;}
.prev-btn:hover{opacity:.7;}
.mini-stat{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:12px;padding:.75rem 1rem;display:flex;flex-direction:column;gap:.2rem;}
.cta-preview{position:relative;}

</style>

<footer>
    <p>© {{ date('Y') }} <strong style="color:rgba(255,255,255,.5)">{{ config('app.name', 'Laravel') }}</strong>. Todos los derechos reservados.</p>
</footer>

<script>
gsap.registerPlugin(ScrollTrigger);

// ─── PARTICLES ────────────────────────────────────────────
const canvas = document.getElementById('bg-canvas');
const ctx = canvas.getContext('2d');
let W, H, pts = [];
const COLS = ['#d9a05b','#a67c52','#734f32','#8c6b4a','#e6b877'];
function resize(){ W = canvas.width = innerWidth; H = canvas.height = innerHeight; }
resize(); addEventListener('resize', resize);
for(let i=0;i<130;i++){
    pts.push({x:Math.random()*1e4%W, y:Math.random()*1e4%H,
              vx:(Math.random()-.5)*.28, vy:(Math.random()-.5)*.28,
              r:Math.random()*1.4+.3, a:Math.random()*.45+.08,
              c:COLS[Math.floor(Math.random()*COLS.length)]});
}
(function drawPts(){
    ctx.clearRect(0,0,W,H);
    for(let i=0;i<pts.length;i++){
        const p=pts[i]; p.x+=p.vx; p.y+=p.vy;
        if(p.x<0)p.x=W; if(p.x>W)p.x=0; if(p.y<0)p.y=H; if(p.y>H)p.y=0;
        ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
        ctx.fillStyle=p.c; ctx.globalAlpha=p.a; ctx.fill();
        for(let j=i+1;j<pts.length;j++){
            const q=pts[j], dx=p.x-q.x, dy=p.y-q.y, d=Math.sqrt(dx*dx+dy*dy);
            if(d<110){ ctx.beginPath(); ctx.moveTo(p.x,p.y); ctx.lineTo(q.x,q.y);
                ctx.strokeStyle='#d9a05b'; ctx.globalAlpha=(1-d/110)*.07; ctx.lineWidth=.5; ctx.stroke(); }
        }
    }
    ctx.globalAlpha=1; requestAnimationFrame(drawPts);
})();

// ─── NAVBAR ───────────────────────────────────────────────
const nav = document.getElementById('nav');
addEventListener('scroll',()=>nav.classList.toggle('solid',scrollY>60));

// ─── MOUSE PARALLAX HERO BG ───────────────────────────────
const heroBg = document.getElementById('heroBg');
addEventListener('mousemove', e=>{
    const x=e.clientX/innerWidth*100, y=e.clientY/innerHeight*100;
    heroBg.style.background=`radial-gradient(ellipse 75% 60% at ${x}% ${y}%,rgba(217,160,91,.2) 0%,transparent 65%),radial-gradient(ellipse 50% 40% at ${100-x}% ${100-y}%,rgba(166,124,82,.11) 0%,transparent 60%)`;
});

// ─── GSAP HERO ENTRANCE ───────────────────────────────────
const tl = gsap.timeline({defaults:{ease:'power3.out'}});
tl.to('#badge',      {opacity:1, y:0, duration:.7, delay:.3})
  .to('#heroTitle',  {opacity:1, y:0, duration:.8}, '-=.3')
  .to('#heroSub',    {opacity:1, y:0, duration:.7}, '-=.4')
  .to('#heroCtaRow', {opacity:1, y:0, duration:.6}, '-=.3')
  .to('.scroll-cue', {opacity:1, duration:.6}, '-=.2')
  .to('.fcard',      {opacity:1, y:0, stagger:.15, duration:.7, ease:'back.out(1.4)'}, '-=.5');

// set initial states
gsap.set(['#badge','#heroTitle','#heroSub','#heroCtaRow','.scroll-cue'],{y:30});
gsap.set('.fcard', {y:20});

// ─── HERO PARALLAX ON SCROLL ──────────────────────────────
gsap.to('#heroContent',{
    yPercent:18, ease:'none',
    scrollTrigger:{trigger:'.hero',start:'top top',end:'bottom top',scrub:true}
});
gsap.to('.hero-grid',{
    yPercent:8, scale:1.04, ease:'none',
    scrollTrigger:{trigger:'.hero',start:'top top',end:'bottom top',scrub:true}
});
gsap.to('.float-cards',{
    yPercent:25, ease:'none',
    scrollTrigger:{trigger:'.hero',start:'top top',end:'bottom top',scrub:true}
});

// ─── STATS COUNTER ────────────────────────────────────────
document.querySelectorAll('.stat-num').forEach(el=>{
    const val = +el.dataset.val, suf = el.dataset.suf||'+';
    ScrollTrigger.create({trigger:el,start:'top 85%',once:true,onEnter:()=>{
        gsap.to({v:0},{v:val,duration:1.8,ease:'power2.out',
            onUpdate:function(){ el.textContent = Math.floor(this.targets()[0].v) + suf; }
        });
    }});
});

// ─── SECTIONS REVEAL ─────────────────────────────────────
// Helper: safe reveal using fromTo so elements are NEVER stuck invisible
function revealFrom(targets, fromVars, stagger, trigger, start){
    start = start || 'top 95%';
    gsap.fromTo(targets,
        Object.assign({opacity:0}, fromVars),
        Object.assign({opacity:1, stagger:stagger||0, duration:.9, ease:'power3.out',
            scrollTrigger:{trigger:trigger, start:start, once:true}},
            // zero-out the from vars in the to
            Object.keys(fromVars).reduce((a,k)=>(a[k]=0,a),{})
        )
    );
}

// Stat items
revealFrom('.stat-item', {y:50}, .12, '.stats-grid');

// Section headers
document.querySelectorAll('.sec-head').forEach(h=>{
    revealFrom(h.children, {y:35}, .1, h);
});

// Feature cards
gsap.fromTo('.feat-card',
    {opacity:0, y:65, rotateX:10},
    {opacity:1, y:0, rotateX:0, stagger:.09, duration:.95, ease:'power3.out',
     scrollTrigger:{trigger:'.feat-grid', start:'top 95%', once:true}}
);

// Cube + text
gsap.fromTo('#cubeScene',
    {opacity:0, x:-70},
    {opacity:1, x:0, duration:1.1, ease:'power3.out',
     scrollTrigger:{trigger:'#cubeSection', start:'top 95%', once:true}}
);
gsap.fromTo('.cube-txt',
    {opacity:0, x:70},
    {opacity:1, x:0, duration:1.1, ease:'power3.out',
     scrollTrigger:{trigger:'#cubeSection', start:'top 95%', once:true}}
);

// Tech cards — key fix: fromTo so they're always visible if trigger missed
gsap.fromTo('.tech-card',
    {opacity:0, y:55, scale:.94},
    {opacity:1, y:0, scale:1, stagger:.1, duration:.95, ease:'back.out(1.2)',
     scrollTrigger:{trigger:'.tech-grid', start:'top 100%', once:true}}
);

// Fallback: ensure tech cards visible after short delay regardless
setTimeout(()=>{ document.querySelectorAll('.tech-card').forEach(c=>c.style.opacity=''); }, 2000);

// CTA left side
gsap.fromTo('.cta-inner > *',
    {opacity:0, y:45},
    {opacity:1, y:0, stagger:.12, duration:1, ease:'power3.out',
     scrollTrigger:{trigger:'#cta', start:'top 100%', once:true}}
);
// CTA right side (preview card)
gsap.fromTo('.cta-preview',
    {opacity:0, x:60, scale:.95},
    {opacity:1, x:0, scale:1, duration:1.1, ease:'power3.out',
     scrollTrigger:{trigger:'#cta', start:'top 100%', once:true}}
);
// Fallback for CTA
setTimeout(()=>{
    document.querySelectorAll('.cta-inner > *, .cta-preview').forEach(c=>c.style.opacity='');
}, 2200);

// ─── 3D TILT on feature cards ────────────────────────────
document.querySelectorAll('.feat-card').forEach(card=>{
    card.addEventListener('mousemove', e=>{
        const r=card.getBoundingClientRect();
        const x=(e.clientX-r.left-r.width/2)/(r.width/2);
        const y=(e.clientY-r.top-r.height/2)/(r.height/2);
        gsap.to(card,{rotateY:x*10,rotateX:-y*10,scale:1.04,duration:.4,ease:'power2.out',transformPerspective:800});
    });
    card.addEventListener('mouseleave', ()=>{
        gsap.to(card,{rotateY:0,rotateX:0,scale:1,duration:.6,ease:'elastic.out(1,.5)',transformPerspective:800});
    });
});

// ─── TECH CARD 3D TILT ───────────────────────────────────
document.querySelectorAll('.tech-card').forEach(card=>{
    card.addEventListener('mousemove', e=>{
        const r=card.getBoundingClientRect();
        const x=(e.clientX-r.left-r.width/2)/(r.width/2);
        const y=(e.clientY-r.top-r.height/2)/(r.height/2);
        gsap.to(card,{rotateY:x*8,rotateX:-y*8,duration:.3,ease:'power2.out',transformPerspective:600});
    });
    card.addEventListener('mouseleave',()=>{
        gsap.to(card,{rotateY:0,rotateX:0,duration:.5,ease:'elastic.out(1,.4)',transformPerspective:600});
    });
});

// ─── CTA ORBS PARALLAX ───────────────────────────────────
gsap.to('.cta-o1',{y:-60,x:40,ease:'none',scrollTrigger:{trigger:'#cta',start:'top bottom',end:'bottom top',scrub:2}});
gsap.to('.cta-o2',{y:60,x:-40,ease:'none',scrollTrigger:{trigger:'#cta',start:'top bottom',end:'bottom top',scrub:2}});

// ─── FLOATING CARDS ANIMATION ─────────────────────────────
['.fc1','.fc2','.fc3','.fc4'].forEach((sel,i)=>{
    gsap.to(sel,{y:`${-12-i*4}px`,duration:3+i*.7,ease:'sine.inOut',yoyo:true,repeat:-1,delay:i*.5});
});
</script>
</body>
</html>