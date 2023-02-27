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

                                <h1>จัดการข้อมูลเอกสาร</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                            role="tab" aria-controls="home" aria-selected="true">จัดการเอกสาร</a>
                                    </li>


                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @include('document.tabs.tabs1')

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

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
                        ajax: "{{ route('generalDocs.ajax') }}",
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

            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        @endpush
    @endsection
