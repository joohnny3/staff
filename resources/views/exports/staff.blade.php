<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $staff)
        <tr>
            <td>{{ $staff->name }}</td>
            <td>{{ $staff->phone }}</td>
            <td>{{ $staff->address }}</td>
        </tr>
    @endforeach
    </tbody>
</table>