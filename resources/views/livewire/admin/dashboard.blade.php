<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Welcome back! Here's an overview of your bookstore.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sales Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Sales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">$12,450</p>
                    <p class="text-green-600 text-sm mt-2">↑ 12% from last month</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">324</p>
                    <p class="text-green-600 text-sm mt-2">↑ 8% from last month</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">1,248</p>
                    <p class="text-green-600 text-sm mt-2">↑ 15% from last month</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Books Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Books</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">542</p>
                    <p class="text-green-600 text-sm mt-2">↑ 5% from last month</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25S6.5 28 12 28s10-4.745 10-10.75C22 10.998 17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Revenue Chart Card -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Revenue Overview</h2>
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>This Month</option>
                    <option>Last Month</option>
                    <option>Last 3 Months</option>
                    <option>Last Year</option>
                </select>
            </div>

            <!-- Chart Placeholder -->
            <div class="h-64 bg-gradient-to-b from-blue-50 to-gray-50 rounded-lg flex items-end justify-around p-4">
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 120px;"></div>
                    <p class="text-xs text-gray-600">Jan</p>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 160px;"></div>
                    <p class="text-xs text-gray-600">Feb</p>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 140px;"></div>
                    <p class="text-xs text-gray-600">Mar</p>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 200px;"></div>
                    <p class="text-xs text-gray-600">Apr</p>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 180px;"></div>
                    <p class="text-xs text-gray-600">May</p>
                </div>
                <div class="flex flex-col items-center space-y-1">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 220px;"></div>
                    <p class="text-xs text-gray-600">Jun</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add New Book</span>
                </button>

                <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-sm flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>View Orders</span>
                </button>

                <button class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium text-sm flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Manage Users</span>
                </button>

                <button class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium text-sm flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Recent Orders</h2>
                <a href="#" class="text-blue-600 text-sm font-medium hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                <!-- Order Item 1 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-sm font-bold text-blue-600">#</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Order #1024</p>
                            <p class="text-xs text-gray-600">John Doe</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">$125.50</p>
                        <span class="inline-block mt-1 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Completed</span>
                    </div>
                </div>

                <!-- Order Item 2 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="text-sm font-bold text-yellow-600">#</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Order #1023</p>
                            <p class="text-xs text-gray-600">Jane Smith</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">$89.99</p>
                        <span class="inline-block mt-1 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">Pending</span>
                    </div>
                </div>

                <!-- Order Item 3 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-sm font-bold text-green-600">#</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Order #1022</p>
                            <p class="text-xs text-gray-600">Michael Johnson</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">$245.00</p>
                        <span class="inline-block mt-1 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Completed</span>
                    </div>
                </div>

                <!-- Order Item 4 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <span class="text-sm font-bold text-red-600">#</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Order #1021</p>
                            <p class="text-xs text-gray-600">Sarah Williams</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">$156.75</p>
                        <span class="inline-block mt-1 px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">Cancelled</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Books -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Top Selling Books</h2>
                <a href="#" class="text-blue-600 text-sm font-medium hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                <!-- Book Item 1 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-200 rounded flex items-center justify-center text-xs font-bold">
                            📖
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">The Great Gatsby</p>
                            <p class="text-xs text-gray-600">F. Scott Fitzgerald</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">245 sales</p>
                        <p class="text-xs text-gray-600">$12.99</p>
                    </div>
                </div>

                <!-- Book Item 2 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-200 rounded flex items-center justify-center text-xs font-bold">
                            📖
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">To Kill a Mockingbird</p>
                            <p class="text-xs text-gray-600">Harper Lee</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">198 sales</p>
                        <p class="text-xs text-gray-600">$14.99</p>
                    </div>
                </div>

                <!-- Book Item 3 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-200 rounded flex items-center justify-center text-xs font-bold">
                            📖
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">1984</p>
                            <p class="text-xs text-gray-600">George Orwell</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">187 sales</p>
                        <p class="text-xs text-gray-600">$13.99</p>
                    </div>
                </div>

                <!-- Book Item 4 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-200 rounded flex items-center justify-center text-xs font-bold">
                            📖
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Pride and Prejudice</p>
                            <p class="text-xs text-gray-600">Jane Austen</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">156 sales</p>
                        <p class="text-xs text-gray-600">$11.99</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
