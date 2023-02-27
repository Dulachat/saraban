@extends('layouts.app')
@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt-3">

        <div class="row">
            @auth()
            @if (auth()->user()->u_level_id == 1)
            <div class="col-md-3">
                <div style="width: 18rem;">
                    <div class="card card-stats mb-4 mb-lg-0 bg-or">
                        <a href="{{ route('admin') }}">
                            <div class="card-body mb-5 mt-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="ni ni-settings"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <h3>จัดการข้อมูลทั่วไป</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endif  
            @if(auth()->user()->u_level_id == 1 or auth()->user()->u_level_id == 3 or auth()->user()->u_level_id == 4)
            <div class="col-md-3">
                <div style="width: 18rem;">
                    <div class="card card-stats mb-4 mb-lg-0 bg-or">
                        <a href="{{ route('generalDocs.ajax') }}">
                            <div class="card-body mb-5 mt-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="ni ni-single-copy-04"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <h3>จัดการข้อมูลเอกสาร</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div style="width: 18rem;">
                    <div class="card card-stats mb-4 mb-lg-0 bg-or">
                        <a href="{{ route('AllDocs') }}">
                            <div class="card-body mb-5 mt-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="ni ni-single-copy-04"></i>
                                    </div>
                                    <div class="col-md-10">
                                        <h3>เอกสารทั้งหมด</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            @endif   
            @endauth
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
