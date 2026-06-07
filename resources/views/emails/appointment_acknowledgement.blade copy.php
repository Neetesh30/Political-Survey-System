<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor application appointment booked</title>
</head>
<body>
    <p>Your FreeStyle Libre sensor application appointment is successfully booked.</p>

    <p>Dear {{ $userName }},</p>
    
    <p>This is to acknowledge that your appointment has been successfully created for the following details:</p>
    
    <ul>
        <li><strong>Date:</strong> {{ $scheduledate }}</li>
        <li><strong>Day:</strong> {{ $scheduleday }}</li>
        <li><strong>Timing:</strong> {{ $scheduletiming }}</li>
    </ul>
    
    <p>Our team will get in touch with you shortly. Thank you for choosing our services.</p>
    
    <p>Now, monitor glucose on your smartphone. Prepare yourself for FreeStyle Libre sensor application.</p>
    
    <p>1 - Make sure the 'NFC' function is enabled in your phone.</p>
    
    <p>Android users: Check your phone's manual or go to the phone settings menu and look for settings
        related to NFC, Connections, Sharing or Wireless and networks.</p>
    
    <p>iPhone users: You must have iPhone 8 or higher and running iOS 15.5 or higher to utilize the NFC
        capability needed.</p>
    
    <p>2 - For optimal application and adhesion of the sensor, ensure your skin is bare and free from body hair.
        Watch the video here (https://www.youtube.com/watch?v=U_y3hvY-6Jw&amp;t=119s) to get started with
        FreeStyle Libre.</p>
    <p>Want to reschedule the appointment? <a href="https://freestyle-libre.saarathihealthcare.com/reschedule">Click here</a> </p>
    
    <p>Regards,<br> Saarathi</p>
   
    <p>Service provider of Abbott for FreeStyle Libre sensor application project</p>
</body>
</html>