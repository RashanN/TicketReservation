
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="container max-w-md mx-auto bg-white rounded-xl shadow-lg p-8 fade-in">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Check-In Confirmation</h1>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <p class="text-gray-600 text-sm mb-2">Coupon Code:</p>
                <p class="text-2xl font-bold text-gray-800 break-all">{{ $coupen->id }}</p>
            </div>

            <form action="{{ route('confirm.checkin') }}" method="POST" class="mb-6">
                @csrf
               
                <input type="hidden" name="coupen_id" value="{{ $coupen->id}}">
                <button type="submit" 
                    class="w-full py-3 px-6 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Confirm Check-In
                </button>
            </form>

            @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 fade-in" role="alert">
                {{ session('success') }}
            </div>
            @elseif (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 fade-in" role="alert">
                {{ session('error') }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>