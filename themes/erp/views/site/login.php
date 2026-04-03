<!-- Particle canvas -->
<canvas id="lp-canvas"></canvas>

<!-- Floating orbs background -->
<div class="lp-bg">
    <div class="lp-orb lp-orb-1"></div>
    <div class="lp-orb lp-orb-2"></div>
    <div class="lp-orb lp-orb-3"></div>
    <div class="lp-grid"></div>
    <div class="lp-cursor-glow" id="lp-cursor-glow"></div>
</div>

<!-- Card rotating border wrapper -->
<div class="lp-card-ring" id="lp-card-ring"></div>

<div class="login-container">
    <div class="login-card">

        <!-- Version badge -->
        <div class="lp-version-badge">v<?= Yii::app()->params['version']; ?></div>

        <!-- Logo -->
        <div class="lp-logo-wrap">
            <img src="<?= Yii::app()->theme->baseUrl ?>/images/logo.svg"
                 alt="<?= Yii::app()->params['company']['name']; ?>"
                 class="company-logo"/>
        </div>

        <!-- Time-of-day greeting -->
        <div class="lp-greeting" id="lp-greeting" aria-live="polite"></div>

        <h5 class="lp-title">Sign in to your account</h5>

        <!-- Screen-reader announcements -->
        <div id="lp-sr-live" role="status" aria-live="polite" aria-atomic="true"
             style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);"></div>

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
            <div class="lp-capslock" id="lp-capslock" role="alert" aria-live="assertive">
                <i class="fas fa-exclamation-triangle"></i> Caps Lock is on
            </div>
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
body.login-page {
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
@keyframes btnRippleAnim {
    to { transform: scale(1); opacity: 0; }
}

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

/* ── Cursor glow ── */
.lp-cursor-glow {
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
    pointer-events: none;
    transform: translate(-50%, -50%);
    transition: left 0.12s ease, top 0.12s ease;
    will-change: left, top;
}

/* ── Rotating card border ring ── */
.lp-card-ring {
    position: fixed;
    border-radius: 22px;
    pointer-events: none;
    z-index: 2;
    opacity: 0;
    transition: opacity 0.8s ease 0.7s;
}
.lp-card-ring.visible {
    opacity: 1;
}
.lp-card-ring::before {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: inherit;
    background: conic-gradient(
        from var(--ring-angle, 0deg),
        transparent 0deg,
        rgba(99,102,241,0.6) 60deg,
        rgba(168,85,247,0.5) 120deg,
        rgba(99,102,241,0.6) 180deg,
        transparent 240deg
    );
    animation: ringRotate 4s linear infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    padding: 2px;
}
@keyframes ringRotate {
    from { --ring-angle: 0deg; }
    to   { --ring-angle: 360deg; }
}
/* @property needed for the conic rotation trick */
@property --ring-angle {
    syntax: '<angle>';
    inherits: false;
    initial-value: 0deg;
}

/* ── Version badge ── */
.lp-version-badge {
    position: absolute; top: 14px; right: 16px;
    font-size: 10px; font-weight: 700; letter-spacing: 0.5px;
    color: #6366f1; background: rgba(99,102,241,0.08);
    border: 1px solid rgba(99,102,241,0.2);
    border-radius: 20px; padding: 2px 9px;
    animation: fadeSlide 0.6s ease 0.8s both;
}

/* ── Time-of-day greeting ── */
.lp-greeting {
    text-align: center;
    font-size: 13px; font-weight: 600;
    color: #6b7280; margin-bottom: 6px;
    min-height: 20px;
    animation: fadeSlide 0.6s ease 0.2s both;
}
.lp-greeting .lp-greet-icon {
    display: inline-block;
    animation: greetBounce 2.5s ease-in-out 1s infinite;
}
@keyframes greetBounce {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-3px); }
}

/* ── Caps Lock warning ── */
.lp-capslock {
    display: none;
    align-items: center; gap: 5px;
    font-size: 11.5px; font-weight: 600; color: #f59e0b;
    background: rgba(245,158,11,0.08);
    border: 1px solid rgba(245,158,11,0.25);
    border-radius: 6px; padding: 4px 10px;
    margin-top: 5px;
}
.lp-capslock.visible {
    display: flex;
    animation: capsIn 0.25s ease forwards;
}
@keyframes capsIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Title scramble — no extra CSS needed, JS handles it ── */

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

    /* ── Time-of-day greeting ── */
    var greetEl = document.getElementById('lp-greeting');
    if (greetEl) {
        var h = new Date().getHours();
        var greetData =
            h >= 5  && h < 12 ? { text: 'Good morning',   icon: '☀️'  } :
            h >= 12 && h < 17 ? { text: 'Good afternoon', icon: '🌤️' } :
            h >= 17 && h < 21 ? { text: 'Good evening',   icon: '🌆' } :
                                 { text: 'Good night',     icon: '🌙'  };
        greetEl.innerHTML =
            greetData.text + ' <span class="lp-greet-icon">' + greetData.icon + '</span>';
    }

    /* ── Caps Lock warning ── */
    var capsEl  = document.getElementById('lp-capslock');
    var pwInput = document.getElementById('lp-pw');
    var pwFocused = false;
    if (capsEl && pwInput) {
        var checkCaps = function (e) {
            if (typeof e.getModifierState !== 'function') return;
            var on = e.getModifierState('CapsLock');
            if (on) {
                if (!capsEl.classList.contains('visible')) {
                    /* re-trigger animation by removing and re-adding */
                    capsEl.classList.remove('visible');
                    void capsEl.offsetWidth;
                    capsEl.classList.add('visible');
                }
                document.getElementById('lp-sr-live').textContent = 'Warning: Caps Lock is on.';
            } else {
                capsEl.classList.remove('visible');
                document.getElementById('lp-sr-live').textContent = '';
            }
        };
        pwInput.addEventListener('focus',  function ()  { pwFocused = true; });
        pwInput.addEventListener('blur',   function ()  { pwFocused = false; });
        /* listen on document so any keypress while pw is focused updates the warning */
        document.addEventListener('keydown', function (e) { if (pwFocused) checkCaps(e); });
        document.addEventListener('keyup',   function (e) { if (pwFocused) checkCaps(e); });
        /* also check immediately when the field gains focus */
        pwInput.addEventListener('focus', checkCaps);
    }

    /* ── Focus trap ── */
    var cardTrap = document.querySelector('.login-card');
    if (cardTrap) {
        var focusable = 'a[href],button:not([disabled]),input:not([disabled]),select,textarea,[tabindex]:not([tabindex="-1"])';
        cardTrap.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab') return;
            var els   = Array.prototype.slice.call(cardTrap.querySelectorAll(focusable));
            var first = els[0], last = els[els.length - 1];
            if (e.shiftKey) {
                if (document.activeElement === first) { e.preventDefault(); last.focus(); }
            } else {
                if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
            }
        });
    }

    /* ── Button click ripple ── */
    var btn = document.querySelector('.lp-btn');
    if (btn) {
        btn.addEventListener('click', function (e) {
            var ripple = document.createElement('span');
            ripple.className = 'lp-btn-ripple';
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height) * 2;
            ripple.style.cssText =
                'position:absolute;border-radius:50%;background:rgba(255,255,255,0.35);' +
                'pointer-events:none;transform:scale(0);animation:btnRippleAnim 0.55s ease-out forwards;' +
                'width:' + size + 'px;height:' + size + 'px;' +
                'left:' + (e.clientX - rect.left - size / 2) + 'px;' +
                'top:'  + (e.clientY - rect.top  - size / 2) + 'px;';
            btn.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 600);
        });
    }

    /* ── aria-live: announce validation errors ── */
    var srLive = document.getElementById('lp-sr-live');
    var loginForm = document.getElementById('login-form');
    if (loginForm && srLive) {
        loginForm.addEventListener('submit', function () {
            setTimeout(function () {
                var errs = loginForm.querySelectorAll('.errorMessage');
                var msgs = [];
                errs.forEach(function (el) { if (el.textContent.trim()) msgs.push(el.textContent.trim()); });
                srLive.textContent = msgs.length ? msgs.join('. ') : '';
            }, 200);
        });
    }

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

        /* night (20-6) = twinkling stars, day/evening = snowflakes */
        var nowH       = new Date().getHours();
        var canvasMode = (nowH >= 20 || nowH < 6) ? 'stars' : 'snow';

        var COUNT = canvasMode === 'stars' ? 80 : 55;
        pts = [];
        for (var i = 0; i < COUNT; i++) {
            pts.push({
                x:      Math.random() * W,
                y:      Math.random() * H,
                vx:     canvasMode === 'snow' ? (Math.random() - 0.3) * 0.35 : (Math.random() - 0.5) * 0.4,
                vy:     canvasMode === 'snow' ? 0.3 + Math.random() * 0.5    : (Math.random() - 0.5) * 0.4,
                r:      canvasMode === 'stars' ? 0.8 + Math.random() * 2     : 1.5 + Math.random() * 1.5,
                phase:  Math.random() * Math.PI * 2  /* twinkle phase */
            });
        }

        var LINK_DIST = 130;
        var tickCount = 0;

        function tick() {
            ctx.clearRect(0, 0, W, H);
            tickCount++;

            for (var a = 0; a < pts.length; a++) {
                var p  = pts[a];

                if (canvasMode === 'snow') {
                    /* Snowflakes drift down, gentle sway */
                    p.x += p.vx + Math.sin(tickCount * 0.02 + p.phase) * 0.2;
                    p.y += p.vy;
                    if (p.y > H + 10) { p.y = -10; p.x = Math.random() * W; }
                    if (p.x < 0)  p.x = W;
                    if (p.x > W)  p.x = 0;

                    var alpha = 0.25 + 0.35 * Math.sin(tickCount * 0.03 + p.phase);
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(147,197,253,' + alpha + ')';
                    ctx.fill();

                } else if (canvasMode === 'stars') {
                    /* Stars twinkle in place, very slow drift */
                    p.x += p.vx * 0.15;
                    p.y += p.vy * 0.15;
                    if (p.x < 0 || p.x > W) p.vx *= -1;
                    if (p.y < 0 || p.y > H) p.vy *= -1;

                    var twinkle = 0.4 + 0.6 * Math.abs(Math.sin(tickCount * 0.04 + p.phase));
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r * twinkle, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(253,224,71,' + (twinkle * 0.6) + ')';
                    ctx.shadowBlur  = 4 * twinkle;
                    ctx.shadowColor = 'rgba(253,224,71,0.5)';
                    ctx.fill();
                    ctx.shadowBlur = 0;

                }
            }
            requestAnimationFrame(tick);
        }
        tick();
    }

    /* ── Cursor glow follows mouse ── */
    var cursorGlow = document.getElementById('lp-cursor-glow');
    if (cursorGlow) {
        document.addEventListener('mousemove', function (e) {
            cursorGlow.style.left = e.clientX + 'px';
            cursorGlow.style.top  = e.clientY + 'px';
        });
    }

    /* ── Rotating border ring — track card position ── */
    var ring     = document.getElementById('lp-card-ring');
    var cardEl   = document.querySelector('.login-card');
    function positionRing() {
        if (!ring || !cardEl) return;
        var r = cardEl.getBoundingClientRect();
        ring.style.left   = r.left   + 'px';
        ring.style.top    = r.top    + 'px';
        ring.style.width  = r.width  + 'px';
        ring.style.height = r.height + 'px';
    }
    positionRing();
    window.addEventListener('resize', positionRing);
    /* Show ring after card entrance */
    setTimeout(function () {
        if (ring) ring.classList.add('visible');
    }, 900);

    /* ── Title text scramble ── */
    var titleEl = document.querySelector('.lp-title');
    if (titleEl) {
        var original = titleEl.textContent.trim();
        var chars    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$';
        var revealed = 0;
        var frame    = 0;

        function scrambleTick() {
            var out = '';
            for (var i = 0; i < original.length; i++) {
                if (original[i] === ' ') { out += ' '; continue; }
                if (i < revealed) {
                    out += original[i];
                } else {
                    out += chars[Math.floor(Math.random() * chars.length)];
                }
            }
            titleEl.textContent = out;
            frame++;
            if (frame % 3 === 0) revealed++;
            if (revealed <= original.length) {
                requestAnimationFrame(scrambleTick);
            } else {
                titleEl.textContent = original;
            }
        }
        /* Start scramble after card enters */
        setTimeout(scrambleTick, 500);
    }

    /* ── Particles attracted toward cursor ── */
    var mouseX = window.innerWidth  / 2;
    var mouseY = window.innerHeight / 2;
    document.addEventListener('mousemove', function (e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

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
