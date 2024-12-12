<!-- resources/views/emails/issued_ticket.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ticket Has Been Issued</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        .ticket-info {
            margin-bottom: 20px;
        }
        .ticket-info p {
            margin: 5px 0;
        }
        .images {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .images img {
            margin: 5px;
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Hello, {{ $memberName }}</h1>
    <p>Your ticket with ID <strong>{{ $ticketId }}</strong> has been issued.</p>

    <h3>QR Codes</h3>
    <ul>
        @foreach ($images as $image)
      
            <li>
                <img src="{{ asset($image) }}" alt="QR Code" style="width: 150px; height: 150px;">
            </li>
        @endforeach
    </ul>
    </div>
</body>
</html>
