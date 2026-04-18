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
    background: transparent;
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    border: none;
    border-radius: 24px;
    padding: 48px 40px 40px;
    box-shadow: none;
    transition: transform 0.3s ease;
  }

  .login-card:hover {
    transform: translateY(-4px);
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
    color: #111827;
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin-bottom: 6px;
  }

  .logo-area p {
    color: #374151;
    font-size: 15px;
    font-weight: 600;
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
    color: #111827;
    font-size: 14px;
    font-weight: 600;
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
    color: #4b5563;
    font-size: 16px;
    transition: color 0.3s ease;
    z-index: 2;
  }

  .form-input {
    width: 100%;
    padding: 14px 16px 14px 46px;
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 12px;
    color: #111827;
    font-size: 15px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    outline: none;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
  }

  .form-input::placeholder {
    color: #6b7280;
    font-weight: 400;
  }

  .form-input:focus {
    background: rgba(255, 255, 255, 0.95);
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
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
    border: 2px solid #6b7280;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.5);
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
    color: #111827;
    font-size: 14px;
    font-weight: 500;
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
    color: #4b5563;
    font-size: 12px;
    font-weight: 600;
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
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    color: #1f2937;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: default;
  }

  .role-badge:hover {
    background: rgba(255, 255, 255, 0.9);
    border-color: rgba(102, 126, 234, 0.4);
    color: #667eea;
  }

  .role-badge i {
    font-size: 13px;
  }

  /* Footer */
  .login-footer {
    text-align: center;
    margin-top: 32px;
    color: #111827;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.02em;
  }

  .login-footer a {
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .login-footer a:hover {
    color: #4f46e5;
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

  /* User Guide Styles */
  .ug-btn {
    position: fixed; top: 20px; right: 30px; z-index: 50;
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    padding: 10px 20px; border-radius: 30px; font-weight: 600; color: #1f2937;
    border: 1px solid rgba(255,255,255,0.5); cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s;
  }
  .ug-btn:hover { background: #fff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
  .ug-btn i { color: #667eea; margin-right: 6px; }

  .ug-modal {
    position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
    background: rgba(15, 12, 41, 0.85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    z-index: 9999; display: flex; opacity: 0; visibility: hidden; transition: all 0.4s ease;
  }
  .ug-modal.active { opacity: 1; visibility: visible; }
  
  .ug-container {
    width: 90%; max-width: 1000px; height: 85vh; margin: auto;
    background: #ffffff; border-radius: 24px; box-shadow: 0 30px 60px rgba(0,0,0,0.3);
    display: flex; overflow: hidden; transform: translateY(30px); transition: all 0.4s ease; position: relative;
  }
  .ug-modal.active .ug-container { transform: translateY(0); }

  .ug-close {
    position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.05);
    width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 18px; color: #4b5563; z-index: 10; transition: background 0.2s;
  }
  .ug-close:hover { background: rgba(239,68,68,0.15); color: #ef4444; }

  .ug-sidebar { width: 250px; background: #f8fafc; border-right: 1px solid #e2e8f0; padding: 30px 0; }
  .ug-sidebar-title { padding: 0 30px 20px; font-weight: 700; font-size: 18px; color: #0f172a; border-bottom: 1px solid #e2e8f0; margin-bottom: 10px; }
  .ug-tab { padding: 15px 30px; display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 500; color: #64748b; transition: all 0.2s; border-left: 3px solid transparent; }
  .ug-tab:hover { background: #f1f5f9; color: #334155; }
  .ug-tab.active { background: #eff6ff; color: #2563eb; border-left-color: #2563eb; font-weight: 600; }
  .ug-tab i { font-size: 16px; width: 20px; text-align: center; }

  .ug-content-area { flex: 1; padding: 40px; overflow-y: auto; background: #ffffff; }
  .ug-pane { display: none; animation: fadeIn 0.4s ease; }
  .ug-pane.active { display: block; }
  .ug-header { margin-bottom: 30px; }
  .ug-header h2 { font-size: 28px; color: #1e293b; margin-bottom: 8px; font-weight: 700; }
  .ug-header p { color: #64748b; font-size: 15px; }

  .ug-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
  .ug-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s; }
  .ug-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,0.06); border-color: #cbd5e1; }
  .ug-card-icon { width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 16px; }
  .ug-card-icon.red { background: #fef2f2; color: #ef4444; }
  .ug-card-icon.green { background: #f0fdf4; color: #22c55e; }
  .ug-card-icon.purple { background: #faf5ff; color: #a855f7; }
  .ug-card h3 { font-size: 16px; color: #0f172a; margin-bottom: 8px; font-weight: 600; }
  .ug-card p { color: #475569; font-size: 13px; line-height: 1.5; }

  @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  @media (max-width: 768px) {
    .ug-container { flex-direction: column; width: 100%; height: 100vh; border-radius: 0; }
    .ug-sidebar { width: 100%; border-right: none; border-bottom: 1px solid #e2e8f0; display: flex; padding: 10px; overflow-x: auto; white-space: nowrap; }
    .ug-sidebar-title { display: none; }
    .ug-tab { padding: 10px 15px; border-left: none; border-bottom: 2px solid transparent; }
    .ug-tab.active { border-left-color: transparent; border-bottom-color: #2563eb; }
    .ug-content-area { padding: 20px; }
  }
</style>
</head>
<body>

<button class="ug-btn" id="openUgBtn">
  <i class="fa fa-book"></i> User Guide
</button>

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



  </div>

  <div class="login-footer">
    <p>© <?php echo date('Y'); ?> <?php echo $system_name; ?> — Powered by <a href="#">Chaturveda Software Solutions</a></p>
  </div>
</div>

<!-- User Guide Modal -->
<div class="ug-modal" id="ugModal">
  <div class="ug-container">
    <div class="ug-close" id="closeUgBtn"><i class="fa fa-times"></i></div>

    <!-- Sidebar -->
    <div class="ug-sidebar">
      <div class="ug-sidebar-title">Application Guide</div>
      <div class="ug-tab active" data-target="pane-admin"><i class="fa fa-shield"></i> Administrator</div>
      <div class="ug-tab" data-target="pane-teacher"><i class="fa fa-chalkboard-teacher"></i> Teacher</div>
      <div class="ug-tab" data-target="pane-student"><i class="fa fa-graduation-cap"></i> Student</div>
      <div class="ug-tab" data-target="pane-parent"><i class="fa fa-users"></i> Parent</div>
      <div class="ug-tab" data-target="pane-accountant"><i class="fa fa-calculator"></i> Accountant</div>
      <div class="ug-tab" data-target="pane-admission"><i class="fa fa-user-plus"></i> Admission</div>
    </div>

    <!-- Content Area -->
    <div class="ug-content-area">
      <!-- Admin Pane -->
      <div class="ug-pane active" id="pane-admin">
        <div class="ug-header">
          <h2>Administrator Portal</h2>
          <p>Complete control over system settings, user management, and high-level analytics.</p>
        </div>
        <div class="ug-grid">
          <div class="ug-card">
            <div class="ug-card-icon purple"><i class="fa fa-cogs"></i></div>
            <h3>System Settings</h3>
            <p>Configure academic years, school branding, external integrations, and core system preferences.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon"><i class="fa fa-users"></i></div>
            <h3>User Management</h3>
            <p>Onboard and manage permissions for teachers, parents, students, accountants, and other staff.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon green"><i class="fa fa-sitemap"></i></div>
            <h3>Academics & HR</h3>
            <p>Organize classes, subjects, syllabus, manage payroll, leave requests, and employee directory.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon red"><i class="fa fa-bullhorn"></i></div>
            <h3>Communication</h3>
            <p>Send bulk SMS and emails, publish global notices, and manage the event calendar.</p>
          </div>
        </div>
      </div>

      <!-- Teacher Pane -->
      <div class="ug-pane" id="pane-teacher">
        <div class="ug-header">
          <h2>Teacher Portal</h2>
          <p>Streamline daily classroom operations, student evaluation, and parent communication.</p>
        </div>
        <div class="ug-grid">
          <div class="ug-card">
            <div class="ug-card-icon green"><i class="fa fa-check-square-o"></i></div>
            <h3>Daily Attendance</h3>
            <p>Quickly mark class attendance with an intuitive interface and view historical attendance reports.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon purple"><i class="fa fa-book"></i></div>
            <h3>Academics & Marks</h3>
            <p>Input exam marks, manage subject-specific study materials, upload homework, and track progress.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon"><i class="fa fa-comments"></i></div>
            <h3>Parent Interactions</h3>
            <p>Send direct messages to parents regarding student behavior, progress, and upcoming events.</p>
          </div>
        </div>
      </div>

      <!-- Student Pane -->
      <div class="ug-pane" id="pane-student">
        <div class="ug-header">
          <h2>Student Portal</h2>
          <p>Empowering students with access to their academic resources and personal timelines.</p>
        </div>
        <div class="ug-grid">
          <div class="ug-card">
            <div class="ug-card-icon"><i class="fa fa-file-text-o"></i></div>
            <h3>Report Cards</h3>
            <p>Real-time access to exam results, performance charts, and downloadable official report cards.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon purple"><i class="fa fa-calendar"></i></div>
            <h3>Timetable & Live Classes</h3>
            <p>View daily class routines and securely join scheduled online live classes via external integrations.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon green"><i class="fa fa-download"></i></div>
            <h3>Study Material</h3>
            <p>Download notes, syllabus, and submit homework assignments directly through the portal.</p>
          </div>
        </div>
      </div>

      <!-- Parent Pane -->
      <div class="ug-pane" id="pane-parent">
        <div class="ug-header">
          <h2>Parent Portal</h2>
          <p>Keeping parents in the loop concerning their child's academic journey and school updates.</p>
        </div>
        <div class="ug-grid">
          <div class="ug-card">
            <div class="ug-card-icon purple"><i class="fa fa-child"></i></div>
            <h3>Child Overview</h3>
            <p>Switch seamlessly between multiple children. Track daily attendance and academic progress in one place.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon green"><i class="fa fa-credit-card"></i></div>
            <h3>Online Fee Payment</h3>
            <p>View upcoming invoices, fee history, and securely pay tuition and other fees via integrated payment gateways.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon"><i class="fa fa-envelope-o"></i></div>
            <h3>Direct Teacher Chat</h3>
            <p>Communicate directly with class teachers for feedback and stay informed with school-wide broadcast messages.</p>
          </div>
        </div>
      </div>

      <!-- Accountant Pane -->
      <div class="ug-pane" id="pane-accountant">
        <div class="ug-header">
          <h2>Accountant Portal</h2>
          <p>Centralized financial management, from fee collection to payroll and expense tracking.</p>
        </div>
        <div class="ug-grid">
          <div class="ug-card">
            <div class="ug-card-icon green"><i class="fa fa-money"></i></div>
            <h3>Fee Collection</h3>
            <p>Create fee types, generate mass invoices for classes, process offline payments, and track defaulters.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon red"><i class="fa fa-line-chart"></i></div>
            <h3>Expense Management</h3>
            <p>Record school expenses, categorize spending, and maintain a clear ledger for transparent accounting.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon purple"><i class="fa fa-file-excel-o"></i></div>
            <h3>Financial Reports</h3>
            <p>Generate precise financial statements, transaction histories, and balance sheets for management review.</p>
          </div>
        </div>
      </div>

      <!-- Admission Pane -->
      <div class="ug-pane" id="pane-admission">
        <div class="ug-header">
          <h2>Admission Portal</h2>
          <p>Streamlined workflow for handling prospective student applications and enrollment.</p>
        </div>
        <div class="ug-grid">
          <div class="ug-card">
            <div class="ug-card-icon"><i class="fa fa-globe"></i></div>
            <h3>Online Applications</h3>
            <p>Review and process incoming applications submitted via the school's public website interface.</p>
          </div>
          <div class="ug-card">
            <div class="ug-card-icon green"><i class="fa fa-user-plus"></i></div>
            <h3>Enrollment Workflow</h3>
            <p>Approve applications, assign roll numbers, allocate hostels/transport, and officially enroll students.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Minimal JS -->
<script>


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

  // User Guide Modal Logic
  const ugModal = document.getElementById('ugModal');
  const openUgBtn = document.getElementById('openUgBtn');
  const closeUgBtn = document.getElementById('closeUgBtn');
  const ugTabs = document.querySelectorAll('.ug-tab');
  const ugPanes = document.querySelectorAll('.ug-pane');

  openUgBtn.addEventListener('click', () => {
    ugModal.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  closeUgBtn.addEventListener('click', () => {
    ugModal.classList.remove('active');
    document.body.style.overflow = 'auto';
  });

  ugModal.addEventListener('click', (e) => {
    if(e.target === ugModal) {
      ugModal.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  });

  ugTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Remove active class from all tabs
      ugTabs.forEach(t => t.classList.remove('active'));
      // Add active to clicked tab
      tab.classList.add('active');
      
      // Hide all panes
      ugPanes.forEach(p => p.classList.remove('active'));
      // Show target pane
      const targetId = tab.getAttribute('data-target');
      document.getElementById(targetId).classList.add('active');
    });
  });
</script>

</body>
</html>
