<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Resignation List</title>
    <style>
        body {
            font-family: '微軟正黑體', sans-serif;
            font-size: 10pt;
        }
        table {
            width: 551px;
            border-collapse: collapse;
        }
        th, td {
            border: 0.5pt solid black;
            padding: 2.78px;
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
        .employee-id { width: 55px; }
        .name { width: 51px; }
        .name-en { width: 65px; }
        .department { width: 115px; }
        .resignation-date, .last-working-day { width: 85px; }
        .note { width: 95px; }
    </style>
</head>
<body>
<p>Dear all,</p>
<p>近期離職名單如下，共計 {{ count($content->resignations) }} 位，請留意<b style="font-weight: bold; color: #0000FF;">最後工作日</b>，並協助當日離退移交流程，謝謝！</p>

<table>
    <thead>
    <tr>
        <th class="employee-id">員編</th>
        <th class="name">姓名</th>
        <th class="name-en">英文姓名</th>
        <th class="department">部門</th>
        <th class="resignation-date leave-date">離職日</th>
        <th class="last-working-day">最後工作日</th>
        <th class="note">備註</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($content->resignations as $resignation)
        <tr>
            <td class="employee-id">{{ $resignation->employee_id }}</td>
            <td class="name">{{ $resignation->name }}</td>
            <td class="name-en">{{ $resignation->name_en }}</td>
            <td class="department">{{ $resignation->department }}</td>
            <td class="resignation-date leave-date">{{ $resignation->resignation_date }}</td>
            <td class="{{ $resignation->note ? 'last-working-day note-present' : 'last-working-day' }}">
                {{ $resignation->last_working_day }}</td>
            <td class="note">{{ $resignation->note }}</td>
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
