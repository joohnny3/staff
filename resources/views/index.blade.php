@extends('layouts.app')

@section('content')
    {{-- staff data --}}
    <div class="row mt-3 mx-2 d-flex justify-content-center">
        @foreach ($data as $staff)
            <div class="col-sm-2 mx-2">
                <div class="card card-primary">
                    <div class="card-header d-flex">
                        <div class="d-flex align-items-center">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="staff_id[]" value="{{ $staff->id }}"
                                    class="form-check-input mr-2">
                            </div>

                            <a href="{{ route('staff.show', ['staff' => $staff]) }}">
                                <h3 class="card-title">{{ $staff->name }}</h3>
                            </a>
                            <div class="d-flex">
                                <a href="{{ route('staff.edit', ['staff' => $staff]) }}"
                                    class="btn btn-sm btn-warning mx-2">Edit</a>
                                <button type="button" class="btn-danger btn-sm btn mx-2"
                                    onclick="deleteStaff({{ $staff->id }})">Dele</button>
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
        @endforeach
    </div>

    <button type="button" class="btn btn-primary mx-2 mt-4" onclick="selectAll()">Select All</button>
    <button type="button" class="btn btn-secondary mx-2 mt-4" onclick="deselectAll()">Cancel All</button>
    <button type="button" class="btn btn-success mx-2 mt-4" onclick="excelDownload()">Download Excel</button>

    <form id="excelDownloadForm" method="POST" style="display: none">
        @csrf
    </form>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <div class="mt-5 justify-content-end d-flex mx-3">
        <form action="{{ route('staff.index') }}" class="mx-2" method="GET">
            <label for="">輸入每頁顯示幾筆資料</label>

            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="phone" value="{{ $phone }}">
            <input type="hidden" name="address" value="{{ $address }}">
            <input type="hidden" name="message" value="{{ $message }}">

            <input type="text" name="perPage" class="btn btn-secondary mx-2 bg-light" placeholder="{{ $perPage }}">
            <button type="submit" class="btn btn-primary mx-2">submit</button>
        </form>
        {{ $data->appends(['perPage' => $perPage, 'name' => $name, 'phone' => $phone, 'address' => $address, 'message' => $message])->links('components.pagination') }}
    </div>
@endsection

<script>
    function selectAll() {
        document.querySelectorAll('input[name="staff_id[]"]').forEach(function(checkbox) {
            checkbox.checked = true;
        });
    }

    function deselectAll() {
        document.querySelectorAll('input[name="staff_id[]"]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }

    function deleteStaff(staffId) {
        if (confirm('確定刪除嗎？')) {
            const deleteForm = document.querySelector('#deleteForm');
            deleteForm.action = '/staff/' + staffId;
            deleteForm.submit();
        }
    }

    function excelDownload() {
        const checkBoxs = document.querySelectorAll('input[name="staff_id[]"]:checked');
        const excelForm = document.querySelector('#excelDownloadForm');

        checkBoxs.forEach(function(checkbox) {
            const checkboxInput = document.createElement('input');
            checkboxInput.name = 'staff_id[]';
            checkboxInput.value = checkbox.value;
            excelForm.appendChild(checkboxInput);
        });

        excelForm.action = '/staff_export';
        excelForm.submit();
    }
</script>
