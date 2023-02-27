@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt-3">

        <div class="row">
            <div class="col-md-3">
                <div style="width: 18rem;">
                    <div class="card card-stats mb-4 mb-lg-0 bg-or">
                        <a href="{{ route('generalDocs2.ajax') }}">
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
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
