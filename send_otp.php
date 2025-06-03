<?php
session_start();

$accountSid = 'AC8b9c1d4098956b8dda46807103de62d0';
$authToken = '4dbb8ec3185828e8797fdc2bb24abb26';
$verifySid = 'VA4bcdcd47c24182eb7f86b71d6a668741';

$phone = $_POST['countryCode'] . $_POST['phoneNumber'];
$_SESSION['phone'] = $phone;

$url = "https://verify.twilio.com/v2/Services/$verifySid/Verifications";
$data = http_build_query([
    'To' => $phone,
    'Channel' => 'sms'
]);

$options = [
    "http" => [
        "header"  => "Authorization: Basic " . base64_encode("$accountSid:$authToken") . "\r\n" .
                     "Content-type: application/x-www-form-urlencoded\r\n",
        "method"  => "POST",
        "content" => $data,
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OTP Sent | BlaqMerchandise</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f1f1f1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      text-align: center;
      width: 100%;
      max-width: 400px;
    }
    h2 {
      color: #333;
    }
    .status {
      margin: 20px 0;
      font-size: 18px;
    }
    input {
      width: 80%;
      padding: 12px;
      margin: 10px 0;
      font-size: 16px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      width: 85%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<div class="container">
<img src="images/logo.jpg.jpg" alt="BlaqMerchandise Logo" style="width: 120px; margin-bottom: 20px;">
  <h2>OTP Verification</h2>

  <?php if (!empty($response) && $response['status'] === 'pending'): ?>
    <div class="status">✅ OTP sent to <strong><?= htmlspecialchars($phone) ?></strong></div>
    <form action="verify_otp.php" method="POST">
      <input type="text" name="otp_code" placeholder="Enter OTP" required>
      <button type="submit">Verify OTP</button>
    </form>
  <?php else: ?>
    <div class="status" style="color:red;">❌ Failed to send OTP.</div>
    <pre><?= print_r($response, true) ?></pre>
  <?php endif; ?>
</div>
</body>
</html>
