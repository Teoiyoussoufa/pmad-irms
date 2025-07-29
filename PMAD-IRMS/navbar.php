<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Fetch companies for search modal (only if not already fetched)
if (!isset($companiesForSearch)) {
    $companiesForSearch = [];
    if (file_exists('includes/db.php')) {
        require_once 'includes/db.php';
        $sql = "SELECT id, company_name, category, country, logo, description, employees_range, capital, website, user_id, (SELECT email FROM users WHERE id = companies.user_id) as email FROM companies ORDER BY company_name ASC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $companiesForSearch[] = $row;
            }
        }
    }
}
?>
<!-- Navbar & Hero Start -->
<div class="container-fluid sticky-top px-0">
    <div class="position-absolute bg-dark" style="left: 0; top: 0; width: 100%; height: 100%;"></div>
    <div class="container px-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-white py-3 px-4">
            <a href="index.php" class="navbar-brand p-0 d-flex align-items-center">
                <img src="img/irms.jpg" alt="IRMS Logo" style="height:48px;width:48px;object-fit:cover;border-radius:12px;margin-right:12px;box-shadow:0 2px 8px #aaa;background:#fff;">
                <h1 class="text-primary m-0" style="font-size:2rem;line-height:1.1;">PMAD-IRMS</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link" style="font-weight:bold;">Home</a>
                    <a href="about.php" class="nav-item nav-link" style="font-weight:bold;">About</a>
                    <!-- <a href="service.php" class="nav-item nav-link" style="font-weight:bold;">Services</a> -->
                    <a href="admin.php" class="nav-item nav-link" style="font-weight:bold;">administrator</a>
                    <a href="companies.php" class="nav-item nav-link" style="font-weight:bold;">Companies</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="font-weight:bold;">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="blog.html" class="dropdown-item">Home</a>
                            <a href="about.php" class="dropdown-item">About</a>
                            <a href="companies.php" class="dropdown-item">Companies</a>
                            <a href="project.php" class="dropdown-item">Project</a>
                            <a href="admin.php" class="dropdown-item">Admin</a>
                        </div>
                    </div>
                    <a href="contact.php" class="nav-item nav-link" style="font-weight:bold;">Contact</a>
                </div>
                <div class="d-flex align-items-center flex-nowrap pt-xl-0">
                    <!-- <button class="btn btn-primary btn-md-square mx-2" id="openSearchModal" type="button"><i class="fas fa-search"></i></button> -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="btn btn-danger rounded-pill text-white py-2 px-4 ms-2 flex-wrap flex-sm-shrink-0">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary rounded-pill text-white py-2 px-4 ms-2 flex-wrap flex-sm-shrink-0">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar & Hero End -->

<!-- Search Modal -->
<style>
#searchCompanyModal .company-modal-content {
    max-width: 600px;
    width: 95vw;
    padding: 32px 24px 24px 24px;
    overflow-y: auto;
    max-height: 90vh;
}
#searchCompanyModal .company-modal-content input.form-control {
    font-size: 1.1rem;
    padding: 10px 14px;
}
#searchCompanyModal .company-modal-content h3 {
    font-size: 1.3rem;
    font-weight: bold;
    color: #1976d2;
}
</style>
<div id="searchCompanyModal" class="company-modal-overlay" style="display:none;">
    <div class="company-modal-content animate-zoom">
        <span class="company-modal-close" id="searchCompanyModalClose">&times;</span>
        <h3 class="mb-3">Search Companies</h3>
        <input type="text" id="companySearchInput" class="form-control mb-3" placeholder="Type company name, category, or country...">
        <div id="companySearchResults"></div>
    </div>
</div>
<script>
const companiesForSearch = <?= json_encode($companiesForSearch) ?>;
const openSearchModalBtn = document.getElementById('openSearchModal');
const searchModal = document.getElementById('searchCompanyModal');
const searchModalClose = document.getElementById('searchCompanyModalClose');
const searchInput = document.getElementById('companySearchInput');
const searchResults = document.getElementById('companySearchResults');

openSearchModalBtn.onclick = function() {
    searchModal.style.display = 'flex';
    searchInput.value = '';
    searchResults.innerHTML = '';
    setTimeout(() => searchInput.focus(), 100);
};
searchModalClose.onclick = function() {
    searchModal.style.display = 'none';
};
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') searchModal.style.display = 'none';
});
searchModal.addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
searchInput.oninput = function() {
    const q = this.value.trim().toLowerCase();
    if (!q) { searchResults.innerHTML = ''; return; }
    const matches = companiesForSearch.filter(c =>
        (c.company_name && c.company_name.toLowerCase().includes(q)) ||
        (c.category && c.category.toLowerCase().includes(q)) ||
        (c.country && c.country.toLowerCase().includes(q))
    );
    if (matches.length === 0) {
        searchResults.innerHTML = '<div class="alert alert-warning">No companies found.</div>';
        return;
    }
    searchResults.innerHTML = matches.map(c => `
        <div class='d-flex align-items-center border rounded p-2 mb-2 company-search-result' style='cursor:pointer;' data-company='${JSON.stringify(c)}'>
            <img src='${c.logo && c.logo !== '' ? c.logo : 'img/service-1.jpg'}' style='width:48px;height:48px;object-fit:contain;border-radius:8px;margin-right:12px;'>
            <div>
                <div style='font-weight:bold;color:#1976d2;'>${c.company_name}</div>
                <div><span class='badge bg-primary'>${c.category}</span> <span class='badge bg-info text-dark'>${c.country}</span></div>
            </div>
        </div>
    `).join('');
    document.querySelectorAll('.company-search-result').forEach(function(el) {
        el.onclick = function() {
            const data = JSON.parse(this.getAttribute('data-company'));
            if (!window.showCompanyModal) {
                alert('Company modal not available on this page.');
                return;
            }
            window.showCompanyModal(data);
            searchModal.style.display = 'none';
        };
    });
};
window.showCompanyModal = function(data) {
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
        html += '<div class="mb-2"><b>Website:</b> <a href="'+data.website+'" target="_blank">'+data.website+'</a></div>';
    }
    html += '<div class="mb-2"><b>Description:</b><br>'+data.description+'</div>';
    html += '<a class="btn btn-success rounded-pill py-2 px-4 mt-2" href="contact.php?company='+encodeURIComponent(data.company_name)+'">Contact</a>';
    var modal = document.getElementById('companyModal');
    var body = document.getElementById('companyModalBody');
    if (modal && body) {
        body.innerHTML = html;
        modal.style.display = 'flex';
    }
};
</script> 