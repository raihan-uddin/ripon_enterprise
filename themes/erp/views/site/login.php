<div class="login-container d-flex align-items-center justify-content-center">
    <div class="login-card shadow-lg rounded-4">
        <div class="text-center mb-4">
            <img src="<?= Yii::app()->theme->baseUrl ?>/images/logo.svg"
                 alt="<?= Yii::app()->params['company']['name']; ?> Logo"
                 class="company-logo mb-2">
        </div>

        <h5 class="text-center mb-3 fw-semibold">Sign in to your account</h5>

        <?php
        $form = $this->beginWidget('CActiveForm', [
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => ['validateOnSubmit' => true],
        ]);
        ?>

        <div class="form-group mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white text-muted"><i class="fas fa-user"></i></span>
                <?= $form->textField($model, 'username', [
                        'placeholder' => 'Username',
                        'class' => 'form-control border-start-0',
                ]); ?>
            </div>
            <small class="text-danger"><?= $form->error($model, 'username'); ?></small>
        </div>

        <div class="form-group mb-3">
            <div class="input-group">
                <span class="input-group-text bg-white text-muted"><i class="fas fa-lock"></i></span>
                <?= $form->passwordField($model, 'password', [
                        'placeholder' => 'Password',
                        'class' => 'form-control border-start-0',
                ]); ?>
            </div>
            <small class="text-danger"><?= $form->error($model, 'password'); ?></small>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember">
                <label class="form-check-label text-muted small" for="remember">
                    Remember Me
                </label>
            </div>
        </div>

        <?= CHtml::submitButton('Sign In', [
                'class' => 'btn btn-primary w-100 fw-semibold py-2 shadow-sm',
        ]); ?>

        <?php $this->endWidget(); ?>

        <div class="text-center mt-3">
            <a href="tel:<?= preg_replace('/[\s\-]/', '', Yii::app()->params['adminPhone']); ?>"
               class="support-call-btn">
                <i class="fas fa-headset"></i>
                Need help? Call <?= Yii::app()->params['adminPhone']; ?>
            </a>
        </div>

        <div class="text-center mt-3 developer-footer">
            <small class="text-muted">
                © <?= date('Y'); ?> <?= Yii::app()->params['developedBy']; ?>. All Rights Reserved.<br>
                <span class="typewriter">
                    Developed & Crafted with ❤️ by
                    <a href="<?= Yii::app()->params['developedByUrl']; ?>" target="_blank" class="dev-link">
                        <strong><?= Yii::app()->params['developedBy']; ?></strong>
                    </a>
                </span>
            </small>
        </div>

    </div>
</div>
<style>
    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatUp {
        0%   { opacity: 0; transform: translateY(30px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes logoPop {
        0%   { transform: scale(0.95); opacity: 0; }
        70%  { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    @keyframes glowPulse {
        0%   { box-shadow: 0 0 0 rgba(13,110,253,0.4); }
        50%  { box-shadow: 0 0 20px rgba(13,110,253,0.5); }
        100% { box-shadow: 0 0 0 rgba(13,110,253,0.4); }
    }

    body {
        background: linear-gradient(135deg, #e3f2fd 0%, #e9ecef 100%);
        background-size: 200% 200%;
        font-family: "Inter", "Poppins", sans-serif;
        height: 100vh;
        margin: 0;
        animation: fadeIn 0.8s ease-in-out;
    }

    .login-container {
        height: 100vh;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: #fff;
        padding: 35px 40px;
        max-width: 420px;
        width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        animation: floatUp 0.9s ease-out;
        transition: all 0.3s ease;
    }
    .login-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.1);
    }

    .company-logo {
        width: 200px;
        max-width: 80%;
        height: auto;
        object-fit: contain;
        margin-bottom: 6px;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        transition: all 0.3s ease;
        animation: logoPop 1.1s ease-out;
    }
    .company-logo:hover {
        transform: scale(1.04);
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.25));
    }

    .form-control {
        font-size: 14px;
        padding: 10px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(13,110,253,0.25);
        border-color: #0d6efd;
    }
    .input-group-text {
        border-right: none;
        border-radius: 6px 0 0 6px;
        background-color: #fff;
        color: #6c757d;
    }
    .form-control.border-start-0 { border-left: none; }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0056d2);
        border: none;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #0b5ed7, #004bb7);
        animation: glowPulse 1.6s ease-in-out infinite;
        transform: translateY(-1px);
    }
    .btn-primary::after {
        content: "";
        position: absolute;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        width: 100px; height: 100px;
        top: 50%; left: 50%;
        transform: translate(-50%,-50%) scale(0);
        opacity: 0;
        transition: transform 0.5s, opacity 1s;
    }
    .btn-primary:active::after {
        transform: translate(-50%,-50%) scale(3);
        opacity: 1;
        transition: 0s;
    }

    .text-muted.small  { font-size: 13px; }
    .form-check-label  { cursor: pointer; }
    .login-card small  { font-size: 12px; color: #6c757d; }

    @media (max-width: 768px) {
        .login-card    { width: 90%; padding: 25px 20px; }
        .company-logo  { width: 150px; }
        h5             { font-size: 16px; }
    }

    .support-call-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
        border: 1.5px solid #0d6efd;
        border-radius: 20px;
        padding: 6px 16px;
        transition: all 0.25s ease;
    }
    .support-call-btn:hover {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 14px rgba(13,110,253,0.35);
        transform: translateY(-1px);
    }
    .support-call-btn i {
        animation: ringPhone 3s ease-in-out infinite;
    }
    @keyframes ringPhone {
        0%,75%,100% { transform: rotate(0deg); }
        80%  { transform: rotate(-18deg); }
        88%  { transform: rotate(18deg); }
        94%  { transform: rotate(-12deg); }
    }

    .developer-footer {
        margin-top: 25px;
        font-size: 13px;
        color: #6c757d;
        animation: fadeIn 1.5s ease-in-out;
    }
    .developer-footer strong { color: #0d6efd; font-weight: 600; }
    .dev-link { color: inherit; text-decoration: none; }
    .dev-link:hover strong { color: #004bb7; text-decoration: underline; }

    .typewriter {
        display: inline-block;
        border-right: 2px solid #0d6efd;
        white-space: nowrap;
        overflow: hidden;
        letter-spacing: 0.03em;
        animation: typing 3.5s steps(35, end), blink 0.8s step-end infinite alternate;
    }
    @keyframes typing { from { width: 0 } to { width: 100% } }
    @keyframes blink  { 50% { border-color: transparent } }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var typewriter = document.querySelector(".typewriter");
        if (!typewriter) return;
        setInterval(function () {
            typewriter.style.animation = "none";
            void typewriter.offsetWidth;
            typewriter.style.animation = null;
        }, 8000);
    });
</script>
