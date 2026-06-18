<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance | My World</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #166088;
            --secondary-color: #4a6fa5;
            --accent-color: #ffc107;
            --dark-color: #151a22;
            --light-color: #f8f9fa;
            --text-color: #333;
            --text-light: #666;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #151a22 0%, #1e2738 100%);
            color: var(--light-color);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .maintenance-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Background Animation */
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(74, 111, 165, 0.1);
            animation: float 15s infinite linear;
        }
        
        .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 15%;
            animation-delay: 3s;
            animation-direction: reverse;
        }
        
        .circle:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 20%;
            animation-delay: 6s;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0.3;
            }
        }
        
        /* Content Styling */
        .maintenance-content {
            max-width: 800px;
            text-align: center;
            z-index: 1;
            position: relative;
        }
        
        .maintenance-icon {
            font-size: 6rem;
            color: var(--accent-color);
            margin-bottom: 2rem;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .maintenance-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--accent-color), #ffdb70);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
        }
        
        .maintenance-subtitle {
            font-size: 1.5rem;
            color: #b0b7c5;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .maintenance-message {
            font-size: 1.1rem;
            color: #8a94a6;
            margin-bottom: 3rem;
            line-height: 1.8;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Countdown Timer */
        .countdown-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 600px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .countdown-title {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: var(--accent-color);
            font-weight: 600;
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        
        .countdown-item {
            text-align: center;
            min-width: 100px;
        }
        
        .countdown-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-color);
            display: block;
            line-height: 1;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
        }
        
        .countdown-label {
            font-size: 0.9rem;
            color: #b0b7c5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Progress Bar */
        .progress-container {
            margin: 2rem 0;
        }
        
        .progress-text {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            color: #b0b7c5;
            font-size: 0.9rem;
        }
        
        .progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--accent-color), #ffdb70);
            border-radius: 4px;
            width: 65%;
            animation: progress-animation 3s infinite alternate;
        }
        
        @keyframes progress-animation {
            0% {
                width: 65%;
            }
            100% {
                width: 70%;
            }
        }
        
        /* Social Links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--light-color);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .social-link:hover {
            background: var(--accent-color);
            color: var(--dark-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }
        
        /* Back to Home Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--accent-color);
            color: var(--dark-color);
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            margin-top: 1rem;
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }
        
        .back-button:hover {
            background: #ffdb70;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
            color: var(--dark-color);
        }
        
        /* Footer */
        .maintenance-footer {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #8a94a6;
            font-size: 0.9rem;
        }
        
        .contact-info {
            margin-top: 1rem;
        }
        
        .contact-link {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .contact-link:hover {
            color: #ffdb70;
            text-decoration: underline;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .maintenance-title {
                font-size: 2.5rem;
            }
            
            .maintenance-subtitle {
                font-size: 1.2rem;
            }
            
            .maintenance-icon {
                font-size: 4rem;
            }
            
            .countdown {
                gap: 1rem;
            }
            
            .countdown-item {
                min-width: 80px;
            }
            
            .countdown-number {
                font-size: 2rem;
            }
            
            .countdown-container {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .maintenance-container {
                padding: 1rem;
            }
            
            .maintenance-title {
                font-size: 2rem;
            }
            
            .maintenance-subtitle {
                font-size: 1rem;
            }
            
            .countdown {
                gap: 0.5rem;
            }
            
            .countdown-item {
                min-width: 70px;
            }
            
            .countdown-number {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="background-animation">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
        
        <div class="maintenance-content">
            <div class="maintenance-icon">
                <i class="fas fa-tools"></i>
            </div>            
            <h1 class="maintenance-title">We'll Be Back Soon!</h1>
            <p class="maintenance-subtitle">This page is currently undergoing maintenance</p>
            
            <p class="maintenance-message">
                We're working hard to improve your experience. Our team is implementing 
                exciting updates and enhancements to make this page even better for you.
            </p>
      
        
            <div class="social-links">
                <a href="#" class="social-link">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-pinterest"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
            
            <a href="{{ url('/') }}" class="back-button">
                <i class="fas fa-home"></i>
                Back to Homepage
            </a>
            
            <div class="maintenance-footer">
                <p>Thank you for your patience and understanding.</p>
                <div class="contact-info">
                    <p>Need immediate assistance? 
                        <a href="mailto:support@myworld.com" class="contact-link">Contact our support team</a>
                    </p>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>