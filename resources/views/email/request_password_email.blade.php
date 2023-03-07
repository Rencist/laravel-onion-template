<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Account Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="background-color: #e9ecef;">
    <p>Silahkan klik kode dibawah ini untuk mengganti password akun anda.</p>
    <a href="{{ 'testing.com/forgot_password?token=' . $token  }}">
        {{ 'testing.com/forgot_password?=' . $token  }}
    </a>
</body>

</html>