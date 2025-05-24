<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Contact</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Add New Contact</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contacts.store') }}" method="POST" class="space-y-4">
            @csrf
            @foreach (['name','email','phone','address','city','state','zip_code'] as $field)
                <div>
                    <label for="{{ $field }}" class="block text-gray-700 capitalize">{{ str_replace('_', ' ', $field) }}</label>
                    <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" id="{{ $field }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old($field) }}" required>
                    @error($field)
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Save Contact
            </button>
        </form>
    </div>
</body>
</html>
