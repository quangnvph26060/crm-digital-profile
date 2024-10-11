<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>
                <li>
                    <a href="{{route('admin.dashboard')}}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.dashboard')}}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Chấm công</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i data-feather="dollar-sign"></i>
                        <span data-key="t-apps">Yêu cầu nạp tiền</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="shopping-bag"></i>
                        <span data-key="t-apps">Tạo đơn</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="apps-calendar.html">
                                <span data-key="t-calendar">Tạo đơn lẻ</span>
                            </a>
                        </li>
                        <li>
                            <a href="apps-chat.html">
                                <span data-key="t-chat">Nhập Excel</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-authentication">Quản lý</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login.html" data-key="t-login">Quản lý vận đơn</a></li>
                        <li><a href="auth-register.html" data-key="t-register">Thống kê tiền hàng</a></li>
                        <li><a href="auth-recoverpw.html" data-key="t-recover-password">Thống kê doanh thu</a></li>
                        <li><a href="auth-lock-screen.html" data-key="t-lock-screen">Đơn hàng cần xử lý</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
