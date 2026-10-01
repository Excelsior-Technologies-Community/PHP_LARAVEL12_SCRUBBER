<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP Laravel 12 Scrubber</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        .glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card {
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }
    </style>
</head>

<body class="py-10 px-4">

    <div class="max-w-7xl mx-auto">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="text-center mb-10">

            <div class="inline-flex items-center justify-center w-16 h-16
                        bg-blue-100 text-blue-600 rounded-2xl mb-4">

                <i class="fa-solid fa-shield-halved text-2xl"></i>

            </div>

            <h1 class="text-4xl font-extrabold mb-2 gradient-text">
                PHP_Laravel12_Scrubber
            </h1>

            <p class="text-gray-500">
                Clean, sanitize and protect raw data using a Laravel Service Layer.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div class="mb-8 p-4 bg-green-50 border border-green-200
                        text-green-700 rounded-xl flex items-center gap-3">

                <i class="fa-solid fa-circle-check text-green-500"></i>

                <span class="font-medium">
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ========================================================= --}}

        @if($errors->any())

            <div class="mb-8 p-4 bg-red-50 border border-red-200
                        text-red-700 rounded-xl">

                <div class="flex items-center gap-2 font-bold mb-2">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                    Please fix the following errors:

                </div>

                <ul class="list-disc ml-6 text-sm">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- ANALYTICS DASHBOARD --}}
        {{-- ========================================================= --}}

        <div class="mb-10">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Scrubbing Analytics
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Overview of processed and sanitized records.
                    </p>

                </div>

                <div class="hidden sm:flex items-center gap-2
                            text-sm text-gray-500">

                    <i class="fa-solid fa-chart-line text-blue-500"></i>

                    Service Layer Activity

                </div>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">

                {{-- Total --}}

                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <div class="flex justify-between items-start">

                        <div>

                            <p class="text-sm text-gray-500 font-medium">
                                Total Records
                            </p>

                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                                {{ $totalRecords }}
                            </h3>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-blue-100
                                    text-blue-600 flex items-center justify-center">

                            <i class="fa-solid fa-database"></i>

                        </div>

                    </div>

                </div>


                {{-- HTML --}}

                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <div class="flex justify-between items-start">

                        <div>

                            <p class="text-sm text-gray-500 font-medium">
                                HTML Cleaned
                            </p>

                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                                {{ $htmlRecords }}
                            </h3>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-orange-100
                                    text-orange-600 flex items-center justify-center">

                            <i class="fa-solid fa-code"></i>

                        </div>

                    </div>

                </div>


                {{-- Email --}}

                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <div class="flex justify-between items-start">

                        <div>

                            <p class="text-sm text-gray-500 font-medium">
                                Emails Masked
                            </p>

                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                                {{ $emailRecords }}
                            </h3>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-purple-100
                                    text-purple-600 flex items-center justify-center">

                            <i class="fa-solid fa-envelope"></i>

                        </div>

                    </div>

                </div>


                {{-- Special Characters --}}

                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <div class="flex justify-between items-start">

                        <div>

                            <p class="text-sm text-gray-500 font-medium">
                                Special Cleaned
                            </p>

                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                                {{ $specialRecords }}
                            </h3>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-red-100
                                    text-red-600 flex items-center justify-center">

                            <i class="fa-solid fa-broom"></i>

                        </div>

                    </div>

                </div>


                {{-- Today --}}

                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <div class="flex justify-between items-start">

                        <div>

                            <p class="text-sm text-gray-500 font-medium">
                                Processed Today
                            </p>

                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                                {{ $todayRecords }}
                            </h3>

                        </div>

                        <div class="w-11 h-11 rounded-xl bg-green-100
                                    text-green-600 flex items-center justify-center">

                            <i class="fa-solid fa-calendar-day"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">


            {{-- ===================================================== --}}
            {{-- LEFT: SCRUB FORM --}}
            {{-- ===================================================== --}}

            <div class="lg:col-span-4">

                <div class="glass p-6 rounded-2xl shadow-xl sticky top-6">

                    <h2 class="text-xl font-bold mb-2 flex items-center gap-2">

                        <i class="fa-solid fa-wand-magic-sparkles text-blue-600"></i>

                        New Scrub

                    </h2>

                    <p class="text-sm text-gray-500 mb-6">
                        Choose a sanitization operation and process your data.
                    </p>


                    <form action="{{ route('scrubber.process') }}"
                          method="POST"
                          class="space-y-5">

                        @csrf


                        {{-- Content --}}

                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Input Content

                            </label>

                            <textarea
                                name="content"
                                placeholder="Enter multiple lines of data..."
                                class="w-full border border-gray-200 rounded-xl p-3
                                       focus:ring-2 focus:ring-blue-500
                                       outline-none transition-all resize-none"
                                rows="7"
                                required>{{ old('content') }}</textarea>

                            <p class="text-xs text-gray-400 mt-2">

                                <i class="fa-solid fa-circle-info mr-1"></i>

                                Multiple lines are processed individually.

                            </p>

                        </div>


                        {{-- Scrubbing Type --}}

                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Scrubbing Type

                            </label>

                            <select
                                name="type"
                                class="w-full border border-gray-200 rounded-xl p-3
                                       focus:ring-2 focus:ring-blue-500
                                       outline-none appearance-none bg-white"
                                required>

                                <option value="html"
                                    {{ old('type') === 'html' ? 'selected' : '' }}>

                                    ✨ Remove HTML Tags

                                </option>

                                <option value="email"
                                    {{ old('type') === 'email' ? 'selected' : '' }}>

                                    📧 Mask Email Address

                                </option>

                                <option value="special"
                                    {{ old('type') === 'special' ? 'selected' : '' }}>

                                    🧹 Remove Special Characters

                                </option>

                            </select>

                        </div>


                        {{-- Submit --}}

                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700
                                   text-white font-bold py-3 px-6 rounded-xl
                                   shadow-lg shadow-blue-200 transition-all
                                   flex items-center justify-center gap-2">

                            Process Now

                            <i class="fa-solid fa-arrow-right"></i>

                        </button>

                    </form>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- RIGHT SIDE --}}
            {{-- ===================================================== --}}

            <div class="lg:col-span-8 space-y-8">


                {{-- ================================================= --}}
                {{-- JUST PROCESSED --}}
                {{-- ================================================= --}}

                @if(session('clean_list'))

                    <div class="bg-blue-600 rounded-2xl p-6
                                text-white shadow-xl">

                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">

                            <i class="fa-solid fa-bolt"></i>

                            Just Processed

                        </h3>

                        <div class="bg-white/10 rounded-xl p-4 space-y-3">

                            @foreach(session('clean_list') as $item)

                                <div class="flex items-start gap-3
                                            font-mono text-sm">

                                    <i class="fa-solid fa-chevron-right
                                              text-blue-200 text-xs mt-1"></i>

                                    <span class="break-all">
                                        {{ $item }}
                                    </span>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- HISTORY --}}
                {{-- ================================================= --}}

                <div class="glass rounded-2xl shadow-xl overflow-hidden">

                    {{-- Header --}}

                    <div class="p-6 border-b border-gray-100">

                        <div class="flex flex-col md:flex-row
                                    md:justify-between md:items-center gap-4">

                            <div>

                                <h3 class="text-xl font-bold flex items-center gap-2">

                                    <i class="fa-solid fa-database text-gray-400"></i>

                                    Scrubbing History

                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Search, filter and export processed records.
                                </p>

                            </div>

                            <span class="bg-gray-100 text-gray-600
                                         px-3 py-1 rounded-full text-xs
                                         font-semibold">

                                Showing {{ $allData->count() }}
                                of {{ $allData->total() }}

                            </span>

                        </div>


                        {{-- ================================================= --}}
                        {{-- SEARCH & FILTER --}}
                        {{-- ================================================= --}}

                        <form method="GET"
                              action="{{ route('scrubber.index') }}"
                              class="mt-5">

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">


                                {{-- Search --}}

                                <div class="md:col-span-5 relative">

                                    <i class="fa-solid fa-magnifying-glass
                                              absolute left-4 top-1/2
                                              -translate-y-1/2 text-gray-400"></i>

                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ $search }}"
                                        placeholder="Search original or cleaned content..."
                                        class="w-full border border-gray-200
                                               rounded-xl pl-11 pr-4 py-3
                                               focus:ring-2 focus:ring-blue-500
                                               outline-none">

                                </div>


                                {{-- Type Filter --}}

                                <div class="md:col-span-3">

                                    <select
                                        name="type"
                                        class="w-full border border-gray-200
                                               rounded-xl px-4 py-3
                                               focus:ring-2 focus:ring-blue-500
                                               outline-none bg-white">

                                        <option value="">
                                            All Types
                                        </option>

                                        <option value="html"
                                            {{ $type === 'html' ? 'selected' : '' }}>
                                            HTML
                                        </option>

                                        <option value="email"
                                            {{ $type === 'email' ? 'selected' : '' }}>
                                            Email
                                        </option>

                                        <option value="special"
                                            {{ $type === 'special' ? 'selected' : '' }}>
                                            Special Characters
                                        </option>

                                    </select>

                                </div>


                                {{-- Filter Button --}}

                                <div class="md:col-span-2">

                                    <button
                                        type="submit"
                                        class="w-full bg-gray-900 hover:bg-gray-800
                                               text-white font-semibold
                                               rounded-xl py-3 transition">

                                        <i class="fa-solid fa-filter mr-1"></i>

                                        Filter

                                    </button>

                                </div>


                                {{-- Export Button --}}

                                <div class="md:col-span-2">

                                    <a
                                        href="{{ route('scrubber.export', [
                                            'search' => $search,
                                            'type' => $type
                                        ]) }}"
                                        class="w-full bg-green-600 hover:bg-green-700
                                               text-white font-semibold
                                               rounded-xl py-3 transition
                                               flex items-center justify-center
                                               gap-2">

                                        <i class="fa-solid fa-file-csv"></i>

                                        Export CSV

                                    </a>

                                </div>

                            </div>


                            {{-- Clear --}}

                            @if($search || $type)

                                <div class="mt-3">

                                    <a
                                        href="{{ route('scrubber.index') }}"
                                        class="inline-flex items-center gap-2
                                               text-sm text-red-500
                                               hover:text-red-700 font-medium">

                                        <i class="fa-solid fa-xmark"></i>

                                        Clear Filters

                                    </a>

                                </div>

                            @endif

                        </form>

                    </div>


                    {{-- ================================================= --}}
                    {{-- TABLE --}}
                    {{-- ================================================= --}}

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="p-4 text-left text-xs
                                               font-bold text-gray-500
                                               uppercase tracking-wider">
                                        Type
                                    </th>

                                    <th class="p-4 text-left text-xs
                                               font-bold text-gray-500
                                               uppercase tracking-wider">
                                        Original Content
                                    </th>

                                    <th class="p-4 text-left text-xs
                                               font-bold text-gray-500
                                               uppercase tracking-wider">
                                        Cleaned Content
                                    </th>

                                    <th class="p-4 text-left text-xs
                                               font-bold text-gray-500
                                               uppercase tracking-wider">
                                        Date
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @forelse($allData as $data)

                                    <tr class="hover:bg-blue-50/50
                                               transition-colors">

                                        {{-- Type --}}

                                        <td class="p-4">

                                            @if($data->type === 'html')

                                                <span class="px-2 py-1 rounded-md
                                                             text-[10px] font-bold
                                                             uppercase
                                                             bg-orange-100
                                                             text-orange-600">

                                                    <i class="fa-solid fa-code mr-1"></i>

                                                    HTML

                                                </span>

                                            @elseif($data->type === 'email')

                                                <span class="px-2 py-1 rounded-md
                                                             text-[10px] font-bold
                                                             uppercase
                                                             bg-purple-100
                                                             text-purple-600">

                                                    <i class="fa-solid fa-envelope mr-1"></i>

                                                    Email

                                                </span>

                                            @else

                                                <span class="px-2 py-1 rounded-md
                                                             text-[10px] font-bold
                                                             uppercase
                                                             bg-red-100
                                                             text-red-600">

                                                    <i class="fa-solid fa-broom mr-1"></i>

                                                    Special

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Original --}}

                                        <td class="p-4 text-sm text-gray-600
                                                   max-w-[260px]">

                                            <div class="truncate"
                                                 title="{{ $data->original_content }}">

                                                {{ $data->original_content }}

                                            </div>

                                        </td>


                                        {{-- Cleaned --}}

                                        <td class="p-4 text-sm font-medium
                                                   text-blue-600 font-mono
                                                   max-w-[260px]">

                                            <div class="truncate"
                                                 title="{{ $data->cleaned_content }}">

                                                {{ $data->cleaned_content }}

                                            </div>

                                        </td>


                                        {{-- Date --}}

                                        <td class="p-4 text-xs text-gray-500
                                                   whitespace-nowrap">

                                            {{ $data->created_at->format('d M Y') }}

                                            <div class="text-gray-400 mt-1">

                                                {{ $data->created_at->format('h:i A') }}

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4"
                                            class="p-12 text-center">

                                            <i class="fa-solid fa-folder-open
                                                      text-gray-200 text-5xl mb-4">
                                            </i>

                                            <p class="text-gray-400">

                                                No matching scrubbed records found.

                                            </p>

                                            @if($search || $type)

                                                <a
                                                    href="{{ route('scrubber.index') }}"
                                                    class="inline-block mt-3
                                                           text-blue-600
                                                           hover:text-blue-800
                                                           text-sm font-semibold">

                                                    Clear filters

                                                </a>

                                            @endif

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PAGINATION --}}
                    {{-- ================================================= --}}

                    @if($allData->hasPages())

                        <div class="p-6 border-t border-gray-100">

                            {{ $allData->links() }}

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</body>

</html>