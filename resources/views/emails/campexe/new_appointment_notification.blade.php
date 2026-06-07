<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment Notification</title>
</head>
<body>
    <p>Dear {{ $campexeName }},</p>
    
    <p>A new Appointemnt is booked by patient name : {{ $userName }} </p>
    <p>Login to dashboard to view details and accept appointment</p>
    <a href="https://freestyle-libre.saarathihealthcare.com/login" style="padding: 20px 20px;color#ffffff;background-color:#000000;">Go to Dashboard</a>
    
    <p>Patient Detais</p>
    <ul>
        <li><strong>Date:</strong> {{ $scheduledate }}</li>
        <li><strong>Day:</strong> {{ $scheduleday }}</li>
        <li><strong>Timing:</strong> {{ $scheduletiming }}</li>
    </ul>
    
    <p>Regards,<br> Saarathi</p>
</body>
</html>