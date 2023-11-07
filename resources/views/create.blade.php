@extends('layouts.app')

@section('content')
    {{-- Form --}}
    <div class="container mt-3">
        <h2>Add Staff</h2>
        <br>
        <table class="table">
            <form action="{{ route('staff.store') }}" method="post">
                @csrf
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
                            <input class="btn btn-light" type="text" name="name">
                        </td>
                        <td>
                            <input class="btn btn-light" type="text" name="phone">
                        </td>
                        <td>
                            <input class="btn btn-light" type="text" name="address">
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
