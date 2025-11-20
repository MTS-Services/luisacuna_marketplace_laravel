<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            /* Light gray background */
        }

        /* Custom Failure color variables, mimicking the structure of the original success template */
        .text-failure {
            color: #dc2626;
            /* red-600 */
        }

        .bg-failure\/10 {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .badge-failure {
            background-color: #fee2e2;
            /* red-100 */
            color: #b91c1c;
            /* red-700 */
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            /* sm */
        }

        /* General Tailwind button styles */
        .btn {
            @apply font-semibold py-3 px-6 rounded-xl transition duration-200 ease-in-out text-center;
        }

        .btn-primary {
            @apply bg-gray-800 text-white hover:bg-gray-700 shadow-lg shadow-gray-500/50;
        }

        .btn-danger {
            @apply bg-red-600 text-white hover:bg-red-700 shadow-md shadow-red-500/50;
        }

        .btn-outline {
            @apply border border-gray-300 text-gray-700 hover:bg-gray-100;
        }

        /* Responsive full-width buttons on mobile */
        @media (max-width: 640px) {
            .btn {
                @apply w-full;
            }
        }
    </style>
</head>

<body>

    <div class="max-w-2xl mx-auto my-12 p-4 sm:p-8">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 text-center">

            <!-- Failure Icon (X Mark) -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-failure/10 rounded-full flex items-center justify-center">
                    <!-- Heroicon X-mark for error/failure -->
                    <svg class="w-12 h-12 text-failure" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- Failure Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Payment Failed
            </h1>

            <p class="text-gray-600 mb-8">
                We couldn't process your payment. Please check your card details or try a different method.
            </p>

            <!-- Transaction Details (Using mock data placeholders) -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-semibold text-gray-800">#TRN-938102</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Amount Attempted:</span>
                        <span class="font-bold text-xl text-gray-800">$149.99</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status:</span>
                        <span class="badge-failure">DECLINED</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Error Code:</span>
                        <span class="font-medium text-failure">Insufficient Funds</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <!-- Primary Action: Retry -->
                <a href="#" class="btn btn-danger">
                    Retry Payment
                </a>
                <!-- Secondary Action: Contact Support or Update Details -->
                <a href="#" class="btn btn-outline">
                    Contact Support
                </a>
            </div>

            <p class="mt-8 text-sm text-gray-500">
                You can also return to the <a href="#"
                    class="text-gray-700 hover:text-gray-900 font-medium underline">checkout page</a> to update your
                information.
            </p>

        </div>
    </div>

</body>

</html>
