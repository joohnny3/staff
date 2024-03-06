<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>社群快報</title>
</head>
<body>
<p>Dear JS 的大家，🎊 本月社群快報來囉🎊</p>

<p>以下為{{$content->month}}月精選案例 :</p>

@foreach ($content->cases as $item)
    <p>📍{{ $item }}</p>
@endforeach

<p>點選連結看更多 👉<a href="https://www.js-adways.com.tw/">社群創意案例月報</a></p>

<p>⚠️部分內容為機密數據，不能提供給客戶❗️</p>
<p>⚠️僅限JS內部及機器人廠商，也要提醒機器人廠商不能提供給客戶</p>

<p>如果有任何問題，請洽數位整合部社群組，感謝 !</p>

<p>Best regards,</p>
<p>JS Notify Bot</p>
<p>傑思‧愛德威媒體股份有限公司 <a href="https://www.js-adways.com.tw/">JS ADWAYS MEDIA INC.</a></p>
<p>Tel: +886 2-66380188 #188 | Fax: +886 2-66360166 | Email: <a href="mailto:johnny.chang@js-adways.com.tw">johnny.chang@js-adways.com.tw</a>
</p>
<p>21F., No.510, Sec. 5, Zhongxiao E. Rd., Xinyi Dist., Taipei City 110, Taiwan 110台北市信義區忠孝東路五段510號21樓</p>
<p>Taiwan / Japan / China / Hong Kong /Korea/ Singapore / Philippines / USA</p>
</body>
</html>
