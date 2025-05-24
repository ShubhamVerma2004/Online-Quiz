<?php
    require('database.php');
    session_start();
    if(isset($_SESSION["email"])) {
        session_destroy();
    }
    
    $ref = @$_GET['q'];        
    if(isset($_POST['submit'])) {    
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $email = stripslashes($email);
        $email = addslashes($email);
        $pass = stripslashes($pass); 
        $pass = addslashes($pass);
        $email = mysqli_real_escape_string($con,$email);
        $pass = mysqli_real_escape_string($con,$pass);                    
        $str = "SELECT * FROM user WHERE email='$email' and password='$pass'";
        $result = mysqli_query($con,$str);
        if((mysqli_num_rows($result))!=1) {
            echo "<script>alert('Sorry.. Wrong Username (or) Password');</script>";
        } else {
            $_SESSION['logged'] = $email;
            $row = mysqli_fetch_array($result);
            $_SESSION['name'] = $row[1];
            $_SESSION['id'] = $row[0];
            $_SESSION['email'] = $row[2];
            $_SESSION['password'] = $row[3];
            header('location: welcome.php?q=1');                    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Online Quiz System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a6bff;
            --secondary-color: #ff6b6b;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --success-color: #20c997;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            width: 100%;
            min-height: 100vh;
            background-color: #f5f7ff;
            color: var(--dark-color);
            overflow-x: hidden;
            background: linear-gradient(135deg, rgba(74, 107, 255, 0.1) 0%, rgba(255, 107, 107, 0.1) 100%);
        }
        
        /* Header Styles */
        header {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .logo img {
            height: 40px;
            transition: var(--transition);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            position: relative;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            bottom: -5px;
            left: 0;
            transition: var(--transition);
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--dark-color);
            cursor: pointer;
        }
        
        /* Login Form Styles */
        .login-section {
            padding: 8rem 5% 4rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            margin: 2rem 0;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        }
        
        .form-container:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-header h2 {
            font-size: 2rem;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: #666;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
            outline: none;
        }
        
        .forgot-password {
            float: right;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 1rem;
            width: 100%;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 5px 15px rgba(74, 107, 255, 0.3);
        }
        
        .btn-primary:hover {
            background-color: #3a5bef;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 107, 255, 0.4);
        }
        
        .btn-danger {
            background-color: var(--secondary-color);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
            margin-top: 1rem;
        }
        
        .btn-danger:hover {
            background-color: #e05555;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        /* Footer Styles */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 4rem 5% 2rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        .footer-column p {
            color: #bbb;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: var(--transition);
        }
        
        .social-links a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 3rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
            font-size: 0.9rem;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 5%;
            }
            
            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: white;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2rem;
                transition: var(--transition);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
            
            .nav-links.active {
                left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .form-container {
                padding: 2rem 1.5rem;
            }
            
            .form-header h2 {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 576px) {
            .form-header h2 {
                font-size: 1.5rem;
            }
            
            .form-header p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <a href="index.php" class="logo">
                <img src="image/logo.jpeg" alt="Quiz Logo">
                QuizMaster
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#features">Features</a></li>
                <li><a href="#">Quizzes</a></li>
                <li><a href="#">Leaderboard</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Login Form Section -->
    <section class="login-section">
        <div class="form-container">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Sign in to continue to your QuizMaster account</p>
            </div>
            <form method="post" action="login.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <a href="javascript:void(0)" class="forgot-password">Forgot Password?</a>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
                <div class="form-footer">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </form>
            <button class="btn btn-danger" onclick="location.href = 'admin.php';">Admin Login</button>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>About QuizMaster</h3>
                <p>QuizMaster is a leading online quiz platform dedicated to making learning fun and interactive for everyone.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php#features">Features</a></li>
                    <li><a href="#">Quizzes</a></li>
                    <li><a href="#">Leaderboard</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Quiz Categories</h3>
                <ul class="footer-links">
                    <li><a href="#">Programming</a></li>
                    <li><a href="#">Science</a></li>
                    <li><a href="#">Mathematics</a></li>
                    <li><a href="#">History</a></li>
                    <li><a href="#">General Knowledge</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <p><i class="fas fa-envelope"></i> Shubhamverma945134@gmail.com</p>
                <p><i class="fas fa-phone"></i> +1 (123) 456-7890</p>
                <p><i class="fas fa-map-marker-alt"></i> Knowledge City</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 QuizMaster. All Rights Reserved. | Designed with <i class="fas fa-heart" style="color: var(--secondary-color);"></i> Shubham Kumar Verma</p>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');
        
        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            mobileMenuBtn.innerHTML = navLinks.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                if(this.getAttribute('href') === '#') return;
                
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if(navLinks.classList.contains('active')) {
                        navLinks.classList.remove('active');
                        mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            });
        });
        
        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if(window.scrollY > 50) {
                header.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>