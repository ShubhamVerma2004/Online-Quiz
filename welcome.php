<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email']))) {
        header("location:login.php");
    } else {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        include_once 'database.php';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Online Quiz System</title>
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
            padding: 1rem 5%;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
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
            font-size: 1rem;
            transition: var(--transition);
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
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
        
        .nav-links a.active {
            color: var(--primary-color);
        }
        
        .nav-links a.active::after {
            width: 100%;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-info img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--dark-color);
            cursor: pointer;
        }
        
        /* Main Content */
        .main-content {
            padding: 6rem 5% 2rem;
            min-height: calc(100vh - 150px);
        }
        
        .welcome-message {
            background: linear-gradient(135deg, var(--primary-color), #6c5ce7);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(74, 107, 255, 0.2);
        }
        
        .welcome-message h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .welcome-message p {
            opacity: 0.9;
        }
        
        /* Quiz Panel */
        .panel {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .panel-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            position: relative;
            padding-bottom: 10px;
        }
        
        .panel-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .table tr:hover {
            background-color: #f8f9fa;
        }
        
        .table-center td, .table-center th {
            text-align: center;
        }
        
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 3px 10px rgba(74, 107, 255, 0.3);
        }
        
        .btn-primary:hover {
            background-color: #3a5bef;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 107, 255, 0.4);
        }
        
        .btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--secondary-color);
            color: white;
        }
        
        /* Quiz Question */
        .quiz-question {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin: 2rem auto;
            max-width: 800px;
        }
        
        .quiz-question h2 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
        }
        
        .quiz-options {
            margin: 1.5rem 0;
        }
        
        .quiz-option {
            display: block;
            margin-bottom: 1rem;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .quiz-option:hover {
            border-color: var(--primary-color);
            background-color: #f8f9fa;
        }
        
        .quiz-option input[type="radio"] {
            margin-right: 10px;
        }
        
        /* Result Panel */
        .result-panel {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin: 2rem auto;
            max-width: 600px;
            text-align: center;
        }
        
        .result-panel h1 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        
        .result-stats {
            margin: 1.5rem 0;
        }
        
        .result-stat {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 5% 2rem;
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
        @media (max-width: 992px) {
            .nav-links {
                gap: 1.5rem;
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
            
            .main-content {
                padding: 6rem 5% 2rem;
            }
        }
        
        @media (max-width: 576px) {
            .welcome-message h1 {
                font-size: 1.5rem;
            }
            
            .panel {
                padding: 1rem;
            }
            
            .table th, .table td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <a href="welcome.php?q=1" class="logo">
                <img src="image/logo.jpeg" alt="Quiz Logo">
                QuizMaster
            </a>
            <ul class="nav-links">
                <li><a href="welcome.php?q=1" class="<?php if(@$_GET['q']==1) echo'active'; ?>"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="welcome.php?q=2" class="<?php if(@$_GET['q']==2) echo'active'; ?>"><i class="fas fa-history"></i> History</a></li>
                <li><a href="welcome.php?q=3" class="<?php if(@$_GET['q']==3) echo'active'; ?>"><i class="fas fa-trophy"></i> Ranking</a></li>
            </ul>
            <div class="user-info">
                <span><?php echo $name; ?></span>
                <a href="logout.php?q=welcome.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php if(@$_GET['q']==1): ?>
            <div class="welcome-message">
                <h1>Welcome, <?php echo $name; ?>!</h1>
                <p>Select a quiz below to test your knowledge and improve your skills.</p>
            </div>
            
            <?php
                $result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
                echo '<div class="panel">
                    <h2 class="panel-title">Available Quizzes</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><center>S.N.</center></th>
                                    <th><center>Topic</center></th>
                                    <th><center>Total Questions</center></th>
                                    <th><center>Total Marks</center></th>
                                    <th><center>Action</center></th>
                                </tr>
                            </thead>
                            <tbody>';
                
                $c = 1;
                while($row = mysqli_fetch_array($result)) {
                    $title = $row['title'];
                    $total = $row['total'];
                    $sahi = $row['sahi'];
                    $eid = $row['eid'];
                    $q12 = mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'") or die('Error98');
                    $rowcount = mysqli_num_rows($q12);    
                    
                    if($rowcount == 0) {
                        echo '<tr>
                            <td><center>'.$c++.'</center></td>
                            <td><center>'.$title.'</center></td>
                            <td><center>'.$total.'</center></td>
                            <td><center>'.$sahi*$total.'</center></td>
                            <td><center>
                                <a href="welcome.php?q=quiz&step=2&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-primary">
                                    <i class="fas fa-play"></i> Start
                                </a>
                            </center></td>
                        </tr>';
                    } else {
                        echo '<tr style="color:#99cc32">
                            <td><center>'.$c++.'</center></td>
                            <td><center>'.$title.' <i class="fas fa-check" title="This quiz is already solved by you"></i></center></td>
                            <td><center>'.$total.'</center></td>
                            <td><center>'.$sahi*$total.'</center></td>
                            <td><center>
                                <a href="update.php?q=quizre&step=25&eid='.$eid.'&n=1&t='.$total.'" class="btn btn-danger">
                                    <i class="fas fa-redo"></i> Restart
                                </a>
                            </center></td>
                        </tr>';
                    }
                }
                echo '</tbody></table></div></div>';
            ?>
        <?php endif; ?>

        <?php if(@$_GET['q']== 'quiz' && @$_GET['step']== 2): ?>
            <?php
                $eid = @$_GET['eid'];
                $sn = @$_GET['n'];
                $total = @$_GET['t'];
                $q = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' AND sn='$sn'");
                
                echo '<div class="quiz-question">';
                while($row = mysqli_fetch_array($q)) {
                    $qns = $row['qns'];
                    $qid = $row['qid'];
                    echo '<h2>Question '.$sn.' of '.$total.'</h2>
                        <p>'.$qns.'</p>';
                }
                
                $q = mysqli_query($con,"SELECT * FROM options WHERE qid='$qid'");
                echo '<form action="update.php?q=quiz&step=2&eid='.$eid.'&n='.$sn.'&t='.$total.'&qid='.$qid.'" method="POST" class="quiz-options">';
                
                while($row = mysqli_fetch_array($q)) {
                    $option = $row['option'];
                    $optionid = $row['optionid'];
                    echo '<label class="quiz-option">
                            <input type="radio" name="ans" value="'.$optionid.'" required> '.$option.'
                          </label>';
                }
                echo '<button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                        <i class="fas fa-paper-plane"></i> Submit Answer
                      </button>
                    </form>
                </div>';
            ?>
        <?php endif; ?>

        <?php if(@$_GET['q']== 'result' && @$_GET['eid']): ?>
            <?php
                $eid = @$_GET['eid'];
                $q = mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email'") or die('Error157');
                
                echo '<div class="result-panel">
                    <h1>Quiz Results</h1>
                    <div class="result-stats">';
                
                while($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    $w = $row['wrong'];
                    $r = $row['sahi'];
                    $qa = $row['level'];
                    
                    echo '<div class="result-stat">
                            <span>Total Questions:</span>
                            <span>'.$qa.'</span>
                          </div>
                          <div class="result-stat" style="color: var(--success-color);">
                            <span>Correct Answers:</span>
                            <span>'.$r.' <i class="fas fa-check-circle"></i></span>
                          </div>
                          <div class="result-stat" style="color: var(--secondary-color);">
                            <span>Wrong Answers:</span>
                            <span>'.$w.' <i class="fas fa-times-circle"></i></span>
                          </div>
                          <div class="result-stat" style="color: var(--primary-color); font-weight: bold;">
                            <span>Your Score:</span>
                            <span>'.$s.' <i class="fas fa-star"></i></span>
                          </div>';
                }
                
                $q = mysqli_query($con,"SELECT * FROM rank WHERE email='$email'") or die('Error157');
                while($row = mysqli_fetch_array($q)) {
                    $s = $row['score'];
                    echo '<div class="result-stat" style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1rem;">
                            <span>Overall Score:</span>
                            <span>'.$s.' <i class="fas fa-chart-line"></i></span>
                          </div>';
                }
                
                echo '</div>
                    <a href="welcome.php?q=1" class="btn btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>';
            ?>
        <?php endif; ?>

        <?php if(@$_GET['q']== 2): ?>
            <?php
                $q = mysqli_query($con,"SELECT * FROM history WHERE email='$email' ORDER BY date DESC") or die('Error197');
                
                echo '<div class="panel">
                    <h2 class="panel-title">Your Quiz History</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><center>S.N.</center></th>
                                    <th><center>Quiz</center></th>
                                    <th><center>Questions Solved</center></th>
                                    <th><center>Correct</center></th>
                                    <th><center>Wrong</center></th>
                                    <th><center>Score</center></th>
                                </tr>
                            </thead>
                            <tbody>';
                
                $c = 0;
                while($row = mysqli_fetch_array($q)) {
                    $eid = $row['eid'];
                    $s = $row['score'];
                    $w = $row['wrong'];
                    $r = $row['sahi'];
                    $qa = $row['level'];
                    $q23 = mysqli_query($con,"SELECT title FROM quiz WHERE eid='$eid'") or die('Error208');
                    
                    while($row = mysqli_fetch_array($q23)) {
                        $title = $row['title'];
                    }
                    $c++;
                    echo '<tr>
                            <td><center>'.$c.'</center></td>
                            <td><center>'.$title.'</center></td>
                            <td><center>'.$qa.'</center></td>
                            <td><center>'.$r.'</center></td>
                            <td><center>'.$w.'</center></td>
                            <td><center>'.$s.'</center></td>
                          </tr>';
                }
                echo '</tbody></table></div></div>';
            ?>
        <?php endif; ?>

        <?php if(@$_GET['q']== 3): ?>
            <?php
                $q = mysqli_query($con,"SELECT * FROM rank ORDER BY score DESC") or die('Error223');
                
                echo '<div class="panel">
                    <h2 class="panel-title">Leaderboard</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><center>Rank</center></th>
                                    <th><center>Name</center></th>
                                    <th><center>Email</center></th>
                                    <th><center>Score</center></th>
                                </tr>
                            </thead>
                            <tbody>';
                
                $c = 0;
                while($row = mysqli_fetch_array($q)) {
                    $e = $row['email'];
                    $s = $row['score'];
                    $q12 = mysqli_query($con,"SELECT * FROM user WHERE email='$e'") or die('Error231');
                    
                    while($row = mysqli_fetch_array($q12)) {
                        $name = $row['name'];
                    }
                    $c++;
                    echo '<tr>
                            <td><center><b>'.$c.'</b></center></td>
                            <td><center>'.$name.'</center></td>
                            <td><center>'.$e.'</center></td>
                            <td><center>'.$s.'</center></td>
                          </tr>';
                }
                echo '</tbody></table></div></div>';
            ?>
        <?php endif; ?>
    </main>

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
                    <li><a href="welcome.php?q=1">Home</a></li>
                    <li><a href="welcome.php?q=2">History</a></li>
                    <li><a href="welcome.php?q=3">Ranking</a></li>
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
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <p><i class="fas fa-envelope"></i>Shubhamverma945134@gmail.com</p>
                <p><i class="fas fa-phone"></i> +1 (123) 456-7890</p>
                <p><i class="fas fa-map-marker-alt"></i>  Knowledge City</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 QuizMaster. All Rights Reserved. | Designed with <i class="fas fa-heart" style="color: var(--secondary-color);"></i>  Shubham Kumar Verma</p>
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
        
        // Highlight selected radio option
        document.querySelectorAll('.quiz-option input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.quiz-option').forEach(option => {
                    option.style.borderColor = '#ddd';
                    option.style.backgroundColor = 'transparent';
                });
                
                if(this.checked) {
                    this.closest('.quiz-option').style.borderColor = 'var(--primary-color)';
                    this.closest('.quiz-option').style.backgroundColor = '#f8f9fa';
                }
            });
        });
    </script>
</body>
</html>