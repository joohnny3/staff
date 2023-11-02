@extends('layouts.app')

@section('content')
 
    {{-- staff data --}}
    <div class="row mt-3 mx-2 d-flex justify-content-center">
        @foreach ($data as $staff)
            <div class="col-sm-2 mx-2">
                <div class="card card-primary">
                    <div class="card-header d-flex">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('staff.show', ['staff' => $staff]) }}">
                                <h3 class="card-title">{{ $staff->name }}</h3>
                            </a>
                            <div class="d-flex">
                                <a href="{{ route('staff.edit', ['staff' => $staff]) }}"
                                    class="btn btn-sm btn-warning mx-2">Edit</a>
                                <button type="button" class="btn-danger btn-sm btn mx-2" data-toggle="modal"
                                    data-target="#exampleModal-{{ $staff->id }}">
                                    Dele
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $staff->phone }}
                    </div>
                    <div class="card-footer">
                        {{ $staff->address }}
                    </div>
                </div>
            </div>


            <!-- Button trigger modal -->
            <form action="{{ route('staff.destroy', $staff->id) }}" method="POST">
                @csrf
                @method('DELETE')
                {{-- <button type="submit" class="btn-danger btn-sm btn mx-2">Dele</button> --}}
                <div class="modal fade" id="exampleModal-{{ $staff->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                確定刪除嗎？
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Modal -->
        @endforeach
    </div>

        <div class="mt-5 justify-content-end d-flex mx-3">
            <form action="{{ route('staff.index') }}" class="mx-2" method="GET">
                <label for="">輸入每頁顯示幾筆資料</label>
                <input type="text" name="perPage" class="btn btn-secondary mx-2">
                <button type="submit" class="btn btn-secondary mx-2">submit</button>
            </form>
            {{ $data->appends(['perPage' => $perPage])->links('vendor.pagination.bootstrap-4') }}
        </div>
@endsection
