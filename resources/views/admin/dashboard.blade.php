<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --light-bg: #f4f7fa;
            --text-color: #2c3e50;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: var(--text-color);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(to bottom right, var(--primary-color), var(--secondary-color));
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu a {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            text-decoration: none;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-menu a i {
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }

        .content-wrapper {
            margin-left: 260px;
            transition: all 0.3s;
            padding: 20px;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 20px;
        }

        .dashboard-cards .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .dashboard-cards .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-icon {
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            padding: 15px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow-x: hidden;
            }
            .content-wrapper {
                margin-left: 0;
            }
        }

        .chart-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <h3 class="mb-0">Admin Panel</h3>
        </div>
        <div class="sidebar-menu">
            <a href="#" class="active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.ticket') }}">
                <i class="fas fa-users"></i> Reservation
            </a>
            {{-- <a href="#">
                <i class="fas fa-chart-bar"></i> Analytics
            </a>
            <a href="#">
                <i class="fas fa-cog"></i> Settings
            </a> --}}
         
        </div>
    </div>

    <div class="content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="btn btn-outline-primary me-3 d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <form class="d-flex flex-grow-1">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
                {{-- <div class="ms-3 dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="User">
                        <span>John Doe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div> --}}
            </div>
        </nav>

        <div class="row dashboard-cards mt-4">
            <div class="col-md-4">
                <div class="card text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Reserved Tickets</h5>
                                <h2> {{ $totalTickets }}</h2>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white" style="background: linear-gradient(to right, #11998e, #38ef7d);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Revenue</h5>
                                <h2 class="card-text">{{$totalPrice}}</h2>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white" style="background: linear-gradient(to right, #ff5f6d, #ffc371);">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Incentive</h5>
                                <h2 class="card-text">{{$totalIncentive}}</h2>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-shopping-cart fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h4 class="mb-4 text-center">Sales Overview</h4>
        
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input 
                            type="text" 
                            id="searchInput" 
                            class="form-control" 
                            placeholder="Search by name or other fields" 
                            onkeyup="filterTable()"
                        />
                    </div>
                    <div class="col-md-3">
                        <select id="paymentStatusFilter" class="form-select" onchange="filterTable()">
                            <option value="">Filter by Payment Status</option>
                            <option value="0">Unpaid</option>
                            <option value="1">Paid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="issuedStatusFilter" class="form-select" onchange="filterTable()">
                            <option value="">Filter by Issued Status</option>
                            <option value="0">Not Issued</option>
                            <option value="1">Issued</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-secondary w-100" onclick="resetFilters()">Clear</button>
                    </div>
                </div>
            </div>
        
        <div style="height: 100vh; overflow-y: auto; padding: 10px; background-color: #ffffff; border-radius: 5px;">
            <table id="reservationTable" class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Ticket ID</th>
                        <th>Member Name</th>
                        <th>Member Email</th>
                        <th>Number of Tickets</th>
                        <th>Total Price</th>
                        <th>Discount Price</th>
                        <th>Date</th>
                        <th>Payment Status</th>
                        <th>QR Generate</th>
                        <th>Issued Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                        <tr>
                            <td class="text-center">{{ $ticket->id }}</td>
                            <td>{{ $ticket->member->name }}</td>
                            <td>{{ $ticket->member->email }}</td>
                            <td class="text-center">{{ $ticket->Numberof_ticket }}</td>
                            <td class="text-end">{{ $ticket->TotalPrice }}</td>
                            <td class="text-end">{{ $ticket->DiscountPrice }}</td>
                            <td class="text-center">{{ $ticket->Date }}</td>
                            <td class="text-center">
                                @if ($ticket->PaymentStatus == '0')
                                    <form action="{{ route('admin.update.payment.status', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to change the payment status for this ticket?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0">
                                            <i class="fas fa-times-circle text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Done</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (\App\Models\CoupenCode::where('ticket_id', $ticket->id)->exists())
                                    <span class="badge bg-success">QR Codes Generated</span>
                                @else
                                    <button class="btn btn-primary" onclick="generateQRCode({{ $ticket->id }}, {{ $ticket->Numberof_ticket }})">
                                        Generate QR Codes       
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($ticket->IssuedStatus == '0')
                                    <form action="{{ route('admin.update.issued.status', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to issue this ticket?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0">
                                            <i class="fas fa-times-circle text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Done</span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                <form action="{{ route('admin.delete.ticket', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Bootstrap JS and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
        <script>
       function filterTable() {
    const searchInput = document.getElementById("searchInput")?.value.toLowerCase() || ""; // Ensure searchInput exists
    const paymentStatus = document.getElementById("paymentStatusFilter").value;
    const issuedStatus = document.getElementById("issuedStatusFilter").value;

    const table = document.getElementById("reservationTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
        const cells = rows[i].getElementsByTagName("td");

        // Get the relevant values from table cells
        const name = cells[1]?.textContent.trim().toLowerCase() || ""; // Member Name

        // Determine payment status based on icon or badge
        const paymentStatusCell = cells[7];
        const paymentStatusIcon = paymentStatusCell.querySelector("i");
        const paymentStatusBadge = paymentStatusCell.querySelector(".badge");

        let currentPaymentStatus = "";
        if (paymentStatusIcon) {
            currentPaymentStatus = "0"; // Unpaid if the icon exists
        } else if (paymentStatusBadge && paymentStatusBadge.textContent.trim().toLowerCase() === "done") {
            currentPaymentStatus = "1"; // Paid if the badge text says "Done"
        }

        // Determine issued status based on icon or badge
        const issuedStatusCell = cells[9];
        const issuedStatusIcon = issuedStatusCell.querySelector("i");
        const issuedStatusBadge = issuedStatusCell.querySelector(".badge");

        let currentIssuedStatus = "";
        if (issuedStatusIcon) {
            currentIssuedStatus = "0"; // Not Issued if the icon exists
        } else if (issuedStatusBadge && issuedStatusBadge.textContent.trim().toLowerCase() === "done") {
            currentIssuedStatus = "1"; // Issued if the badge text says "Done"
        }

        let isVisible = true;

        // Apply search filter
        if (searchInput && !name.includes(searchInput)) {
            isVisible = false;
        }

        // Apply payment status filter
        if (paymentStatus && currentPaymentStatus !== paymentStatus) {
            isVisible = false;
        }

        // Apply issued status filter
        if (issuedStatus && currentIssuedStatus !== issuedStatus) {
            isVisible = false;
        }

        // Toggle row visibility
        rows[i].style.display = isVisible ? "" : "none";
    }
}

function resetFilters() {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) searchInput.value = "";

    document.getElementById("paymentStatusFilter").value = "";
    document.getElementById("issuedStatusFilter").value = "";

    filterTable(); // Reapply the filter
}




function generateQRCode(ticketId, numberOfTickets) {
        // Create a container for QR codes
        const qrContainer = document.createElement('div');
        qrContainer.classList.add('qr-container');
        document.body.appendChild(qrContainer);

        // Loop through the number of tickets and generate QR codes
        for (let i = 0; i < numberOfTickets; i++) {
            const uniqueCode = 'COUPON_' + Math.random().toString(36).substr(2, 9); // Generate unique code
            const qrUrl = '/confirm-checking?code=' + uniqueCode; // URL for the QR code

            const qrCanvas = document.createElement('canvas');
            qrContainer.appendChild(qrCanvas);

            // Generate the QR code
            QRCode.toCanvas(qrCanvas, qrUrl, function (error) {
                if (error) console.error(error);
                console.log('QR Code generated for ' + uniqueCode);

                // After QR Code is generated, send it to the server
                sendQRCodeToServer(ticketId, uniqueCode, qrCanvas.toDataURL('image/png'));
            });
        }
    }

    // Function to send QR Code data to the server
    function sendQRCodeToServer(ticketId, uniqueCode, qrImageData) {
        fetch('/save-qr-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                ticketId: ticketId,
                uniqueCode: uniqueCode,
                qrImageData: qrImageData
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('QR code saved successfully:', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    

        </script>
        
        
</x-app-layout>
