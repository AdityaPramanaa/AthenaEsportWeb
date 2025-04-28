@props([
    'searchPlaceholder' => 'Cari...',
    'filters' => [],
    'types' => []
])

<div class="mb-8">
    <form action="{{ request()->url() }}" method="GET" class="space-y-6">
        <!-- Search Bar -->
        <div class="relative w-full" data-aos="fade-right">
            <input type="text"
                   name="search"
                   placeholder="{{ $searchPlaceholder }}"
                   value="{{ request('search') }}"
                   class="w-full px-5 py-3 bg-surface border border-border rounded-lg focus:border-primary focus:ring-1 focus:ring-primary transition-all">
            <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" data-aos="fade-up">
            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Kategori</label>
                <select name="category" 
                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-900">
                    @foreach($filters as $filter)
                        <option value="{{ $filter['value'] }}" 
                                {{ request('category') == $filter['value'] ? 'selected' : '' }}>
                            {{ $filter['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tipe -->
            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Tipe Event</label>
                <select name="type" 
                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-900">
                    @foreach($types as $type)
                        <option value="{{ $type['value'] }}" 
                                {{ request('type') == $type['value'] ? 'selected' : '' }}>
                            {{ $type['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-200">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
        </div>
    </form>
</div> 