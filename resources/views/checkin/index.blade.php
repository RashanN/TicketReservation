<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-pink-50 min-h-screen p-4">
    <div class="container mx-auto max-w-7xl">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ auth()->user()->role === 'superadmin' ? route('admin.dashboard') : route('dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to {{ auth()->user()->role === 'admin' ? 'Admin' : '' }} Dashboard
            </a>
        </div>

        <!-- Header -->
        <div class="gradient-header rounded-t-xl shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-white text-center">Check-ins Dashboard</h1>
            <p class="text-indigo-100 text-center mt-2">Manage and track all check-in records</p>
        </div>

        <!-- Rest of the content remains the same -->
        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-purple-600 rounded-lg shadow-lg p-4 text-white text-center animate-fade-in">
                <h3 class="text-lg font-semibold">Total Check-ins</h3>
                <p class="text-2xl font-bold">{{ $checkins->total() }}</p>
            </div>
            <div class="bg-blue-600 rounded-lg shadow-lg p-4 text-white text-center animate-fade-in" style="animation-delay: 0.1s">
                <h3 class="text-lg font-semibold">Today's Check-ins</h3>
                <p class="text-2xl font-bold">{{ $checkins->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</p>
            </div>
            <div class="bg-indigo-600 rounded-lg shadow-lg p-4 text-white text-center animate-fade-in" style="animation-delay: 0.2s">
                <h3 class="text-lg font-semibold">Active Members</h3>
                <p class="text-2xl font-bold">{{ $checkins->unique('member_id')->count() }}</p>
            </div>
        </div>

        <!-- Table for desktop -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white">
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Day 1</th>
                            <th class="px-6 py-4 text-left">Ticket</th>
                            <th class="px-6 py-4 text-left">Member</th>
                            <th class="px-6 py-4 text-left">Coupon</th>
                            <th class="px-6 py-4 text-left">Created At</th>
                            <th class="px-6 py-4 text-left">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkins as $checkin)
                        <tr class="hover:bg-indigo-50 transition-colors duration-150 ease-in-out animate-fade-in">
                            <td class="px-6 py-4 text-indigo-600 font-semibold">#{{ $checkin->id }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full">{{ $checkin->day1 }}</span>
                            </td>
                            <td class="px-6 py-4 text-purple-600">{{ $checkin->ticket_id }}</td>
                            <td class="px-6 py-4 text-blue-600">{{ $checkin->member_id }}</td>
                            <td class="px-6 py-4 text-indigo-600">{{ $checkin->coupen_id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $checkin->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $checkin->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cards for mobile -->
            <div class="md:hidden space-y-4 p-4">
                @foreach($checkins as $checkin)
                <div class="card-gradient rounded-lg shadow-md p-4 space-y-3 animate-fade-in">
                    <div class="flex justify-between items-center border-b border-indigo-100 pb-2">
                        <span class="text-lg font-bold text-indigo-600">#{{ $checkin->id }}</span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">{{ $checkin->day1 }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-purple-50 rounded-lg p-2">
                            <p class="text-xs text-purple-500 font-medium">Ticket ID</p>
                            <p class="text-purple-700 font-semibold">{{ $checkin->ticket_id }}</p>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg p-2">
                            <p class="text-xs text-blue-500 font-medium">Member ID</p>
                            <p class="text-blue-700 font-semibold">{{ $checkin->member_id }}</p>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-lg p-2">
                            <p class="text-xs text-indigo-500 font-medium">Coupon ID</p>
                            <p class="text-indigo-700 font-semibold">{{ $checkin->coupen_id }}</p>
                        </div>
                        
                        <div class="bg-pink-50 rounded-lg p-2">
                            <p class="text-xs text-pink-500 font-medium">Created</p>
                            <p class="text-pink-700 font-semibold">{{ $checkin->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-200">
                {{ $checkins->links() }}
            </div>
        </div>
    </div>
</body>
</html>