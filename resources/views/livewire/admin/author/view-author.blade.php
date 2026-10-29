<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">{{ $author->name }}</h1>
            <p class="mt-1 text-sm text-gray-600">Author profile and metadata</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.authors.edit', $author) }}"
               class="rounded bg-yellow-500 px-4 py-2 font-bold text-white hover:bg-yellow-600">Edit</a>
            <a href="{{ route('admin.authors.index') }}"
               class="rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-700">Back to List</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <section class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-bold text-gray-700">Author Details</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="font-semibold text-gray-700">Full Name</dt>
                    <dd class="text-gray-600">{{ $author->name }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Slug</dt>
                    <dd class="break-all font-mono text-gray-600">{{ $author->slug }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Email</dt>
                    <dd class="text-gray-600">
                        @if ($author->email)
                            <a href="mailto:{{ $author->email }}" class="text-blue-600 hover:underline">{{ $author->email }}</a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Website</dt>
                    <dd class="break-all text-gray-600">
                        @if ($author->website)
                            <a href="{{ $author->website }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">{{ $author->website }}</a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Birth Date</dt>
                    <dd class="text-gray-600">{{ $author->birth_date?->format('F d, Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Country</dt>
                    <dd class="text-gray-600">{{ $author->country ?: '—' }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-bold text-gray-700">Metadata</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="font-semibold text-gray-700">Created At</dt>
                    <dd class="text-gray-600">{{ $author->created_at?->format('M d, Y H:i:s') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Last Updated</dt>
                    <dd class="text-gray-600">{{ $author->updated_at?->format('M d, Y H:i:s') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-700">Status</dt>
                    <dd>
                        @if ($author->trashed())
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Deleted</span>
                        @else
                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Active</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </section>
    </div>

    @if ($author->bio)
        <section class="mt-6 rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-bold text-gray-700">Biography</h2>
            <p class="whitespace-pre-wrap text-gray-600">{{ $author->bio }}</p>
        </section>
    @endif
</div>