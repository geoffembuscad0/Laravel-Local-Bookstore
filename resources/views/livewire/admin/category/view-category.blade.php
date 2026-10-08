<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Category Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Category Details</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="font-semibold text-gray-700">Name</dt>
                    <dd class="text-gray-600">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Slug</dt>
                    <dd class="text-gray-600 font-mono">{{ $category->slug }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Parent Category</dt>
                    <dd class="text-gray-600">
                        @if ($category->parent)
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                {{ $category->parent->name }}
                            </span>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Timestamps -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Metadata</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="font-semibold text-gray-700">Created At</dt>
                    <dd class="text-gray-600">{{ $category->created_at->format('M d, Y H:i:s') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Last Updated</dt>
                    <dd class="text-gray-600">{{ $category->updated_at->format('M d, Y H:i:s') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Status</dt>
                    <dd>
                        @if ($category->deleted_at)
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                Deleted
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                Active
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Description -->
    @if ($category->description)
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Description</h2>
            <p class="text-gray-600 whitespace-pre-wrap">{{ $category->description }}</p>
        </div>
    @endif

    <!-- Subcategories -->
    @if ($category->children->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Subcategories</h2>
            <ul class="space-y-2">
                @foreach ($category->children as $child)
                    <li class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span>
                            <a href="{{ route('admin.categories.view', $child) }}" class="text-blue-500 hover:underline">
                                {{ $child->name }}
                            </a>
                        </span>
                        <span class="text-sm text-gray-500">{{ $child->slug }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
