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
                                    เพิ่มประเภทเอกสาร
                                </button>
                                <h1>จัดการประเภทเอกสาร</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table ">
                                    <thead class="thead text-monospace ">
                                        <tr>
                                            <th scope="col" colspan="" class="text-sm">ลำดับ</th>
                                            <th scope="col" colspan="" class="text-sm">ชื่อประเภทเอกสาร</th>
                                            <th scope="col" colspan="" class="text-sm">แก้ไข</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @foreach ($data_type as $row)
                                            <tr>
                                                <th class="text-md">{{ $data_type->firstItem() + $loop->index }}
                                                </th>
                                                <td class="text-md">{{ $row->type_name }}</td>
                                                <td class="text-md"> <button type="button" class="btn btn-warning "
                                                        data-toggle="modal" data-target="#editModal{{ $row->type_id }}">
                                                        edit
                                                    </button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- edit --}}
        @foreach ($data_type as $row)
            <div class="modal fade " id="editModal{{ $row->type_id }}" tabindex="-1" role="dialog"
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
                                    <form action="" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="type_name"
                                                value="{{ $row->type_name }}" placeholder="" required>
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
        @endforeach
    </div>
@endsection
