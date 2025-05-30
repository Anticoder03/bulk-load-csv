<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CSV Validation - Webappfix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">
                    📊 CSV Validation Results
                </h1>

                <!-- Validation Summary -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm text-blue-600 font-medium">Total Rows</div>
                            <div class="text-2xl font-bold text-blue-700">{{ $validationResult['totalRows'] }}</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm text-green-600 font-medium">Valid Rows</div>
                            <div class="text-2xl font-bold text-green-700">{{ $validationResult['validCount'] }}</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <div class="text-sm text-red-600 font-medium">Invalid Rows</div>
                            <div class="text-2xl font-bold text-red-700">{{ $validationResult['invalidCount'] }}</div>
                        </div>
                    </div>
                </div>

                @if (!empty($validationResult['errors']))
                    <!-- Header Errors -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Header Errors</h2>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <ul class="list-disc list-inside text-red-600">
                                @foreach ($validationResult['errors'] as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (!empty($validationResult['invalidRows']))
                    <!-- Row Errors -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Row Validation Errors</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Row</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Data</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Errors</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($validationResult['invalidRows'] as $invalidRow)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $invalidRow['row'] }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">
                                                <pre class="whitespace-pre-wrap">{{ json_encode($invalidRow['data'], JSON_PRETTY_PRINT) }}</pre>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-red-600">
                                                <ul class="list-disc list-inside">
                                                    @foreach ($invalidRow['errors'] as $field => $errors)
                                                        @foreach ($errors as $error)
                                                            <li>{{ $field }}: {{ $error }}</li>
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Data Preview -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Data Preview (First 5 Rows)</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach ($headers as $header)
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($previewData as $row)
                                    <tr>
                                        @foreach ($row as $cell)
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $cell }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('customer.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        ← Back to Upload
                    </a>

                    @if ($validationResult['isValid'])
                        <form action="{{ route('customer.process') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Import Valid Data
                            </button>
                        </form>
                    @else
                        <div class="text-red-600 text-sm">
                            Please fix the validation errors before importing
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html> 