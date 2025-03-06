<style>
/* Sidebar Offcanvas */
.offcanvas {
    width: 250px;
    background-color: #fff; /* White background */
    color: #000;
    border-right: 1px solid #ddd;
    display: flex;
    flex-direction: column; /* Makes content stack vertically */
    height: 100vh; /* Full height */
}

/* Sidebar Navigation */
.sidebar-nav {
    flex-grow: 1; /* Pushes footer to the bottom */
    padding: 1rem 0;
}

/* Sidebar Links */
a.sidebar-link {
    padding: 12px 20px;
    color: #000;
    display: flex;
    align-items: center;
    font-size: 16px;
    white-space: nowrap;
    border-left: 3px solid transparent;
    text-decoration: none;
    transition: all 0.3s ease;
}

.sidebar-link i {
    font-size: 1.2rem;
    margin-right: 10px;
}

a.sidebar-link:hover {
    background-color: #f1f1f1;
    border-left: 3px solid #000;
}

/* Sidebar Footer (Logout Button at Bottom) */
.sidebar-footer {
    padding: 0; /* Remove extra padding */
    border-top: 1px solid #ddd;
    width: 100%; /* Ensure it takes full width */
}

/* Logout Button */
.sidebar-footer .sidebar-link {
    color: #000;
    display: flex;
    align-items: center;
    padding: 15px 20px; /* Adjust padding for better spacing */
    width: 100%; /* Ensure it covers the full width */
    text-decoration: none;
    transition: background 0.3s ease-in-out;
}

/* Hover Effect - Full Width */
.sidebar-footer .sidebar-link:hover {
    background-color: #f1f1f1; /* Light gray hover */
    width: 100%;
}


</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="btn btn-dark me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Walang Pangalan</a>
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">

        </li>
    </ul>
</nav>

<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">Walang Pangalan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class='bx bxs-dashboard'></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class='bx bxs-calendar'></i>
                <span>Inventory</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class='bx bx-edit-alt'></i>
                <span>Outlets</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class='bx bxs-food-menu'></i>
                <span>Department</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class='bx bx-fork'></i>
                <span>Category</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class='bx bx-clipboard'></i>
                <span>Users</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="#" class="sidebar-link" id="logout-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class='bx bx-log-out'></i>
            <span>Logout</span>
        </a>
    </div>
</div>