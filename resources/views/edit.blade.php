@extends('layouts.app')

@section('content')
    {{-- Form --}}
    <div class="container mt-3">
        <h2>Edit Staff</h2>
        <br>
        <table class="table">
            <form action="{{ route('staff.update', ['staff' => $data['id']]) }}" method="post">
                @csrf
                @method('PUT')
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                                <input class="btn btn-light" type="text" name="name" value="{{ $data->name }}">
                        </td>
                        <td>
                            <input class="btn btn-light" type="text" name="phone" value="{{ $data->phone }}">
                        </td>
                        <td>
                            <input class="btn btn-light" type="text" name="address" value="{{ $data->address }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-light" type="submit">Submit</button>
                        </td>
                    </tr>
                </tbody>
            </form>
        </table>
    </div>
@endsection
