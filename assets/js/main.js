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
                chart: { height: 350, type: 'area', toolbar: { show: false }, background: 'transparent', zoom: { enabled: false }, animations: { enabled: true } },
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

    // --- Data Table Logic ---
    let dataTable = $('#dataViewerTable').DataTable({
        dom: 't<"flex justify-end pt-4"p>',
        paging: true,
        searching: true,
        pageLength: 7,
        info: false,
        lengthChange: false,
        columnDefs: [
            { orderable: false, targets: -1 }
        ],
        drawCallback: function () {
            if (window.feather) feather.replace();
            if (window.lucide) lucide.createIcons();
        }
    });

    const filterSearchInput = document.querySelector('#data-viewer input[type="text"]');
    if (filterSearchInput) {
        filterSearchInput.addEventListener('keyup', function () {
            dataTable.search(this.value).draw();
        });
    }

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
                item.grossAmount ? `₱ ${Number(item.grossAmount).toLocaleString()}` : '—',
                item.netAmount ? `₱ ${Number(item.netAmount).toLocaleString()}` : '—',
                item.inputTax ? `₱ ${Number(item.inputTax).toLocaleString()}` : '<span class="text-red-500">NA</span>',
                `
                <div class="flex items-center justify-center space-x-3">
                    <button class="view-btn text-blue-500 hover:text-blue-700" title="View" data-id="${item.id}">
                        <i data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                    <button class="edit-btn text-green-500 hover:text-green-700" title="Edit" data-id="${item.id}">
                        <i data-lucide="edit" class="w-5 h-5"></i>
                    </button>
                    <button class="delete-btn text-red-500 hover:text-red-700" title="Delete" data-id="${item.id}">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>
                `
            ]);

            dataTable.clear().rows.add(rows).draw();
            feather.replace();
            if (window.lucide) lucide.createIcons();

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
            }
        } catch (error) {
            console.error('Error loading dropdown options:', error);
        }
    }

    loadDropdownOptions();
    loadDataViewerTable();

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

    // --- Light View/Edit/Delete Modals ---
    document.getElementById('dataViewerTable').addEventListener('click', async (e) => {
        const viewBtn = e.target.closest('.view-btn');
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');

        // --- VIEW RECORD ---
        if (viewBtn) {
            const id = viewBtn.dataset.id;

            try {
                const formData = new FormData();
                formData.append('action', 'view');
                formData.append('id', id);

                const response = await fetch('receiptDetail.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.status === 'success') {
                    const item = data.data;

                    document.getElementById('viewImage').src = item.file_path;
                    document.getElementById('vDate').textContent = item.date || '';
                    document.getElementById('vOrderNumber').textContent = item.order_or_reference_number || '';
                    document.getElementById('vSupplierName').textContent = item.supplier_name || '';
                    document.getElementById('vSupplierAddress').textContent = item.supplier_address || '';
                    document.getElementById('vSupplierRegisterName').textContent = item.supplier_register_name || '';
                    document.getElementById('vSupplierTIN').textContent = item.supplier_tin || '';
                    document.getElementById('vPurchaseCategory').textContent = item.purchase_category || '';
                    document.getElementById('vExpenseCategory').textContent = item.expense_category || '';
                    document.getElementById('vGrossAmount').textContent = `₱ ${Number(item.gross_purchase_amount).toLocaleString()}`;
                    document.getElementById('vNetAmount').textContent = `₱ ${Number(item.net_purchase_amount).toLocaleString()}`;
                    document.getElementById('vInputTax').textContent = `₱ ${Number(item.input_tax).toLocaleString()}`;
                    document.getElementById('vVatExempt').textContent = item.vat_exempt_purchases || '';
                    document.getElementById('vZeroRated').textContent = item.zero_rated_purchases || '';

                    openLightModal('viewModal');
                } else {
                    Swal.fire('Error', data.message || 'Record not found', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'Failed to load record details', 'error');
            }
        }

        // --- EDIT RECORD ---
        if (editBtn) {
            const id = editBtn.dataset.id;

            try {
                const formData = new FormData();
                formData.append('action', 'view');
                formData.append('id', id);

                const response = await fetch('receiptDetail.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.status === 'success') {
                    const item = data.data;

                    let formattedDate = '';
                    if (item.date) {
                        const parts = item.date.split('/');
                        if (parts.length === 3) {
                            const [mm, dd, yyyy] = parts;
                            formattedDate = `${yyyy}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}`;
                        }
                    }

                    console.log(formattedDate)

                    document.getElementById('editId').value = item.id || '';
                    document.getElementById('editDate').value = formattedDate || '';
                    document.getElementById('editOrderNumber').value = item.order_or_reference_number || '';
                    document.getElementById('editSupplierName').value = item.supplier_name || '';
                    document.getElementById('editSupplierRegisterName').value = item.supplier_register_name || '';
                    document.getElementById('editSupplierAddress').value = item.supplier_address || '';
                    document.getElementById('editSupplierTIN').value = item.supplier_tin || '';
                    document.getElementById('editPurchaseCategory').value = item.purchase_category || '';
                    document.getElementById('editExpenseCategory').value = item.expense_category || '';
                    document.getElementById('editGrossAmount').value = item.gross_purchase_amount || '';
                    document.getElementById('editNetAmount').value = item.net_purchase_amount || '';
                    document.getElementById('editInputTax').value = item.input_tax || '';
                    document.getElementById('editVatExempt').value = item.vat_exempt_purchases || '';
                    document.getElementById('editZeroRated').value = item.zero_rated_purchases || '';
                    document.getElementById('editPreview').src = item.file_path;

                    openLightModal('editModal');
                } else {
                    Swal.fire('Error', data.message || 'Record not found', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'Failed to load record details', 'error');
            }
        }

        // --- DELETE RECORD ---
        if (deleteBtn) {
            const id = deleteBtn.dataset.id;

            Swal.fire({
                icon: 'warning',
                title: 'Delete this record?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6b7280'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const formData = new FormData();
                        formData.append('action', 'delete');
                        formData.append('id', id);

                        const response = await fetch('receiptDetail.php', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await response.json();

                        if (data.status === 'success') {
                            loadDropdownOptions();
                            loadDataViewerTable();
                            renderDashboard();
                            Swal.fire('Deleted!', data.message || 'Record deleted.', 'success');
                        } else {
                            Swal.fire('Error', data.message || 'Failed to delete record.', 'error');
                        }
                    } catch (err) {
                        Swal.fire('Error', 'Failed to delete record.', 'error');
                    }
                }
            });
        }
    });

    // --- EDIT FORM SUBMIT (Update Record) ---
    document.getElementById('editForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        let dateInput = document.getElementById('editDate').value;
        let [yyyy, mm, dd] = dateInput.split("-");
        let formattedDate = `${mm}/${dd}/${yyyy}`;
        formData.set('editDate', formattedDate);
        formData.append('action', 'update');

        try {
            Swal.fire({
                title: 'Updating...',
                text: 'Please wait while the record is being updated.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const response = await fetch('receiptDetail.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            Swal.close();

            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: result.message || 'Record updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });

                closeLightModal('editModal');
                loadDropdownOptions();
                loadDataViewerTable();
                renderDashboard();

            } else {
                Swal.fire('Error', result.message || 'Failed to update record.', 'error');
            }
        } catch (err) {
            Swal.close();
            Swal.fire('Error', 'An unexpected error occurred while updating.', 'error');
        }
    });

    function openLightModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex', 'fade-in');
    }

    function closeLightModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('closeViewModal').onclick = () => closeLightModal('viewModal');
    document.getElementById('closeEditModal').onclick = () => closeLightModal('editModal');
    document.getElementById('cancelEdit').onclick = () => closeLightModal('editModal');

    // document.getElementById('editImage').addEventListener('change', function (e) {
    //     const file = e.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = () => document.getElementById('editPreview').src = reader.result;
    //         reader.readAsDataURL(file);
    //     }
    // });

    const style = document.createElement('style');
    style.innerHTML = `
        .fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from {opacity:0; transform: scale(0.95);} to {opacity:1; transform: scale(1);} }
    `;
    document.head.appendChild(style);

    // --- Export Modal Logic ---
    const exportModal = document.getElementById("exportModal");
    const openExportModalBtn = document.getElementById("openExportModalBtn");
    const closeExportModalBtn = document.getElementById("closeExportModalBtn");
    const cancelExportBtn = document.getElementById("cancelExportBtn");
    const modalPanel = exportModal?.querySelector(".modal-panel");

    if (exportModal && openExportModalBtn && closeExportModalBtn && cancelExportBtn && modalPanel) {

        // Open modal
        openExportModalBtn.addEventListener("click", () => {
        exportModal.classList.remove("hidden");
        exportModal.classList.add("flex");
        setTimeout(() => {
            modalPanel.classList.remove("opacity-0", "scale-95");
            modalPanel.classList.add("opacity-100", "scale-100");
        }, 10);
        });

        // Close modal
        const closeModal = () => {
        modalPanel.classList.remove("opacity-100", "scale-100");
        modalPanel.classList.add("opacity-0", "scale-95");
        setTimeout(() => {
            exportModal.classList.remove("flex");
            exportModal.classList.add("hidden");
        }, 200);
        };

        closeExportModalBtn.addEventListener("click", closeModal);
        cancelExportBtn.addEventListener("click", closeModal);

        // Click outside to close
        exportModal.addEventListener("click", (e) => {
        if (e.target === exportModal) closeModal();
        });
    }

    async function exportReceiptData() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            Swal.fire({
            icon: 'warning',
            title: 'Missing Dates',
            text: 'Please select both start and end dates',
            timer: 2000,
            showConfirmButton: false
            });
            return;
        }

        const formData = new FormData();
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);

        const checkResponse = await fetch('exportReceipts.php', {
            method: 'POST',
            body: formData
        });

        const contentType = checkResponse.headers.get('Content-Type');

        if (contentType && contentType.includes('application/json')) {
            const result = await checkResponse.json();

            Swal.fire({
                icon: 'error',
                title: 'No Record Found',
                text: result.message || 'No data found in the selected date range',
                timer: 2500,
                showConfirmButton: false
            });
        } else {
            const blob = await checkResponse.blob();
            const url = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = 'receipts_data_export.csv';
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);

            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';

            const exportModal = document.getElementById("exportModal");
            const modalPanel = exportModal?.querySelector(".modal-panel");

            modalPanel.classList.remove("opacity-100", "scale-100");
            modalPanel.classList.add("opacity-0", "scale-95");
            setTimeout(() => {
                exportModal.classList.remove("flex");
                exportModal.classList.add("hidden");
            }, 200);

            Swal.fire({
                icon: 'success',
                title: 'Download Started!',
                timer: 2000,
                showConfirmButton: false
            });
        }
    }

    document.getElementById('exportReceiptsBtn').addEventListener('click', exportReceiptData);

    async function checkAuth() {
        try {
            const res = await fetch("include/auth.php?action=auth_js", { method: "POST" });
            const data = await res.json();
            if (data.response) window.location.href = "login.php";
        } catch (err) {
            console.error("Auth error:", err);
        }
    }

    setInterval(checkAuth, 15 * 60 * 1000);

    checkAuth();
});