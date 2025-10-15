<?php
include_once('include/auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-white text-slate-800">
    <!-- Header -->
    <header class="sticky top-0 bg-white/90 backdrop-blur-lg z-20 border-b border-slate-200">
        <div class="px-4 sm:px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <!-- <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-500 to-pink-500">EmpireOne</h1> -->

            <img src="assets/images/logo.png" alt="EmpireOne Logo" class="h-10 sm:h-12 w-auto drop-shadow-[0_2px_6px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300" / style="height: 55px;">
            <!-- Centered Nav Tabs -->
            <nav class="hidden md:flex flex-grow h-full justify-center">
                <div class="relative flex items-center justify-center h-full">
                    <div id="active-tab-pill" class="absolute h-10 bg-pink-100 rounded-lg"></div>
                    <ul id="tab-list" class="relative flex items-center justify-center gap-x-8 h-full">
                        <li><a href="#" class="tab-link z-10 px-4 py-2 rounded-lg flex items-center text-base font-medium transition-colors duration-300" data-tab="dashboard"><i data-feather="grid" class="w-5 h-5 mr-2"></i>Dashboard</a></li>
                        <li><a href="#" class="tab-link z-10 px-4 py-2 rounded-lg flex items-center text-base font-medium transition-colors duration-300" data-tab="data-viewer"><i data-feather="database" class="w-5 h-5 mr-2"></i>Data
                            Viewer</a></li>
                        <li><a href="#" class="tab-link z-10 px-4 py-2 rounded-lg flex items-center text-base font-medium transition-colors duration-300" data-tab="upload"><i data-feather="upload-cloud" class="w-5 h-5 mr-2"></i>Upload</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Right Icons -->
            <div class="flex items-center">
                <div class="relative">
                    <button id="profile-button" class="flex items-center space-x-2 p-1.5 pr-3 rounded-full hover:bg-slate-100 transition-colors duration-300">
                        <img src="https://placehold.co/40x40/ec4899/ffffff?text=<?= substr($sFullName, 0, 1) ?>" alt="User Avatar" class="w-8 h-8 rounded-full">
                        <span class="font-medium text-sm text-slate-700 hidden sm:inline"><?= $sFullName ?></span>
                        <i id="profile-chevron" data-feather="chevron-down" class="w-5 h-5 text-slate-500 transition-transform duration-300"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown" class="profile-dropdown absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg overflow-hidden border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                            <p class="text-sm font-semibold text-slate-900 truncate"><?= $sFullName ?></p>
                            <!-- <p class="text-xs text-slate-500">Administrator</p> -->
                        </div>
                        <div class="border-t border-slate-200 py-1">
                            <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i
                                data-feather="log-out" class="w-4 h-4 mr-3 text-red-500"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Nav -->
        <nav class="md:hidden bg-white border-t border-slate-200">
            <ul id="mobile-tab-list" class="flex items-center justify-around h-16">
                <li><a href="#" class="tab-link z-10 p-2 rounded-lg flex flex-col items-center text-xs font-medium transition-colors duration-300" data-tab="dashboard"><i data-feather="grid" class="w-5 h-5 mb-1"></i>Dashboard</a></li>
                <li><a href="#" class="tab-link z-10 p-2 rounded-lg flex flex-col items-center text-xs font-medium transition-colors duration-300" data-tab="data-viewer"><i data-feather="database" class="w-5 h-5 mb-1"></i>Data Viewer</a></li>
                <li><a href="#" class="tab-link z-10 p-2 rounded-lg flex flex-col items-center text-xs font-medium transition-colors duration-300" data-tab="upload"><i data-feather="upload-cloud" class="w-5 h-5 mb-1"></i>Upload</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="gradient-bg min-h-screen">
        <div class="p-4 sm:p-6 md:p-8">
            <!-- Dashboard Content -->
            <div id="dashboard" class="tab-content">
                <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md mb-8 animated-item border border-slate-200" style="opacity:0; animation-delay: 100ms;">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800">Analytics Dashboard</h2>
                        <p class="text-slate-500 text-base md:text-lg">Discover What Your Data Reveals</p>
                    </div>
                    <button id="quick-guide-button" class="p-3 bg-pink-100 rounded-lg hover:bg-pink-200 transition-colors">
                        <i data-feather="help-circle" class="w-8 h-8 text-pink-500"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Stat Cards -->
                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-pink-500 animated-item transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="opacity:0; animation-delay: 300ms;">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-medium text-slate-500">Gross Purchases</h3>
                            <div class="p-2 bg-pink-100 rounded-lg">
                                <i data-feather="dollar-sign" class="w-4 h-4 text-pink-500"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold mt-2 text-slate-800" id="grossPurchases">&#8369;00.00</p>
                        <!-- <p class="text-sm text-green-500 mt-1 flex items-center"><i data-feather="arrow-up" class="w-3 h-3 mr-1"></i> 0% from last month</p> -->
                        <p class="text-xs text-slate-400 mt-2">Total purchases before deductions</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-fuchsia-500 animated-item transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="opacity:0; animation-delay: 400ms;">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-medium text-slate-500">Net Purchases</h3>
                            <div class="p-2 bg-fuchsia-100 rounded-lg">
                                <i data-feather="shopping-cart" class="w-4 h-4 text-fuchsia-500"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold mt-2 text-slate-800" id="netPurchases">&#8369;00.00</p>
                        <!-- <p class="text-sm text-green-500 mt-1 flex items-center"><i data-feather="arrow-up" class="w-3 h-3 mr-1"></i> 0% from last month</p> -->
                        <p class="text-xs text-slate-400 mt-2">Purchases after tax deductions</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-sky-500 animated-item transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="opacity:0; animation-delay: 500ms;">
                        <div class="flex justify-between items-start">
                            <h3 class="text-base font-medium text-slate-500">Input Tax</h3>
                            <div class="p-2 bg-sky-100 rounded-lg">
                                <i data-feather="percent" class="w-4 h-4 text-sky-500"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold mt-2 text-slate-800" id="inputTax">&#8369;00.00</p>
                        <!-- <p class="text-sm text-green-500 mt-1 flex items-center"><i data-feather="arrow-up" class="w-3 h-3 mr-1"></i> 0% from last month</p> -->
                        <p class="text-xs text-slate-400 mt-2">Total tax on purchases</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-indigo-500 animated-item transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="opacity:0; animation-delay: 600ms;">
                        <h3 class="text-base font-medium text-slate-500 mb-4">VAT Categories</h3>
                        <div class="space-y-3 mt-4">
                            <div class="flex justify-between items-center text-base">
                                <span class="text-slate-600">VAT-Exempt</span>
                                <span class="font-semibold text-slate-800" id="vatExempt">&#8369;0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-base">
                                <span class="text-slate-600">Zero-Rated</span>
                                <span class="font-semibold text-slate-800" id="zeroRated">&#8369;0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mt-6">
                    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-md animated-item border border-slate-200" style="opacity:0; animation-delay: 700ms;">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Monthly Financial Trends</h3>
                        <div id="financialTrendsChart"></div>
                    </div>
                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md animated-item border border-slate-200" style="opacity:0; animation-delay: 800ms;">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Category Breakdown</h3>
                        <div id="comparisonChart"></div>
                    </div>
                </div>
            </div>

            <!-- Data Viewer Content -->
            <div id="data-viewer" class="tab-content">
                <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md mb-8 animated-item border border-slate-200" style="opacity:0;">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800">Data Viewer</h2>
                        <p class="text-slate-500 text-base md:text-lg">Browse and validate extracted financial data.</p>
                    </div>
                    <div class="p-3 bg-pink-100 rounded-lg">
                        <i data-feather="table" class="w-8 h-8 text-pink-500"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-4 animated-item border border-slate-200" style="opacity:0; animation-delay: 100ms;">
                    <div class="flex justify-between items-center mb-4 px-2 pt-2">
                        <h3 class="text-lg font-semibold text-slate-800 flex items-center"><i data-feather="filter"
                            class="w-5 h-5 mr-2 text-slate-400"></i>Filters & Search</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <input type="text" placeholder="Search supplier, order #..." class="w-full lg:col-span-2 bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none">
                        <select id="supplierSelect" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none">
                            <option>All Suppliers</option>
                        </select>

                        <select id="categorySelect" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none">
                            <option>All Expense Categories</option>
                        </select>
                        <div class="flex justify-end gap-x-2">
                            <button id="resetFiltersBtn" class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200">Reset</button>
                            <!-- Export Button -->
                            <button id="openExportModalBtn" class="px-4 py-2 text-sm font-medium text-white bg-pink-500 rounded-lg hover:bg-pink-600 transition">
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white rounded-xl shadow-md animated-item border border-slate-200 p-6 overflow-x-auto" style="opacity:0; animation-delay: 200ms;">
                    <table id="dataViewerTable" class="w-full text-base text-left text-slate-500" style="width:100%">
                        <thead class="text-sm text-white uppercase bg-pink-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">Image</th>
                                <th scope="col" class="px-6 py-4">Date</th>
                                <th scope="col" class="px-6 py-4">Order #</th>
                                <th scope="col" class="px-6 py-4">Supplier</th>
                                <th scope="col" class="px-6 py-4">Address</th>
                                <th scope="col" class="px-6 py-4">Gross</th>
                                <th scope="col" class="px-6 py-4">Net</th>
                                <th scope="col" class="px-6 py-4">VAT</th>
                                <th scope="col" class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Upload Content -->
            <div id="upload" class="tab-content">
                <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md mb-8 animated-item border border-slate-200" style="opacity:0;">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800">Upload Receipts & Documents</h2>
                        <p class="text-slate-500 text-base md:text-lg">Upload financial documents for AI-powered data extraction and analysis.</p>
                    </div>
                    <div class="p-3 bg-pink-100 rounded-lg">
                        <i data-feather="file-text" class="w-8 h-8 text-pink-500"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 md:p-8 animated-item border border-slate-200" style="opacity:0; animation-delay: 100ms;">
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Upload Financial Documents</h3>
                    <div id="dropzone" class="mt-6 border-2 border-dashed border-slate-300 rounded-xl p-12 text-center cursor-pointer hover:border-pink-500 transition-all duration-300 group hover:bg-pink-50/50">
                        <div class="flex flex-col items-center text-slate-500">
                            <div class="w-16 h-16 bg-pink-50 rounded-full flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110">
                                <i data-feather="upload-cloud" class="w-8 h-8 text-pink-500"></i>
                            </div>
                            <p class="font-semibold text-base">Drag & drop your receipts here</p>
                            <p class="text-sm">or click to browse files</p>
                            <p class="text-sm mt-2 text-slate-400">Supports: JPEG, PNG (Max 10MB per file)</p>
                        </div>
                        <input type="file" class="hidden" multiple accept="image/png, image/jpeg, image/jpg">
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-8 mt-6 animated-item border border-slate-200" style="opacity:0; animation-delay: 200ms;">
                    <h3 class="text-xl font-semibold text-slate-800 mb-8 text-center">How It Works</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mb-4"><i data-feather="file-plus" class="w-8 h-8 text-pink-500"></i></div>
                            <h4 class="font-semibold text-base mb-2">1. Upload</h4>
                            <p class="text-base text-slate-500">Upload clear images of receipts, invoices, and bills.
                            </p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-fuchsia-100 rounded-full flex items-center justify-center mb-4"><i data-feather="cpu" class="w-8 h-8 text-fuchsia-500"></i></div>
                            <h4 class="font-semibold text-base mb-2">2. Enhance</h4>
                            <p class="text-base text-slate-500">AI automatically enhances image quality and removes noise.
                            </p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center mb-4"><i data-feather="check-circle" class="w-8 h-8 text-sky-500"></i></div>
                            <h4 class="font-semibold text-base mb-2">3. Extract</h4>
                            <p class="text-base text-slate-500">Advanced AI extracts all financial data automatically.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Quick Guide Modal -->
    <div id="quick-guide-modal-overlay" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">
        <div id="quick-guide-modal-content" class="modal-content bg-slate-50 rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b sticky top-0 bg-slate-50/80 backdrop-blur-sm">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center"><i data-feather="help-circle"
                        class="w-6 h-6 mr-3 text-pink-500"></i>Quick Guide for New Users</h2>
                    <button id="close-modal" class="p-1 rounded-full hover:bg-slate-200"><i data-feather="x" class="w-5 h-5 text-slate-600"></i></button>
                </div>
                <p class="text-slate-600 mt-1">Welcome to the Finance AI Extraction System! This quick guide will help you get started.</p>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-5 border-l-4 border-blue-500 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center mb-2"><i data-feather="upload"
                        class="w-5 h-5 mr-2 text-blue-500"></i>1. Upload Documents</h3>
                    <p class="text-slate-600 mb-3 text-sm">Start by uploading your financial documents (receipts, invoices, bills, statements).</p>
                    <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                        <li>Supported formats: JPEG, PNG, PDF</li>
                        <li>Max size: 10MB per file</li>
                        <li>Use clear, high-quality images</li>
                    </ul>
                    <div class="mt-4"><span class="text-xs font-medium bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Navigate to
                        Upload page</span></div>
                </div>
                <div class="bg-white rounded-lg p-5 border-l-4 border-purple-500 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center mb-2"><i data-feather="cpu"
                        class="w-5 h-5 mr-2 text-purple-500"></i>2. AI Processing</h3>
                    <p class="text-slate-600 mb-3 text-sm">Our AI automatically analyzes and extracts financial data from your documents.</p>
                    <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                        <li>Extracts supplier details, amounts, dates</li>
                        <li>Categorizes purchases and calculates taxes</li>
                        <li>Processing takes a few seconds per document</li>
                    </ul>
                    <div class="mt-4"><span class="text-xs font-medium bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Automatic
                        processing</span></div>
                </div>
                <div class="bg-white rounded-lg p-5 border-l-4 border-green-500 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center mb-2"><i data-feather="edit"
                        class="w-5 h-5 mr-2 text-green-500"></i>3. Review & Edit Data</h3>
                    <p class="text-slate-600 mb-3 text-sm">Check the extracted data and make corrections if needed.</p>
                    <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                        <li>View all extracted information</li>
                        <li>Edit supplier details, amounts, categories</li>
                        <li>Delete incorrect records</li>
                    </ul>
                    <div class="mt-4"><span class="text-xs font-medium bg-green-100 text-green-700 px-2 py-1 rounded-full">Data Viewer
                        page</span></div>
                </div>
                <div class="bg-white rounded-lg p-5 border-l-4 border-orange-500 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center mb-2"><i data-feather="download"
                        class="w-5 h-5 mr-2 text-orange-500"></i>4. Export Data</h3>
                    <p class="text-slate-600 mb-3 text-sm">Export your processed data for accounting or analysis.</p>
                    <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                        <li>Export to Excel format</li>
                        <li>Filter by date range</li>
                        <li>Includes all financial details</li>
                    </ul>
                    <div class="mt-4"><span class="text-xs font-medium bg-orange-100 text-orange-700 px-2 py-1 rounded-full">Data Viewer
                        → Export</span></div>
                </div>
                <div class="md:col-span-2 bg-white rounded-lg p-5 border-l-4 border-indigo-500 shadow-sm">
                    <h3 class="font-semibold text-lg flex items-center mb-2"><i data-feather="bar-chart"
                        class="w-5 h-5 mr-2 text-indigo-500"></i>5. View Analytics</h3>
                    <p class="text-slate-600 mb-3 text-sm">Monitor your financial trends and insights on the dashboard.
                    </p>
                    <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                        <li>Monthly spending trends</li>
                        <li>VAT analysis and optimization</li>
                        <li>Supplier and category breakdowns</li>
                    </ul>
                    <div class="mt-4"><span class="text-xs font-medium bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">Dashboard
                        page</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300 modal-panel">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-slate-800">Select Date Range</h3>
                <button id="closeExportModalBtn" class="text-slate-400 hover:text-slate-600 text-3xl leading-none">&times;</button>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="startDate" class="block text-sm font-medium text-slate-600 mb-1">Start Date</label>
                    <input type="date" id="startDate" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none">
                </div>
                <div>
                    <label for="endDate" class="block text-sm font-medium text-slate-600 mb-1">End Date</label>
                    <input type="date" id="endDate" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none">
                </div>
            </div>
            <div class="flex justify-end gap-4 mt-8">
                <button id="cancelExportBtn" class="px-6 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition">Cancel</button>
                <button class="px-6 py-2 text-sm font-medium text-white bg-pink-500 rounded-lg hover:bg-pink-600 transition" id="exportReceiptsBtn">Export</button>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 backdrop-blur-sm transition-all duration-300">
        <div class="bg-gradient-to-br from-white via-pink-50 to-white rounded-2xl shadow-[0_0_40px_rgba(236,72,153,0.15)] w-full max-w-5xl p-8 relative border border-pink-100 animate-fadeIn">
            <button id="closeViewModal" class="absolute top-3 right-4 text-gray-500 hover:text-pink-600 text-3xl leading-none">&times;</button>

            <h3 class="text-2xl font-bold text-pink-600 mb-6 flex items-center border-b border-pink-100 pb-3"><i data-lucide="eye" class="w-6 h-6 mr-2"></i> View Record</h3>

            <!-- Two-column layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <!-- Left: Image -->
                <div class="flex flex-col items-center justify-start bg-white/80 border border-pink-100 rounded-xl p-6 shadow-inner h-full">
                    <h4 class="text-base font-semibold text-gray-700 mb-4 flex items-center"><i data-lucide="image" class="w-4 h-4 mr-2 text-pink-500"></i> Original Image</h4>
                    <div class="flex justify-center items-center w-full">
                        <img id="viewImage" class="rounded-xl border border-pink-200 shadow-md object-contain max-h-[400px] w-full">
                    </div>
                </div>

                <!-- Right: Data (Each field one row) -->
                <div id="viewContent" class="flex flex-col gap-3 text-gray-700 text-[15px] bg-white/80 p-6 rounded-xl border border-pink-100 shadow-inner max-h-[70vh] overflow-y-auto leading-relaxed">
                    <!-- Filled dynamically by JS -->
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Date:</span> <span id="vDate"></span></div>
                        <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Order Number:</span>
                            <span id="vOrderNumber"></span>
                        </div>
                        <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Supplier Name:</span>
                            <span id="vSupplierName"></span>
                        </div>
                        <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Supplier Register Name:</span> <span id="vSupplierRegisterName"></span>
                        </div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Supplier
                Address:</span> <span id="vSupplierAddress"></span></div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Supplier TIN:</span>
                        <span id="vSupplierTIN"></span>
                    </div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Purchase
                Category:</span> <span id="vPurchaseCategory"></span></div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Expense
                Category:</span> <span id="vExpenseCategory"></span></div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Gross Amount:</span>
                        <span id="vGrossAmount"></span>
                    </div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Net Amount:</span>
                        <span id="vNetAmount"></span>
                    </div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Input Tax:</span>
                        <span id="vInputTax"></span>
                    </div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">VAT Exempt:</span>
                        <span id="vVatExempt"></span>
                    </div>
                    <div class="flex justify-between border-b border-pink-50 pb-1"><span class="font-semibold">Zero Rated:</span>
                        <span id="vZeroRated"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 backdrop-blur-sm transition-all duration-300">
        <div class="bg-gradient-to-br from-white via-pink-50 to-white rounded-2xl shadow-[0_0_40px_rgba(236,72,153,0.15)] w-full max-w-3xl p-6 relative border border-pink-100 animate-fadeIn" style="max-width: 1050px;">
            <button id="closeEditModal" class="absolute top-3 right-4 text-gray-500 hover:text-pink-600 text-3xl leading-none">&times;</button>

            <h3 class="text-2xl font-bold text-pink-600 mb-6 flex items-center border-b border-pink-100 pb-3"><i data-lucide="edit-3" class="w-6 h-6 mr-2"></i> Edit Record</h3>

            <!-- Two-column layout for Edit -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <!-- Left: Image upload -->
                <div class="flex flex-col items-center justify-center bg-white/70 border border-pink-100 rounded-xl p-5 shadow-inner">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center"><i data-lucide="image" class="w-4 h-4 mr-2 text-pink-500"></i> Upload / Preview</h4>
                    <img id="editPreview" src="https://placehold.co/300x300/fce7f3/db2777?text=IMG" class="rounded-xl border border-pink-200 shadow-md object-contain max-h-[280px] w-auto mb-4">
                    <!-- <input type="file" id="editImage" accept="image/*" class="text-sm text-gray-700 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 cursor-pointer"> -->
                </div>

                <!-- Right: Form Fields with Scroll -->
                <form id="editForm" class="bg-white/70 rounded-xl border border-pink-100 shadow-inner p-5 space-y-4 text-gray-700 text-sm max-h-[65vh] overflow-y-auto">

                    <input type="hidden" name="id" id="editId">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Date</label>
                            <input type="date" name="editDate" id="editDate" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Order #</label>
                            <input type="text" name="editOrderNumber" id="editOrderNumber" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Supplier Name</label>
                            <input type="text" name="editSupplierName" id="editSupplierName" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Supplier Register Name</label>
                            <input type="text" name="editSupplierRegisterName" id="editSupplierRegisterName" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Supplier Address</label>
                            <input type="text" name="editSupplierAddress" id="editSupplierAddress" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Supplier TIN</label>
                            <input type="text" name="editSupplierTIN" id="editSupplierTIN" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Purchase Category</label>
                            <input type="text" name="editPurchaseCategory" id="editPurchaseCategory" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Expense Category</label>
                            <input type="text" name="editExpenseCategory" id="editExpenseCategory" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Gross Amount</label>
                            <input type="text" name="editGrossAmount" id="editGrossAmount" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Net Amount</label>
                            <input type="text" name="editNetAmount" id="editNetAmount" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Input Tax</label>
                            <input type="text" name="editInputTax" id="editInputTax" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">VAT Exempt</label>
                            <input type="text" name="editVatExempt" id="editVatExempt" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1 font-medium">Zero Rated</label>
                            <input type="text" name="editZeroRated" id="editZeroRated" class="w-full rounded-xl border border-gray-200 px-3 py-2 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 shadow-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-5 border-t border-pink-100 mt-5">
                        <button type="button" id="cancelEdit" class="px-6 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">Cancel</button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600 shadow-md hover:shadow-lg transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>