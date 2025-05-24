<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online Quiz System | Test Your Knowledge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="image/logo.png" />
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
        
        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            background: linear-gradient(135deg, rgba(74, 107, 255, 0.1) 0%, rgba(255, 107, 107, 0.1) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(74, 107, 255, 0.05) 0%, transparent 70%);
            animation: pulse 15s infinite alternate;
        }
        
        .hero-content {
            max-width: 600px;
            z-index: 1;
            animation: fadeInUp 1s ease;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            line-height: 1.2;
        }
        
        .hero h1 span {
            color: var(--primary-color);
            position: relative;
        }
        
        .hero h1 span::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 10px;
            background-color: rgba(74, 107, 255, 0.2);
            z-index: -1;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #555;
            line-height: 1.6;
        }
        
        .hero-btns {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 1rem;
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
        
        .btn-secondary {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        
        .hero-image {
            position: absolute;
            right: 5%;
            width: 50%;
            max-width: 700px;
            animation: float 6s ease-in-out infinite;
        }
        
        /* Features Section */
        .features {
            padding: 6rem 5%;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        
        .section-title p {
            color: #777;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats {
            padding: 4rem 5%;
            background: linear-gradient(135deg, var(--primary-color), #6c5ce7);
            color: white;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .stat-item {
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* CTA Section */
        .cta {
            padding: 6rem 5%;
            text-align: center;
            background-color: #f8f9fa;
        }
        
        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
        }
        
        .cta p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        /* Footer */
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
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.05;
            }
            100% {
                transform: scale(1.1);
                opacity: 0.1;
            }
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.8rem;
            }
            
            .hero-image {
                width: 45%;
                opacity: 0.7;
            }
        }
        
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
            
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 100px;
                height: auto;
                min-height: 100vh;
            }
            
            .hero-content {
                max-width: 100%;
                margin-bottom: 3rem;
            }
            
            .hero-btns {
                justify-content: center;
            }
            
            .hero-image {
                position: relative;
                right: auto;
                width: 80%;
                margin: 0 auto;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .hero-btns {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn {
                width: 100%;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <a href="#" class="logo">
                <img src="image/logo.jpeg" alt="Quiz Logo">
                QuizMaster
            </a>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#">Quizzes</a></li>
                <li><a href="#">Leaderboard</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Test Your Knowledge with Our <span>Online Quiz System</span></h1>
            <p>Join thousands of learners worldwide and challenge yourself with our interactive quizzes. Improve your skills, track your progress, and compete with others.</p>
            <div class="hero-btns">
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            </div>
        </div>
        <img src="image/online quiz.png" alt="Online Quiz Illustration" class="hero-image">
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-title">
            <h2>Why Choose Our Quiz Platform</h2>
            <p>Discover the features that make our online quiz system stand out from the rest</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Instant Feedback</h3>
                <p>Get immediate results and detailed explanations for each question to enhance your learning experience.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Progress Tracking</h3>
                <p>Monitor your improvement over time with comprehensive analytics and performance reports.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3>Competitive Leaderboards</h3>
                <p>Compete with other users and climb the leaderboard to showcase your knowledge.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-count="10000">0</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="500">0</div>
                <div class="stat-label">Quizzes Available</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="95">0</div>
                <div class="stat-label">% Satisfaction</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="24">0</div>
                <div class="stat-label">/7 Support</div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to Challenge Yourself?</h2>
            <p>Join our community of learners today and start your journey to knowledge mastery with our interactive quiz platform.</p>
            <div class="hero-btns">
                <a href="register.php" class="btn btn-primary">Get Started Now</a>
            </div>
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
                    <li><a href="#">Home</a></li>
                    <li><a href="#features">Features</a></li>
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
        
        // Animate stats counter
        function animateStats() {
            const statItems = document.querySelectorAll('.stat-item');
            
            statItems.forEach(item => {
                const numberElement = item.querySelector('.stat-number');
                const target = parseInt(numberElement.getAttribute('data-count'));
                const duration = 2000; // Animation duration in ms
                const step = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateNumber = () => {
                    current += step;
                    if(current < target) {
                        numberElement.textContent = Math.floor(current);
                        requestAnimationFrame(updateNumber);
                    } else {
                        numberElement.textContent = target;
                    }
                };
                
                // Start animation when element is in viewport
                const observer = new IntersectionObserver((entries) => {
                    if(entries[0].isIntersecting) {
                        updateNumber();
                        observer.unobserve(item);
                    }
                });
                
                observer.observe(item);
            });
        }
        
        // Run when page loads
        document.addEventListener('DOMContentLoaded', () => {
            animateStats();
            
            // Header scroll effect
            window.addEventListener('scroll', () => {
                const header = document.querySelector('header');
                if(window.scrollY > 50) {
                    header.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
                } else {
                    header.style.boxShadow = 'none';
                }
            });
        });
    </script>
</body>
</html>