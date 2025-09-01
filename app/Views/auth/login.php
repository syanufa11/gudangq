<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<style>
    .sign-in-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding: 20px;
    }

    /* Animated background particles */
    .sign-in-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="20;80;20" dur="3s" repeatCount="indefinite"/></circle><circle cx="50" cy="60" r="1.5" fill="rgba(255,255,255,0.15)"><animate attributeName="cy" values="60;10;60" dur="4s" repeatCount="indefinite"/></circle><circle cx="80" cy="40" r="2.5" fill="rgba(255,255,255,0.08)"><animate attributeName="cy" values="40;90;40" dur="5s" repeatCount="indefinite"/></circle></svg>');
        z-index: 1;
        pointer-events: none;
    }

    .login-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 420px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        padding: 48px 40px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        transform: translateY(0);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: slideInUp 0.8s ease forwards;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
        background-size: 300% 100%;
        animation: gradientMove 3s ease-in-out infinite;
    }

    @keyframes gradientMove {

        0%,
        100% {
            background-position: 0% 0%;
        }

        50% {
            background-position: 100% 0%;
        }
    }

    .login-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 35px 80px rgba(0, 0, 0, 0.15);
    }

    .welcome-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: fadeInDown 0.8s ease 0.2s backwards;
    }

    .welcome-subtitle {
        color: #718096;
        font-size: 1rem;
        font-weight: 400;
        animation: fadeInDown 0.8s ease 0.4s backwards;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Form Input Styles (Dirapikan) */
    .form-floating {
        position: relative;
        margin-bottom: 20px;
    }

    .form-control {
        height: 50px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 16px 16px 44px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
        color: #2d3748;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        background: rgba(255, 255, 255, 1);
        outline: none;
    }

    .form-label {
        position: absolute;
        top: 50%;
        left: 44px;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 14px;
        transition: all 0.2s ease;
        pointer-events: none;
    }

    .form-control:focus+.form-label,
    .form-control:not(:placeholder-shown)+.form-label {
        top: -6px;
        left: 44px;
        font-size: 12px;
        color: #667eea;
        font-weight: 600;
        background: white;
        padding: 0 4px;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #a0aec0;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 16px;
        color: #a0aec0;
        cursor: pointer;
    }

    .password-toggle:hover {
        color: #667eea;
    }

    /* Button Signin */
    .btn-signin {
        width: 100%;
        height: 56px;
        border-radius: 16px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-size: 200% 100%;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        margin-top: 24px;
        cursor: pointer;
    }

    .btn-signin:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Logo */
    .logo-section {
        text-align: center;
        margin-bottom: 32px;
    }

    .logo-section img {
        max-width: 80px;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 480px) {
        .login-card {
            padding: 32px 24px;
            border-radius: 20px;
        }

        .form-control {
            height: 48px;
            padding: 14px 14px 14px 40px;
        }

        .form-control:focus+.form-label,
        .form-control:not(:placeholder-shown)+.form-label {
            left: 40px;
        }

        .input-icon {
            left: 10px;
            font-size: 14px;
        }

        .btn-signin {
            height: 52px;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="logo-section">
            <img src="<?= isset($aplikasi['logo']) ? base_url($aplikasi['logo']) : base_url('template/html/images/logo.png') ?>"
                alt="Logo">
        </div>

        <div class="welcome-header">
            <h1 class="welcome-title">Welcome Back</h1>
            <p class="welcome-subtitle">Sign in to continue to your admin panel</p>
        </div>

        <form action="<?= base_url('auth/login') ?>" method="post" id="loginForm">
            <?= csrf_field() ?>

            <div class="form-floating">
                <input type="text" class="form-control" id="login" name="login" placeholder=" " autocomplete="username"
                    required>
                <label for="login" class="form-label">Email or Username</label>
                <i class="fas fa-user input-icon"></i>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder=" "
                    autocomplete="current-password" required>
                <label for="password" class="form-label">Password</label>
                <i class="fas fa-lock input-icon"></i>
                <button type="button" class="password-toggle" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <!-- <div class="text-end mb-3">
                <a href="<?= base_url('auth/forgot') ?>" class="forgot-link">Forgot your password?</a>
            </div> -->

            <button type="submit" class="btn-signin" id="submitBtn">
                <span class="loading-spinner" id="loadingSpinner"></span>
                <span id="buttonText">Sign In</span>
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const toggleIcon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const buttonText = document.getElementById('buttonText');

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            loadingSpinner.style.display = 'inline-block';
            buttonText.textContent = 'Signing In...';
            setTimeout(() => {
                submitBtn.disabled = false;
                loadingSpinner.style.display = 'none';
                buttonText.textContent = 'Sign In';
            }, 10000);
        });

        setTimeout(() => { document.getElementById('login').focus(); }, 1500);
    });
</script>
<?= $this->endSection() ?>