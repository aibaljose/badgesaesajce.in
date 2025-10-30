 
 <script src="/public/assets/js/student/badges.js?v=<?= filemtime('badges.js') ?>"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 <!--<script src="badges.js?v=<?= filemtime('badges.js') ?>"></script>-->

 <main class="main-content">

<main class="container">
    
  <div class="container-fluid bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">Badges</h2>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-2"></i>
                            <span>Date (Newest First)</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item sort-option" href="#" data-sort="date-desc">Date (Newest First)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="date-asc">Date (Oldest First)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="name-asc">Name (A-Z)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="name-desc">Name (Z-A)</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 badge-categories-container">
                         <div class="text-center py-2">
                            <i class="fas fa-spinner fa-spin"></i> Loading categories...
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 badges-grid-container">
                <div class="col-12 text-center py-5">
                    <i class="fas fa-spinner fa-spin"></i> Loading badges...
                </div>
            </div>
        </div>
    </div>

    
    
    
 
 <!--<section class="py-5">-->
 <!--      <header class="mb-4">-->
 <!--       <h1 class="display-5 fw-bold text-dark">My Badges </h1>-->
 <!--       <p class="text-muted">A collection of all the badges I've earned.</p>-->
 <!--   </header>-->
 <!--       <div class="container">-->
            <!-- Row to hold the badge cards -->
 <!--           <div class="row justify-content-center">-->

                <!-- Green Badge Card -->
 <!--               <div class="col-xl-3 col-md-6 mb-4">-->
 <!--                   <div class="card h-100 border-0 shadow-sm rounded-4 card-badge">-->
                        <!-- Top border element for color accent -->
 <!--                       <div class="border-top border-5 border-success rounded-top-4"></div>-->
 <!--                       <div class="card-body text-center d-flex flex-column">-->
                            <!-- Icon container with relative positioning for the plus badge -->
 <!--                           <div class="position-relative d-inline-block mx-auto mb-4 mt-2">-->
                                <!-- The main shield/icon shape -->
 <!--                               <div class="d-flex align-items-center justify-content-center bg-success bg-gradient text-white rounded-4 shadow" style="width: 90px; height: 90px;">-->
 <!--                                   <div class="text-center">-->
 <!--                                       <div class="fs-2 fw-bold lh-1">5</div>-->
 <!--                                       <div class="fs-5">📚</div>-->
 <!--                                   </div>-->
 <!--                               </div>-->
                                <!-- The plus icon positioned on the corner -->
 <!--                               <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center text-success fw-bold" style="width: 28px; height: 28px;">+</div>-->
 <!--                           </div>-->
 <!--                           <h5 class="card-title fw-semibold fs-6">5 sets studied</h5>-->
 <!--                           <p class="card-text text-muted small mt-auto">Earned 1/23/2024</p>-->
 <!--                       </div>-->
 <!--                   </div>-->
 <!--               </div>-->

                <!-- Orange Badge Card -->
 <!--               <div class="col-xl-3 col-md-6 mb-4">-->
 <!--                   <div class="card h-100 border-0 shadow-sm rounded-4 card-badge">-->
 <!--                       <div class="border-top border-5 border-warning rounded-top-4"></div>-->
 <!--                       <div class="card-body text-center d-flex flex-column">-->
 <!--                           <div class="position-relative d-inline-block mx-auto mb-4 mt-2">-->
 <!--                               <div class="d-flex align-items-center justify-content-center bg-warning bg-gradient text-white rounded-4 shadow" style="width: 90px; height: 90px;">-->
 <!--                                   <div>-->
 <!--                                       <div class="fs-2 fw-bold lh-1">25</div>-->
 <!--                                       <div class="fs-5">🏆</div>-->
 <!--                                   </div>-->
 <!--                               </div>-->
 <!--                               <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center text-warning fw-bold" style="width: 28px; height: 28px;">+</div>-->
 <!--                           </div>-->
 <!--                           <h5 class="card-title fw-semibold fs-6">25 sets studied</h5>-->
 <!--                           <p class="card-text text-muted small mt-auto">Earned 1/20/2024</p>-->
 <!--                       </div>-->
 <!--                   </div>-->
 <!--               </div>-->

                <!-- Purple Badge Card -->
 <!--               <div class="col-xl-3 col-md-6 mb-4">-->
 <!--                   <div class="card h-100 border-0 shadow-sm rounded-4 card-badge">-->
 <!--                       <div class="border-top border-5 border-purple rounded-top-4"></div>-->
 <!--                       <div class="card-body text-center d-flex flex-column">-->
 <!--                           <div class="position-relative d-inline-block mx-auto mb-4 mt-2">-->
 <!--                               <div class="d-flex align-items-center justify-content-center bg-gradient-purple text-white rounded-4 shadow" style="width: 90px; height: 90px;">-->
 <!--                                   <div>-->
 <!--                                       <div class="fs-2 fw-bold lh-1">10</div>-->
 <!--                                       <div class="fs-5">⭐</div>-->
 <!--                                   </div>-->
 <!--                               </div>-->
 <!--                               <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center text-purple fw-bold" style="width: 28px; height: 28px;">+</div>-->
 <!--                           </div>-->
 <!--                           <h5 class="card-title fw-semibold fs-6">Perfect Score</h5>-->
 <!--                           <p class="card-text text-muted small mt-auto">Earned 1/22/2024</p>-->
 <!--                       </div>-->
 <!--                   </div>-->
 <!--               </div>-->

                <!-- Blue Badge Card -->
 <!--               <div class="col-xl-3 col-md-6 mb-4">-->
 <!--                   <div class="card h-100 border-0 shadow-sm rounded-4 card-badge">-->
 <!--                       <div class="border-top border-5 border-primary rounded-top-4"></div>-->
 <!--                       <div class="card-body text-center d-flex flex-column">-->
 <!--                           <div class="position-relative d-inline-block mx-auto mb-4 mt-2">-->
 <!--                               <div class="d-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-4 shadow" style="width: 90px; height: 90px;">-->
 <!--                                   <div>-->
 <!--                                       <div class="fs-2 fw-bold lh-1">1</div>-->
 <!--                                       <div class="fs-5">🎯</div>-->
 <!--                                   </div>-->
 <!--                               </div>-->
 <!--                               <div class="position-absolute top-0 start-100 translate-middle bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 28px; height: 28px;">+</div>-->
 <!--                           </div>-->
 <!--                           <h5 class="card-title fw-semibold fs-6">First Achievement</h5>-->
 <!--                           <p class="card-text text-muted small mt-auto">Earned 1/15/2024</p>-->
 <!--                       </div>-->
 <!--                   </div>-->
 <!--               </div>-->

 <!--           </div>-->
 <!--       </div>-->
 <!--   </section>-->
    <!-- Badge Modal -->
<!-- Badge Details Modal -->
<div class="modal fade" id="badgeDetailsModal" tabindex="-1" aria-labelledby="badgeDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow rounded-4">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="badgeDetailsModalLabel">Badge Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="d-flex gap-4 align-items-start">
          <img id="badge-icon" src="" alt="Badge Icon" class="rounded-circle" style="width: 100px; height: 100px; object-fit: contain; background-color: #f0f0f0;">
          <div>
            <h4 id="badge-name" class="mb-1"></h4>
            <p class="text-muted mb-2" id="badge-category"></p>
            <p id="badge-description" class="mb-0 small text-secondary"></p>
          </div>
        </div>
        <hr>
        <div class="row mt-3">
          <div class="col-md-6 mb-2">
            <strong>Student ID:</strong> <span id="student-id"></span>
          </div>
          <div class="col-md-6 mb-2">
            <strong>Awarded By:</strong> <span id="staff-name"></span> (<span id="staff-code"></span>)
          </div>
          <div class="col-md-6 mb-2">
            <strong>Awarded Date:</strong> <span id="awarded-date"></span>
          </div>
          <div class="col-md-6 mb-2">
            <strong>Status:</strong> <span id="badge-status" class="badge bg-success text-uppercase"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


    </main>
