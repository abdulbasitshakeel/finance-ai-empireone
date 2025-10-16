<?php

include_once('include/db.php');

if(isset($_SESSION['logined_user']))
{
  header('location: index.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - EmpireOne</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    body {
      font-family: "Inter", sans-serif;
      overflow: hidden;
      position: relative;
      background: url('./assets/images/login-bg.jpg') center/cover no-repeat;
    }

    /* ✨ Gradient overlay (pastel) */
    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background: linear-gradient(to right, #e4c3e0c7, #fcc9c6, #fee6c4, #bbd2febd);
      opacity: 0.55;
      z-index: 0;
      pointer-events: none;
    }

    /* 🖤 Soft black overlay for contrast */
    body::after {
      content: "";
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.25);
      z-index: 0;
      pointer-events: none;
    }

    #particles-js {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    /* 🌸 Glass Form Container */
    .glass-container {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.55);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    /* ✨ Before / After Glowing Circles */
    .glass-container::before,
    .glass-container::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.5;
      z-index: 0;
      animation: floatCircle 12s ease-in-out infinite alternate;
    }

    .glass-container::before {
      width: 220px;
      height: 220px;
      top: -80px;
      left: -80px;
      background: radial-gradient(circle, rgba(255, 183, 197, 0.8), transparent 70%);
    }

    .glass-container::after {
      width: 280px;
      height: 280px;
      bottom: -100px;
      right: -100px;
      background: radial-gradient(circle, rgba(187, 210, 254, 0.8), transparent 70%);
      animation-delay: 4s;
    }

    @keyframes floatCircle {
      0% {
        transform: translate(0, 0) scale(1);
      }

      100% {
        transform: translate(30px, -30px) scale(1.1);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.98);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .form-container {
      animation: fadeIn 1s ease-out forwards;
    }

    /* Inputs clean + minimal look */
    .input-field {
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.75);
      color: #1f2937;
      border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .input-field:focus {
      background: rgba(255, 255, 255, 0.85);
      border-color: rgba(0, 0, 0, 0.15);
      outline: none;
      box-shadow: none;
    }

    .input-group {
      position: relative;
      z-index: 2;
    }

    .floating-label {
      position: absolute;
      top: 0.85rem;
      left: 3rem;
      color: #6b7280;
      pointer-events: none;
      transition: all 0.2s ease-out;
      transform-origin: left top;
    }

    .input-field:focus~.floating-label,
    .input-field:not(:placeholder-shown)~.floating-label {
      transform: translateY(-1.5rem) scale(0.8);
      color: #7e22ce;
    }

    /* 🌟 Logo animation (glow + pulse) */
    @keyframes logoGlow {
      0% {
        filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.2)) drop-shadow(0 0 15px rgba(187, 210, 254, 0.4));
      }

      50% {
        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.4)) drop-shadow(0 0 30px rgba(187, 210, 254, 0.6));
      }

      100% {
        filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.2)) drop-shadow(0 0 15px rgba(187, 210, 254, 0.4));
      }
    }

    .logo-animate {
      animation: logoGlow 5s ease-in-out infinite;
    }

    /* 🎯 Smooth Sign-in Button */
    .btn-login {
      background: linear-gradient(to right, #a855f7, #ec4899);
      transition: all 0.4s ease;
      transform-origin: center;
    }

    .btn-login:hover {
      background: linear-gradient(to right, #9333ea, #db2777);
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(236, 72, 153, 0.4), 0 0 10px rgba(168, 85, 247, 0.3);
    }

    .btn-login:active {
      transform: scale(0.98);
      box-shadow: 0 0 8px rgba(236, 72, 153, 0.3);
    }

    /* Custom SweetAlert2 Toast for Login */
    .login-swal {
      background: #fff3f3 !important;          /* light red background */
      color: #991b1b !important;               /* dark red text */
      border: 1px solid #fecaca !important;    /* soft red border */
      border-radius: 12px !important;          /* rounded corners */
      font-size: 15px !important;
      font-weight: 500 !important;
      box-shadow: 0 4px 14px rgba(0,0,0,0.18) !important;
      padding: 10px 16px !important;
    }

    /* Title text */
    .login-swal .swal2-title {
      font-size: 16px !important;
      font-weight: 600 !important;
    }

    /* Progress bar */
    .login-swal .swal2-timer-progress-bar {
      background: linear-gradient(to right, #ef4444, #f87171) !important;
      height: 4px !important;
      border-radius: 4px !important;
    }
  </style>
</head>

<body>
  <div id="particles-js"></div>

  <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
    <div class="form-container w-full max-w-md">
      <div class="glass-container rounded-2xl p-8 sm:p-10" style="padding: 50px 40px;">
        <div class="text-center mb-8 relative z-2 flex flex-col items-center justify-center">
          <img src="assets/images/logo.png" alt="EmpireOne Logo"
            class="h-20 sm:h-24 w-auto mb-4 object-contain logo-animate" style="height: 5rem;" />
          <h2 class="text-4xl font-bold text-gray-900">Welcome</h2>
          <p class="text-gray-700 mt-1">Login To Continue</p>
        </div>

        <form>
          <div class="space-y-8">
            <div class="relative input-group">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-feather="mail" class="w-5 h-5 text-gray-500 input-icon transition-colors duration-300"></i>
              </div>
              <input id="email" name="email" type="email" autocomplete="email" required
                class="input-field block w-full pl-12 pr-4 py-3 rounded-lg placeholder-transparent focus:outline-none"
                placeholder="Email address" />
              <label for="email" class="floating-label">Email address</label>
            </div>

            <div class="relative input-group">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-feather="lock" class="w-5 h-5 text-gray-500 input-icon transition-colors duration-300"></i>
              </div>
              <input id="password" name="password" type="password" autocomplete="current-password" required
                class="input-field block w-full pl-12 pr-4 py-3 rounded-lg placeholder-transparent focus:outline-none"
                placeholder="Password" />
              <label for="password" class="floating-label">Password</label>
            </div>
          </div>

          <div class="mt-8">
            <button type="submit"
              class="btn-login w-full flex justify-center py-3 px-4 rounded-lg text-base font-medium text-white focus:outline-none">
              Sign in
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ✨ Particles Script -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      feather.replace();
      particlesJS("particles-js", {
        particles: {
          number: {
            value: 80,
            density: {
              enable: true,
              value_area: 800
            }
          },
          color: {
            value: "#ffffff"
          },
          shape: {
            type: "circle"
          },
          opacity: {
            value: 0.4
          },
          size: {
            value: 3,
            random: true
          },
          line_linked: {
            enable: true,
            distance: 150,
            color: "#ffffff",
            opacity: 0.2,
            width: 1,
          },
          move: {
            enable: true,
            speed: 2
          },
        },
        interactivity: {
          events: {
            onhover: {
              enable: true,
              mode: "repulse"
            },
            onclick: {
              enable: true,
              mode: "push"
            },
          },
          modes: {
            repulse: {
              distance: 100,
              duration: 0.4
            }
          },
        },
        retina_detect: true,
      });
    });
    
    const loginForm = document.querySelector("form");
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(loginForm);
      try {
        const res = await fetch("login_verify.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();
        if (data.status === 'success' && data.redirect) {
          window.location.href = data.redirect;
        } else {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            customClass: {
              popup: 'login-swal'
            }
          });
        }
      } catch (error) {
        console.error("Error:", error);
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Something went wrong!',
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true
        });
      }
    });
  </script>
</body>

</html>