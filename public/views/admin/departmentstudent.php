

<div class="container mt-5">
    <!-- Stats Cards Row -->
    <!-- <div class="row mb-4">
        <!-- ... your existing stats cards ... -->
    </div> 

    <!-- Student Listing Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Student Directory</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchStudent" placeholder="Search student...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">Sl No</th>
                            <th scope="col">Student ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Department</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample student with profile link -->
                        <tr>
                            <td class="text-center">1</td>
                            <td>STU001</td>
                            <td>
                                
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold text">John Doe</div>
                                            <small class="text-muted">Third Year</small>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>Computer Science</td>
                            <td class="text-center">
                                <div class="btn-group">
                                <a href="/student/profile" class="btn btn-sm btn-outline-primary text-decoration-none">
                                <i class="fas fa-eye"></i> View Profile
                                </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Other sample students -->
                        <tr>
                            <td class="text-center">2</td>
                            <td>STU002</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold">Jane Smith</div>
                                        <small class="text-muted">Second Year</small>
                                    </div>
                                </div>
                            </td>
                            <td>Mechanical Engineering</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    padding: .25rem .5rem;
}

.btn-group .btn i {
    font-size: 0.875rem;
}

.pagination {
    margin-bottom: 0;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}
</style>