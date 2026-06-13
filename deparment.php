<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Departments</title>

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    /* Reset & base */
    * {
      box-sizing: border-box;
      margin: 0px;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background: linear-gradient(135deg, #f7f9fc 0%, #edf2f7 50%, #e2e8f0 100%);
      color: #2d3748;
      padding: 50px 15px;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      position: relative;
      overflow-x: hidden;
    }

    /* Animated background elements */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
                  radial-gradient(circle at 80% 20%, rgba(56, 178, 172, 0.05) 0%, transparent 50%),
                  radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.03) 0%, transparent 50%);
      z-index: -1;
      animation: floatLight 25s ease-in-out infinite;
    }

    @keyframes floatLight {
      0%, 100% { transform: translateY(0px) scale(1); }
      50% { transform: translateY(-30px) scale(1.1); }
    }
    
    /* Container */
    .container {
      max-width: 1220px;
      width: auto;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 28px;
      padding: 80px 40px;
      display: flex;
      justify-content: center;
      gap: 35px;
      box-shadow: 0 25px 80px rgba(0, 0, 0, 0.08),
                  0 0 0 1px rgba(255, 255, 255, 0.5),
                  inset 0 1px 0 rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(226, 232, 240, 0.3);
      
      flex-wrap: wrap;
      position: relative;
    }

    /* Decorative elements */
    .container::before {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
      border-radius: 30px;
      z-index: -1;
      animation: borderGlow 6s linear infinite;
      opacity: 0.1;
    }

    @keyframes borderGlow {
      0% { filter: hue-rotate(0deg); }
      100% { filter: hue-rotate(360deg); }
    }

    /* Page title */
    .page-title {
      width: 100%;
      text-align: center;
      margin-bottom: 60px;
      font-size: 3.2rem;
      font-weight: 700;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: gradientShiftLight 5s ease infinite;
      position: relative;
    }

    .page-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, #667eea, #764ba2);
      border-radius: 2px;
      animation: underlineGlow 3s ease-in-out infinite;
    }

    @keyframes gradientShiftLight {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes underlineGlow {
      0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.5); }
      50% { box-shadow: 0 0 40px rgba(118, 75, 162, 0.8); }
    }

    /* Department card */
    .dept-card {
      background: linear-gradient(145deg, #ffffff, #f8fafc);
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08),
                  0 1px 0 rgba(255, 255, 255, 0.8),
                  inset 0 1px 0 rgba(255, 255, 255, 0.9);
      padding: 45px 35px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
      cursor: pointer;
      color: #2d3748;
      text-align: center;
      user-select: none;
      width: 255px;
      box-sizing: border-box;
      border: 1px solid rgba(226, 232, 240, 0.6);
      position: relative;
      overflow: hidden;
    }
    
    /* Shimmer effect */
    .dept-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
      transition: left 0.6s ease;
    }

    .dept-card:hover::before {
      left: 100%;
    }

    /* Floating animation */
    .dept-card {
      animation: cardFloat 6s ease-in-out infinite;
    }

    .dept-card:nth-child(2) { animation-delay: -1s; }
    .dept-card:nth-child(3) { animation-delay: -2s; }
    .dept-card:nth-child(4) { animation-delay: -3s; }
    .dept-card:nth-child(5) { animation-delay: -4s; }

    @keyframes cardFloat {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-8px); }
    }

    .dept-card:hover {
      transform: translateY(-20px) scale(1.05);
      box-shadow: 0 35px 70px rgba(0, 0, 0, 0.15),
                  0 0 0 1px rgba(102, 126, 234, 0.2),
                  0 0 50px rgba(102, 126, 234, 0.1);
      background: linear-gradient(145deg, #ffffff, #f1f5f9);
      border-color: rgba(102, 126, 234, 0.3);
      animation: none;
    }

    /* Icon container */
    .dept-icon {
      width: 110px;
      height: 110px;
      border-radius: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 10px;
      color: white;
      font-size: 48px;
      user-select: none;
      position: relative;
      transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    /* Icon backgrounds with gradients */
    .dept-card.super-admin .dept-icon {
      background: linear-gradient(135deg, #667eea, #764ba2);
      box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
    }
    .dept-card.store-admin .dept-icon {
      background: linear-gradient(135deg, #48bb78, #38a169);
      box-shadow: 0 15px 35px rgba(72, 187, 120, 0.3);
    }
    .dept-card.manager .dept-icon {
      background: linear-gradient(135deg, #f6ad55, #ed8936);
      box-shadow: 0 15px 35px rgba(246, 173, 85, 0.3);
    }
    .dept-card.salesperson .dept-icon {
      background: linear-gradient(135deg, #4299e1, #3182ce);
      box-shadow: 0 15px 35px rgba(66, 153, 225, 0.3);
    }

    /* Icon hover effects */
    .dept-card:hover .dept-icon {
      transform: scale(1.15) rotate(10deg);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    /* Pulsing effect for icons */
    .dept-icon::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 100%;
      height: 100%;
      border-radius: 24px;
      background: inherit;
      transform: translate(-50%, -50%);
      animation: iconPulse 4s ease-in-out infinite;
      z-index: -1;
      opacity: 0.3;
    }

    @keyframes iconPulse {
      0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
      50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.1; }
    }

    /* Role Title */
    .dept-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 18px;
      color: #2d3748;
      position: relative;
      z-index: 2;
      transition: all 0.3s ease;
    }

    .dept-card:hover .dept-title {
      color: #1a202c;
      transform: translateY(-2px);
    }

    /* Role Description */
    .dept-desc {
      font-size: 1.05rem;
      color: #718096;
      line-height: 1.7;
      max-width: 280px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
      transition: all 0.3s ease;
    }

    .dept-card:hover .dept-desc {
      color: #4a5568;
      transform: translateY(-1px);
    }

    /* Responsive */
    @media (max-width: 680px) {
      .dept-card {
        width: 100%;
        margin: 0 10px;
      }
      .container {
        padding: 50px 25px;
        gap: 2px;
      }
      body {
        padding: 30px 10px;
      }
      .page-title {
        font-size: 2.8rem;
        margin-bottom: 45px;
      }
      .dept-icon {
        width: 90px;
        height: 90px;
        font-size: 40px;
        margin-bottom: 25px;
      }
      .dept-title {
        font-size: 1.6rem;
      }
      .dept-desc {
        max-width: 100%;
        font-size: 1rem;
      }
    }
  </style>

  <!-- FontAwesome icons -->
  <script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script>
</head>
<body>

  <div class="container">
    <h1 class="page-title">Departments</h1>

    <div class="dept-card super-admin">
      <div class="dept-icon">
        <i class="fas fa-user-shield" aria-hidden="true"></i>
      </div>
      <div class="dept-title">Super Admin</div>
      <div class="dept-desc">
        Has full control over the system, manages all users and settings with complete authority.
      </div>
    </div>

    <div class="dept-card store-admin">
      <div class="dept-icon">
        <i class="fas fa-store" aria-hidden="true"></i>
      </div>
      <div class="dept-title">Store Admin</div>
      <div class="dept-desc">
        Oversees daily store operations and manages store staff and inventory efficiently.
      </div>
    </div>

    <div class="dept-card manager">
      <div class="dept-icon">
        <i class="fas fa-user-tie" aria-hidden="true"></i>
      </div>
      <div class="dept-title">Manager</div>
      <div class="dept-desc">
        Manages team workflows, performance metrics, and reports to the store administration.
      </div>
    </div>

    <div class="dept-card salesperson">
      <div class="dept-icon">
        <i class="fas fa-user-check" aria-hidden="true"></i>
      </div>
      <div class="dept-title">Salesperson</div>
      <div class="dept-desc">
        Handles customer interactions, sales processes, and supports daily store operations.
      </div>
    </div>

  </div>

</body>
</html>