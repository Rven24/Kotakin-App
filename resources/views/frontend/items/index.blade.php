<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotakin - Katalog Stok Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-stone-900 text-stone-100 font-sans antialiased min-h-screen">

    <!-- Header Navbar -->
    <nav class="border-b border-stone-800 bg-stone-950/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-tight uppercase border border-stone-700 px-3 py-1 bg-stone-900">KOTAKIN</span>
                <span class="text-xs text-stone-400">Warehouse Inventory</span>
            </div>
            
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-xs text-stone-400">Halo, <strong class="text-stone-200">{{ auth()->user()->name }}</strong> ({{ strtoupper(auth()->user()->role) }})</span>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin" class="text-xs font-semibold uppercase tracking-wider bg-stone-100 text-stone-900 px-3 py-1.5 hover:bg-stone-300 transition">
                            Admin Panel
                        </a>
                    @endif

                    <form action="/admin/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs border border-stone-700 hover:bg-stone-800 text-stone-300 px-3 py-1.5 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/admin/login" class="text-xs font-semibold uppercase tracking-wider bg-stone-100 text-stone-900 px-4 py-2 hover:bg-stone-300 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Hero & Filter -->
        <div class="mb-8 border-b border-stone-800 pb-6">
            <h1 class="text-2xl font-bold tracking-tight mb-2">Cek Stok Barang</h1>
            <p class="text-stone-400 text-sm mb-6">Cari lokasi rak dan sisa stok barang secara real-time.</p>

            <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari SKU atau nama barang..." 
                    class="bg-stone-950 border border-stone-800 text-stone-100 px-4 py-2.5 text-sm focus:outline-none focus:border-stone-500 flex-1"
                >
                <select name="category" class="bg-stone-950 border border-stone-800 text-stone-300 px-4 py-2.5 text-sm focus:outline-none focus:border-stone-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-stone-800 border border-stone-700 hover:bg-stone-700 text-white px-6 py-2.5 text-sm font-medium transition">
                    Filter
                </button>
            </form>
        </div>

        <!-- Grid Items -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" x-data="{ selectedItem: null }">
            @forelse($items as $item)
                <div class="border border-stone-800 bg-stone-950/40 p-5 flex flex-col justify-between hover:border-stone-700 transition relative">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-mono text-stone-400">{{ $item->sku }}</span>
                            
                            <!-- Badge Status Persediaan -->
                            @if($item->stock <= 0)
                                <span class="text-[10px] uppercase font-bold border border-rose-900 bg-rose-950/50 text-rose-400 px-2 py-0.5">Habis</span>
                            @elseif($item->stock <= $item->min_stock)
                                <span class="text-[10px] uppercase font-bold border border-amber-900 bg-amber-950/50 text-amber-400 px-2 py-0.5">Menipis</span>
                            @else
                                <span class="text-[10px] uppercase font-bold border border-emerald-900 bg-emerald-950/50 text-emerald-400 px-2 py-0.5">Aman</span>
                            @endif
                        </div>
                        
                        <h2 class="font-semibold text-stone-100 text-lg mb-1">{{ $item->name }}</h2>
                        <p class="text-xs text-stone-500 mb-4">
                            Kategori: <span class="text-stone-300">{{ $item->category->name ?? '-' }}</span> | 
                            Rak: <span class="text-stone-300">{{ $item->location->code ?? '-' }}</span>
                        </p>
                    </div>

                    <div class="border-t border-stone-800/60 pt-3 flex justify-between items-center mt-4">
                        <div>
                            <span class="text-xs text-stone-500 block">Sisa Stok</span>
                            <span class="text-lg font-bold font-mono {{ $item->stock <= $item->min_stock ? 'text-rose-400' : 'text-stone-100' }}">
                                {{ $item->stock }} <span class="text-xs font-normal text-stone-400">{{ $item->unit }}</span>
                            </span>
                        </div>
                        <button 
                            @click="selectedItem = {{ json_encode($item->load(['category', 'location'])) }}"
                            class="text-xs border border-stone-700 hover:bg-stone-800 text-stone-200 px-3 py-1.5 transition">
                            Detail &rarr;
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full border border-dashed border-stone-800 p-8 text-center text-stone-500">
                    Tidak ada data barang yang ditemukan.
                </div>
            @endforelse

            <!-- Alpine.js Quick Detail Modal -->
            <div x-show="selectedItem" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" @click.self="selectedItem = null">
                <div class="bg-stone-900 border border-stone-700 max-w-md w-full p-6 relative">
                    <button @click="selectedItem = null" class="absolute top-4 right-4 text-stone-400 hover:text-white">&times;</button>
                    
                    <span class="text-xs font-mono text-stone-400 block mb-1" x-text="selectedItem?.sku"></span>
                    <h3 class="text-xl font-bold text-stone-100 mb-4" x-text="selectedItem?.name"></h3>

                    <div class="space-y-2 text-sm text-stone-300 mb-6">
                        <div class="flex justify-between border-b border-stone-800 pb-1">
                            <span class="text-stone-500">Kategori:</span>
                            <span class="font-medium" x-text="selectedItem?.category?.name || '-'"></span>
                        </div>
                        <div class="flex justify-between border-b border-stone-800 pb-1">
                            <span class="text-stone-500">Lokasi / Rak:</span>
                            <span class="font-medium" x-text="(selectedItem?.location?.name || '-') + ' (' + (selectedItem?.location?.code || '-') + ')'"></span>
                        </div>
                        <div class="flex justify-between border-b border-stone-800 pb-1">
                            <span class="text-stone-500">Harga Satuan:</span>
                            <span class="font-mono text-emerald-400" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedItem?.price || 0)"></span>
                        </div>
                        <div class="flex justify-between border-b border-stone-800 pb-1">
                            <span class="text-stone-500">Batas Stok Minimum:</span>
                            <span class="font-mono" x-text="(selectedItem?.min_stock || 0) + ' ' + (selectedItem?.unit || '')"></span>
                        </div>
                    </div>

                        <button @click="selectedItem = null" class="w-full bg-stone-800 border border-stone-700 hover:bg-stone-700 text-white text-sm py-2 transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $items->links() }}
        </div>
    </main>
</body>
</html>