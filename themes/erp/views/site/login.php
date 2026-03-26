<!-- Particle canvas -->
<canvas id="lp-canvas"></canvas>

<!-- Floating orbs background -->
<div class="lp-bg">
    <div class="lp-orb lp-orb-1"></div>
    <div class="lp-orb lp-orb-2"></div>
    <div class="lp-orb lp-orb-3"></div>
    <div class="lp-grid"></div>
</div>

<div class="login-container">
    <div class="login-card">

        <!-- Logo -->
        <div class="lp-logo-wrap">
            <img src="<?= Yii::app()->theme->baseUrl ?>/images/logo.svg"
                 alt="<?= Yii::app()->params['company']['name']; ?>"
                 class="company-logo"/>
        </div>

        <h5 class="lp-title">Sign in to your account</h5>

        <?php
        $form = $this->beginWidget('CActiveForm', [
            'id'                     => 'login-form',
            'enableClientValidation' => true,
            'clientOptions'          => ['validateOnSubmit' => true],
        ]);
        ?>

        <div class="lp-field">
            <div class="lp-input-wrap">
                <i class="fas fa-user lp-icon"></i>
                <?= $form->textField($model, 'username', [
                    'placeholder'  => 'Username',
                    'class'        => 'lp-input',
                    'autocomplete' => 'username',
                ]); ?>
                <span class="lp-tick"><i class="fas fa-check"></i></span>
            </div>
            <div class="lp-err"><?= $form->error($model, 'username'); ?></div>
        </div>

        <div class="lp-field">
            <div class="lp-input-wrap has-toggle">
                <i class="fas fa-lock lp-icon"></i>
                <?= $form->passwordField($model, 'password', [
                    'placeholder'  => 'Password',
                    'class'        => 'lp-input',
                    'id'           => 'lp-pw',
                    'autocomplete' => 'current-password',
                ]); ?>
                <span class="lp-tick"><i class="fas fa-check"></i></span>
                <button type="button" class="lp-pw-eye" onclick="lpTogglePw()" tabindex="-1">
                    <i class="fas fa-eye" id="lp-eye-ico"></i>
                </button>
            </div>
            <div class="lp-err"><?= $form->error($model, 'password'); ?></div>
        </div>

        <div class="lp-remember">
            <label class="lp-check-label">
                <input type="checkbox" id="remember" class="lp-check-input">
                <span class="lp-check-box"></span>
                Remember Me
            </label>
        </div>

        <?= CHtml::submitButton('Sign In', ['class' => 'lp-btn']); ?>

        <?php $this->endWidget(); ?>

        <!-- Support -->
        <div class="text-center mt-3">
            <a href="tel:<?= preg_replace('/[\s\-]/', '', Yii::app()->params['adminPhone']); ?>"
               class="lp-support-btn">
                <i class="fas fa-headset"></i>
                Need help? <?= Yii::app()->params['adminPhone']; ?>
            </a>
        </div>

        <!-- Footer -->
        <div class="lp-footer">
            <small>© <?= date('Y'); ?> <?= Yii::app()->params['developedBy']; ?>. All Rights Reserved.</small><br>
            <span class="typewriter">
                Crafted with ❤️ by
                <a href="<?= Yii::app()->params['developedByUrl']; ?>" target="_blank" class="lp-dev-link">
                    <strong><?= Yii::app()->params['developedBy']; ?></strong>
                </a>
            </span>
        </div>

    </div>
</div>

<style>
/* ── Reset ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ── Page ── */
body.hold-transition.login-page {
    background: #f0f4ff;
    height: 100vh;
    overflow: hidden;
    font-family: 'Source Sans Pro', 'Inter', sans-serif;
}

/* ── Animated background ── */
.lp-bg {
    position: fixed; inset: 0; z-index: 0; overflow: hidden;
    background: linear-gradient(135deg, #e8f0fe 0%, #f0f4ff 50%, #e3f2fd 100%);
}
.lp-orb {
    position: absolute; border-radius: 50%;
    filter: blur(80px); opacity: 0;
    animation: orbDrift 12s ease-in-out infinite;
}
.lp-orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, #bfdbfe, transparent 70%); top: -150px; left: -100px; animation-delay: 0s; }
.lp-orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, #c7d2fe, transparent 70%); bottom: -120px; right: -80px; animation-delay: 4s; }
.lp-orb-3 { width: 280px; height: 280px; background: radial-gradient(circle, #bae6fd, transparent 70%); top: 40%; left: 55%; animation-delay: 7s; }
@keyframes orbDrift {
    0%,100% { opacity: 0.5; transform: translate(0,0) scale(1); }
    50%      { opacity: 0.8; transform: translate(-20px,-30px) scale(1.08); }
}
.lp-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(99,102,241,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99,102,241,0.04) 1px, transparent 1px);
    background-size: 36px 36px;
}

/* ── Container ── */
.login-container {
    position: relative; z-index: 2;
    height: 100vh;
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
}

/* ── Card ── */
.login-card {
    background: rgba(255,255,255,0.82);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px;
    padding: 44px 60px;
    width: 100%; max-width: 560px;
    box-shadow: 0 8px 32px rgba(99,102,241,0.10), 0 2px 8px rgba(0,0,0,0.06);
    animation: cardIn 0.7s cubic-bezier(0.22,1,0.36,1) both;
    position: relative; overflow: hidden;
}
/* Shimmer sweep on load */
.login-card::before {
    content: '';
    position: absolute; top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.45), transparent);
    animation: cardShimmer 1.2s ease-out 0.4s forwards;
}
@keyframes cardShimmer {
    from { left: -100%; }
    to   { left: 160%; }
}
@keyframes cardIn {
    from { opacity: 0; transform: translateY(28px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* ── Logo ── */
.lp-logo-wrap {
    text-align: center; margin-bottom: 20px;
    animation: logoIn 0.9s cubic-bezier(0.22,1,0.36,1) 0.15s both;
}
@keyframes logoIn {
    from { opacity: 0; transform: scale(0.85) translateY(-10px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.company-logo {
    width: 200px; max-width: 80%; height: auto;
    filter: drop-shadow(0 2px 6px rgba(0,0,0,0.12));
    transition: transform 0.3s ease, filter 0.3s ease;
}
.company-logo:hover {
    transform: scale(1.04);
    filter: drop-shadow(0 4px 12px rgba(99,102,241,0.3));
}

/* ── Title ── */
.lp-title {
    text-align: center; font-size: 16px; font-weight: 600;
    color: #374151; margin-bottom: 22px; letter-spacing: 0.2px;
    animation: fadeSlide 0.6s ease 0.25s both;
}
@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Fields ── */
.lp-field { margin-bottom: 4px; animation: fadeSlide 0.6s ease both; }
.lp-field:nth-child(4) { animation-delay: 0.30s; }
.lp-field:nth-child(5) { animation-delay: 0.38s; }

.lp-input-wrap {
    position: relative; display: flex; align-items: center;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    transition: border-color 0.2s, box-shadow 0.2s;
    overflow: hidden;
}
.lp-input-wrap:focus-within {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}
.lp-input-wrap:focus-within .lp-icon { color: #6366f1; }

.lp-icon {
    position: absolute; left: 13px;
    font-size: 13px; color: #9ca3af;
    pointer-events: none;
    transition: color 0.2s;
}
.lp-input {
    width: 100%; height: 44px;
    padding: 0 44px 0 38px;
    border: none; outline: none; background: transparent;
    font-size: 14px; color: #111827;
}
.lp-input::placeholder { color: #9ca3af; }
.lp-pw-eye {
    position: absolute; right: 12px;
    background: none; border: none; cursor: pointer;
    color: #9ca3af; font-size: 13px; padding: 0;
    transition: color 0.2s;
}
.lp-pw-eye:hover { color: #6366f1; }

.lp-err { min-height: 16px; font-size: 11.5px; color: #ef4444; margin-top: 4px; }
.lp-err .errorMessage { display: inline; }

/* ── Remember ── */
.lp-remember { margin-bottom: 20px; animation: fadeSlide 0.6s ease 0.44s both; }
.lp-check-label {
    display: inline-flex; align-items: center; gap: 8px;
    cursor: pointer; font-size: 13px; color: #6b7280; user-select: none;
}
.lp-check-input { display: none; }
.lp-check-box {
    width: 17px; height: 17px;
    border: 1.5px solid #d1d5db; border-radius: 4px;
    background: #fff; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.18s ease;
}
.lp-check-input:checked + .lp-check-box {
    background: #6366f1; border-color: #6366f1;
}
.lp-check-input:checked + .lp-check-box::after {
    content: ''; width: 4px; height: 8px;
    border: 2px solid #fff; border-top: none; border-left: none;
    transform: rotate(45deg) translateY(-1px); display: block;
}

/* ── Button ── */
.lp-btn {
    width: 100%; height: 46px;
    border: none; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #fff; font-size: 15px; font-weight: 600; letter-spacing: 0.3px;
    cursor: pointer; position: relative; overflow: hidden;
    transition: transform 0.18s, box-shadow 0.18s;
    box-shadow: 0 4px 14px rgba(99,102,241,0.4);
    animation: fadeSlide 0.6s ease 0.5s both;
}
/* Shimmer streak on the button */
.lp-btn::before {
    content: '';
    position: absolute; top: 0; left: -75%;
    width: 50%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
    transform: skewX(-20deg);
    animation: btnStreak 3s ease-in-out 1.2s infinite;
}
@keyframes btnStreak {
    0%,100% { left: -75%; }
    40%      { left: 130%; }
}
.lp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(99,102,241,0.5);
}
.lp-btn:active { transform: translateY(0); }
/* Ripple */
.lp-btn::after {
    content: ''; position: absolute;
    width: 120px; height: 120px;
    background: rgba(255,255,255,0.2); border-radius: 50%;
    top: 50%; left: 50%;
    transform: translate(-50%,-50%) scale(0); opacity: 0;
    transition: transform 0.4s, opacity 0.6s;
}
.lp-btn:active::after { transform: translate(-50%,-50%) scale(3); opacity: 1; transition: 0s; }

/* ── Support button ── */
.lp-support-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 600; color: #6366f1;
    text-decoration: none;
    border: 1.5px solid rgba(99,102,241,0.35);
    border-radius: 20px; padding: 6px 16px;
    transition: all 0.25s ease;
    animation: fadeSlide 0.6s ease 0.6s both;
}
.lp-support-btn:hover {
    background: #6366f1; color: #fff;
    box-shadow: 0 4px 14px rgba(99,102,241,0.35);
    transform: translateY(-1px);
}
.lp-support-btn i { animation: ringPhone 3.5s ease-in-out infinite; }
@keyframes ringPhone {
    0%,80%,100% { transform: rotate(0); }
    84%  { transform: rotate(-18deg); }
    90%  { transform: rotate(18deg); }
    95%  { transform: rotate(-10deg); }
}

/* ── Footer ── */
.lp-footer {
    margin-top: 22px; text-align: center;
    font-size: 12px; color: #9ca3af; line-height: 1.8;
    animation: fadeSlide 0.6s ease 0.7s both;
}
.lp-dev-link { color: inherit; text-decoration: none; }
.lp-dev-link strong { color: #6366f1; font-weight: 600; transition: color 0.2s; }
.lp-dev-link:hover strong { color: #4f46e5; text-decoration: underline; }

/* ── Typewriter ── */
.typewriter {
    display: inline-block; border-right: 2px solid #6366f1;
    white-space: nowrap; overflow: hidden; letter-spacing: 0.03em;
    animation: typing 3.5s steps(35,end), blink 0.8s step-end infinite alternate;
}
@keyframes typing { from { width: 0 } to { width: 100% } }
@keyframes blink  { 50% { border-color: transparent } }

/* ── Particle canvas ── */
#lp-canvas {
    position: fixed; inset: 0;
    width: 100%; height: 100%;
    z-index: 1; pointer-events: none;
}

/* ── Logo breathing pulse ── */
.company-logo {
    animation: logoIn 0.9s cubic-bezier(0.22,1,0.36,1) 0.15s both,
               logoPulse 4s ease-in-out 1.2s infinite !important;
}
@keyframes logoPulse {
    0%,100% { filter: drop-shadow(0 2px 6px rgba(0,0,0,0.12)); }
    50%      { filter: drop-shadow(0 4px 18px rgba(99,102,241,0.35)); transform: scale(1.02); }
}

/* ── Card 3D tilt (applied via JS) ── */
.login-card {
    transform-style: preserve-3d;
    will-change: transform;
    transition: box-shadow 0.3s ease;
}

/* ── Input filled tick ── */
.lp-input-wrap .lp-tick {
    position: absolute; right: 12px;
    color: #22c55e; font-size: 12px;
    opacity: 0; transform: scale(0) rotate(-45deg);
    transition: opacity 0.25s, transform 0.25s;
    pointer-events: none;
}
.lp-input-wrap.filled .lp-tick {
    opacity: 1; transform: scale(1) rotate(0deg);
}
/* shift password field tick left of eye toggle */
.lp-input-wrap.has-toggle .lp-tick { right: 38px; }
/* shift pw eye button so it doesn't overlap tick */
.lp-input-wrap.has-toggle .lp-pw-eye { right: 12px; }

/* ── Orbs — extra animation variety ── */
.lp-orb-1 { animation-name: orbDrift1; }
.lp-orb-2 { animation-name: orbDrift2; }
.lp-orb-3 { animation-name: orbDrift3; }
@keyframes orbDrift1 {
    0%,100% { opacity:0.45; transform:translate(0,0) scale(1); }
    33%      { opacity:0.7;  transform:translate(30px,-40px) scale(1.1); }
    66%      { opacity:0.55; transform:translate(-20px,20px) scale(0.95); }
}
@keyframes orbDrift2 {
    0%,100% { opacity:0.4;  transform:translate(0,0) scale(1); }
    40%      { opacity:0.65; transform:translate(-35px,25px) scale(1.08); }
    70%      { opacity:0.5;  transform:translate(20px,-15px) scale(1.02); }
}
@keyframes orbDrift3 {
    0%,100% { opacity:0.3;  transform:translate(0,0) scale(1); }
    50%      { opacity:0.55; transform:translate(25px,-30px) scale(1.12); }
}

/* ── Grid slow drift ── */
.lp-grid { animation: gridDrift 20s linear infinite; }
@keyframes gridDrift {
    from { background-position: 0 0, 0 0; }
    to   { background-position: 36px 36px, 36px 36px; }
}

/* ── Button — enhanced pulse on idle ── */
.lp-btn { animation: fadeSlide 0.6s ease 0.5s both, btnIdle 3s ease-in-out 2s infinite; }
@keyframes btnIdle {
    0%,100% { box-shadow: 0 4px 14px rgba(99,102,241,0.4); }
    50%      { box-shadow: 0 6px 24px rgba(99,102,241,0.65), 0 0 0 4px rgba(99,102,241,0.08); }
}

/* ── Responsive ── */
@media (max-width: 480px) {
    .login-card   { padding: 28px 22px; }
    .company-logo { width: 160px; }
}
</style>

<script>
function lpTogglePw() {
    var pw  = document.getElementById('lp-pw');
    var ico = document.getElementById('lp-eye-ico');
    if (!pw) return;
    pw.type = pw.type === 'password' ? 'text' : 'password';
    ico.className = pw.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

document.addEventListener('DOMContentLoaded', function () {

    /* ── Typewriter loop ── */
    var tw = document.querySelector('.typewriter');
    if (tw) {
        setInterval(function () {
            tw.style.animation = 'none';
            void tw.offsetWidth;
            tw.style.animation = null;
        }, 8000);
    }

    /* ── Input filled-tick ── */
    document.querySelectorAll('.lp-input').forEach(function (inp) {
        var wrap = inp.closest('.lp-input-wrap');
        function syncTick() {
            if (inp.value.trim().length > 0) {
                wrap.classList.add('filled');
            } else {
                wrap.classList.remove('filled');
            }
        }
        inp.addEventListener('input', syncTick);
        inp.addEventListener('blur',  syncTick);
        syncTick(); /* in case browser autofill */
    });

    /* ── Canvas particle constellation ── */
    var canvas = document.getElementById('lp-canvas');
    if (canvas && canvas.getContext) {
        var ctx = canvas.getContext('2d');
        var W, H, pts;

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', resize);

        var COUNT = 55;
        pts = [];
        for (var i = 0; i < COUNT; i++) {
            pts.push({
                x:  Math.random() * W,
                y:  Math.random() * H,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                r:  1.5 + Math.random() * 1.5
            });
        }

        var LINK_DIST = 130;

        function tick() {
            ctx.clearRect(0, 0, W, H);

            for (var a = 0; a < pts.length; a++) {
                var p = pts[a];
                p.x += p.vx;
                p.y += p.vy;
                if (p.x < 0 || p.x > W) p.vx *= -1;
                if (p.y < 0 || p.y > H) p.vy *= -1;

                /* dot */
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(99,102,241,0.35)';
                ctx.fill();

                /* lines to nearby dots */
                for (var b = a + 1; b < pts.length; b++) {
                    var q  = pts[b];
                    var dx = p.x - q.x, dy = p.y - q.y;
                    var d  = Math.sqrt(dx * dx + dy * dy);
                    if (d < LINK_DIST) {
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(q.x, q.y);
                        ctx.strokeStyle = 'rgba(99,102,241,' + (0.12 * (1 - d / LINK_DIST)) + ')';
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(tick);
        }
        tick();
    }

    /* ── 3-D card tilt on mouse move ── */
    var card = document.querySelector('.login-card');
    if (card) {
        var resetTimer;
        var tiltReady = false;

        function applyTilt(rotX, rotY) {
            card.style.transition = 'transform 0.15s ease, box-shadow 0.15s ease';
            card.style.transform  = 'perspective(900px) rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg)';
            card.style.boxShadow  =
                (rotY * -2) + 'px ' + (rotX * 2) + 'px 40px rgba(99,102,241,0.18), ' +
                '0 8px 32px rgba(99,102,241,0.10), 0 2px 8px rgba(0,0,0,0.06)';
        }

        function resetTilt() {
            card.style.transition = 'transform 0.6s ease, box-shadow 0.6s ease';
            card.style.transform  = 'perspective(900px) rotateX(0deg) rotateY(0deg)';
            card.style.boxShadow  = '';
        }

        /* CSS animations override inline styles — clear cardIn once it finishes */
        card.addEventListener('animationend', function handler(e) {
            if (e.animationName === 'cardIn') {
                card.style.animation = 'none';
                tiltReady = true;
                card.removeEventListener('animationend', handler);
            }
        });

        document.addEventListener('mousemove', function (e) {
            if (!tiltReady) return;
            var rect = card.getBoundingClientRect();
            var cx   = rect.left + rect.width  / 2;
            var cy   = rect.top  + rect.height / 2;
            var dx   = (e.clientX - cx) / (window.innerWidth  / 2);
            var dy   = (e.clientY - cy) / (window.innerHeight / 2);
            applyTilt(-dy * 6, dx * 6);

            clearTimeout(resetTimer);
            resetTimer = setTimeout(resetTilt, 1200);
        });

        document.addEventListener('mouseleave', resetTilt);
    }

});
</script>
