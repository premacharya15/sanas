<?php
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}
?>
<div class="wl-left-sidebar sidebar-dark active">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="navbar-toggler collapsed" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" role="button">
                <p class="nav-title d-xl-none d-lg-none m-0">Dashboard</p>
                <i class="fas fa-bars" aria-hidden="true"></i>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('my-dashboard')) echo 'active'; ?>" href="<?php echo home_url('/my-dashboard/'); ?>">
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('my-events')) echo 'active'; ?>" href="<?php echo home_url('/my-events/'); ?>">
                            <i class="fa-regular fa-clock"></i>
                            My Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('my-contacts')) echo 'active'; ?>" href="<?php echo home_url('/my-contact/'); ?>">
                            <i class="fa-regular fa-address-card"></i>
                            My Contacts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('my-favorites')) echo 'active'; ?>" href="<?php echo home_url('/my-favorites/'); ?>">
                            <i class="fa-regular fa-heart"></i>
                            My Favorites
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('budget')) echo 'active'; ?>" href="<?php echo home_url('/budget/'); ?>">
                            <i class="fa-regular fa-calendar-days"></i>
                            Budget Calculator
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('vendors-list')) echo 'active'; ?>" href="<?php echo home_url('/vendors-list/'); ?>">
                            <i class="fa-regular fa-rectangle-list"></i>
                            Vendors List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('my-vendors')) echo 'active'; ?>" href="<?php echo home_url('/my-vendors/'); ?>">
                            <i class="fa-solid fa-handshake"></i>
                            My Vendors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('to-do-list')) echo 'active'; ?>" href="<?php echo home_url('/to-do-list/'); ?>">
                            <i class="fa-solid fa-list"></i>
                            To Do List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (is_page('my-profile')) echo 'active'; ?>" href="<?php echo home_url('/my-profile/'); ?>">
                            <i class="fa-regular fa-user"></i>
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item logout-btn">
                        <a class="nav-link" href="javascript:void(0);" data-logout-url="<?php echo wp_logout_url(home_url()); ?>">
                            <i class="fa-solid fa-power-off"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>