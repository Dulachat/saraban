<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="row">
        <div class="col-md-12 mt--2">

            <button type="button" class="btn btn-success " style="float:right;" data-toggle="modal"
                data-target="#document">
                เพิ่มเอกสาร
            </button>

            <button type="button" class="btn btn-info " style="float:right;" data-toggle="modal"
                data-target="#government">
                เพิ่มส่วนราชการ
            </button>

            <button type="button" class="btn btn-primary " style="float:right;" data-toggle="modal"
                data-target="#exampleModal">
                เพิ่มประเภทเอกสาร
            </button>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-6 mt--4">
            <input class="form-control" type="text" wire:model="searchTable" >
        </div>
    </div> --}}
    <div class="row">

        <div class="col-md-12 mt-2">
            <div class='table-responsive'>
                <table class="yajra-datatable">
                    <thead class="thead text-monospace ">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ที่</th>
                            <th>ชื่อส่วนราชการ</th>
                            <th>ชื่อเอกสาร</th>
                            <th>วันที่นำเข้าเอกสาร</th>
                            <th>ประเภทเอกสาร</th>
                            <th>แก้ไข</th>
                            <th>เพิ่มเติม</th>


                        </tr>
                    </thead>
                    <tbody class="">

                        {{-- @foreach ($documentJoin as $rows)
                            <tr>
                                <th class="text-md">{{ $documentJoin->firstItem() + $loop->index }}</th>
                                <td class="text-md">{{ $rows->book_number }}</td>
                                <td class="text-md">{{ $rows->government_name }}</td>
                                <td class="text-md">{{ $rows->docs_name }}</td>
                                <td class="text-md">{{ $rows->created_at }}</td>
                                <td class="text-md">{{ $rows->type_name }}</td>
                                <td class="text-md"> <button type="button" class="btn btn-warning " data-toggle="modal"
                                        data-target="#editModal{{ $rows->docs_id }} ">
                                        edit
                                    </button></td>
                                <td class="text-md"> <button type="button" class="btn btn-info " data-toggle="modal"
                                        data-target="#info{{ $rows->docs_id }}">
                                        info
                                    </button></td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <div class="d-flex justify-content-center">
        {{-- {!! $documentJoin->links() !!} --}}
    </div>

</div>


{{-- government add --}}
<div class="modal fade " id="government" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">เพิ่มส่วนราชการ</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb--2">
                        <form action="{{ route('addGovernment') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="government_name"
                                    placeholder="ชื่อส่วนราชการ" required>
                            </div>
                            <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก">
                        </form>
                        @error('government')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <br>

                </div>

            </div>
        </div>
    </div>
</div>
{{-- document add --}}
<div class="modal fade " id="document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="government">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">เพิ่มเอกสาร</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt--2">
                        <form action="{{ route('addDocument') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mt--3">

                                        <select class="form-control selectpicker " id="" name="title_data"
                                            data-live-search="true" required>
                                            <option selected disabled>ส่วนราชการ</option>
                                            @foreach ($government as $rows)
                                                <option value="{{ $rows->government_id }}">
                                                    {{ $rows->government_name }}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt--3">
                                        <input type="text" class="form-control" name="book_number" placeholder="ที่"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt--3">
                                        <input type="text" class="form-control" name="docs_name"
                                            placeholder="ชื่อเรื่อง" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt--3">
                                        <select class="form-control " id="select2" name="priority" required>
                                            <option value="">ระดับความสำคัญ</option>
                                            <option value="0">ปกติ</option>
                                            <option value="1">ลับ</option>
                                            <option value="2">ลับมาก</option>
                                            <option value="3">ลับที่สุด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt--3">
                                        <input type="date" class="form-control" name="docs_date"
                                            placeholder="วันที่เอกสาร" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt--3">
                                        <select class="form-control " id="select2" name="type_id" required>
                                            <option value="">ประเภทเอกสาร</option>
                                            @foreach ($data_type as $rows)
                                                <option value="{{ $rows->type_id }}">{{ $rows->type_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt--3">
                                        <input type="file" class="form-control" id="path_data" name="path_data"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 mt--2">
                                    <div class="form-group mt--2">
                                        <select class="form-control selectpicker" id="permission" name="permission[]"
                                            multiple>
                                            <option selected disabled>สิทธิ์การเข้าถึง</option>
                                            @foreach ($permission as $row)
                                                <option value="{{ $row->permission_id }}">{{ $row->permission_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt--2" id="select_permission">

                                    </div>

                                </div>
                                <div class="col-md-12 mt--2">
                                    <div class="form-group">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="รายละเอียดเอกสาร" rows="3"
                                            name="docs_detail"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก"
                                onclick="confirm('ยืนยันการเพิ่มข้อมูล')">
                        </form>
                        @error('error')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <br>

                </div>

            </div>
        </div>
    </div>
</div>

{{-- addType --}}
<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">เพิ่มประเภทเอกสาร</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb--2">
                        <form action="{{ route('addDocsType') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="type_name"
                                    placeholder="ชื่อประเภทเอกสาร" required>
                            </div>
                            <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก">
                        </form>
                        @error('data_types')
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
@foreach ($documentJoin as $rows)
    <div class="modal fade " id="editModal{{ $rows->docs_id }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="editModal">แก้ไขเอกสาร</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt--2">
                            <form action="{{ route('updateDoc') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="docs_id" value="{{ $rows->docs_id }}">
                                    <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <select class="form-control selectpicker " id=""
                                                name="title_data" data-live-search="true">
                                                <option value="{{ $rows->government_id }}">
                                                    {{ $rows->government_name }}</option>
                                                @foreach ($government as $go)
                                                    <option value="{{ $go->government_id }}">
                                                        {{ $go->government_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <input type="text" class="form-control"
                                                value="{{ $rows->book_number }}" name="book_number"
                                                placeholder="ที่" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <input type="text" class="form-control"
                                                value="{{ $rows->docs_name }}" name="docs_name"
                                                placeholder="ชื่อเรื่อง">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mt--3">
                                            <select class="form-control " id="select2" name="type_id">
                                                <option value="{{ $rows->priority }}">{{ $rows->priority }}</option>
                                                <option value="">ระดับความสำคัญ</option>
                                                <option value="0">ปกติ</option>
                                                <option value="1">ลับ</option>
                                                <option value="2">ลับมาก</option>
                                                <option value="3">ลับที่สุด</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mt--3">
                                            <input type="date" name="docs_date" class="form-control"
                                                value="{{ $rows->docs_date }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mt--3">
                                            <select class="form-control " id="select2" name="type_id">
                                                <option value="{{ $rows->type_id }}">{{ $rows->type_name }}
                                                </option>
                                                @foreach ($data_type as $type)
                                                    <option value="{{ $type->type_id }}">{{ $type->type_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <input type="file" class="form-control" name="path_data"
                                                value="{{ $rows->path_data }}">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12 mt--2">
                                        <div class="form-group">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="รายละเอียดเพิ่มเติม..." rows="3"
                                                name="docs_detail">{{ $rows->docs_detail }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <input type="hidden" class="form-control" name="view_docs"
                                                value="{{ auth()->user()->id }}">
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก"
                                    onclick="confirm('ยืนยันการแก้ไขข้อมูล')">
                            </form>
                            @error('data_types')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endforeach
{{-- info --}}
@foreach ($documentJoin as $rows)
    <div class="modal fade " id="info{{ $rows->docs_id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="government">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">รายละเอียดเพิ่มเติม</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt--2">
                            {{-- <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <input type="text" class="form-control"
                                                value="{{ $rows->government_name }}" name=""
                                                placeholder="ส่วนราชการ" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mt--3">
                                            <input type="text" class="form-control"
                                                value="{{ $rows->docs_name }}" placeholder="ชื่อเรื่อง" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mt--3">
                                            <input type="text" class="form-control" value="{{ $rows->priority }}"
                                                placeholder="ระดับความสำคัญ" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mt--3">
                                            <input type="date" class="form-control"
                                                value="{{ $rows->docs_date }}" placeholder="วันที่เอกสาร" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mt--3">
                                            <input type="text" class="form-control"
                                                value="{{ $rows->type_name }}" placeholder="ประเภทเอกสาร" readonly>
                                        </div>
                                    </div>
                                   
                                    

                                    <div class="col-md-12 mt--2">
                                        <div class="form-group">
                                            <textarea class="form-control" value="{{ $rows->docs_detail }}" id="exampleFormControlTextarea1"
                                                placeholder="รายละเอียดเอกสาร" rows="3" name="docs_detail" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </form> --}}
                            <div class="col-md-12 mt--2">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="รายละเอียดเพิ่มเติม" " id="exampleFormControlTextarea1"
                                                                            placeholder="รายละเอียดเอกสาร" rows="3" name="docs_detail" readonly>{{ $rows->docs_detail }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mt--3">
                                <iframe src="/{{ $rows->path_data }}" frameborder="0" width="752px"
                                    height="550px"></iframe>
                            </div>
                            @error('data_types')
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
