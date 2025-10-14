document.addEventListener('DOMContentLoaded', function () {
    feather.replace();

    const tabs = document.querySelectorAll('.tab-link');
    const contents = document.querySelectorAll('.tab-content');
    const activeTabPill = document.getElementById('active-tab-pill');
    const tabList = document.getElementById('tab-list');
    const profileButton = document.getElementById('profile-button');
    const profileDropdown = document.getElementById('profile-dropdown');
    const profileChevron = document.getElementById('profile-chevron');

    const quickGuideButton = document.getElementById('quick-guide-button');
    const modalOverlay = document.getElementById('quick-guide-modal-overlay');
    const modalContent = document.getElementById('quick-guide-modal-content');
    const closeModalButton = document.getElementById('close-modal');

    function movePill(activeTab) {
        if (activeTab) {
            activeTabPill.style.width = `${activeTab.offsetWidth}px`;
            activeTabPill.style.left = `${activeTab.offsetLeft}px`;
        }
    }

    function setActiveTab(tabId, isInitial = false) {
        document.querySelectorAll('.tab-link').forEach(t => {
            t.classList.remove('text-pink-500');
            t.classList.add('text-slate-500', 'hover:text-pink-500');
        });
        contents.forEach(c => c.classList.remove('active'));

        const activeTabs = document.querySelectorAll(`.tab-link[data-tab="${tabId}"]`);
        const activeContent = document.getElementById(tabId);

        if (activeTabs.length > 0 && activeContent) {
            activeTabs.forEach(t => {
                t.classList.add('text-pink-500');
                t.classList.remove('text-slate-500');
            });
            activeContent.classList.add('active');

            const desktopTab = document.querySelector(`#tab-list .tab-link[data-tab="${tabId}"]`);
            if (isInitial) {
                setTimeout(() => movePill(desktopTab), 50);
            } else {
                movePill(desktopTab);
            }

            const newAnimatedItems = activeContent.querySelectorAll('.animated-item');
            newAnimatedItems.forEach(item => {
                item.style.opacity = '0';
                item.style.animation = 'none';
                item.offsetHeight;
                item.style.animation = '';
            });
        }
    }

    document.querySelectorAll('.tab-link').forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            const tabId = tab.dataset.tab;
            setActiveTab(tabId);
        });
    });

    profileButton.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('active');
        profileChevron.classList.toggle('rotate-180');
    });

    window.addEventListener('click', (e) => {
        if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('active');
            profileChevron.classList.remove('rotate-180');
        }
    });

    const dropzone = document.getElementById('dropzone');
    if (dropzone) {
        dropzone.addEventListener('dragover', (e) => { e.preventDefault(); });
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            const files = e.dataTransfer.files;
            console.log(files);
        });
        dropzone.addEventListener('click', () => { dropzone.querySelector('input[type="file"]').click(); });
    }

    // --- Image Upload Handling ---
    const fileInput = dropzone.querySelector('input[type="file"]');

    async function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);

        try {
            Swal.fire({
                title: 'Uploading...',
                text: `Please wait while ${file.name} is being uploaded.`,
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const response = await fetch('uploadImage.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            Swal.close();

            if (result.status === 'success') {
                loadDropdownOptions();
                loadDataViewerTable();
                renderDashboard();

                Swal.fire({
                    icon: 'success',
                    title: 'Upload Successful!',
                    text: result.message || `${file.name} uploaded successfully.`,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: result.message || 'Something went wrong while uploading.',
                    confirmButtonColor: '#d33'
                });
            }

        } catch (err) {
            Swal.close();
            console.error('Upload error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred while uploading the image.',
                confirmButtonColor: '#d33'
            });
        }
    }

    fileInput.addEventListener('change', async (e) => {
        const files = e.target.files;
        for (const file of files) {
            await uploadImage(file);
        }
        e.target.value = '';
    });

    dropzone.addEventListener('drop', async (e) => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        for (const file of files) {
            await uploadImage(file);
        }
    });

    // Modal Logic
    function openModal() {
        modalOverlay.classList.remove('hidden');
        modalOverlay.classList.add('flex');
        modalOverlay.classList.remove('closed');
        modalContent.classList.remove('closed');
        modalOverlay.classList.add('open');
        modalContent.classList.add('open');
    }

    function closeModal() {
        modalOverlay.classList.add('closed');
        modalContent.classList.add('closed');
        setTimeout(() => {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
            modalOverlay.classList.remove('open');
            modalContent.classList.remove('open');
        }, 400);
    }

    quickGuideButton.addEventListener('click', openModal);
    closeModalButton.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });


    let financialTrendsChart, comparisonChart;

    async function fetchDashboardData() {
        try {
            const response = await fetch('dashboardData.php');
            if (!response.ok) throw new Error('Network error');
            return await response.json();
        } catch (err) {
            console.error('Error fetching dashboard data:', err);
            return null;
        }
    }

    function updateStatCards(data) {
        if (!data) return;

        document.getElementById('grossPurchases').textContent = `₱ ${data.grossPurchases.toLocaleString()}`;
        document.getElementById('netPurchases').textContent = `₱ ${data.netPurchases.toLocaleString()}`;
        document.getElementById('inputTax').textContent = `₱ ${data.inputTax.toLocaleString()}`;
        document.getElementById('vatExempt').textContent = `₱ ${data.vatExemptPurchases.toLocaleString()}`;
        document.getElementById('zeroRated').textContent = `₱ ${data.zeroRatedPurchases.toLocaleString()}`;
    }

    function getChartOptions(data) {
        const textColor = '#475569';
        const gridColor = '#e2e8f0';

        return {
            financialTrends: {
                series: [
                    { name: 'Gross Purchases', data: data.monthlyFinancialTrends.map(d => d.grossPurchases) },
                    { name: 'Input Tax', data: data.monthlyFinancialTrends.map(d => d.inputTax) },
                    { name: 'Net Purchases', data: data.monthlyFinancialTrends.map(d => d.netPurchases) }
                ],
                chart: { height: 350, type: 'area', toolbar: { show: false }, background: 'transparent' },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2.5 },
                colors: ['#ec4899', '#d946ef', '#8b5cf6'],
                fill: { type: "gradient", gradient: { shade: 'light', opacityFrom: 0.7, opacityTo: 0.1 } },
                xaxis: {
                    categories: data.monthlyFinancialTrends.map(d => d.month),
                    labels: { style: { colors: textColor, fontSize: '12px' } },
                    axisBorder: { show: false }, axisTicks: { show: false }
                },
                yaxis: { labels: { style: { colors: textColor }, formatter: val => `₱ ${val}` } },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                legend: { position: 'top', horizontalAlign: 'left' }
            },
            comparison: {
                series: [
                    { name: 'This Month', data: data.financialComparison.map(c => c.thisMonth) },
                    { name: 'Last Month', data: data.financialComparison.map(c => c.lastMonth) }
                ],
                chart: { type: 'bar', height: 350, toolbar: { show: false }, background: 'transparent' },
                plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 6 } },
                dataLabels: { enabled: false },
                colors: ['#ec4899', '#8b5cf6'],
                xaxis: {
                    categories: data.financialComparison.map(c => c.category),
                    labels: { style: { colors: textColor } }
                },
                yaxis: { labels: { style: { colors: textColor }, formatter: val => `₱ ${val}` } },
                legend: { position: 'top', horizontalAlign: 'right' }
            }
        };
    }

    async function renderDashboard() {
        const data = await fetchDashboardData();
        if (!data) return;

        updateStatCards(data);

        const options = getChartOptions(data);

        if (financialTrendsChart) financialTrendsChart.destroy();
        if (comparisonChart) comparisonChart.destroy();

        financialTrendsChart = new ApexCharts(document.querySelector("#financialTrendsChart"), options.financialTrends);
        comparisonChart = new ApexCharts(document.querySelector("#comparisonChart"), options.comparison);

        financialTrendsChart.render();
        comparisonChart.render();
    }

    let dataTable = $('#dataViewerTable').DataTable({
        "dom": 't<"flex justify-end pt-4"p>',
        "paging": true,
        "searching": true,
        "pageLength": 7,
        "info": false,
        "lengthChange": false
    });

    // Re-initialize search for the filter input
    const filterSearchInput = document.querySelector('#data-viewer input[type="text"]');
    if (filterSearchInput) {
        filterSearchInput.addEventListener('keyup', function () {
            dataTable.search(this.value).draw();
        });
    }

    // --- Data Viewer Dynamic Fetching ---
    async function fetchDataViewerData(params = {}) {
        const query = new URLSearchParams(params).toString();
        const response = await fetch(`dataViewerData.php?${query}`);
        const result = await response.json();
        return result;
    }

    async function loadDataViewerTable() {
        const searchInput = document.querySelector('#data-viewer input[type="text"]');
        const supplierSelect = document.querySelectorAll('#data-viewer select')[0];
        const categorySelect = document.querySelectorAll('#data-viewer select')[1];

        const params = {
            search: searchInput.value || "",
            supplier: supplierSelect.value === "All Suppliers" ? "" : supplierSelect.value,
            expense_category: categorySelect.value === "All Expense Categories" ? "" : categorySelect.value,
            limit: 100
        };

        try {
            const result = await fetchDataViewerData(params);

            if (result.status !== 'success' || !Array.isArray(result.data)) {
                dataTable.clear().draw();
                return;
            }

            const rows = result.data.map(item => [
                `<img src="${item.imageUrl || item.file_path || 'https://placehold.co/40x40/fce7f3/db2777?text=IMG'}" class="rounded-md w-10 h-10">`,
                item.date || '—',
                item.orderNumber || '—',
                `<span class="font-medium text-slate-900">${item.supplierName || '—'}</span>`,
                item.supplierAddress || '—',
                item.grossAmount ? `₱${Number(item.grossAmount).toLocaleString()}` : '—',
                item.netAmount ? `₱${Number(item.netAmount).toLocaleString()}` : '—',
                item.inputTax ? `₱${Number(item.inputTax).toLocaleString()}` : '<span class="text-red-500">NA</span>'
            ]);

            dataTable.clear().rows.add(rows).draw();

        } catch (error) {
            console.error("Data Viewer Load Error:", error);
        }
    }

    document.querySelector('#data-viewer input[type="text"]').addEventListener('input', debounce(loadDataViewerTable, 400));
    document.querySelectorAll('#data-viewer select').forEach(sel => sel.addEventListener('change', loadDataViewerTable));
    document.querySelector('#data-viewer button').addEventListener('click', loadDataViewerTable);

    function debounce(fn, delay) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn(...args), delay);
        };
    }

    async function loadDropdownOptions() {
        const supplierSelect = document.getElementById('supplierSelect');
        const categorySelect = document.getElementById('categorySelect');

        try {
            const response = await fetch('dataViewerOptions.php');
            const result = await response.json();

            if (result.status === 'success') {
                supplierSelect.innerHTML = `<option value="">All Suppliers</option>`;
                categorySelect.innerHTML = `<option value="">All Expense Categories</option>`;

                result.suppliers.forEach(supplier => {
                    const opt = document.createElement('option');
                    opt.value = supplier;
                    opt.textContent = supplier;
                    supplierSelect.appendChild(opt);
                });

                result.categories.forEach(category => {
                    const opt = document.createElement('option');
                    opt.value = category;
                    opt.textContent = category;
                    categorySelect.appendChild(opt);
                });
            } else {
                console.warn('Dropdown data not loaded properly:', result);
            }
        } catch (error) {
            console.error('Error loading dropdown options:', error);
        }
    }

    loadDropdownOptions();
    loadDataViewerTable();

    // --- Reset Filters Button ---
    resetFiltersBtn.addEventListener('click', async () => {
        const supplierSelect = document.getElementById('supplierSelect');
        const categorySelect = document.getElementById('categorySelect');
        const searchInput = document.querySelector('#data-viewer input[type="text"]');

        searchInput.value = '';
        supplierSelect.value = '';
        categorySelect.value = '';

        const dataTableInstance = $('#dataViewerTable').DataTable();
        dataTableInstance.search('').draw();

        await loadDataViewerTable();
    });

    setActiveTab('dashboard', true);
    renderDashboard();

    window.addEventListener('resize', () => {
        const activeTab = document.querySelector('.tab-link.text-pink-500');
        movePill(activeTab);
    });
});