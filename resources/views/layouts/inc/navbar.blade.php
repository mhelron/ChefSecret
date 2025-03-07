<style>
/* Sidebar Offcanvas */
/* Sidebar Offcanvas */
.offcanvas {
    width: 250px;
    color: #fff; /* Change text to white for better contrast */
    border-right: 1px solid #444; /* Darker border for consistency */
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
    color: #bbb; /* Slightly dimmed white */
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

/* Hover Effect */
a.sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.1); /* Subtle white overlay */
    color: #fff; /* Ensures text stays white */
    border-left: 3px solid #fff; /* Bootstrap primary blue */
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 0;
    border-top: 1px solid #444; /* Darker border */
    width: 100%;
}

/* Logout Button */
.sidebar-footer .sidebar-link {
    color: #bbb; /* Dimmed white */
    display: flex;
    align-items: center;
    padding: 15px 20px;
    width: 100%;
    text-decoration: none;
    transition: background 0.3s ease-in-out;
}

/* Sidebar Footer Hover */
.sidebar-footer .sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}

</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="btn btn-dark me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Asset Management System</a>
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">

        </li>
    </ul>
</nav>

<div class="offcanvas offcanvas-start bg-dark" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel" style="color: fff;">Asset Management System</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('dashboard.index') }}" class="sidebar-link">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('inventory.index') }}" class="sidebar-link">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </a>
        </li>
        <!--
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="bi bi-shop"></i>
                <span>Outlets</span>
            </a>
        </li>
        -->
        <!--
        <li class="sidebar-item">
            <a href="{{ route('departments.index') }}" class="sidebar-link">
                <i class="bi bi-building"></i>
                <span>Departments</span>
            </a>
        </li>
                -->
        <li class="sidebar-item">
            <a href="{{ route('categories.index') }}" class="sidebar-link">
                <i class="bi bi-folder"></i>
                <span>Categories</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('users.index') }}" class="sidebar-link">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="#" class="sidebar-link" id="logout-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-in-left"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

 <!-- Logout Confirmation Modal -->
 <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    </div>
                    <div class="modal-body">
                        <p class="pt-4 pb-4">Are you sure you want to log out?</p>
                        <!-- Align buttons to the right -->
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirm-logout-btn">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

<script>
    document.getElementById('logout-link').addEventListener('click', function(e) {
    e.preventDefault();
    try {
        var myModal = new bootstrap.Modal(document.getElementById('logoutModal'));
        myModal.show();
    } catch (error) {
        console.error('Error initializing modal: ', error);
    }
});

document.getElementById('confirm-logout-btn').addEventListener('click', function() {
    document.getElementById('logout-form').submit();
});

document.addEventListener('hidden.bs.modal', function (event) {
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
});
</script>