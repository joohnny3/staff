<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Resignation List</title>
    <style>
        body {
            font-family: 'Microsoft JhengHei', sans-serif;
            font-size: 10pt;
        }
        table {
            width: 35%;
            border-collapse: collapse;
        }
        th, td {
            border: 0.5pt solid black;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #C6E0B4;
        }
        .leave-date {
            background-color: #D9D9D9;
        }
        .last-working-day {
            background-color: #FCE4D6;
            font-weight: bold;
        }
        .last-working-day.note-present {
            color: red;
        }
        .sign {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<p>Dear all,</p>
<p>近期離職名單如下，共計 {{ count($content->resignations) }} 位，請留意最後工作日，並協助當日離退移交流程，謝謝！</p>

<table>
    <thead>
    <tr>
        <th>員編</th>
        <th>姓名</th>
        <th>英文姓名</th>
        <th>部門</th>
        <th class="leave-date">離職日</th>
        <th class="last-working-day">最後工作日</th>
        <th>備註</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($content->resignations as $resignation)
        <tr>
            <td>{{ $resignation->employee_id }}</td>
            <td>{{ $resignation->name }}</td>
            <td>{{ $resignation->name_en }}</td>
            <td>{{ $resignation->department }}</td>
            <td class="leave-date">{{ $resignation->resignation_date }}</td>
            <td class="{{ $resignation->note ? 'last-working-day note-present' : 'last-working-day' }}">
                {{ $resignation->last_working_day }}</td>
            <td>{{ $resignation->note }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="sign">
    <p>--</p>
    <p>Best Regards,</p>
    <p>JS-Adways HR</p>
</div>
</body>
</html>
