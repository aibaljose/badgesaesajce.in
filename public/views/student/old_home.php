
 <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

      <link rel="stylesheet" href="/public/assets/css/studenthome.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<script>
      const user = <?php echo json_encode($_SESSION['auth_user']); ?>;

    console.log(user)
    </script>
    
    
<div class="main-content">
    <!--<div class="container mobile-container">-->
        <!-- Badge Status Overview -->
    <!--    <div class="badge-overview">-->
    <!--        <div class="stats-cards">-->
    <!--            <div class="stat-card approved">-->
    <!--                <i class="fas fa-check-circle"></i>-->
    <!--                <div class="stat-info">-->
    <!--                    <h3>12</h3>-->
    <!--                    <p>Approved Certificates</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="stat-card pending">-->
    <!--                <i class="fas fa-clock"></i>-->
    <!--                <div class="stat-info">-->
    <!--                    <h3>5</h3>-->
    <!--                    <p>Pending Review</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="stat-card rejected">-->
    <!--                <i class="fas fa-times-circle"></i>-->
    <!--                <div class="stat-info">-->
    <!--                    <h3>2</h3>-->
    <!--                    <p>Rejected</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="stat-card reverted">-->
    <!--                <i class="fas fa-undo"></i>-->
    <!--                <div class="stat-info">-->
    <!--                    <h3>3</h3>-->
    <!--                    <p>Reverted Certificates</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->



 <section class="dashboard-section" aria-labelledby="stats-title">
                <h2 id="stats-title" class="section-title">Your Progress</h2>
                <div class="stats-grid">
                    <a href="/certificates/approved" class="stat-card approved">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-info">
                            <span class="stat-number">12</span>
                            <span class="stat-label">Approved</span>
                        </div>
                    </a>
                    <a href="/certificates/pending" class="stat-card pending">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-info">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Pending Review</span>
                        </div>
                    </a>
                    <a href="/certificates/rejected" class="stat-card rejected">
                        <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                        <div class="stat-info">
                            <span class="stat-number">2</span>
                            <span class="stat-label">Rejected</span>
                        </div>
                    </a>
                    <a href="/certificates/reverted" class="stat-card reverted">
                        <div class="stat-icon"><i class="fas fa-undo"></i></div>
                        <div class="stat-info">
                            <span class="stat-number">3</span>
                            <span class="stat-label">Reverted</span>
                        </div>
                    </a>
                </div>
            </section>
       

        <!-- Badge Categories -->
        <div class="section">
            <h2 class="mobile-section-title">Badge Categories</h2>
            <div class="category-grid">
                <div class="category-card">
                    <i class="fas fa-laptop-code"></i>
                    <h3>Technical Skills</h3>
                    <p>15 Badges Available</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-users"></i>
                    <h3>Soft Skills</h3>
                    <p>8 Badges Available</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-certificate"></i>
                    <h3>Certifications</h3>
                    <p>12 Badges Available</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-trophy"></i>
                    <h3>Achievements</h3>
                    <p>10 Badges Available</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    
</style>

