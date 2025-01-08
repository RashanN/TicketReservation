<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .checkout-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .form-control {
            border-radius: 8px;
        }
        .checkout-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            margin: -30px -30px 30px;
            padding: 20px 30px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="checkout-container">
                    <div class="checkout-header">
                        <h2 class="mb-0">Complete Your Purchase</h2>
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action=" {{ route('payment.process') }} " method="POST" id="checkoutForm" novalidate>
                        @csrf
                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Name</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    value="{{ old('first_name', $name ?? '') }}" 
                                    required>
                                <div class="invalid-feedback">Name is required</div>
                            </div>
                           
                            
                            <!-- Contact Information -->
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email"   value="{{ old('email', $email ?? '') }}" required>
                                <div class="invalid-feedback">Valid email is required</div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone"  value="{{ old('phone', $phone ?? '') }}"  required>
                                <div class="invalid-feedback">Phone number is required</div>
                            </div>
                            
                         
                        
                            <!-- Payment Information -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control" name="card_number" 
                                           placeholder="1234 5678 9012 3456" required>
                                    <div class="invalid-feedback">Card number is required</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-12 mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" name="expiry" 
                                       placeholder="MM/YY" required>
                                <div class="invalid-feedback">Expiry date is required</div>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" name="cvv" 
                                       placeholder="123" required>
                                <div class="invalid-feedback">CVV is required</div>
                            </div>
                            
                            <!-- Order Summary -->
                            <div class="col-12">
                                <div class="order-summary">
                                    <h4 class="mb-3">Order Summary</h4>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total</span>
                                        <span>LKR{{ $grandTotal }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Pay Now 
                            </button>
                        </div>
                        <input type="hidden" name="total" value="{{ $grandTotal }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript for Form Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
            
            // Credit card formatting
            document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formatted = value.replace(/(.{4})/g, '$1 ').trim();
                e.target.value = formatted;
            });
            
            // Expiry date formatting
            document.querySelector('input[name="expiry"]').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }
                e.target.value = value;
            });
        });
    </script>
</body>
</html>
