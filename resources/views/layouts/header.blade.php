<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ConstructKaro</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
    }

    header {
      background-color: #1c2c3e;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .logo-container {
      display: flex;
      align-items: center;
    }

    .logo-container img {
      max-height: 60px;
      width: auto;
      display: block;
    }

    .brand-text {
      color: white;
      font-size: 24px;
      font-weight: bold;
      margin-left: 10px;
    }

    .brand-text span {
      color: #f25c05;
    }

    nav {
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      font-size: 16px;
    }

    nav a:hover {
      color: #f25c05;
      border-bottom: 2px solid #f25c05;
      padding-bottom: 2px;
      transition: all 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }

      nav {
        margin-top: 10px;
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>

<header>
  <div class="logo-container">
    {{-- <img src="storage/logo/nobglogo.png" alt="ConstructKaro Logo" /> --}}
    <div class="brand-text">CONSTRUCT<span>KARO</span></div>
  </div>

  <nav>
    <a href="#home">Home</a>
    <a href="#services">Services</a>
    <a href="#projects">Projects</a>
    <a href="#contact">Contact</a>
  </nav>
</header>

</body>
</html>
