<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="bg-success text-white p-4 d-flex align-items-center">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
                        </div>
                        <div>
                            <h2 class="h4 mb-0">Reservation Confirmed</h2>
                            <p class="mb-0 small opacity-75">Your booking is now complete</p>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="bg-light rounded-3 p-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 text-muted">Reference Number</h5>
                                    <div class="h4 mb-0 text-dark font-monospace">
                                        {{ $referenceNumber }}
                                    </div>
                                </div>
                                <div>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        Confirmed
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 py-2">
                                    <i class="bi bi-speedometer me-2"></i>Dashboard
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.ticket') }}" class="btn btn-outline-secondary w-100 py-2">
                                    <i class="bi bi-cart me-2"></i>Reservations
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light text-center p-3">
                        <small class="text-muted">
                            Need assistance? Contact our support team at support@example.com
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>