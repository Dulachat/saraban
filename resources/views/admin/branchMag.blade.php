@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                <b>{{ session('success') }}</b>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12">

                <div class="card card-stats">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success " style="float:right;" data-toggle="modal"
                                    data-target="#exampleModal">
                                    เพิ่มสาขาวิชา
                                </button>
                                <h1>จัดการสาขาวิชา</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="yajra-datatable">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อสาขา</th>
                                            <th>แก้ไข</th>
                                           
                                          
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        {{-- @foreach ($branches as $row)
                                            <tr>
                                                <th class="text-md">{{ $branches->firstItem() + $loop->index }}</th>
                                                <td class="text-md">{{ $row->branch_name }}</td>
                                                <td class="text-md"> <button type="button" class="btn btn-warning "
                                                        data-toggle="modal" data-target="#editModal{{ $row->branch_id }}">
                                                        edit
                                                    </button></td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        {{-- add --}}
        <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">เพิ่มสาขา</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb--2">
                                <form action="{{ route('addBranch') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="branch_name" placeholder="ชื่อสาขา"
                                            required>
                                    </div>
                                    <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก"
                                        onclick="confirm('ยืนยันข้อมูล')">
                                </form>
                                @error('branches')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- edit --}}
        @foreach ($branches as $row)
            <div class="modal fade " id="editModal{{ $row->branch_id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">เพิ่มสาขา</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb--2">
                                    <form action="{{ url('/admin/branchMag/update/' . $row->branch_id) }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="branch_name"
                                                value="{{ $row->branch_name }}" placeholder="ชื่อสาขา">
                                        </div>
                                        <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก">
                                    </form>
                                    @error('branches')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @push('js')
        <script>
            $(function() {
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('branchMag.ajax') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'Nomor'
                        },
                        {
                            data: 'branch_name',
                            name: 'branch_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        },

                    ],
                    destroy: true      
                });

            });
        </script>
    @endpush
@endsection
