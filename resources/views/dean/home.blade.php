@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt-3">

        <div class="row">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>เอกสารทั้งหมด</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                         <div class="col-md-12 mt--6"> <button type="button" class="btn btn-success " style="float:right;" data-toggle="modal"
                            data-target="#deanDocument">
                            ส่งข้อความ
                        </button></div>
                            <div class="col-md-12">
                                <table class="yajra-datatable ">
                                    <thead class="thead text-monospace ">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ที่</th>
                                            <th>ชื่อส่วนราชการ</th>
                                            <th>ชื่อเอกสาร</th>
                                            <th>ประเภทเอกสาร</th>
                                            <th>วันที่</th>
                                            <th>เพิ่มเติม</th>


                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        {{-- @foreach ($loadDocs as $row)
                                            <tr>
                                                <th class="text-md">{{ $loadDocs->firstItem() + $loop->index }}</th>
                                                <td class="text-md">{{ $row->book_number }}</td>
                                                <td class="text-md">{{ $row->government_name }}</td>
                                                <td class="text-md">{{ $row->docs_name }}</td>
                                                <td class="text-md">{{ $row->docs_detail }}</td>
                                                <td class="text-md">{{ $row->type_name }}</td>
                                                <td class="text-md">{{ $row->docs_date }}</td>
                                             
                                                <td class="text-md"> <button type="button" class="btn btn-info "
                                                        data-toggle="modal" data-target="#info{{ $row->docs_id }}">
                                                        info
                                                    </button></td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{-- {!! $loadDocs->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- add --}}
    <div class="modal fade " id="deanDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">ส่งข้อความ</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb--2">
                        <form action="{{ route('addMessenger') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                              
                              
                                <div class="col-md-12">
                                    <div class="form-group mt--3">
                                        <input type="text" class="form-control" name="docs_name"
                                            placeholder="ชื่อเรื่อง" required>
                                    </div>
                                </div>
                             
                                <div class="col-md-12">
                                    <div class="form-group mt--3">
                                        <input type="date" class="form-control" name="docs_date"
                                            placeholder="วันที่เอกสาร" required>
                                    </div>
                                </div>
                              
                                <div class="col-md-12">
                                    <div class="form-group mt--3">
                                        <input type="file" class="form-control" id="path_data" name="path_data" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mt--2">
                                    <div class="form-group mt--2">
                                        <select class="form-control selectpicker" id="permission" name="permission[]"
                                            multiple >
                                            <option selected disabled>สิทธิ์การเข้าถึง</option>
                                            @foreach ($permission as $row)             
                                                <option value="{{ $row->permission_id }}">{{ $row->permission_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12"  >
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
    {{-- info --}}
    @foreach ($loadDocs as $rows)
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
@endsection
@push('js')
<script type='text/javascript'>
    $('#permission').change(function() {
        if ($(this).val() != '') {
            var select = $(this).val();
            if (select[0] == 6) {
                console.log(select);
                let selectBranch = `
                            <label for="selectRecipient">เลือกรายการ</label>
                            <select name="selectRecipient[]" id="selectRecipient" class="form-control select2-multiple" data-select2-id="1" tabindex="-1"
                                aria-hidden="true" multiple="" >                                                                                                                                                                
                            </select>
                        `;
                document.querySelector('#select_permission').innerHTML = selectBranch;
                var data = {!! json_encode($user->toArray()) !!};
                let formOption = `<option value="">--เลือกรายชื่ออาจารย์--</option>`;
                for (let i = 0; i < data.length; i++) {
                    formOption +=
                        `<option value='${data[i].id}'>${data[i].fname_TH} ${data[i].lname_TH}</option>`;
                }
                $('.select2-multiple').select2({
                    placeholder: "Select",
                    allowClear: true
                });
                document.querySelector('#selectRecipient').innerHTML = formOption;

            }
            if (select[0] == 2) {
                console.log(select);
                let selectBranch = `
                            <label for="selectRecipient">เลือกรายการ</label>
                            <select name="selectRecipient[]" id="selectRecipient" class="form-control select2-multiple" data-select2-id="1" tabindex="-1"
                                aria-hidden="true" multiple="" >                                                                                                                                                                
                            </select>
                        `;
                document.querySelector('#select_permission').innerHTML = selectBranch;
                var data = {!! json_encode($branch->toArray()) !!};

                let formOption = `<option value="">--เลือกสาขา--</option>`;
                for (let i = 0; i < data.length; i++) {
                    formOption +=
                        `<option value='${data[i].branch_id}'>${data[i].branch_name}</option>`;
                }
                $('.select2-multiple').select2({
                    placeholder: "Select",
                    allowClear: true
                });

                document.querySelector('#selectRecipient').innerHTML = formOption;

            }


            console.log(select)
        }

    });
</script>


<script>
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('homeDean.ajax') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'Nomor'
                },
                {
                    data: 'book_number',
                    name: 'book_number'
                },
                {
                    data: 'government_name',
                    name: 'government_name'
                },
                {
                    data: 'docs_name',
                    name: 'docs_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'type_name',
                    name: 'type_name'
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
