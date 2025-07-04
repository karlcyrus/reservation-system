<?php
include 'db_connection.php'; // Connect to PostgreSQL using PDO
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // You can use password_verify() if using hashed passwords
        if ($password === $user['password']) {
            header("Location: schedule.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="custom-navbar">
    <div class="logo">MediPet</div>
    <div class="menu-toggle">&#9776;</div> <!-- burger icon -->
        <div class="custom-nav-links">
            <a href="#home">Home</a>
            <a href="#about-us">About Us</a>
            <a href="#service-offer">Service</a>
        </div>
    </div>
    <section id="home" class="hp_background">
        <div class="form_container fade-slide">
            <h1>Login</h1>
            <?php if (!empty($error)): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form_input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required placeholder="Username">
                </div>
                <div class="form_input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required placeholder="Password">
                </div>
                    <button type="submit" class="login_button">Login</button>
                </form>
            </div>
    </section>
    <section id="about-us" class="d-flex align-items-center py-5  fade-slide" style="background: #ffffff;">
        <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between">
            <div class="image-container text-center text-lg-start">
                <div class="image-wrapper">
                    <img src="Images/pic-dog.jpg" class="img-fluid rounded shadow" alt="Dog">
                </div>
            </div>
            <div class="text-content ml-lg-5 p-5">
                <h3 class="text-muted mb-5">Why people choose us</h3>
                <h2 class="text-primary mb-4">A few reasons why people prefer our services</h2>
                <p class="mb-4">Since our establishment in 1999, we have worked to deliver the best grooming services for your dogs and cats. Pet owners across the US choose our salon for:</p>
                <ul class="list-unstyled">
                    <li class="mb-2">✔ Healthy and safe environment</li>
                    <li class="mb-2">✔ High-quality and sterile equipment</li>
                    <li class="mb-2">✔ Different grooming styles for your pets</li>
                    <li>✔ Convenient and affordable</li>
                </ul>
                <a href="#" class="btn btn-warning mt-4 fs-5">Book Now</a>
            </div>
        </div>
    </section>
    <section id="service-offer" class="fade-slide">
        <div class="container d-flex flex-column justify-content-center align-items-center text-center">
            <h1 class="mb-3" style="color:	#5D1049">Let us take care of your pets! Grooming? Check-up? Safe hands?</h1>
            <h1 class="mb-5" style="color: #FF6F00">Book now!</h1>
            <h2 class="mb-4" style="color: #263238">Our Services</h2>
            <p class="mb-4" style="color: #546E7A">Explore our premium grooming and veterinary services tailored for your pets.</p>
            <div class="container service-container">
                <div class="service-box">
                    <div class="grooming-service">
                        <i class="fa-solid fa-shower fa-3x" style="color: #00838F"></i>
                    </div>
                    <p class="service-text" style="color: #37474F">Grooming Service</p>
                    <p class="service-desc" style="color: #607D8B">Professional grooming to keep your pets clean and stylish.</p>
                </div>
                
                <div class="service-box">
                    <div class="checkup-service">
                        <i class="fa-solid fa-check-to-slot fa-3x" style="color: #00838F"></i>
                    </div>
                    <p class="service-text" style="color: #37474F">Check-up Service</p>
                    <p class="service-desc" style="color: #607D8B">Regular health checks to keep your furry friends in top shape.</p>
                </div>

                <div class="service-box">
                    <div class="vaccine-service">  
                        <i class="fa-solid fa-syringe fa-3x" style="color: #00838F"></i>
                    </div>
                    <p class="service-text" style="color: #37474F">Vaccinatione Service</p>
                    <p class="service-desc" style="color: #607D8B">Protect your pets with essential and up-to-date vaccinations.</p> 
                </div>

                <div class="service-box"> 
                    <div class="medical-service">
                        <i class="fa-solid fa-suitcase-medical fa-3x" style="color: #00838F"></i>
                    </div>
                    <p class="service-text" style="color: #37474F">Medical Service</p>
                    <p class="service-desc" style="color: #607D8B">Safe and professional medical treatments for your pet’s well-being.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="fourth-section">
        <div class="container d-flex flex-column justify-content-center align-items-center text-center">
            <h1 class="fade-slide">What we offer</h1>
        </div>
    </section>
<script src="script.js"></script>
</body>
</html>