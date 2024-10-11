<!doctype html>
<html lang="vi">
<head>
        <meta charset="utf-8" />
        <title>THÔNG TIN DỰ ÁN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('libs/assets/images/favicon.ico')}}">

        <!-- plugin css -->
        <link href="{{asset('libs/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

        <!-- preloader css -->
        <link rel="stylesheet" href="{{asset('libs/assets/css/preloader.min.css')}}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{asset('libs/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('libs/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('libs/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        @yield('css')
        <style>
            @media (max-width: 768px) {
                .logo {
                    text-align: center;
                }
                .logo img {
                    width: 80%;
                }
            }
        </style>
    </head>

    <body data-layout="horizontal">

    <!-- <body data-layout="horizontal"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <div class="main-content">
                <div class="page-content" style="margin-top: 0px; padding-top: 20px">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 logo">
                                <img src="https://sgomedia.vn/wp-content/uploads/2023/05/logo-sgo-media-file-chot-1.png" width="50%" alt="">
                            </div>
                            <div class="col-md-6 col-lg-6" style="text-align: center">
                                <h5>
                                    CÔNG TY CP CÔNG NGHỆ VÀ TRUYỀN THÔNG WEB89 VIỆT NAM
                                </h5>
                                <p>
                                    <i>
                                        Địa chỉ: 164 Khuất Duy Tiến - Thanh Xuân - Hà Nội
                                    </i>
                                </p>
                                <p>
                                    <i>
                                        VPGĐ: 222 Nguyễn Văn Lộc - Hà Đông - Hà Nội
                                    </i>
                                </p>
                                <p>
                                    <i>
                                        Hotline: 0981185620 / 0981185620 - Email: info@web89.vn - Website: <a href="https://web89.vn/" target="_blank">web89.vn</a> - <a href="https://sgomedia.vn/" target="_blank">sgomedia.vn</a>
                                    </i>
                                </p>
                            </div>
                        </div>
                        <br>
                        @if (session("success"))
                            <div class="alert alert-success">
                                {{ session("success") }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('store-customer') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">THÔNG TIN LIÊN HỆ</h4>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Người liên hệ <span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="info[name]" type="text" value="{{ old('info.name') }}" id="example-text-input">
                                                            @error("info.name")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Số điện thoại<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="info[phone]" value="{{ old('info.phone') }}" type="text" value="" id="example-search-input">
                                                            @error("info.phone")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Email<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="info[email]" type="email" value="{{ old('info.email') }}" id="example-email-input">
                                                            @error("info.email")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Chức vụ<span class="text text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="info[position]" value="{{ old('info.position') }}" id="example-url-input">
                                                        @error("info.position")
                                                            <span class="text text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Thương hiệu (tên công ty)<span class="text text-danger">*</span></label>
                                                        <input class="form-control" type="text"  name="info[company]" value="{{ old('info.company') }}" id="example-tel-input">
                                                        @error("info.company")
                                                            <span class="text text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Lĩnh vực hoạt động<span class="text text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="info[activity]" value="{{ old('info.activity') }}" id="example-password-input">
                                                        @error("info.activity")
                                                            <span class="text text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">TỔNG QUAN DỰ ÁN - MỤC TIÊU</h4>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Tại sao anh chị muốn triển khai SEO cho website? Mục đích làm SEO là gì? <span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="overview[reason]" value="{{ old('overview.reason') }}" type="text" value="" id="example-text-input">
                                                            @error("overview.reason")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Sản phẩm/ dịch vụ nào anh chị muốn đẩy SEO (liệt kê 2-5)<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="overview[product]" type="text" value="{{ old('overview.product') }}" id="example-search-input">
                                                            @error("overview.product")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Ngân sách/ tháng:<span class="text text-danger">*</span></label>
                                                        <input class="form-control" name="overview[budget]" type="number" value="{{ old('overview.budget') }}" id="example-url-input">
                                                        @error("overview.budget")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Thời gian triển khai dự kiến mong muốn:<span class="text text-danger">*</span></label>
                                                        <input class="form-control" name="overview[time]" type="text" value="{{ old('overview.time') }}" id="example-tel-input">
                                                        @error("overview.time")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">List keyword chính mong muốn lên top:<span class="text text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="overview[keyword]" value="{{ old('overview.keyword') }}" id="example-email-input">
                                                        @error("overview.keyword")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">KINH NGHIỆM TRIỂN KHAI DỰ ÁN SEO</h4>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Anh chị đã từng triển khai SEO bao giờ chưa? Nếu có thì là inhouse tự thực thi hay thuê đơn vị chuyên môn làm?<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="experience[exp_seo]" type="text" value="{{ old('experience.exp_seo') }}" id="example-text-input">
                                                            @error("experience.exp_seo")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Trường hợp anh chị đã từng hợp tác với đơn vị SEO khác, đâu là lý do anh chị tìm đơn vị triển khai SEO mới?<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="experience[reason]" type="text" value="{{ old('experience.reason') }}" id="example-search-input">
                                                            @error("experience.reason")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Mong muốn/ yêu cầu về đơn vị thực thi SEO tới?
                                                                (Cách thức làm việc, lưu ý trong quá trình hợp tác)<span class="text text-danger">*</span></label>
                                                            <input class="form-control" type="text" name="experience[wish]" value="{{ old('experience.wish') }}" id="example-url-input">
                                                            @error("experience.wish")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">THÔNG TIN WEBSITE</h4>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Website<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="website[url]" type="text" value="{{ old('website.url') }}" id="example-text-input">
                                                            @error("website.url")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Share thông tin tài khoản Google Analytics, Google Search Console (mục tiêu để chuyên gia phân tích sâu tình trạng website). Hoặc xuất báo cáo 3 tháng gần nhất được không?</label>
                                                            <input class="form-control" name="website[account]" type="text" value="{{ old('website.account') }}" id="example-search-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Website đối thủ:</label>
                                                            <input class="form-control" name="website[url_competitor]" type="text" value="{{ old('website.url_competitor') }}" id="example-url-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">THÔNG TIN SẢN PHẨM/DỊCH VỤ</h4>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Ngành: <span class="text text-danger">*</span></label>
                                                            <input class="form-control"  name="product[industry]" type="text" value="{{ old('product.industry') }}" id="example-text-input">
                                                            @error("product.industry")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Giá sản phẩm:<span class="text text-danger">*</span></label>
                                                            <input class="form-control" name="product[price_product]" type="text" value="{{ old('product.price_product') }}" id="example-search-input">
                                                            @error("product.price_product")
                                                                <span class="text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Kênh truyền thông đem đến chuyển đổi tốt nhất cho doanh nghiệp hiện nay</label>
                                                            <input class="form-control" name="product[channel]" type="text" value="{{ old('product.channel') }}" id="example-search-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Thế mạnh của sản phẩm/ dịch vụ:<span class="text text-danger">*</span></label>
                                                        <input class="form-control" name="product[strengths]"  type="text" value="{{ old('product.strengths') }}" id="example-url-input">
                                                        @error("product.strengths")
                                                            <span class="text text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Các kênh truyền thông đang sử dụng: Fanpage Facebook, Website <span class="text text-danger">*</span></label>
                                                        <input class="form-control" name="product[social]" type="text" value="{{ old('product.social') }}" id="example-tel-input">
                                                        @error("product.social")
                                                            <span class="text text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Các hoạt động khuyến mãi/ chiến dịch đang diễn ra:</label>
                                                        <input class="form-control" name="product[coupon]" type="text" value="{{ old('product.coupon') }}" id="example-tel-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Những vấn đề, khó khăn doanh nghiệp đang gặp phải:</label>
                                                        <input class="form-control" type="text" name="product[challenge]" value="{{ old('product.challenge') }}" id="example-email-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">ĐỐI TƯỢNG KHÁCH HÀNG</h4>
                                        </div>
                                        <div class="card-body p-4">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Khách hàng mục tiêu:</label>
                                                            <input class="form-control" name="customer[target]" type="text" value="{{ old('customer.target') }}" id="example-text-input">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Độ tuổi:</label>
                                                            <input class="form-control" name="customer[old]" type="text" value="{{ old('customer.old') }}" id="example-search-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Khu vực:</label>
                                                        <input class="form-control" name="customer[region]" type="text" value="{{ old('customer.region') }}" id="example-url-input">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Thói quen, sở thích, hành vi:</label>
                                                        <input class="form-control" name="customer[favourite]" type="text" value="{{ old('customer.favourite') }}" id="example-tel-input">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Giới tính</label>
                                                        <input class="form-control" name="customer[gender]" type="text" value="{{ old('customer.gender') }}" id="example-email-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button style="width: 100%" class="btn btn-primary">
                                        XÁC NHẬN GỬI
                                    </button>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
                @include('customers.layouts.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right Sidebar -->
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('libs/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('libs/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('libs/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('libs/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('libs/assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('libs/assets/libs/feather-icons/feather.min.js')}}"></script>
        <!-- pace js -->
        <script src="{{asset('libs/assets/libs/pace-js/pace.min.js')}}"></script>

        <!-- apexcharts -->
        <script src="{{asset('libs/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- Plugins js-->
        <script src="{{asset('libs/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{asset('libs/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js')}}"></script>
        <!-- dashboard init -->
        {{-- <script src="{{asset('libs/assets/js/pages/dashboard.init.js')}}"></script> --}}

        <script src="{{asset('libs/assets/js/app.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @yield('scripts')
    </body>
</html>
