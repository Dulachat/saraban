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
                                    เพิ่มผู้ใช้งาน
                                </button>
                                <h1>จัดการผู้ใช้งาน</h1>
                               
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class=" yajra-datatable ">
                                    <thead class="thead text-monospace ">
                                        <tr>
                                            <th >ลำดับ</th>
                                            <th >ชื่อ-นามสกุล</th>
                                            <th >สาขาวิชา</th>
                                            <th >ระดับผู้ใช้</th>
                                            <th >แก้ไข</th>

                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        {{-- @foreach ($user_table as $row)
                                            <tr>
                                                <th class="text-md">{{ $user_table->firstItem() + $loop->index }}
                                                </th>
                                                <td class="text-md">
                                                    {{ $row->fname_TH }}{{ ' ' }}{{ $row->lname_TH }}</td>
                                                <td class="text-md">{{ $row->branch_name }}</td>
                                                <td class="text-md">{{ $row->lv_name }}</td>
                                                <td class="text-md"><a
                                                        href="{{ url('/admin/userMag/update/' . $row->id) }}"
                                                        type="button" class="btn btn-warning " data-toggle="modal"
                                                        data-target="#editModal{{ $row->id }}">
                                                        edit
                                                    </a></td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            
                            </div>
                        </div>
                        {{-- <div class="d-flex justify-content-center">
                            {!! $user_table->links() !!}
                       </div> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
    {{-- add --}}
    <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">เพิ่มผู้ใช้งาน</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addUser') }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-md-12 mb--2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-sm-2 mb--2">
                                <div class="form-group">
                                    <select class="form-control" name="title_name_id" id="" required>
                                        <option value="">คำนำหน้าชื่อ</option>
                                        @foreach ($title as $row)
                                            <option value="{{ $row->title_name_id }}">{{ $row->title_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 mb--2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="fname_TH" placeholder="ชื่อ" required>
                                </div>
                            </div>
                            <div class="col-sm-6 mb--2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="lname_TH" placeholder="นามสกุล"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6 mb--2">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="อีเมล์">
                                </div>
                            </div>
                            <div class="col-sm-6 mb--2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="tel" placeholder="เบอร์โทรศัพท์">
                                </div>
                            </div>
                            <div class="col-sm-6 mb--2">
                                <div class="form-group">
                                    <select class="form-control" name="branch_id" id="">
                                        <option>สาขาวิชา</option>
                                        @foreach ($allbranch as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 mb--2">
                                <div class="form-group">
                                    <select class="form-control" name="department" id="department">
                                        <option>ภาควิชา</option>
                                        @foreach ($department as $row)
                                            <option value="{{ $row->department_id }}">{{ $row->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 mb--2">
                                <div class="form-group">
                                    <select class="form-control" name="u_level_id" id="">
                                        <option>ระดับผู้ใช้งาน</option>
                                        @foreach ($allu_status as $u_status)
                                            <option value="{{ $u_status->u_level_id }}">{{ $u_status->lv_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <input onclick="return confirm('ยืนยันการเพิ่มข้อมูล ?')" type="submit" class="btn btn-success" style="float:right;" value="บันทึก">
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit --}}
    @foreach ($user_table as $row)
        <div class="modal fade " id="editModal{{ $row->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="editModal">แก้ไขผู้ใช้งาน</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/admin/userMag/update/' . $row->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb--2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" placeholder="Username"
                                            value="{{ $row->username }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-2 mb--2">
                                    <div class="form-group">
                                        <select class="form-control" name="title_name_id" id="" required>
                                            <option value="{{ $row->title_name_id }}">{{ $row->title_name }}</option>
                                            @foreach ($title as $rows)
                                            <option value="{{ $rows->title_name_id }}">{{ $rows->title_name }}
                                            </option>
                                             @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb--2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="fname_TH" placeholder="ชื่อ"
                                            value="{{ $row->fname_TH }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb--2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lname_TH" placeholder="นามสกุล"
                                            value="{{ $row->lname_TH }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb--2">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="อีเมล์"
                                            value="{{ $row->email }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb--2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tel" placeholder="เบอร์โทรศัพท์"
                                            value="{{ $row->tel }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb--2">
                                    <div class="form-group">
                                        <select class="form-control" name="branch_id" id="">
                                            <option value="{{ $row->branch_id }}">{{ $row->branch_name }}
                                            </option>
                                            @foreach ($allbranch as $branch)
                                                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb--2">
                                    <div class="form-group">
                                        <select class="form-control" name="u_level_id">
                                            <option value="{{ $row->u_level_id }}">
                                                {{ $row->lv_name }}
                                            </option>
                                            @foreach ($allu_status as $u_status)
                                                <option value="{{ $u_status->u_level_id }}">{{ $u_status->lv_name }}
                                                </option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                            </div>
                            @error('fname_TH')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br>
                            <input onclick="return confirm('ยืนยันการแก้ไขข้อมูล ?')"  type="submit" class="btn btn-success" style="float:right;" value="บันทึก" >
                    </div>
                    </form>


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
                ajax: "{{ route('userMag.ajax') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'Nomor'
                    },
                    {
                        data: 'fname_TH',
                        name: 'fname_TH'
                       
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'lv_name',
                        name: 'lv_name'
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
