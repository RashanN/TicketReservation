<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Reservation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Arial', sans-serif;
        }

        .reservation-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 40px;
            margin-top: 50px;
            border-left: 5px solid #007bff;
            transition: all 0.3s ease;
        }

        .reservation-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            transition: color 0.3s ease;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="reservation-container">
                    <h2 class="text-center mb-4 text-primary">Ticket Reservation</h2>
                    
                    <form action="{{ route('buy.tickets') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       required>
                                <div class="error-message" id="nameError">
                                    Please enter your full name
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       required>
                                <div class="error-message" id="emailError">
                                    Please enter a valid email address
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nic" class="form-label">NIC Number</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nic" 
                                       name="nic" 
                                       required>
                                <div class="error-message" id="nicError">
                                    Please enter your NIC number
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone" 
                                       required>
                                <div class="error-message" id="phoneError">
                                    Please enter your phone number
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company" class="form-label">Company Name (Optional)</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="company" 
                                       name="company">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="designation" class="form-label">Designation (Optional)</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="designation" 
                                       name="designation">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tickets" class="form-label">Number of Tickets</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="tickets" 
                                   name="tickets" 
                                   min="1" 
                                   value="1" 
                                   required>
                            <div class="error-message" id="ticketsError">
                                Please enter number of tickets
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="total" class="form-label">Total</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="total" 
                                       name="total" 
                                       readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="discount" 
                                       name="discount" 
                                       readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="grandTotal" class="form-label">Grand Total</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="grandTotal" 
                                       name="grandTotal" 
                                       readonly>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Reserve Tickets
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reservationForm');
            const requiredFields = form.querySelectorAll('[required]');

            // Validation function
            function validateField(field) {
                const errorElement = document.getElementById(`${field.id}Error`);
                
                if (field.value.trim() === '') {
                    field.classList.add('is-invalid');
                    errorElement.style.opacity = '1';
                    return false;
                } else {
                    field.classList.remove('is-invalid');
                    errorElement.style.opacity = '0';
                    
                    // Additional specific validations
                    if (field.type === 'email') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(field.value)) {
                            field.classList.add('is-invalid');
                            errorElement.style.opacity = '1';
                            return false;
                        }
                    }
                    
                    if (field.type === 'tel') {
                        const phoneRegex = /^[0-9]{10}$/;
                        if (!phoneRegex.test(field.value.replace(/\s/g, ''))) {
                            field.classList.add('is-invalid');
                            errorElement.style.opacity = '1';
                            return false;
                        }
                    }
                }
                return true;
            }

            // Add real-time validation
            requiredFields.forEach(field => {
                field.addEventListener('input', function() {
                    validateField(this);
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let isValid = true;
                requiredFields.forEach(field => {
                    if (!validateField(field)) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    // Here you would typically send the form data via AJAX
                    alert('Form is valid! Ready to submit.');
                    
                    // Example AJAX submission (you'd replace with your actual submission logic)
                    // fetch('/your-submission-route', {
                    //     method: 'POST',
                    //     body: new FormData(form)
                    // })
                    // .then(response => response.json())
                    // .then(data => {
                    //     // Handle successful submission
                    // })
                    // .catch(error => {
                    //     // Handle errors
                    // });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const ticketsInput = document.getElementById('tickets');
            const totalInput = document.getElementById('total');
            const discountInput = document.getElementById('discount');
            const grandTotalInput = document.getElementById('grandTotal');

            // Function to calculate Total, Discount and Grand Total
            function calculateTotal() {
                const ticketPrice = 35000;
                const numTickets = parseInt(ticketsInput.value, 10);
                
                if (isNaN(numTickets) || numTickets <= 0) {
                    totalInput.value = '0';
                    discountInput.value = '0';
                    grandTotalInput.value = '0';
                    return;
                }

                const total = numTickets * ticketPrice;
                totalInput.value = total;

                // Check if date is before 2025-01-01 for 10% discount
                const currentDate = new Date();
                const discountDate = new Date('2025-01-01');
                let discount = 0;

                if (currentDate < discountDate) {
                    discount = total * 0.1;
                }

                discountInput.value = discount;
                grandTotalInput.value = total - discount;
            }

            // Event listener to recalculate when tickets are changed
            ticketsInput.addEventListener('input', calculateTotal);

            // Initialize calculation
            calculateTotal();
        });
    </script>
</body>
</html>