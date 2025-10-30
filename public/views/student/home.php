 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="/public/assets/js/student/home.js"></script>
<style>
    html{
        text-decoration: none;
    }
</style>
<main class="main-content">
    <a href="/upload_certificate">
<button type="button" 
        class="btn btn-primary rounded-circle shadow" 
        data-bs-toggle="tooltip" 
        data-bs-placement="left" 
        title="Upload Certificate"
        style="position: fixed; bottom: 80px; right: 20px; width: 60px; height: 60px; z-index: 1000;">
    <i class="fas fa-cloud-upload-alt"></i>
</button></a>

<script>  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });</script>


<div id="main-content" class="transition-all duration-300 ease-in-out  ">
    <main class="p-4 md:p-8 mt-[90px] ms-lg-64 px-3 py-4">
        <div class="max-w-7xl mx-auto">
            <!--<header class="pb-6 border-b border-slate-200">-->
            <!--    <h1 class="text-3xl md:text-4xl font-bold text-slate-800">Badges AES</h1>-->
            <!--    <p class="mt-2 text-base text-slate-500">Welcome back! Here's a summary of your progress. 🚀</p>-->
            <!--</header>-->

<style>
        .congratulations-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }
        
        .congratulations-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        
        .progress-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .progress-item {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background-color 0.2s ease;
        }
        
        .progress-item:hover {
            background-color: #f8f9fa;
        }
        
        .badge-category-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        
        .badge-category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            text-decoration: none;
            color: inherit;
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
    </style>

<div class="row ">
<div class="container ">
  <div class="shadow rounded-4 d-flex align-items-center justify-content-between p-3 gap-3 flex-nowrap"
       style="background: linear-gradient(135deg, #4e54c8, #8f94fb); color: white; overflow-x: auto;">

    <!-- Left: Trophy + Message -->
    <div class="d-flex align-items-center gap-3 flex-grow-1">
      <!--<img src="https://img.icons8.com/fluency/48/trophy.png" alt="Trophy" style="flex-shrink: 0;">-->
      <div>
        <h6 class="fw-bold mb-2 mb-md-1">welcome,  <?php echo ucwords(strtolower(str_replace('_', ' ', $authUser['u-name'])));
 ?></h6>
        <p class="mb-0 text-light small">
        Here are all the badges available for you.<br class="d-none d-md-block">
   
        </p>
      </div>
    </div>

    <!-- Right: Points Box -->
    <div class=" text-white text-center  px-3 py-2" style="min-width: 120px; flex-shrink: 0;">
      <div class="fw-bold fs-8"><h1>95</h1></div>
      <div class="small text-white">Badges</div>
    </div>
  </div>
</div>



            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Total Badges</p>
                                    <h3 class="fw-bold mb-0" id="total-badges">4</h3>
                                    <small class="text-success"><i ></i> Earned badges</small>
                                </div>
                                <div class="icon-circle bg-primary  text-white">
                                    <i class="fas fa-medal"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1" >Pending</p>
                                    <h3 class="fw-bold mb-0" id="pending-count">0</h3>
                                    <small class="text-success"><i class=""></i> Pending certficates</small>
                                </div>
                                <div class="icon-circle bg-success bg-warning text-white">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="col-xl-3 col-md-6">
                    <div class="stats-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Rejected</p>
                                    <h3 class="fw-bold mb-0"id="rejected-count">12</h3>
                                    <small class="text-success"><i class=""></i> Rejected certficates</small>
                                </div>
                                <div class="icon-circle bg-success  bg-danger  text-white">
                                    <i class="fas fa-undo"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-xl-3 col-md-6">
                    <div class="stats-card card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Reverted</p>
                                    <h3 class="fw-bold mb-0" id="reverted-count">12</h3>
                                    <small class="text-success"><i class=""></i>Reverted certficates</small>
                                </div>
                                <div class="icon-circle bg-success bg-info text-white">
                                    <i class="fas fa-undo"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        

<!--<section class="py-4" aria-labelledby="stats-title">-->
<!--   <h2 id="stats-title" class="h4 fw-bold mb-4">Your Progress</h2>-->
<!--   <div class="row g-3">-->
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="view_certificates/?status=approved" class="card h-100 border text-decoration-none">-->
<!--               <div class="card-body shadow">-->
<!--                   <div class="d-flex align-items-center mb-3">-->
<!--                       <div class="bg-success rounded p-2 me-3">-->
<!--                           <i class="fas fa-check-circle text-white"></i>-->
<!--                       </div>-->
<!--                       <div>-->
<!--                           <h4 id="approved-count" class="fw-bold mb-0 text-dark">0</h4>-->
<!--                           <small class="text-muted">Approved</small>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <div class="d-flex justify-content-between align-items-center">-->
<!--                       <span class="text-muted small">View details</span>-->
<!--                       <i class="fas fa-arrow-right text-muted small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
       
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="view_certificates/?status=pending" class="card h-100 border text-decoration-none">-->
<!--               <div class="card-body shadow">-->
<!--                   <div class="d-flex align-items-center mb-3">-->
<!--                       <div class="bg-warning rounded p-2 me-3">-->
<!--                           <i class="fas fa-clock text-white"></i>-->
<!--                       </div>-->
<!--                       <div>-->
<!--                           <h4 id="pending-count" class="fw-bold mb-0 text-dark">0</h4>-->
<!--                           <small class="text-muted">Pending Review</small>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <div class="d-flex justify-content-between align-items-center">-->
<!--                       <span class="text-muted small">View details</span>-->
<!--                       <i class="fas fa-arrow-right text-muted small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
       
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="view_certificates/?status=rejected" class="card h-100 border text-decoration-none">-->
<!--               <div class="card-body shadow">-->
<!--                   <div class="d-flex align-items-center mb-3">-->
<!--                       <div class="bg-danger rounded p-2 me-3">-->
<!--                           <i class="fas fa-times-circle text-white"></i>-->
<!--                       </div>-->
<!--                       <div>-->
<!--                           <h4 id="rejected-count" class="fw-bold mb-0 text-dark">0</h4>-->
<!--                           <small class="text-muted">Rejected</small>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <div class="d-flex justify-content-between align-items-center">-->
<!--                       <span class="text-muted small">View details</span>-->
<!--                       <i class="fas fa-arrow-right text-muted small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
       
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="view_certificates/?status=reverted" class="card h-100 border text-decoration-none">-->
<!--               <div class="card-body shadow">-->
<!--                   <div class="d-flex align-items-center mb-3">-->
<!--                       <div class="bg-info rounded p-2 me-3">-->
<!--                           <i class="fas fa-undo text-white"></i>-->
<!--                       </div>-->
<!--                       <div>-->
<!--                           <h4 id="reverted-count" class="fw-bold mb-0 text-dark">0</h4>-->
<!--                           <small class="text-muted">Reverted</small>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <div class="d-flex justify-content-between align-items-center">-->
<!--                       <span class="text-muted small">View details</span>-->
<!--                       <i class="fas fa-arrow-right text-muted small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
<!--   </div>-->
<!--</section>-->








            <!--<section class="dashboard-section" aria-labelledby="stats-title">-->
            <!--    <h2 id="stats-title" class="section-title">Your Progress</h2>-->
            <!--    <div class="stats-grid">-->
            <!--        <a href="view_certificates/?status=approved" class="stat-card approved">-->
            <!--            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>-->
            <!--            <div class="stat-info">-->
            <!--                <span class="stat-number">12</span>-->
            <!--                <span class="stat-label">Approved</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--        <a href="view_certificates/?status=pending" class="stat-card pending">-->
            <!--            <div class="stat-icon"><i class="fas fa-clock"></i></div>-->
            <!--            <div class="stat-info">-->
            <!--                <span class="stat-number">5</span>-->
            <!--                <span class="stat-label">Pending Review</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--        <a href="view_certificates/?status=rejected" class="stat-card rejected">-->
            <!--            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>-->
            <!--            <div class="stat-info">-->
            <!--                <span class="stat-number">2</span>-->
            <!--                <span class="stat-label">Rejected</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--        <a href="view_certificates/?status=reverted" class="stat-card reverted">-->
            <!--            <div class="stat-icon"><i class="fas fa-undo"></i></div>-->
            <!--            <div class="stat-info">-->
            <!--                <span class="stat-number">3</span>-->
            <!--                <span class="stat-label">Reverted</span>-->
            <!--            </div>-->
            <!--        </a>-->
            <!--    </div>-->
            <!--</section>-->
            
            
            <!-- <section class="dashboard-section" aria-labelledby="categories-title">-->
            <!--    <h2 id="categories-title" class="section-title">Explore Badge Categories</h2>-->
            <!--    <div class="category-grid">-->
            <!--        <a href="/badges/technical" class="category-card">-->
            <!--            <i class="fas fa-laptop-code category-icon"></i>-->
            <!--            <h3>Technical Skills</h3>-->
            <!--            <p>15 Badges Available</p>-->
            <!--            <span class="arrow-indicator">&rarr;</span>-->
            <!--        </a>-->
            <!--        <a href="/badges/soft-skills" class="category-card">-->
            <!--            <i class="fas fa-users category-icon"></i>-->
            <!--            <h3>Soft Skills</h3>-->
            <!--            <p>8 Badges Available</p>-->
            <!--            <span class="arrow-indicator">&rarr;</span>-->
            <!--        </a>-->
            <!--        <a href="/badges/certifications" class="category-card">-->
            <!--            <i class="fas fa-certificate category-icon"></i>-->
            <!--            <h3>Certifications</h3>-->
            <!--            <p>12 Badges Available</p>-->
            <!--            <span class="arrow-indicator">&rarr;</span>-->
            <!--        </a>-->
            <!--        <a href="/badges/achievements" class="category-card">-->
            <!--            <i class="fas fa-trophy category-icon"></i>-->
            <!--            <h3>Achievements</h3>-->
            <!--            <p>10 Badges Available</p>-->
            <!--            <span class="arrow-indicator">&rarr;</span>-->
            <!--        </a>-->
            <!--    </div>-->
            <!--</section>-->
            
            
            
            
            
            
<!--            <section class="py-4" aria-labelledby="categories-title">-->
                
                
                
<!--   <h2 id="categories-title" class="h4 fw-bold mb-4">Explore Badge Categories</h2>-->
<!--   <div class="row g-4">-->
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="/badges/technical" class="card h-100 border-0 shadow-sm text-decoration-none">-->
<!--               <div class="card-body text-center p-4">-->
<!--                   <div class="mb-3">-->
<!--                       <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">-->
<!--                           <i class="fas fa-laptop-code text-primary fs-4"></i>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <h5 class="card-title fw-bold text-dark mb-2">Technical Skills</h5>-->
<!--                   <p class="card-text text-muted mb-3">15 Badges Available</p>-->
<!--                   <div class="d-flex justify-content-center align-items-center">-->
<!--                       <span class="text-primary small fw-medium me-2">Explore</span>-->
<!--                       <i class="fas fa-arrow-right text-primary small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
       
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="/badges/soft-skills" class="card h-100 border-0 shadow-sm text-decoration-none">-->
<!--               <div class="card-body text-center p-4">-->
<!--                   <div class="mb-3">-->
<!--                       <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">-->
<!--                           <i class="fas fa-users text-success fs-4"></i>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <h5 class="card-title fw-bold text-dark mb-2">Soft Skills</h5>-->
<!--                   <p class="card-text text-muted mb-3">8 Badges Available</p>-->
<!--                   <div class="d-flex justify-content-center align-items-center">-->
<!--                       <span class="text-success small fw-medium me-2">Explore</span>-->
<!--                       <i class="fas fa-arrow-right text-success small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
       
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="/badges/certifications" class="card h-100 border-0 shadow-sm text-decoration-none">-->
<!--               <div class="card-body text-center p-4">-->
<!--                   <div class="mb-3">-->
<!--                       <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">-->
<!--                           <i class="fas fa-certificate text-warning fs-4"></i>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <h5 class="card-title fw-bold text-dark mb-2">Certifications</h5>-->
<!--                   <p class="card-text text-muted mb-3">12 Badges Available</p>-->
<!--                   <div class="d-flex justify-content-center align-items-center">-->
<!--                       <span class="text-warning small fw-medium me-2">Explore</span>-->
<!--                       <i class="fas fa-arrow-right text-warning small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
       
<!--       <div class="col-lg-3 col-md-6">-->
<!--           <a href="/badges/achievements" class="card h-100 border-0 shadow-sm text-decoration-none">-->
<!--               <div class="card-body text-center p-4">-->
<!--                   <div class="mb-3">-->
<!--                       <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">-->
<!--                           <i class="fas fa-trophy text-info fs-4"></i>-->
<!--                       </div>-->
<!--                   </div>-->
<!--                   <h5 class="card-title fw-bold text-dark mb-2">Achievements</h5>-->
<!--                   <p class="card-text text-muted mb-3">10 Badges Available</p>-->
<!--                   <div class="d-flex justify-content-center align-items-center">-->
<!--                       <span class="text-info small fw-medium me-2">Explore</span>-->
<!--                       <i class="fas fa-arrow-right text-info small"></i>-->
<!--                   </div>-->
<!--               </div>-->
<!--           </a>-->
<!--       </div>-->
<!--   </div>-->
<!--</section>-->
            
           
           
<section class="py-4" aria-labelledby="categories-title">
    <h2 id="categories-title" class="h4 fw-bold mb-4">Explore Badge Categories</h2>
    <div class="row g-4" id="badge-category-container">
        <!-- Cards will be injected here by JS -->
    </div>
    <div class="text-center mt-4">
        <button id="show-more-btn" class="btn btn-outline-primary d-none">Show More</button>
    </div>
</section>
 
            
            
            
            
            
            
            
            
            
            
            
        </div>
    </main>