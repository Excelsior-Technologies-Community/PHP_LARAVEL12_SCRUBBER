<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP Laravel 12 Scrubber</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
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
            background: linear-gradient(135deg,
                    #3b82f6 0%,
                    #2563eb 100%);

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

        {{-- HEADER --}}
        <div class="text-center mb-10">

            <div
                class="inline-flex items-center justify-center
                   w-16 h-16 bg-blue-100 text-blue-600
                   rounded-2xl mb-4">
                <i class="fa-solid fa-shield-halved text-2xl"></i>
            </div>

            <h1 class="text-4xl font-extrabold mb-2 gradient-text">
                PHP_Laravel12_Scrubber
            </h1>

            <p class="text-gray-500">
                Clean, sanitize and protect raw data using Laravel Service Layer.
            </p>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))

        <div
            class="mb-8 p-4 bg-green-50
                   border border-green-200 text-green-700
                   rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-green-500"></i>

            <span class="font-medium">
                {{ session('success') }}
            </span>
        </div>

        @endif

        {{-- ERRORS --}}
        @if($errors->any())

        <div
            class="mb-8 p-4 bg-red-50
                   border border-red-200 text-red-700
                   rounded-xl">

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

        {{-- ANALYTICS --}}
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

            </div>

            <div
                class="grid grid-cols-1 sm:grid-cols-2
                   lg:grid-cols-6 gap-5">

                {{-- TOTAL --}}
                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-gray-500 font-medium">
                        Total Records
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $totalRecords }}
                    </h3>

                </div>

                {{-- HTML --}}
                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-gray-500 font-medium">
                        HTML
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $htmlRecords }}
                    </h3>

                </div>

                {{-- EMAIL --}}
                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-gray-500 font-medium">
                        Email
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $emailRecords }}
                    </h3>

                </div>

                {{-- SPECIAL --}}
                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-gray-500 font-medium">
                        Special
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $specialRecords }}
                    </h3>

                </div>

                {{-- PHONE --}}
                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-gray-500 font-medium">
                        Phone
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $phoneRecords }}
                    </h3>

                </div>

                {{-- TODAY --}}
                <div class="stat-card glass rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-gray-500 font-medium">
                        Today
                    </p>

                    <h3 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $todayRecords }}
                    </h3>

                </div>

            </div>

        </div>

        {{-- MAIN --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- LEFT --}}
            <div class="lg:col-span-4">

                <div class="glass p-6 rounded-2xl shadow-xl sticky top-6">

                    <h2 class="text-xl font-bold mb-2 flex items-center gap-2">

                        <i class="fa-solid fa-wand-magic-sparkles text-blue-600"></i>

                        New Scrub

                    </h2>

                    <p class="text-sm text-gray-500 mb-6">
                        Choose a sanitization operation and process your data.
                    </p>

                    <form
                        action="{{ route('scrubber.process') }}"
                        method="POST"
                        class="space-y-5">

                        @csrf

                        {{-- CONTENT --}}
                        <div>

                            <label
                                class="block text-sm font-semibold
                                   text-gray-700 mb-2">
                                Input Content
                            </label>

                            <textarea
                                name="content"
                                placeholder="Enter multiple lines of data..."
                                class="w-full border border-gray-200
                                   rounded-xl p-3
                                   focus:ring-2 focus:ring-blue-500
                                   outline-none transition-all
                                   resize-none"
                                rows="7"
                                required>{{ old('content') }}</textarea>

                            <p class="text-xs text-gray-400 mt-2">
                                Multiple lines are processed individually.
                            </p>

                        </div>

                        {{-- TYPE --}}
                        <div>

                            <label
                                class="block text-sm font-semibold
                                   text-gray-700 mb-2">
                                Scrubbing Type
                            </label>

                            <select
                                name="type"
                                class="w-full border border-gray-200
                                   rounded-xl p-3
                                   focus:ring-2 focus:ring-blue-500
                                   outline-none bg-white"
                                required>

                                <optgroup label="Existing">

                                    <option value="html">
                                        Remove HTML Tags
                                    </option>

                                    <option value="email">
                                        Mask Email Address
                                    </option>

                                    <option value="special">
                                        Remove Special Characters
                                    </option>

                                </optgroup>

                                <optgroup label="New Features">

                                    <option value="phone">
                                        Mask Phone Number
                                    </option>

                                    <option value="url">
                                        Sanitize URL
                                    </option>

                                    <option value="trim">
                                        Trim Whitespace
                                    </option>

                                    <option value="lowercase">
                                        Convert to Lowercase
                                    </option>

                                    <option value="uppercase">
                                        Convert to Uppercase
                                    </option>

                                    <option value="spaces">
                                        Normalize Spaces
                                    </option>

                                    <option value="html_encode">
                                        Encode HTML Entities
                                    </option>

                                </optgroup>

                            </select>

                        </div>

                        {{-- SUBMIT --}}
                        <button
                            type="submit"
                            class="w-full bg-blue-600
                               hover:bg-blue-700
                               text-white font-bold py-3 px-6
                               rounded-xl shadow-lg
                               transition-all">

                            <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>

                            Process Now

                        </button>

                    </form>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- JUST PROCESSED --}}
                @if(session('clean_list'))

                <div
                    class="bg-blue-600 rounded-2xl p-6
                           text-white shadow-xl">

                    <h3 class="text-lg font-bold mb-4">

                        <i class="fa-solid fa-bolt mr-2"></i>

                        Just Processed

                    </h3>

                    <div
                        class="bg-white/10 rounded-xl p-4 space-y-3">

                        @foreach(session('clean_list') as $item)

                        <div class="font-mono text-sm break-all">

                            <i
                                class="fa-solid fa-chevron-right
                                           text-blue-200 mr-2"></i>

                            {{ $item }}

                        </div>

                        @endforeach

                    </div>

                </div>

                @endif

                {{-- HISTORY --}}
                <div class="glass rounded-2xl shadow-xl overflow-hidden">

                    {{-- HEADER --}}
                    <div class="p-6 border-b border-gray-100">

                        <div
                            class="flex flex-col md:flex-row
                               md:justify-between
                               md:items-center gap-4">

                            <div>

                                <h3 class="text-xl font-bold">

                                    <i
                                        class="fa-solid fa-database
                                           text-gray-400 mr-2"></i>

                                    Scrubbing History

                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Search, filter, export and delete records.
                                </p>

                            </div>

                            <span
                                class="bg-gray-100 text-gray-600
                                   px-3 py-1 rounded-full text-xs
                                   font-semibold">
                                Showing {{ $allData->count() }}
                                of {{ $allData->total() }}
                            </span>

                        </div>

                        {{-- FILTER --}}
                        <form
                            method="GET"
                            action="{{ route('scrubber.index') }}"
                            class="mt-5">

                            <div
                                class="grid grid-cols-1
                                   md:grid-cols-12 gap-3">

                                {{-- SEARCH --}}
                                <div class="md:col-span-4">

                                    <label
                                        class="block text-xs font-semibold
                                           text-gray-500 mb-1">
                                        Search
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ old('search', $search) }}"
                                        placeholder="Search original or cleaned content..."
                                        class="w-full border border-gray-200
                                           rounded-xl px-4 py-3
                                           focus:ring-2
                                           focus:ring-blue-500
                                           focus:border-blue-500
                                           outline-none">

                                </div>

                                {{-- TYPE --}}
                                <div class="md:col-span-3">

                                    <label
                                        class="block text-xs font-semibold
                                           text-gray-500 mb-1">
                                        Type
                                    </label>

                                    <select
                                        name="type"
                                        class="w-full border border-gray-200
                                           rounded-xl px-4 py-3
                                           bg-white
                                           focus:ring-2
                                           focus:ring-blue-500">

                                        <option value="">
                                            All Types
                                        </option>

                                        <option
                                            value="html"
                                            {{ $type === 'html' ? 'selected' : '' }}>
                                            HTML
                                        </option>

                                        <option
                                            value="email"
                                            {{ $type === 'email' ? 'selected' : '' }}>
                                            Email
                                        </option>

                                        <option
                                            value="special"
                                            {{ $type === 'special' ? 'selected' : '' }}>
                                            Special
                                        </option>

                                        <option
                                            value="phone"
                                            {{ $type === 'phone' ? 'selected' : '' }}>
                                            Phone
                                        </option>

                                        <option
                                            value="url"
                                            {{ $type === 'url' ? 'selected' : '' }}>
                                            URL
                                        </option>

                                        <option
                                            value="trim"
                                            {{ $type === 'trim' ? 'selected' : '' }}>
                                            Trim
                                        </option>

                                        <option
                                            value="lowercase"
                                            {{ $type === 'lowercase' ? 'selected' : '' }}>
                                            Lowercase
                                        </option>

                                        <option
                                            value="uppercase"
                                            {{ $type === 'uppercase' ? 'selected' : '' }}>
                                            Uppercase
                                        </option>

                                        <option
                                            value="spaces"
                                            {{ $type === 'spaces' ? 'selected' : '' }}>
                                            Normalize Spaces
                                        </option>

                                        <option
                                            value="html_encode"
                                            {{ $type === 'html_encode' ? 'selected' : '' }}>
                                            HTML Encode
                                        </option>

                                    </select>

                                </div>

                                {{-- DATE --}}
                                <div class="md:col-span-3">

                                    <label
                                        class="block text-xs font-semibold
                                           text-gray-500 mb-1">
                                        Date
                                    </label>

                                    <input
                                        type="date"
                                        name="date"
                                        value="{{ $date }}"
                                        class="w-full border border-gray-200
                                           rounded-xl px-4 py-3
                                           focus:ring-2
                                           focus:ring-blue-500">

                                </div>

                                {{-- FILTER BUTTON --}}
                                <div class="md:col-span-2 flex items-end">

                                    <button
                                        type="submit"
                                        class="w-full bg-gray-900
                                           hover:bg-gray-800
                                           text-white font-semibold
                                           rounded-xl py-3">

                                        <i class="fa-solid fa-filter mr-1"></i>

                                        Filter

                                    </button>

                                </div>

                            </div>

                            {{-- FILTER ACTIONS --}}
                            <div class="flex flex-wrap gap-4 mt-4">

                                {{-- EXPORT --}}
                                <a
                                    href="{{ route('scrubber.export', [
                                    'search' => $search,
                                    'type' => $type,
                                    'date' => $date,
                                ]) }}"
                                    class="bg-green-600
                                       hover:bg-green-700
                                       text-white font-semibold
                                       rounded-xl px-5 py-3">

                                    <i class="fa-solid fa-file-csv mr-2"></i>

                                    Export CSV

                                </a>

                                {{-- CLEAR --}}
                                @if($search || $type || $date)

                                <a
                                    href="{{ route('scrubber.index') }}"
                                    class="text-red-500
                                           hover:text-red-700
                                           font-semibold py-3">

                                    <i class="fa-solid fa-xmark mr-1"></i>

                                    Clear Filters

                                </a>

                                @endif

                            </div>

                        </form>

                    </div>

                    {{-- BULK DELETE --}}
                    <form
                        method="POST"
                        action="{{ route('scrubber.bulkDelete') }}"
                        id="bulkDeleteForm">

                        @csrf

                        @method('DELETE')

                        {{-- BULK ACTION BAR --}}
                        <div
                            class="p-4 bg-red-50
                               border-b border-red-100
                               flex flex-wrap items-center
                               justify-between gap-3">

                            <label
                                class="flex items-center gap-2
                                   text-sm font-semibold
                                   text-gray-700">

                                <input
                                    type="checkbox"
                                    id="selectAll"
                                    class="w-4 h-4">

                                Select All

                            </label>

                            <button
                                type="submit"
                                id="bulkDeleteButton"
                                disabled
                                onclick="return confirm(
                                'Delete selected records?'
                            )"
                                class="bg-red-600 hover:bg-red-700
                                   disabled:bg-gray-300
                                   disabled:cursor-not-allowed
                                   text-white px-4 py-2
                                   rounded-lg text-sm font-semibold">

                                <i class="fa-solid fa-trash mr-1"></i>

                                Delete Selected

                            </button>

                        </div>

                        {{-- TABLE --}}
                        <div class="overflow-x-auto">

                            <table class="w-full">

                                <thead class="bg-gray-50">

                                    <tr>

                                        <th class="p-4 text-left">
                                            Select
                                        </th>

                                        <th
                                            class="p-4 text-left text-xs
                                           font-bold text-gray-500
                                           uppercase">
                                            Type
                                        </th>

                                        <th
                                            class="p-4 text-left text-xs
                                           font-bold text-gray-500
                                           uppercase">
                                            Original
                                        </th>

                                        <th
                                            class="p-4 text-left text-xs
                                           font-bold text-gray-500
                                           uppercase">
                                            Cleaned
                                        </th>

                                        <th
                                            class="p-4 text-left text-xs
                                           font-bold text-gray-500
                                           uppercase">
                                            Date
                                        </th>

                                        <th
                                            class="p-4 text-left text-xs
                                           font-bold text-gray-500
                                           uppercase">
                                            Action
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-gray-100">

                                    @forelse($allData as $data)

                                    <tr class="hover:bg-blue-50/50">

                                        {{-- CHECKBOX --}}
                                        <td class="p-4">

                                            <input
                                                type="checkbox"
                                                name="ids[]"
                                                value="{{ $data->id }}"
                                                class="record-checkbox w-4 h-4">

                                        </td>

                                        {{-- TYPE --}}
                                        <td class="p-4">

                                            <span
                                                class="px-2 py-1
                                                   rounded-md
                                                   text-[10px]
                                                   font-bold
                                                   uppercase
                                                   bg-blue-100
                                                   text-blue-600">

                                                {{ str_replace(
                                                '_',
                                                ' ',
                                                $data->type
                                            ) }}

                                            </span>

                                        </td>

                                        {{-- ORIGINAL --}}
                                        <td
                                            class="p-4 text-sm
                                               text-gray-600
                                               max-w-[220px]">

                                            <div
                                                class="truncate"
                                                title="{{ $data->original_content }}">
                                                {{ $data->original_content }}
                                            </div>

                                        </td>

                                        {{-- CLEANED --}}
                                        <td
                                            class="p-4 text-sm
                                               text-blue-600
                                               font-mono
                                               max-w-[220px]">

                                            <div
                                                class="truncate"
                                                title="{{ $data->cleaned_content }}">
                                                {{ $data->cleaned_content }}
                                            </div>

                                        </td>

                                        {{-- DATE --}}
                                        <td
                                            class="p-4 text-xs
                                               text-gray-500
                                               whitespace-nowrap">

                                            {{ $data->created_at->format('d M Y') }}

                                            <div class="text-gray-400 mt-1">

                                                {{ $data->created_at->format('h:i A') }}

                                            </div>

                                        </td>

                                        {{-- DELETE --}}
                                        <td class="p-4">

                                            <button
                                                type="button"
                                                onclick="deleteRecord({{ $data->id }})"
                                                class="text-red-500
                                                   hover:text-red-700"
                                                title="Delete record">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="p-12 text-center">

                                            <i
                                                class="fa-solid
                                                   fa-folder-open
                                                   text-gray-200
                                                   text-5xl mb-4"></i>

                                            <p class="text-gray-400">
                                                No matching scrubbed records found.
                                            </p>

                                            @if($search || $type || $date)

                                            <a
                                                href="{{ route('scrubber.index') }}"
                                                class="inline-block mt-3
                                                       text-blue-600
                                                       hover:text-blue-800
                                                       font-semibold">
                                                Clear filters
                                            </a>

                                            @endif

                                        </td>

                                    </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </form>

                    {{-- PAGINATION --}}
                    @if($allData->hasPages())

                    <div class="p-6 border-t border-gray-100">

                        {{ $allData->links() }}

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- INDIVIDUAL DELETE FORM --}}
    <form
        id="deleteRecordForm"
        method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        /*
    |--------------------------------------------------------------------------
    | Select All
    |--------------------------------------------------------------------------
    */

        const selectAll = document.getElementById('selectAll');

        const recordCheckboxes = document.querySelectorAll(
            '.record-checkbox'
        );

        const bulkDeleteButton = document.getElementById(
            'bulkDeleteButton'
        );

        function updateBulkDeleteButton() {

            const checkedCount = document.querySelectorAll(
                '.record-checkbox:checked'
            ).length;

            bulkDeleteButton.disabled = checkedCount === 0;
        }

        selectAll.addEventListener(
            'change',
            function() {

                recordCheckboxes.forEach(
                    function(checkbox) {
                        checkbox.checked = selectAll.checked;
                    }
                );

                updateBulkDeleteButton();
            }
        );

        recordCheckboxes.forEach(
            function(checkbox) {

                checkbox.addEventListener(
                    'change',
                    function() {

                        const checkedCount =
                            document.querySelectorAll(
                                '.record-checkbox:checked'
                            ).length;

                        selectAll.checked =
                            checkedCount === recordCheckboxes.length;

                        selectAll.indeterminate =
                            checkedCount > 0 &&
                            checkedCount < recordCheckboxes.length;

                        updateBulkDeleteButton();
                    }
                );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Individual Delete
        |--------------------------------------------------------------------------
        */

        function deleteRecord(id) {

            const confirmed = confirm(
                'Are you sure you want to delete this record?'
            );

            if (!confirmed) {
                return;
            }

            const form = document.getElementById(
                'deleteRecordForm'
            );

            form.action = "{{ url('/scrubber') }}/" + id;

            form.submit();
        }
    </script>

</body>

</html>