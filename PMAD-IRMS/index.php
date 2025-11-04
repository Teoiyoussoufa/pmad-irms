<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require_once 'includes/db.php';

// Fetch companies for homepage
$companies = [];
$sql = "SELECT c.*, u.email FROM companies c JOIN users u ON c.user_id = u.id ORDER BY c.company_name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>PMAD-IRMS - Investment Management System</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="img/irms.jpg">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
        <div class="container-fluid topbar px-0 d-none d-lg-block">
            <div class="container px-0">
                <div class="row gx-0 align-items-center" style="height: 45px;">
                    <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                        <div class="d-flex flex-wrap">
                            <a href="#" class="text-muted me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                            <a href="#" class="text-muted me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+237 2234567890</a>
                            <a href="#" class="text-muted me-0"><i class="fas fa-envelope text-primary me-2"></i>pmadirms@gmail.com</a>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end">
                        <div class="d-flex align-items-center justify-content-end">
                            <a href="#" class="btn btn-primary btn-square rounded-circle nav-fill me-3"><i class="fab fa-facebook-f text-white"></i></a>
                            <a href="#" class="btn btn-primary btn-square rounded-circle nav-fill me-3"><i class="fab fa-twitter text-white"></i></a>
                            <a href="#" class="btn btn-primary btn-square rounded-circle nav-fill me-3"><i class="fab fa-instagram text-white"></i></a>
                            <a href="#" class="btn btn-primary btn-square rounded-circle nav-fill me-0"><i class="fab fa-linkedin-in text-white"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->


        <!-- Navbar & Hero Start -->
        <?php include 'navbar.php'; ?>
        <!-- Navbar & Hero End -->

        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h4 class="modal-title mb-0" id="exampleModalLabel">Search by keyword</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->

        <!-- Carousel Start -->
        <style>
        .header-carousel .header-carousel-item img {
            max-height: 340px;
            width: 100%;
            object-fit: cover;
        }
        .carousel-caption-inner h1 {
            font-size: 2.2rem !important;
            line-height: 1.2;
            margin-bottom: 1rem !important;
        }
        .carousel-caption-inner p {
            font-size: 1.1rem !important;
            margin-bottom: 1.2rem !important;
        }
        .carousel-caption-inner .btn {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            padding-left: 22px !important;
            padding-right: 22px !important;
            font-size: 1rem !important;
            margin-bottom: 0.5rem !important;
        }
        .header-carousel .carousel-caption {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }
        </style>
        <div class="header-carousel owl-carousel">
            <div class="header-carousel-item">
                <div class="header-carousel-item-img-1">
                    <img src="img/africa-2.jpg" class="img-fluid w-100" alt="Image">
                </div>
                <div class="carousel-caption">
                    <div class="carousel-caption-inner text-start p-3">
                        <h1 class="display-4 text-capitalize text-white mb-2 fadeInUp animate__animated" data-animation="fadeInUp" data-delay="1.3s" style="animation-delay: 1.3s;">Empowering African Investment and Entrepreneurship</h1>
                        <p class="mb-3 fs-5 fadeInUp animate__animated" data-animation="fadeInUp" data-delay="1.5s" style="animation-delay: 1.5s;">Connecting investors and businesses across Africa to drive sustainable growth, innovation, and opportunity. Join PMAD-IRMS and be part of Africa’s economic transformation.</p>
                        <a class="btn btn-primary rounded-pill me-3 fadeInUp animate__animated" data-animation="fadeInUp" data-delay="1.5s" style="animation-delay: 1.7s;" href="register.php">Apply Now</a>
                        <a class="btn btn-dark rounded-pill fadeInUp animate__animated" data-animation="fadeInUp" data-delay="1.5s" style="animation-delay: 1.7s;" href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item mx-auto">
                <div class="header-carousel-item-img-2">
                    <img src="img/africa-1.jpg" class="img-fluid w-100" alt="Image">
                </div>
                <div class="carousel-caption">
                    <div class="carousel-caption-inner text-center p-3">
                        <h1 class="display-4 text-capitalize text-white mb-2">Africa’s Premier Investment Platform</h1>
                        <p class="mb-3 fs-5">Discover, invest, and grow with leading African companies and entrepreneurs. PMAD-IRMS is your gateway to impactful investments and business success across the continent.</p>
                        <a class="btn btn-primary rounded-pill me-3" href="register.php">Apply Now</a>
                        <a class="btn btn-dark rounded-pill" href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item">
                <div class="header-carousel-item-img-3">
                    <img src="img/africa-3.jpeg" class="img-fluid w-100" alt="Image">
                </div>
                <div class="carousel-caption">
                    <div class="carousel-caption-inner text-end p-3">
                        <h1 class="display-4 text-capitalize text-white mb-2">Investing in Africa’s Future</h1>
                        <p class="mb-3 fs-5">Join a vibrant community of investors and entrepreneurs building Africa’s next generation of businesses. PMAD-IRMS connects you to opportunities that matter.</p>
                        <a class="btn btn-primary rounded-pill me-3" href="register.php">Apply Now</a>
                        <a class="btn btn-dark rounded-pill" href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->


        <!-- Companies Start -->
        <div class="container-fluid service py-5" style="padding-left:0;padding-right:0;">
            <div class="py-5" style="width:100%;">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h4 class="text-primary">Our Companies</h4>
                    <h1 class="display-4">Explore Companies Available on the System</h1>
                </div>
                <style>
                    .companies-grid {
                        display: grid;
                        grid-template-columns: repeat(5, 1fr);
                        gap: 32px 20px;
                        width: 100vw;
                        padding-left: 2vw;
                        padding-right: 2vw;
                    }
                    @media (max-width: 1200px) {
                        .companies-grid { grid-template-columns: repeat(3, 1fr); }
                    }
                    @media (max-width: 900px) {
                        .companies-grid { grid-template-columns: repeat(2, 1fr); }
                    }
                    @media (max-width: 600px) {
                        .companies-grid { grid-template-columns: 1fr; }
                    }
                </style>
                <?php if (count($companies) === 0): ?>
                    <div class="alert alert-info">No companies registered yet.</div>
                <?php endif; ?>
                <div class="companies-grid">
                    <?php foreach ($companies as $company): ?>
                    <div class="company-home-card w-100 company-card-clickable" tabindex="0"
                        data-company='<?= json_encode([
                            "logo" => $company["logo"],
                            "company_name" => $company["company_name"],
                            "category" => $company["category"],
                            "country" => $company["country"],
                            "capital" => number_format($company["capital"], 0, ',', ' '),
                            "employees_range" => $company["employees_range"],
                            "description" => $company["description"],
                            "website" => $company["website"],
                            "email" => $company["email"]
                        ]) ?>'>
                        <?php if ($company['logo'] && file_exists($company['logo'])): ?>
                            <img src="<?= htmlspecialchars($company['logo']) ?>" class="company-home-img" alt="Logo">
                        <?php else: ?>
                            <img src="img/service-1.jpg" class="company-home-img" alt="No Logo">
                        <?php endif; ?>
                        <div class="company-home-content flex-grow-1">
                            <div class="h4 mb-2 d-inline-flex text-start" style="font-weight:bold; color:#1976d2;">
                                <i class="fas fa-building fa-2x me-2"></i> <?= htmlspecialchars($company['company_name']) ?>
                            </div>
                            <div class="mb-2"><span class="badge bg-primary">Category: <?= htmlspecialchars($company['category']) ?></span></div>
                            <div class="mb-2"><span class="badge bg-info text-dark">Country: <?= htmlspecialchars($company['country']) ?></span></div>
                            <div class="mb-2"><span class="badge bg-success">Capital: <?= number_format($company['capital'], 0, ',', ' ') ?> FCFA</span></div>
                            <div class="mb-2"><span class="badge bg-secondary">Employees: <?= htmlspecialchars($company['employees_range']) ?></span></div>
                            <p class="mb-3" style="min-height:60px;"> <?= nl2br(htmlspecialchars($company['description'])) ?> </p>
                            <?php if ($company['website']): ?>
                                <a class="btn btn-light rounded-pill py-2 px-4" href="<?= htmlspecialchars($company['website']) ?>" target="_blank">Visit Website</a>
                            <?php endif; ?>
                            <a class="btn btn-success rounded-pill py-2 px-4 mt-2" href="contact.php?company=<?= urlencode($company['company_name']) ?>">Contact</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Company Modal -->
                <div id="companyModal" class="company-modal-overlay" style="display:none;">
                    <div class="company-modal-content animate-zoom">
                        <span class="company-modal-close" id="companyModalClose">&times;</span>
                        <div id="companyModalBody"></div>
                    </div>
                </div>
                <style>
                .company-modal-overlay {
                    position: fixed;
                    top: 0; left: 0; right: 0; bottom: 0;
                    width: 100vw; height: 100vh;
                    background: rgba(0,0,0,0.55);
                    z-index: 9999;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .company-modal-content {
                    background: #fff;
                    border-radius: 18px;
                    max-width: 520px;
                    width: 95vw;
                    padding: 32px 24px 24px 24px;
                    box-shadow: 0 8px 32px #1976d2aa;
                    position: relative;
                    animation: zoomInModal 0.3s cubic-bezier(.4,2,.6,1) forwards;
                }
                @keyframes zoomInModal {
                    0% { transform: scale(0.7); opacity: 0; }
                    100% { transform: scale(1); opacity: 1; }
                }
                .company-modal-close {
                    position: absolute;
                    top: 12px; right: 18px;
                    font-size: 2rem;
                    color: #1976d2;
                    cursor: pointer;
                    font-weight: bold;
                    z-index: 2;
                }
                .company-modal-content img {
                    width: 90px; height: 90px;
                    object-fit: contain;
                    border-radius: 12px;
                    background: #f8f8f8;
                    border: 2px solid #42a5f5;
                    margin-bottom: 12px;
                }
                .company-modal-content h2 {
                    font-size: 1.5rem;
                    color: #1976d2;
                    font-weight: bold;
                    margin-bottom: 8px;
                }
                .company-modal-content .badge {
                    font-size: 1rem;
                    margin-right: 6px;
                }
                .company-modal-content .btn {
                    margin-top: 10px;
                }
                </style>
                <script>
                document.querySelectorAll('.company-card-clickable').forEach(function(card) {
                    card.addEventListener('click', function(e) {
                        // Always open the modal, even if a link or button is clicked
                        e.preventDefault();
                        try {
                            var data = JSON.parse(this.getAttribute('data-company'));
                        } catch (err) {
                            console.error('Invalid data-company JSON for card:', this, err);
                            alert('This company card is broken. Please contact the site administrator.');
                            return;
                        }
                        var html = '';
                        if (data.logo && data.logo !== '' && data.logo !== 'img/service-1.jpg') {
                            html += '<img src="'+data.logo+'" alt="Logo">';
                        } else {
                            html += '<img src="img/service-1.jpg" alt="No Logo">';
                        }
                        html += '<h2>'+data.company_name+'</h2>';
                        html += '<div class="mb-2"><span class="badge bg-primary">Category: '+data.category+'</span>';
                        html += '<span class="badge bg-info text-dark">Country: '+data.country+'</span>';
                        html += '<span class="badge bg-success">Capital: '+data.capital+' FCFA</span>';
                        html += '<span class="badge bg-secondary">Employees: '+data.employees_range+'</span></div>';
                        html += '<div class="mb-2"><b>Email:</b> '+data.email+'</div>';
                        if (data.website) {
                            html += '<div class="mb-2"><b>Website:</b> <a href="'+data.website+'" target="_blank" class="modal-website-link">'+data.website+'</a></div>';
                        }
                        html += '<div class="mb-2"><b>Description:</b><br>'+data.description+'</div>';
                        html += '<a class="btn btn-success rounded-pill py-2 px-4 mt-2 modal-contact-link" href="contact.php?company='+encodeURIComponent(data.company_name)+'">Contact</a>';
                        document.getElementById('companyModalBody').innerHTML = html;
                        document.getElementById('companyModal').style.display = 'flex';
                    });
                });
                // Allow navigation for links/buttons inside the modal only
                setTimeout(function() {
                    document.getElementById('companyModalBody').addEventListener('click', function(e) {
                        if (e.target.classList.contains('modal-contact-link') || e.target.classList.contains('modal-website-link')) {
                            e.stopPropagation();
                        }
                    });
                }, 100);
                document.getElementById('companyModalClose').onclick = function() {
                    document.getElementById('companyModal').style.display = 'none';
                };
                window.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') document.getElementById('companyModal').style.display = 'none';
                });
                document.getElementById('companyModal').addEventListener('click', function(e) {
                    if (e.target === this) this.style.display = 'none';
                });
                </script>
            </div>
        </div>
        <!-- Companies End -->

        <!-- About Start -->
        <div class="container-fluid about bg-light py-5">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 col-xl-5 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="about-img">
                            <img src="img/about-3.png" class="img-fluid w-100 rounded-top bg-white" alt="Image">
                            <img src="img/about-2.jpg" class="img-fluid w-100 rounded-bottom" alt="Image">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-7 wow fadeInRight" data-wow-delay="0.3s">
                        <h4 class="text-primary">About Us</h4>
                        <h1 class="display-5 mb-4">About PMAD-IRMS</h1>
                        <p class="text ps-4 mb-4">PMAD-IRMS is a leading platform dedicated to fostering investment and entrepreneurship throughout Africa. We connect visionary investors with high-potential companies, supporting economic development and job creation across the continent.</p>
                        <div class="row g-4 justify-content-between mb-5">
                            <div class="col-lg-6 col-xl-5">
                                <p class="text-dark"><i class="fas fa-check-circle text-primary me-1"></i> Strategy & Consulting</p>
                                <p class="text-dark mb-0"><i class="fas fa-check-circle text-primary me-1"></i> Business Process</p>
                            </div>
                            <div class="col-lg-6 col-xl-7">
                                <p class="text-dark"><i class="fas fa-check-circle text-primary me-1"></i> Marketing Rules</p>
                                <p class="text-dark mb-0"><i class="fas fa-check-circle text-primary me-1"></i> Partnerships</p>
                            </div>
                        </div>
                        <div class="row g-4 justify-content-between mb-5">
                            <div class="col-xl-5"><a href="#" class="btn btn-primary rounded-pill py-3 px-5">Discover More</a></div>
                            <div class="col-xl-7 mb-5">
                                <div class="about-customer d-flex position-relative">
                                    <img src="img/customer-img-1.jpg" class="img-fluid btn-xl-square position-absolute" style="left: 0; top: 0;"  alt="Image">
                                    <img src="img/customer-img-2.jpg" class="img-fluid btn-xl-square position-absolute" style="left: 45px; top: 0;" alt="Image">
                                    <img src="img/customer-img-3.jpg" class="img-fluid btn-xl-square position-absolute" style="left: 90px; top: 0;" alt="Image">
                                    <img src="img/customer-img-1.jpg" class="img-fluid btn-xl-square position-absolute" style="left: 135px; top: 0;" alt="Image">
                                    <div class="position-absolute text-dark" style="left: 220px; top: 10px;">
                                        <p class="mb-0">5m+ Trusted</p>
                                        <p class="mb-0">Global Customers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center">
                            <div class="col-sm-4">
                                <div class="bg-primary rounded p-4">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="counter-value fs-1 fw-bold text-dark" data-toggle="counter-up">32</span>
                                        <h4 class="text-dark fs-1 mb-0" style="font-weight: 600; font-size: 25px;">k+</h4>
                                    </div>
                                    <div class="w-100 d-flex align-items-center justify-content-center">
                                        <p class="text-white mb-0">Project Complete</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bg-dark rounded p-4">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="counter-value fs-1 fw-bold text-white" data-toggle="counter-up">21</span>
                                        <h4 class="text-white fs-1 mb-0" style="font-weight: 600; font-size: 25px;">+</h4>
                                    </div>
                                    <div class="w-100 d-flex align-items-center justify-content-center">
                                        <p class="mb-0">Years Of Experience</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bg-primary rounded p-4">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="counter-value fs-1 fw-bold text-dark" data-toggle="counter-up">97</span>
                                        <h4 class="text-dark fs-1 mb-0" style="font-weight: 600; font-size: 25px;">+</h4>
                                    </div>
                                    <div class="w-100 d-flex align-items-center justify-content-center">
                                        <p class="text-white mb-0">Team Members</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Services Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h4 class="text-primary">Our Companies</h4>
                    <h1 class="display-4">Explore Companies Available on the System</h1>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php if (count($companies) === 0): ?>
                        <div class="col-12"><div class="alert alert-info">No companies registered yet.</div></div>
                    <?php endif; ?>
                    <style>
                        .company-home-card {
                            min-height: 420px;
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                            box-shadow: 0 2px 8px #eee;
                            border-radius: 16px;
                            background: #fff;
                            border-top: 5px solid #42a5f5;
                            transition: box-shadow 0.2s, transform 0.2s;
                            margin-bottom: 24px;
                        }
                        .company-home-card:hover {
                            box-shadow: 0 8px 24px #b3e5fc;
                            transform: translateY(-4px) scale(1.02);
                        }
                        .company-home-img {
                            width: 100%;
                            height: 180px;
                            object-fit: contain;
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                            background: #f8f8f8;
                            border-bottom: 1px solid #e0e0e0;
                        }
                        .company-home-content {
                            padding: 18px 12px 12px 12px;
                        }
                        @media (max-width: 991px) {
                            .company-home-card { min-height: 440px; }
                        }
                        @media (max-width: 767px) {
                            .company-home-card { min-height: 380px; }
                        }
                    </style>
                    <?php foreach ($companies as $i => $company): ?>
                    <div class="col-lg-4 col-md-6 col-12 d-flex align-items-stretch">
                        <div class="company-home-card w-100">
                            <?php if ($company['logo'] && file_exists($company['logo'])): ?>
                                <img src="<?= htmlspecialchars($company['logo']) ?>" class="company-home-img" alt="Logo">
                            <?php else: ?>
                                <img src="img/service-1.jpg" class="company-home-img" alt="No Logo">
                            <?php endif; ?>
                            <div class="company-home-content flex-grow-1">
                                <div class="h4 mb-2 d-inline-flex text-start" style="font-weight:bold; color:#1976d2;">
                                    <i class="fas fa-building fa-2x me-2"></i> <?= htmlspecialchars($company['company_name']) ?>
                                </div>
                                <div class="mb-2"><span class="badge bg-primary">Category: <?= htmlspecialchars($company['category']) ?></span></div>
                                <div class="mb-2"><span class="badge bg-info text-dark">Country: <?= htmlspecialchars($company['country']) ?></span></div>
                                <div class="mb-2"><span class="badge bg-success">Capital: <?= number_format($company['capital'], 0, ',', ' ') ?> FCFA</span></div>
                                <div class="mb-2"><span class="badge bg-secondary">Employees: <?= htmlspecialchars($company['employees_range']) ?></span></div>
                                <p class="mb-3" style="min-height:60px;"> <?= nl2br(htmlspecialchars($company['description'])) ?> </p>
                                <?php if ($company['website']): ?>
                                    <a class="btn btn-light rounded-pill py-2 px-4" href="<?= htmlspecialchars($company['website']) ?>" target="_blank">Visit Website</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Services End -->


        <!-- Project Start -->
        <div class="container-fluid project">
            <div class="container">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h4 class="text-primary">Our Projects</h4>
                    <h1 class="display-4">Explore Our Latest Projects</h1>
                </div>
                <div class="project-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                    <div class="project-item h-100 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="project-img">
                            <img src="img/projects-1.jpg" class="img-fluid w-100 rounded" alt="Image">
                        </div>
                        <div class="project-content bg-light rounded p-4">
                            <div class="project-content-inner">
                                <div class="project-icon mb-3"><i class="fas fa-chart-line fa-4x text-primary"></i></div>
                                <p class="text-dark fs-5 mb-3">Business Growth</p>
                                <a href="#" class="h4">Business Strategy And Investment Planning Growth Consulting</a>
                                <div class="pt-4">
                                    <a class="btn btn-light rounded-pill py-3 px-5" href="#">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-item h-100 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="project-img">
                            <img src="img/projects-1.jpg" class="img-fluid w-100 rounded" alt="Image">
                        </div>
                        <div class="project-content bg-light rounded p-4">
                            <div class="project-content-inner">
                                <div class="project-icon mb-3"><i class="fas fa-signal fa-4x text-primary"></i></div>
                                <p class="text-dark fs-5 mb-3">Marketing Strategy</p>
                                <a href="#" class="h4">Product Sailing Marketing Strategy For Improve Business</a>
                                <div class="pt-4">
                                    <a class="btn btn-light rounded-pill py-3 px-5" href="#">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-item h-100">
                        <div class="project-img">
                            <img src="img/projects-1.jpg" class="img-fluid w-100 rounded" alt="Image">
                        </div>
                        <div class="project-content bg-light rounded p-4">
                            <div class="project-content-inner">
                                <div class="project-icon mb-3"><i class="fas fa-signal fa-4x text-primary"></i></div>
                                <p class="text-dark fs-5 mb-3">Marketing Strategy</p>
                                <a href="#" class="h4">Product Sailing Marketing Strategy For Improve Business</a>
                                <div class="pt-4">
                                    <a class="btn btn-light rounded-pill py-3 px-5" href="#">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Project End -->


        <!-- Team Start -->
        <!-- <div class="container-fluid team pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                    <h4 class="text-primary">Our Team</h4>
                    <h1 class="display-4">Our PMAD IRMS Company Dedicated Team Member</h1>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item rounded">
                            <div class="team-img">
                                <img src="img/team-1.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fas fa-share-alt"></i></a>
                                    <div class="team-icon-share">
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-twitter"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-0" href=""><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="team-content bg-dark text-center rounded-bottom p-4">
                                <div class="team-content-inner rounded-bottom">
                                    <h4 class="text-white">Mark D. Brock</h4>
                                    <p class="text-muted mb-0">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item rounded">
                            <div class="team-img">
                                <img src="img/team-2.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fas fa-share-alt"></i></a>
                                    <div class="team-icon-share">
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-twitter"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-0" href=""><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="team-content bg-dark text-center rounded-bottom p-4">
                                <div class="team-content-inner rounded-bottom">
                                    <h4 class="text-white">Mark D. Brock</h4>
                                    <p class="text-muted mb-0">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item rounded">
                            <div class="team-img">
                                <img src="img/team-3.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fas fa-share-alt"></i></a>
                                    <div class="team-icon-share">
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-twitter"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-0" href=""><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="team-content bg-dark text-center rounded-bottom p-4">
                                <div class="team-content-inner rounded-bottom">
                                    <h4 class="text-white">Mark D. Brock</h4>
                                    <p class="text-muted mb-0">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-item rounded">
                            <div class="team-img">
                                <img src="img/team-4.jpg" class="img-fluid w-100 rounded-top" alt="Image">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fas fa-share-alt"></i></a>
                                    <div class="team-icon-share">
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-3" href=""><i class="fab fa-twitter"></i></a>
                                        <a class="btn btn-primary btn-sm-square text-white rounded-circle mb-0" href=""><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="team-content bg-dark text-center rounded-bottom p-4">
                                <div class="team-content-inner rounded-bottom">
                                    <h4 class="text-white">Mark D. Brock</h4>
                                    <p class="text-muted mb-0">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Team End -->


        <!-- Testimonial Start -->
        <!-- <div class="container-fluid testimonial bg-light py-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-xl-4 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="h-100 rounded">
                            <h4 class="text-primary">Our Feedbacks </h4>
                            <h1 class="display-4 mb-4">Clients are Talking</h1>
                            <p class="mb-4">Our partners and clients share their experiences of growth, collaboration, and success through PMAD-IRMS. See how our platform is making a difference in Africa’s investment landscape.</p>
                            <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Read All Reviews <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="testimonial-carousel owl-carousel wow fadeInUp" data-wow-delay="0.1s">
                            <div class="testimonial-item bg-white rounded p-4 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="d-flex">
                                    <div><i class="fas fa-quote-left fa-3x text-dark me-3"></i></div>
                                    <p class="mt-4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magnam eos impedit eveniet dolorem culpa ullam incidunt vero quo recusandae nemo? Molestiae doloribus iure,
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="my-auto text-end">
                                        <h5>Person Name</h5>
                                        <p class="mb-0">Profession</p>
                                    </div>
                                    <div class="bg-white rounded-circle ms-3">
                                        <img src="img/testimonial-1.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border: 1px solid; border-color: var(--bs-primary);" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item bg-white rounded p-4 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="d-flex">
                                    <div><i class="fas fa-quote-left fa-3x text-dark me-3"></i></div>
                                    <p class="mt-4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magnam eos impedit eveniet dolorem culpa ullam incidunt vero quo recusandae nemo? Molestiae doloribus iure,
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="my-auto text-end">
                                        <h5>Person Name</h5>
                                        <p class="mb-0">Profession</p>
                                    </div>
                                    <div class="bg-white rounded-circle ms-3">
                                        <img src="img/testimonial-2.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border: 1px solid; border-color: var(--bs-primary);" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item bg-white rounded p-4 wow fadeInUp" data-wow-delay="0.7s">
                                <div class="d-flex">
                                    <div><i class="fas fa-quote-left fa-3x text-dark me-3"></i></div>
                                    <p class="mt-4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magnam eos impedit eveniet dolorem culpa ullam incidunt vero quo recusandae nemo? Molestiae doloribus iure,
                                    </p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="my-auto text-end">
                                        <h5>Person Name</h5>
                                        <p class="mb-0">Profession</p>
                                    </div>
                                    <div class="bg-white rounded-circle ms-3">
                                        <img src="img/testimonial-3.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border: 1px solid; border-color: var(--bs-primary);" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Testimonial End -->


        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <div class="footer-item">
                                <h4 class="text-white mb-4">Newsletter</h4>
                                <p class="mb-3">Stay up to date with the latest investment opportunities, platform news, and success stories from across Africa. Subscribe to our newsletter!</p>
                                <div class="position-relative mx-auto rounded-pill">
                                    <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                                    <button type="button" class="btn btn-primary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2">SignUp</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Explore</h4>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Home</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Services</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> About Us</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Latest Projects</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> testimonial</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Our Team</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Contact Info</h4>
                            <a href=""><i class="fa fa-map-marker-alt me-2"></i> Yaoundé, Cameroon</a>
                            <a href=""><i class="fas fa-envelope me-2"></i> pmadirms@gmail.com</a>
                            <a href=""><i class="fas fa-phone me-2"></i> +237 2234567890</a>
                            <a href="" class="mb-3"><i class="fas fa-print me-2"></i> +012 345 67890</a>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-light btn-md-square me-2" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-light btn-md-square me-2" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-light btn-md-square me-2" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-light btn-md-square me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item-post d-flex flex-column">
                            <h4 class="text-white mb-4">Popular Post</h4>
                            <div class="d-flex flex-column mb-3">
                                <p class="text-uppercase text-primary mb-2">Investment</p>
                                <a href="#" class="text-body">Revisiting Your Investment & Distribution Goals</a>
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <p class="text-uppercase text-primary mb-2">Business</p>
                                <a href="#" class="text-body">Dimensional Fund Advisors Interview with Director</a>
                            </div>
                            <div class="footer-btn text-start">
                                <a href="#" class="btn btn-light rounded-pill px-4">View All Post <i class="fa fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        
        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#" class="border-bottom text-primary"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-body">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom text-primary" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>