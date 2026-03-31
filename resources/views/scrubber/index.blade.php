<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Laravel 12 Scrubber</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .gradient-text { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="py-12 px-4">

    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold mb-2 gradient-text">PHP_Laravel12_Scrubber</h1>
            <p class="text-gray-500">Tamara raw data ne clean ane safe banavo ek click ma.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4">
                <div class="glass p-6 rounded-2xl shadow-xl sticky top-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-blue-600"></i> New Scrub
                    </h2>
                    
                    <form action="/process" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Input Content</label>
                            <textarea name="content" placeholder="E.g. <h1>Hello</h1> or email@example.com..." 
                                class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all" 
                                rows="6"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Scrubbing Type</label>
                            <select name="type" class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none appearance-none bg-white">
                                <option value="html">✨ Remove HTML Tags</option>
                                <option value="email">📧 Mask Email Address</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2">
                            Process Now <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>

                    @if(session('success'))
                        <div class="mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-8 space-y-8">
                
                @if(session('clean_list'))
                <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-xl">
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-bolt"></i> Just Processed
                    </h3>
                    <div class="bg-white/10 rounded-xl p-4 space-y-2">
                        @foreach(session('clean_list') as $item)
                            <div class="flex items-center gap-3 font-mono text-sm">
                                <i class="fa-solid fa-chevron-right text-blue-200 text-xs"></i> {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="glass rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <i class="fa-solid fa-database text-gray-400"></i> History Log
                        </h3>
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                            Total: {{ $allData->count() }}
                        </span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Original Content</th>
                                    <th class="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Cleaned</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($allData as $data)
                                <tr class="hover:bg-blue-50/50 transition-colors">
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $data->type == 'html' ? 'bg-orange-100 text-orange-600' : 'bg-purple-100 text-purple-600' }}">
                                            {{ $data->type }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600 max-w-[200px] truncate">{{ $data->original_content }}</td>
                                    <td class="p-4 text-sm font-medium text-blue-600 font-mono">{{ $data->cleaned_content }}</td>
                                
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($allData->isEmpty())
                        <div class="p-12 text-center">
                            <i class="fa-solid fa-folder-open text-gray-200 text-5xl mb-4"></i>
                            <p class="text-gray-400">No data stored yet.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>