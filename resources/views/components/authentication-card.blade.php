<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden" style="background:#0f0b08; font-family:'Inter', sans-serif; color:#fff;">
    <!-- Background orbs -->
    <div style="position:fixed;border-radius:50%;filter:blur(100px);pointer-events:none;z-index:0;width:600px;height:600px;background:rgba(217,160,91,.08);top:-80px;left:-120px;animation:orbFloat 12s ease-in-out infinite;"></div>
    <div style="position:fixed;border-radius:50%;filter:blur(100px);pointer-events:none;z-index:0;width:500px;height:500px;background:rgba(166,124,82,.06);bottom:-80px;right:-80px;animation:orbFloat 15s ease-in-out infinite reverse;"></div>
    <div style="position:fixed;border-radius:50%;filter:blur(100px);pointer-events:none;z-index:0;width:400px;height:400px;background:rgba(140,107,74,.05);top:40%;left:40%;animation:orbFloat 10s ease-in-out infinite 3s;"></div>
    
    <canvas id="login-canvas" style="position:fixed;inset:0;z-index:0;pointer-events:none;"></canvas>

    <!-- Main Card Container (Split Layout) -->
    <div class="relative z-10 w-full max-w-5xl flex flex-col md:flex-row shadow-2xl overflow-hidden rounded-3xl" style="background:rgba(28,21,16,.75); backdrop-filter:blur(16px); border:1px solid rgba(217,160,91,.2); box-shadow:0 30px 60px rgba(0,0,0,.6); min-height: 600px;">
        
        <!-- Left Side: Image / Illustration Placeholder -->
        <div class="w-full md:w-1/2 hidden md:flex flex-col items-center justify-center p-8 relative" style="background: linear-gradient(135deg, rgba(217,160,91,.05), rgba(166,124,82,.02)); border-right: 1px solid rgba(255,255,255,.05);">
            <!-- Replace image src below when ready -->
            <img src="https://via.placeholder.com/600x600/1c1510/d9a05b?text=Image+Placeholder" alt="Illustration" class="w-full max-w-sm drop-shadow-2xl rounded-xl opacity-90 transition-transform duration-700 hover:scale-105" style="border:1px solid rgba(217,160,91,.15);">
            <div class="mt-8 text-center max-w-xs">
                <h3 style="font-size: 1.4rem; font-weight: 800; background: linear-gradient(135deg, #e6b877, #bf956b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Gestión Optimizada</h3>
                <p class="mt-2 text-sm text-gray-400">Administra todos tus productos con la mejor tecnología.</p>
            </div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 py-10 sm:px-12 relative z-10">
            @isset($logo)
                <div class="flex flex-col items-center mb-6">
                    {{ $logo }}
                </div>
            @endisset
            
            <div class="w-full max-w-sm mx-auto">
                {{ $slot }}
            </div>
        </div>
    </div>

    <style>
        @keyframes orbFloat{
            0%,100%{transform:translate(0,0) scale(1);}
            33%{transform:translate(30px,-40px) scale(1.08);}
            66%{transform:translate(-20px,20px) scale(.93);}
        }
        /* Overrides for text/inputs inside auth */
        .text-gray-900 { color: #fff !important; }
        .text-gray-600 { color: rgba(255,255,255,.6) !important; }
        .text-gray-400 { color: rgba(255,255,255,.6) !important; }
        .bg-white { background: transparent !important; }
        .dark\:bg-gray-800 { background: transparent !important; }
        .dark\:bg-gray-900 { background: transparent !important; }
        input.border-gray-300 { background: rgba(0,0,0,.2) !important; border-color: rgba(217,160,91,.3) !important; color: #fff !important; }
        input.border-gray-300:focus { border-color: #d9a05b !important; box-shadow: 0 0 0 1px #d9a05b !important; }
        button.bg-gray-800 { background: linear-gradient(135deg, #d9a05b, #a67c52) !important; border:none !important; color: #fff !important; box-shadow: 0 0 20px rgba(217,160,91,.4) !important; transition: all .3s; }
        button.bg-gray-800:hover { transform: translateY(-2px); box-shadow: 0 0 30px rgba(166,124,82,.6) !important; }
    </style>

    <script>
        // PARTICLES
        const canvasL = document.getElementById('login-canvas');
        if(canvasL) {
            const ctxL = canvasL.getContext('2d');
            let wL, hL, ptsL = [];
            const COLS_L = ['#d9a05b','#a67c52','#734f32','#8c6b4a','#e6b877'];
            function resizeL(){ wL = canvasL.width = innerWidth; hL = canvasL.height = innerHeight; }
            resizeL(); window.addEventListener('resize', resizeL);
            for(let i=0;i<60;i++){
                ptsL.push({x:Math.random()*1e4%wL, y:Math.random()*1e4%hL,
                           vx:(Math.random()-.5)*.2, vy:(Math.random()-.5)*.2,
                           r:Math.random()*1.2+.3, a:Math.random()*.4+.05,
                           c:COLS_L[Math.floor(Math.random()*COLS_L.length)]});
            }
            (function drawPtsL(){
                ctxL.clearRect(0,0,wL,hL);
                for(let i=0;i<ptsL.length;i++){
                    const p=ptsL[i]; p.x+=p.vx; p.y+=p.vy;
                    if(p.x<0)p.x=wL; if(p.x>wL)p.x=0; if(p.y<0)p.y=hL; if(p.y>hL)p.y=0;
                    ctxL.beginPath(); ctxL.arc(p.x,p.y,p.r,0,Math.PI*2);
                    ctxL.fillStyle=p.c; ctxL.globalAlpha=p.a; ctxL.fill();
                    for(let j=i+1;j<ptsL.length;j++){
                        const q=ptsL[j], dx=p.x-q.x, dy=p.y-q.y, d=Math.sqrt(dx*dx+dy*dy);
                        if(d<90){ ctxL.beginPath(); ctxL.moveTo(p.x,p.y); ctxL.lineTo(q.x,q.y);
                            ctxL.strokeStyle='#d9a05b'; ctxL.globalAlpha=(1-d/90)*.05; ctxL.lineWidth=.5; ctxL.stroke(); }
                    }
                }
                ctxL.globalAlpha=1; requestAnimationFrame(drawPtsL);
            })();
        }
    </script>
</div>
