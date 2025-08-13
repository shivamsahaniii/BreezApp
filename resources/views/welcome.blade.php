<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Pro</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/homePage/style.css'])
</head>
<body>
    <!-- Fixed Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <!-- Logo -->
                <a href="/" class="navbar-brand">
                    <i class="bi bi-building"></i>
                    CRM Pro
                </a>
                
                <!-- Navigation Buttons -->
                <div class="d-flex align-items-center">
                    <a href="{{route('login')}}" class="btn-login">Login</a>
                    <a href="{{route('register')}}" class="btn-register">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <!-- <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="hero-title">Simplify Your CRM</h1>
                    <p class="hero-subtitle">
                        All your Accounts, Contacts, and Leads in one place.
                    </p>
                    <a href="#features" class="btn-hero">
                        Get Started
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Features Section -->
    <section id="features" class="features-section pb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title mt-4">Everything You Need</h2>
                    <p class="section-subtitle mb-4">
                        Streamline your sales process with our comprehensive CRM features designed for modern businesses.
                    </p>
                </div>
            </div>
            
            <div class="row">
                <!-- Accounts Feature -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="feature-title">Accounts</h3>
                        <p class="feature-description">
                            Manage companies and organization profiles with comprehensive business intelligence and relationship tracking.
                        </p>
                    </div>
                </div>
                
                <!-- Contacts Feature -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="feature-title">Contacts</h3>
                        <p class="feature-description">
                            Manage people related to those companies with detailed contact information and communication history.
                        </p>
                    </div>
                </div>
                
                <!-- Leads Feature -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h3 class="feature-title">Leads</h3>
                        <p class="feature-description">
                            Capture and convert potential clients with advanced lead scoring and automated nurturing workflows.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 CRM Pro. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>