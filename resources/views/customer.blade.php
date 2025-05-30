<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Import CSV - Webappfix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white shadow-lg rounded-xl w-full max-w-md p-6">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
                📥 Import Large CSV File
            </h1>

            @if ($message = Session::get('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="this.parentElement.parentElement.remove();" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"><title>Close</title><path
                                d="M14.348 5.652a1 1 0 0 0-1.414 0L10 8.586 7.066 5.652A1 1 0 1 0 5.652 7.066L8.586 10l-2.934 2.934a1 1 0 1 0 1.414 1.414L10 11.414l2.934 2.934a1 1 0 0 0 1.414-1.414L11.414 10l2.934-2.934a1 1 0 0 0 0-1.414z" /></svg>
                    </span>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">{{ $message }}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" onclick="this.parentElement.parentElement.remove();" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"><title>Close</title><path
                                d="M14.348 5.652a1 1 0 0 0-1.414 0L10 8.586 7.066 5.652A1 1 0 1 0 5.652 7.066L8.586 10l-2.934 2.934a1 1 0 1 0 1.414 1.414L10 11.414l2.934 2.934a1 1 0 0 0 1.414-1.414L11.414 10l2.934-2.934a1 1 0 0 0 0-1.414z" /></svg>
                    </span>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.validate') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="csv" class="block text-gray-700 font-medium mb-2">CSV File</label>
                    <input type="file" name="csv" id="csv" accept=".csv"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <p class="mt-1 text-sm text-gray-500">Maximum file size: 10MB. Required columns: name, email, phone</p>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                        Validate CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
