<?php 
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
$system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
?>

<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Smart School Management System — Enterprise Login">
<link rel="icon" sizes="16x16" href="<?php echo base_url() ?>uploads/logo.png">
<title>Login | <?php echo $system_title;?></title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0f0c29 url('<?php echo base_url(); ?>assets/images/login_b.png') no-repeat center center;
    background-size: cover;
    overflow: hidden;
    position: relative;
  }

  /* Animated Background Orbs - disabled for image background */
  body::before,
  body::after {
    display: none;
  }

  @keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.05); }
    66% { transform: translate(-20px, 20px) scale(0.95); }
  }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }

  @keyframes pulse-ring {
    0% { transform: scale(0.33); }
    80%, 100% { opacity: 0; }
  }

  /* Login Container */
  .login-container {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 460px;
    padding: 20px;
    animation: fadeInUp 0.8s ease-out;
  }

  /* Glass Card */
  .login-card {
    background: #ffffff;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 24px;
    padding: 48px 40px 40px;
    box-shadow: 
      0 32px 64px rgba(0, 0, 0, 0.15),
      0 8px 24px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .login-card:hover {
    transform: translateY(-4px);
    box-shadow: 
      0 40px 80px rgba(0, 0, 0, 0.2),
      0 12px 32px rgba(0, 0, 0, 0.12);
  }

  /* Logo Area */
  .logo-area {
    text-align: center;
    margin-bottom: 36px;
  }

  .logo-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
  }

  .logo-wrapper::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 200%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    animation: shimmer 3s infinite;
  }

  .logo-wrapper img {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    object-fit: contain;
    position: relative;
    z-index: 1;
  }

  .logo-area h1 {
    color: #1a1a2e;
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin-bottom: 6px;
  }

  .logo-area p {
    color: #6b7280;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 0.02em;
  }

  /* Form */
  .login-form {
    margin-top: 8px;
  }

  .form-group {
    margin-bottom: 20px;
    position: relative;
  }

  .form-group label {
    display: block;
    color: #374151;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 8px;
    letter-spacing: 0.02em;
  }

  .input-wrapper {
    position: relative;
  }

  .input-wrapper i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 16px;
    transition: color 0.3s ease;
    z-index: 2;
  }

  .form-input {
    width: 100%;
    padding: 14px 16px 14px 46px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    color: #1f2937;
    font-size: 15px;
    font-family: 'Inter', sans-serif;
    font-weight: 400;
    outline: none;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
  }

  .form-input::placeholder {
    color: #9ca3af;
    font-weight: 300;
  }

  .form-input:focus {
    background: #ffffff;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
  }

  .form-input:focus + i,
  .input-wrapper:focus-within i {
    color: #667eea;
  }

  /* Remember & Forgot */
  .form-extras {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
  }

  .remember-me {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
  }

  .remember-me input[type="checkbox"] {
    -webkit-appearance: none;
    appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #d1d5db;
    border-radius: 5px;
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
  }

  .remember-me input[type="checkbox"]:checked {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
  }

  .remember-me input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 12px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .remember-me span {
    color: #6b7280;
    font-size: 13px;
    font-weight: 400;
  }

  .forgot-link {
    color: #667eea;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .forgot-link:hover {
    color: #8b9cf7;
    text-decoration: none;
  }

  /* Login Button */
  .btn-login {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    letter-spacing: 0.04em;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
  }

  .btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s ease;
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.45);
  }

  .btn-login:hover::before {
    left: 100%;
  }

  .btn-login:active {
    transform: translateY(0);
  }

  .btn-login i {
    margin-right: 8px;
  }

  /* Divider */
  .divider {
    display: flex;
    align-items: center;
    margin: 24px 0;
    gap: 16px;
  }

  .divider::before,
  .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
  }

  .divider span {
    color: #9ca3af;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }

  /* Role Badges */
  .role-badges {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    color: #6b7280;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: default;
  }

  .role-badge:hover {
    background: rgba(102, 126, 234, 0.1);
    border-color: rgba(102, 126, 234, 0.3);
    color: #667eea;
  }

  .role-badge i {
    font-size: 13px;
  }

  /* Footer */
  .login-footer {
    text-align: center;
    margin-top: 32px;
    color: rgba(255, 255, 255, 0.85);
    font-size: 12px;
    letter-spacing: 0.02em;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
  }

  .login-footer a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .login-footer a:hover {
    color: #667eea;
  }

  /* Toast Notification */
  .toast-error {
    position: fixed;
    top: 24px;
    right: 24px;
    padding: 16px 24px;
    background: rgba(239, 68, 68, 0.9);
    backdrop-filter: blur(12px);
    border-radius: 12px;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 32px rgba(239, 68, 68, 0.3);
    z-index: 9999;
    animation: fadeInUp 0.4s ease-out;
  }

  .toast-error i {
    font-size: 18px;
  }

  /* Password Reset Form */
  #recoverform {
    display: none;
  }

  /* Responsive */
  @media (max-width: 480px) {
    .login-card {
      padding: 36px 24px 32px;
      border-radius: 20px;
    }
    .logo-area h1 {
      font-size: 18px;
    }
    .role-badges {
      gap: 6px;
    }
    .role-badge {
      padding: 6px 12px;
      font-size: 11px;
    }
  }
</style>
</head>
<body>

<?php if (($this->session->flashdata('error_message')) !=''): ?>
<div class="toast-error" id="errorToast">
  <i class="fa fa-exclamation-circle"></i>
  <?php echo $this->session->flashdata('error_message'); ?>
</div>
<?php endif; ?>

<div class="login-container">
  <div class="login-card">
    
    <!-- Logo -->
    <div class="logo-area">
      <div class="logo-wrapper">
        <img src="<?php echo base_url(); ?>uploads/logo.png" alt="Logo">
      </div>
      <h1><?php echo $system_name; ?></h1>
      <p>Sign in to your account</p>
    </div>

    <!-- Login Form -->
    <form method="post" id="loginform" class="login-form" action="<?php echo base_url();?>login/validate_login">
      
      <div class="form-group">
        <label for="email">Email Address</label>
        <div class="input-wrapper">
          <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required autofocus autocomplete="email">
          <i class="fa fa-envelope"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrapper">
          <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required autocomplete="current-password">
          <i class="fa fa-lock"></i>
        </div>
      </div>

      <div class="form-extras">
        <label class="remember-me">
          <input type="checkbox" id="remember">
          <span>Remember me</span>
        </label>
        <a href="javascript:void(0)" id="to-recover" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="btn-login">
        <i class="fa fa-sign-in"></i> Sign In
      </button>

    </form>

    <!-- Role Divider -->
    <div class="divider">
      <span>Supported Roles</span>
    </div>

    <div class="role-badges">
      <span class="role-badge"><i class="fa fa-shield"></i> Admin</span>
      <span class="role-badge"><i class="fa fa-calculator"></i> Accountant</span>
      <span class="role-badge"><i class="fa fa-user-plus"></i> Admission</span>
      <span class="role-badge"><i class="fa fa-graduation-cap"></i> Student</span>
      <span class="role-badge"><i class="fa fa-users"></i> Parent</span>
      <span class="role-badge"><i class="fa fa-chalkboard-teacher"></i> Teacher</span>
    </div>

    <!-- Password Reset Form (hidden) -->
    <form method="post" id="recoverform" class="login-form" action="<?php echo base_url();?>login/reset_password">
      <div class="form-group">
        <label for="recover-email">Enter your registered email</label>
        <div class="input-wrapper">
          <input type="email" id="recover-email" name="email" class="form-input" placeholder="Enter your email" required>
          <i class="fa fa-envelope"></i>
        </div>
      </div>
      <div style="display:flex; gap:10px; margin-top:16px;">
        <a href="<?php echo base_url();?>" style="flex:1;">
          <button type="button" class="btn-login" style="background: rgba(255,255,255,0.1); font-size:13px;">
            <i class="fa fa-arrow-left"></i> Back
          </button>
        </a>
        <button type="submit" class="btn-login" style="flex:1; font-size:13px;">
          <i class="fa fa-key"></i> Reset
        </button>
      </div>
    </form>

  </div>

  <div class="login-footer">
    <p>© <?php echo date('Y'); ?> <?php echo $system_name; ?> — Powered by <a href="#">Chaturveda Software Solutions</a></p>
  </div>
</div>

<!-- Minimal JS -->
<script>
  // Toggle forgot password form
  document.getElementById('to-recover').addEventListener('click', function() {
    document.getElementById('loginform').style.display = 'none';
    document.querySelector('.form-extras').style.display = 'none';
    document.getElementById('recoverform').style.display = 'block';
  });

  // Auto-hide error toast
  var toast = document.getElementById('errorToast');
  if (toast) {
    setTimeout(function() {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(-20px)';
      toast.style.transition = 'all 0.4s ease';
      setTimeout(function() { toast.remove(); }, 400);
    }, 4000);
  }

  // Input focus animations
  document.querySelectorAll('.form-input').forEach(function(input) {
    input.addEventListener('focus', function() {
      this.closest('.form-group').classList.add('focused');
    });
    input.addEventListener('blur', function() {
      this.closest('.form-group').classList.remove('focused');
    });
  });
</script>

</body>
</html>
