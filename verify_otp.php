<?php
session_start();

// Your Twilio credentials
$accountSid = 'AC8b9c1d4098956b8dda46807103de62d0';
$authToken = '4dbb8ec3185828e8797fdc2bb24abb26';
$verifySid = 'VA4bcdcd47c24182eb7f86b71d6a668741';

// Get data
$phone = $_SESSION['phone'] ?? null;
$otpCode = $_POST['otp_code'] ?? null;

// Fail early if missing
if (!$phone || !$otpCode) {
    die('Phone number or OTP is missing.');
}

// Verify OTP with Twilio
$url = "https://verify.twilio.com/v2/Services/$verifySid/VerificationCheck";
$data = http_build_query([
    'To' => $phone,
    'Code' => $otpCode
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

// ✅ REDIRECT if verified
if (!empty($response['status']) && $response['status'] === 'approved') {
    header("Location: home1.php");
    exit;
}

// ❌ Show error
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OTP Verification | BlaqMerchandise</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f8f8;
      text-align: center;
      padding-top: 50px;
    }
    .container {
      background: white;
      margin: auto;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 90%;
      max-width: 400px;
    }
    h2 {
      color: #e74c3c;
    }
    .details {
      margin-top: 20px;
      text-align: left;
      font-size: 12px;
      background: #f1f1f1;
      padding: 10px;
      border-radius: 6px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>❌ OTP Verification Failed</h2>
  <p>Please check the code and try again.</p>

  <div class="details">
    <strong>Debug Info:</strong>
    <pre><?php print_r($response); ?></pre>
  </div>
</div>

</body>
</html>
