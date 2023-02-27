@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt-3">

        <div class="row">
            <div class="card" style="width: 100%">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>เอกสารเข้าใหม่</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <table class="yajra-datatable">
                                        <thead class="thead text-monospace ">
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ที่</th>
                                                <th>ชื่อส่วนราชการ</th>
                                                <th>ชื่อเอกสาร</th>
                                                <th>วันที่</th>
                                                <th>ตอบรับเอกสาร</th>
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
                                                    <td class="text-md">{{ $row->docs_date }}</td>
                                                    <td class="text-md"> <button type="button" class="btn btn-success "
                                                            data-toggle="modal"
                                                            data-target="#Reactive{{ $row->reactive_id }}">
                                                            <i class="ni ni-check-bold"></i>
                                                        </button>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- reactive --}}
    @foreach ($loadDocs as $rows)
        <div class="modal fade " id="Reactive{{ $rows->reactive_id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered " role="government">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">ลงเลขรับหนังสือ</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt--2">
                                <div class="form-group mt--3">
                                    <form action="{{ route('updateReactive') }}">
                                        <input type="hidden" name="reactive_id" value="{{ $rows->reactive_id }}">
                                        <input type="hidden" name="docs_id" value="{{ $rows->docs_id }}">
                                        <input type="text" class="form-control" name="reactive_number"
                                            id="reactive_number">
                                        <br>
                                        <input type="submit" class="btn btn-success" style="float:right;" value="บันทึก"
                                            onclick="confirm('ยืนยันข้อมูล')">
                                    </form>

                                </div>
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
    @endforeach
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

<script>
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('homestaff.ajax') }}",
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
                    data: 'action',
                    name: 'action',
                
                },
                {
                    data: 'action2',
                    name: 'action2',
                    orderable: true,
                    searchable: true
                },

            ],
            destroy: true      
        });

    });
</script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
