    <!DOCTYPE html>
    <html>
    <head>
    <title>Holiday Request Status Update</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        }
        .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
        background-color: #f2f2f2;
        padding: 10px;
        text-align: center;
        }
        .content {
        padding: 20px;
        }
        .footer {
        background-color: #f2f2f2;
        padding: 10px;
        text-align: center;
        }
    </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
        <h2>Holiday Request Status Update</h2>
        </div>
        <div class="content">
        <p>Dear {{ $requestUserDetails->name }},</p>
        <p>We have reviewed your holiday request for {{ $holiday->day }}.</p>
        <p><strong>Status:</strong> {{ $holiday->type }}</p>
        @if($holiday->type == 'Approve')
            <p><span style="color: green;">Your holiday request has been approved.</span></p>
        @else
            <p><span style="color: red;">Your holiday request has been declined.</span></p>
        @endif
        <p>Please find the details of your request below:</p>
        <ul>
            <li>Requested Date: {{ $holiday->day }}</li>
            <li>Status: {{ $holiday->type }}</li>
        </ul>
        <p>If you have any questions or concerns, please do not hesitate to reach out to us.</p>
        </div>
        <div class="footer">
        <p>Best regards,</p>
        <p>{{ auth()->user()->name }}</p>
        </div>
    </div>
    </body>
    </html>
