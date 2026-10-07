<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">{{ $book->title }}</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.books.edit', $book) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('admin.books.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div>
            @if ($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full rounded mb-6">
            @else
                <div class="w-full h-64 bg-gray-200 rounded mb-6 flex items-center justify-center text-gray-400">
                    No Cover Image
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div>
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-2">Book Details</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="font-semibold text-gray-700">Title</dt>
                        <dd class="text-gray-600">{{ $book->title }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">ISBN</dt>
                        <dd class="text-gray-600">{{ $book->isbn ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">SKU</dt>
                        <dd class="text-gray-600">{{ $book->sku ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Slug</dt>
                        <dd class="text-gray-600">{{ $book->slug }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-2">Pricing</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="font-semibold text-gray-700">Price</dt>
                        <dd class="text-lg text-green-600 font-bold">${{ number_format($book->price, 2) }}</dd>
                    </div>
                    @if ($book->discount_price)
                        <div>
                            <dt class="font-semibold text-gray-700">Discount Price</dt>
                            <dd class="text-lg text-red-600 font-bold">${{ number_format($book->discount_price, 2) }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-2">Inventory</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="font-semibold text-gray-700">Stock</dt>
                        <dd class="text-gray-600">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->stock }} units
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-2">Publication Info</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="font-semibold text-gray-700">Pages</dt>
                        <dd class="text-gray-600">{{ $book->pages ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Language</dt>
                        <dd class="text-gray-600">{{ $book->language ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Publication Date</dt>
                        <dd class="text-gray-600">{{ $book->publication_date?->format('F d, Y') ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-2">Relations</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="font-semibold text-gray-700">Publisher</dt>
                        <dd class="text-gray-600">{{ $book->publisher?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-700">Primary Author</dt>
                        <dd class="text-gray-600">{{ $book->primaryAuthor?->name ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if ($book->description)
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Description</h2>
            <p class="text-gray-600 whitespace-pre-wrap">{{ $book->description }}</p>
        </div>
    @endif

    <!-- Metadata -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Metadata</h2>
        <dl class="space-y-4">
            <div>
                <dt class="font-semibold text-gray-700">Created</dt>
                <dd class="text-gray-600">{{ $book->created_at?->format('F d, Y g:i A') }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Last Updated</dt>
                <dd class="text-gray-600">{{ $book->updated_at?->format('F d, Y g:i A') }}</dd>
            </div>
        </dl>
    </div>
</div>