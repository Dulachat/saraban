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
                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <table class="table ">
                                        <thead class="thead text-monospace ">
                                            <tr>
                                                <th scope="col" colspan="" class="text-sm">ลำดับ</th>
                                                <th scope="col" colspan="" class="text-sm">ชื่อส่วนราชการ</th>
                                                <th scope="col" colspan="" class="text-sm">ชื่อเอกสาร</th>
                                                <th scope="col" colspan="" class="text-sm">วันที่</th>
                                                <th scope="col" colspan="" class="text-sm">เพิ่มเติม</th>


                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach ($DocsAll as $row)
                                                <tr>
                                                    <th class="text-md">{{ $DocsAll->firstItem() + $loop->index }}</th>
                                                    <td class="text-md">{{ $row->government_name }}</td>
                                                    <td class="text-md">{{ $row->docs_name }}</td>
                                                    <td class="text-md">{{ $row->docs_date }}</td>
                                                    <td class="text-md"> <button type="button" class="btn btn-info "
                                                            data-toggle="modal" data-target="#info{{ $row->docs_id }}">
                                                            info
                                                        </button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $DocsAll->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- reactive --}}

    {{-- info --}}
    @foreach ($DocsAll as $rows)
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
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
