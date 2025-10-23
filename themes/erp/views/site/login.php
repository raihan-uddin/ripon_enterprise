<div class="login-container d-flex align-items-center justify-content-center">
    <div class="login-card shadow-lg rounded-4">
        <div class="text-center mb-4">
            <img src="<?= Yii::app()->theme->baseUrl ?>/images/voucher-logo.png"
                 alt="<?= Yii::app()->params['company']['name']; ?> Logo"
                 class="company-logo mb-2">
<!--            <p class="text-muted small">Admin Panel v--><?php //= Yii::app()->params['version']; ?><!--</p>-->
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
<!--            <a href="#" class="small text-primary text-decoration-none">Forgot Password?</a>-->
        </div>

        <?= CHtml::submitButton('Sign In', [
                'class' => 'btn btn-primary w-100 fw-semibold py-2 shadow-sm',
        ]); ?>

        <?php $this->endWidget(); ?>

        <div class="text-center mt-4 developer-footer">
            <small class="text-muted">
                © <?= date('Y'); ?> <?= Yii::app()->params['developedBy']; ?>. All Rights Reserved.<br>
                <span class="typewriter">
                    Developed & Crafted with ❤️ by <strong><?= Yii::app()->params['developedBy']; ?></strong>
                </span>
            </small>
        </div>

    </div>
</div>
<style>
    /* 🌈 BACKGROUND ANIMATION */
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* ✨ PAGE FADE-IN */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* 🪶 CARD FLOAT */
    @keyframes floatUp {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* 💠 LOGO POP-IN */
    @keyframes logoPop {
        0% {
            transform: scale(0.95);
            opacity: 0;
        }
        70% {
            transform: scale(1.05);
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }

    /* 🔆 BUTTON GLOW PULSE */
    @keyframes glowPulse {
        0% {
            box-shadow: 0 0 0 rgba(13, 110, 253, 0.4);
        }
        50% {
            box-shadow: 0 0 20px rgba(13, 110, 253, 0.5);
        }
        100% {
            box-shadow: 0 0 0 rgba(13, 110, 253, 0.4);
        }
    }

    /* --- BASE PAGE STYLE --- */
    body {
        background: linear-gradient(135deg, #e3f2fd 0%, #e9ecef 100%);
        background-size: 200% 200%;
        animation: gradientShift 10s ease infinite;
        font-family: "Inter", "Poppins", sans-serif;
        height: 100vh;
        margin: 0;
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes floatParticles {
        0% {
            background-position: 0% 0%, 100% 100%;
        }
        100% {
            background-position: 100% 100%, 0% 0%;
        }
    }


    /* --- LOGIN CONTAINER --- */
    .login-container {
        height: 100vh;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* --- LOGIN CARD --- */
    .login-card {
        background: #fff;
        padding: 35px 40px;
        max-width: 420px;
        width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        animation: floatUp 0.9s ease-out;
        transition: all 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
    }

    /* --- LOGO STYLE --- */
    .company-logo {
        width: 200px;
        max-width: 80%;
        height: auto;
        object-fit: contain;
        margin-bottom: 6px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        transition: all 0.3s ease;
        animation: logoPop 1.1s ease-out;
    }

    .company-logo:hover {
        transform: scale(1.04);
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.25));
    }

    /* --- FORM FIELDS --- */
    .form-control {
        font-size: 14px;
        padding: 10px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        border-color: #0d6efd;
    }

    .input-group-text {
        border-right: none;
        border-radius: 6px 0 0 6px;
        background-color: #fff;
        color: #6c757d;
    }

    .form-control.border-start-0 {
        border-left: none;
    }

    /* --- BUTTON STYLING --- */
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

    /* --- BUTTON RIPPLE EFFECT --- */
    .btn-primary::after {
        content: "";
        position: absolute;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 100px;
        height: 100px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        opacity: 0;
        transition: transform 0.5s, opacity 1s;
    }

    .btn-primary:active::after {
        transform: translate(-50%, -50%) scale(3);
        opacity: 1;
        transition: 0s;
    }

    /* --- TEXT & LABELS --- */
    .text-muted.small {
        font-size: 13px;
    }

    .form-check-label {
        cursor: pointer;
    }

    /* --- CARD FOOTER --- */
    .login-card small {
        font-size: 12px;
        color: #6c757d;
    }

    /* --- RESPONSIVE DESIGN --- */
    @media (max-width: 768px) {
        .login-card {
            width: 90%;
            padding: 25px 20px;
        }

        .company-logo {
            width: 150px;
        }

        h5 {
            font-size: 16px;
        }
    }

    /* --- Developer Footer --- */
    .developer-footer {
        margin-top: 25px;
        font-size: 13px;
        color: #6c757d;
        animation: fadeIn 1.5s ease-in-out;
    }

    .developer-footer strong {
        color: #0d6efd;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .developer-footer strong:hover {
        color: #004bb7;
    }

    .dev-link {
        color: #0d6efd;
        text-decoration: none;
        margin-left: 4px;
        transition: all 0.3s ease;
    }

    .dev-link:hover {
        color: #004bb7;
        text-decoration: underline;
    }

    /* --- Typewriter Animation --- */
    .typewriter {
        display: inline-block;
        border-right: 2px solid #0d6efd;
        white-space: nowrap;
        overflow: hidden;
        letter-spacing: 0.03em;
        animation: typing 3.5s steps(35, end),
        blink 0.8s step-end infinite alternate;
    }

    @keyframes typing {
        from {
            width: 0
        }
        to {
            width: 100%
        }
    }

    @keyframes blink {
        50% {
            border-color: transparent
        }
    }

</style>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const typewriter = document.querySelector(".typewriter");
        setInterval(() => {
            typewriter.style.animation = "none";
            void typewriter.offsetWidth; // Trigger reflow
            typewriter.style.animation = null;
        }, 8000);
    });
</script>
