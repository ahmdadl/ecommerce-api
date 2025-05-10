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
        <svg class="success-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" stroke="#28a745" stroke-width="2" />
            <path d="M8 12l2.5 2.5L16 9" stroke="#28a745" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <h1>Payment Successful!</h1>
        <p>Thank you for your purchase.</p>
        <div class="countdown">Redirecting in <span id="countdown">5</span> seconds...</div>
    </div>

    <script>
        function afterDone() {
            console.log("Countdown complete!");
            // Add your redirect or other logic here
            // For example: window.location.href = 'https://your-redirect-url.com';
            window.location.href = "{{ url('payments/' . $paymentAttempt->id . '/after-success') }}";
        }

        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            countdown -= 1;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                afterDone();
            }
        }, 1000);
    </script>
</body>

</html>
