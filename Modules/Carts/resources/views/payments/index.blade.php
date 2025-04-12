<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }

        .container {
            text-align: center;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .success-icon {
            width: 64px;
            height: 64px;
            margin-bottom: 1rem;
        }

        h1 {
            color: #333;
            margin-bottom: 1rem;
        }

        .countdown {
            font-size: 1.5rem;
            color: #666;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="display: flex; flex-direction: column; align-items: center;gap: 2rem">
            <a href="{{ route('payments.success', $paymentAttempt) }}">go to success</a>

            <a href="{{ route('payments.failed', $paymentAttempt) }}">go to failed</a>
        </div>
    </div>

    <script></script>
</body>

</html>
