@extends('admins.layouts.index')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Trao đổi từ khóa - <b>{{$mission->keyword}}</b></h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="col-lg-12">
            @include('globals.alert')
        </div>
        <div class="d-lg-flex">
            <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
                <div class="card">
                    <div class="p-3 px-lg-4 border-bottom">
                        <div class="row">
                            <div class="col-xl-4 col-7">
                                <div class="d-flex align-items-center">

                                    <div class="flex-grow-1">
                                        <h5 class="font-size-14 mb-1 text-truncate"><a href="#" class="text-dark">{{$mission->user->full_name}}</a></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-5">
                                <ul class="list-inline user-chat-nav text-end mb-0">
                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-search"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                                <form class="px-2">
                                                    <div>
                                                        <input type="text" class="form-control border bg-soft-light" placeholder="Search...">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Profile</a>
                                                <a class="dropdown-item" href="#">Archive</a>
                                                <a class="dropdown-item" href="#">Muted</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="chat-conversation p-3 px-2" data-simplebar>
                        <ul class="list-unstyled mb-0">
                            {{-- <li class="chat-day-title">
                                <span class="title">Today</span>
                            </li> --}}
                            @foreach ($comments as $item)
                                <li class="{{is_null($item->user_id) ? 'right' : ''}}">
                                    <div class="conversation-list">
                                        <div class="ctext-wrap">
                                            <div class="ctext-wrap-content">
                                                <h5 class="conversation-name">
                                                    <a href="#" class="user-name">
                                                        {{is_null($item->user_id) ? $item->admin->username : $item->user->full_name}}
                                                    </a>
                                                <span class="time">{{$item->created_at->format('H:i d/m/Y')}}</span></h5>
                                                <p class="mb-0">
                                                    {{$item->message}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="p-3 border-top">
                        <form action="{{route('admin.mission.store-comment', ['id' => $mission->id])}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="position-relative">
                                        <input name="message" type="text" class="form-control border bg-soft-light" placeholder="Nhập nội dung...">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Gửi</span> <i class="mdi mdi-send float-end"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end user chat -->
        </div>
        <!-- End d-lg-flex  -->

    </div> <!-- container-fluid -->
</div>
@endsection
