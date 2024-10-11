<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                @if (auth('admin')->user()->level === 2)
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M8.5 11.5v-1h7v1h-7Zm0-4v-1h7v1h-7Zm-2.5 7h8.725L18 18.758V4H6v10.5ZM6 20h11.685l-3.435-4.5H6V20Zm13 1H5V3h14v18ZM6 20V4v16Zm0-4.5v-1v1Z"/></svg>
                            <span data-key="t-apps">Quản lý hồ sơ</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            {{-- <li>
                            <a href="{{ route('admin.admin.add') }}">
                                <span data-key="t-calendar">Danh mục hồ sơ</span>
                            </a>
                        </li> --}}
                            <li>
                                <a href="{{ route('admin.admin.list') }}">
                                    <span data-key="t-chat">Danh sách</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><path fill="currentColor" d="M10.8 0c.274 0 .537.113.726.312l3.2 3.428c.176.186.274.433.274.689V15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1zM14 5h-3.5a.5.5 0 0 1-.5-.5V1H2v14h12zm-8.5 7a.5.5 0 1 1 0-1h5a.5.5 0 1 1 0 1zm0-3a.5.5 0 0 1 0-1h5a.5.5 0 1 1 0 1z"/></svg>
                            <span data-key="t-apps">Quản lý văn bản</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                          
                            <li>
                                <a href="#">
                                    <span data-key="t-chat">Danh sách</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 1024 1024"><path fill="currentColor" d="M746 835.28L544.529 723.678c74.88-58.912 95.216-174.688 95.216-239.601v-135.12c0-89.472-118.88-189.12-238.288-189.12c-119.376 0-241.408 99.664-241.408 189.12v135.12c0 59.024 24.975 178.433 100.624 239.089L54 835.278S0 859.342 0 889.342v81.088c0 29.84 24.223 54.064 54 54.064h692c29.807 0 54.031-24.224 54.031-54.064v-81.087c0-31.808-54.032-54.064-54.032-54.064zm-9.967 125.215H64.002V903.28c4.592-3.343 11.008-7.216 16.064-9.536c1.503-.688 3.007-1.408 4.431-2.224l206.688-112.096c18.848-10.224 31.344-29.184 33.248-50.528s-7.008-42.256-23.712-55.664c-53.664-43.024-76.656-138.32-76.656-189.152V348.96c0-45.968 86.656-125.12 177.408-125.12c92.432 0 174.288 78.065 174.288 125.12v135.12c0 50.128-15.568 145.84-70.784 189.28a64.098 64.098 0 0 0-24.224 55.664a64.104 64.104 0 0 0 33.12 50.849l201.472 111.6c1.777.975 4.033 2.031 5.905 2.848c4.72 2 10.527 5.343 14.783 8.288v57.887zM969.97 675.936L765.505 564.335c74.88-58.912 98.224-174.688 98.224-239.601v-135.12c0-89.472-121.872-190.128-241.28-190.128c-77.6 0-156.943 42.192-203.12 96.225c26.337 1.631 55.377 1.664 80.465 9.664c33.711-26.256 76.368-41.872 122.656-41.872c92.431 0 177.278 79.055 177.278 126.128v135.12c0 50.127-18.56 145.84-73.775 189.28a64.098 64.098 0 0 0-24.224 55.664a64.104 64.104 0 0 0 33.12 50.848l204.465 111.6c1.776.976 4.032 2.032 5.904 2.848c4.72 2 10.527 5.344 14.783 8.288v56.912H830.817c19.504 14.72 25.408 35.776 32.977 64h106.192c29.807 0 54.03-24.224 54.03-54.064V730.03c-.015-31.84-54.047-54.096-54.047-54.096z"/></svg>
                            <span data-key="t-apps">Quản lý người dùng</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                          
                            <li>
                                <a href="{{route('admin.admin.list')}}">
                                    <span data-key="t-chat">Danh sách</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title mt-2" data-key="t-components">Cấu hình</li>
                    <li>
                        <a href="{{route('admin.config.index')}}" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 50 50"><path fill="currentColor" d="M25.511 2.892L1.268 23H7v24h36V23h6.268L25.511 2.892zM30.942 40H19.593l2.38-10.711c-1.439-1-2.38-2.506-2.38-4.35c0-3.038 2.541-5.439 5.674-5.439c3.135 0 5.675 2.493 5.675 5.531c0 1.845-.941 3.245-2.379 4.242L30.942 40z"/></svg>
                            <span data-key="t-apps">Cơ quan</span>
                        </a>
                    
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
