@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-3">
            <div style="width: 18rem;">
                <div class="card card-stats mb-4 mb-lg-0 bg-or">
                    <a href="{{route('userMag.ajax')}}">
                        <div class="card-body mt-5 mb-5">
                            <div class="row">
                                <div class="col-md-2">
                                    <i class="ni ni-settings"></i>
                                </div>
                                <div class="col-md-10">
                                    <h3>จัดการผู้ใช้งาน</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div style="width: 18rem;">
                <div class="card card-stats mb-4 mb-lg-0 bg-or">
                    <a href="{{route('branchMag.ajax')}}">
                        <div class="card-body mt-5 mb-5">
                            <div class="row">
                                <div class="col-md-2">
                                    <i class="ni ni-single-copy-04"></i>
                                </div>
                                <div class="col-md-10">
                                    <h3>จัดการสาขาวิชา</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection