<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Mail with Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .important-notice {
            background-color: #f9f9f9;
            border-left: 4px solid #ffcc00;
            margin-top: 20px;
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>測試信件</h1>
<p>寄件人 {{ $content->name }} </p>
<p>這是一封主管發送的測試郵件，其中包含一個簡單的表格</p>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>對內CUE編號</th>
        <th>產品線</th>
        <th>產品</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>{{ $content->phone }}</td>
        <td>豐富產品</td>
        <td>UNICORN</td>
    </tr>
    <tr>
        <td>2</td>
        <td>161-2469</td>
        <td>小編</td>
        <td>廣告素材</td>
    </tr>
    <tr>
        <td>3</td>
        <td>162-3585</td>
        <td>網紅業配</td>
        <td>寫手</td>
    </tr>
    </tbody>
</table>
<div class="important-notice">
    <strong>重要提示：</strong>這是一個重要的提示文本。請確保閱讀並理解此信息。
</div>
<div>
    <p>這是示範郵件，展示Laravel 中嵌入圖片。</p>
    <img src="{{ $message->embed(storage_path('app/public/pokemon.jpeg')) }}" alt="pokemon">
</div>
</body>
</html>
