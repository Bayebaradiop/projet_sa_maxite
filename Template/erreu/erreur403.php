<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fall Page Design</title>
    <style>
        /* Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        /* Variables */
        :root {
            --primary: #ff4757;
            --secondary: #5352ed;
            --gradient-1: #ff6b6b;
            --gradient-2: #ff9f43;
            --dark: #2f3542;
            --light: #f1f2f6;
            --text: #333;
        }
        
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Particles Background */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            animation: float 20s infinite ease-in-out;
        }
        
    
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
        }
        
   
        nav ul {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
            transition: color 0.3s;
        }
        
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, var(--gradient-1), var(--gradient-2));
            transition: width 0.3s ease;
        }
    
        
        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4rem 0;
            position: relative;
        }
        
        .hero h1 {
            font-size: 5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 2rem;
            background: linear-gradient(to right, var(--gradient-1), var(--gradient-2));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: pulse 2s infinite;
            text-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
     
        
        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--gradient-1), var(--gradient-2));
            color: white;
        }
        
        .btn-secondary {
            background: white;
            color: var(--dark);
            border: 2px solid var(--gradient-2);
        }
        
        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.15);
        }
        
   
     
        
     
        
  
    </style>
</head>
<body>

    

    <div class="container">
       
        <section class="hero">
            <h1>Pas d'autorisation</h1>
        </section>
        
        
    </div>
</body>
</html>