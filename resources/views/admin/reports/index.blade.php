@extends('layouts.app')

@section('title', 'Admin Reports')

@section('content')
<div class="p-4 sm:p-8 space-y-6 sm:space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-slate-100">Reports</h1>
            <p class="text-slate-500 dark:text-slate-400">Download loan, contribution and withdrawal reports (Excel/PDF) + view graphs.</p>
        </div>

        <div class="flex items-center gap-3">
            <button id="resetBtn" class="px-4 h-11 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm font-bold hover:bg-slate-100 dark:hover:bg-slate-700">
                Reset
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row gap-4 sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Report Generator</h2>
                <p class="text-sm text-slate-500">Select a report type, filter by date, then download or visualize.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" class="report-type-btn px-4 py-2 rounded-lg border text-xs font-bold" data-type="loans">Loans</button>
                <button type="button" class="report-type-btn px-4 py-2 rounded-lg border text-xs font-bold" data-type="contributions">Contributions</button>
                <button type="button" class="report-type-btn px-4 py-2 rounded-lg border text-xs font-bold" data-type="withdrawals">Withdrawals</button>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <form id="reportForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">From</label>
                        <input id="from" type="date" name="from" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-sm font-bold text-on-surface-variant p-3 focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">To</label>
                        <input id="to" type="date" name="to" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-sm font-bold text-on-surface-variant p-3 focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Exports</label>
                        <div class="flex gap-3 flex-wrap">
                            <button type="button" id="excelBtn" class="px-4 py-3 bg-primary text-white rounded-lg font-black text-xs uppercase tracking-widest hover:bg-primary/90">
                                Excel
                            </button>
                            <button type="button" id="pdfBtn" class="px-4 py-3 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-lg font-black text-xs uppercase tracking-widest border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700">
                                PDF
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Reports may take time to generate for large date ranges.
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-start justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Graph</h2>
                <p class="text-sm text-slate-500">Monthly trend based on selected date range.</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total</p>
                <p class="text-xl font-black text-slate-900 dark:text-white">
                    <span id="totalAmount">0</span>
                </p>
                <p class="text-xs font-bold text-slate-500">Items: <span id="totalCount">0</span></p>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="h-[300px] w-full relative">
                <div class="absolute inset-0 flex flex-col justify-between pt-2">
                    <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                    <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                    <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                    <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                    <div class="border-t border-slate-100 dark:border-slate-800 w-full"></div>
                </div>

                <svg id="chartSvg" class="absolute inset-0 h-full w-full" preserveAspectRatio="none" viewBox="0 0 1000 300">
                    <defs>
                        <linearGradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#1773cf" />
                            <stop offset="100%" stop-color="#1773cf" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    <path id="areaPath" d="M0 300 L1000 300 Z" fill="url(#chartGradient)" opacity="0.1"></path>
                    <polyline id="linePath" fill="none" stroke="#1773cf" stroke-width="3" stroke-linecap="round" points=""></polyline>
                </svg>

                <div class="absolute bottom-[-24px] w-full flex justify-between px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="xAxisLabels">
                    <span>—</span><span>—</span><span>—</span><span>—</span><span>—</span><span>—</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const form = document.getElementById('reportForm');
        const fromInput = document.getElementById('from');
        const toInput = document.getElementById('to');

        const excelBtn = document.getElementById('excelBtn');
        const pdfBtn = document.getElementById('pdfBtn');

        const resetBtn = document.getElementById('resetBtn');

        const typeButtons = Array.from(document.querySelectorAll('.report-type-btn'));
        let selectedType = 'loans';

        const totalAmountEl = document.getElementById('totalAmount');
        const totalCountEl = document.getElementById('totalCount');
        const linePath = document.getElementById('linePath');
        const areaPath = document.getElementById('areaPath');
        const xAxisLabels = document.getElementById('xAxisLabels');

        function setActiveType(type) {
            selectedType = type;
            typeButtons.forEach(btn => {
                const active = btn.dataset.type === type;
                btn.classList.toggle('bg-primary', active);
                btn.classList.toggle('text-white', active);
                btn.classList.toggle('border-primary', active);

                btn.classList.toggle('bg-white', !active);
                btn.classList.toggle('text-slate-700', !active);
                btn.classList.toggle('dark:text-slate-200', !active);
                btn.classList.toggle('border-slate-200', !active);
                btn.classList.toggle('dark:border-slate-700', !active);
            });
        }

        function getPayload() {
            return {
                type: selectedType,
                from: fromInput.value || '',
                to: toInput.value || ''
            };
        }

        async function fetchData() {
            const payload = getPayload();
            const params = new URLSearchParams(payload);

            const res = await fetch(`{{ route('admin.reports.data') }}?` + params.toString(), {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            });
            const data = await res.json();
            renderGraph(data);
        }

        function renderGraph(data) {
            const points = data.points || [];
            const amounts = points.map(p => Number(p.amount));
            const maxAmount = Math.max(...amounts, 0) || 1;

            const chartWidth = 1000;
            const chartHeight = 300;
            const paddingBottom = 0;

            if (!points.length) {
                totalAmountEl.textContent = '0';
                totalCountEl.textContent = '0';
                linePath.setAttribute('points', '');
                areaPath.setAttribute('d', `M0 ${chartHeight} L${chartWidth} ${chartHeight} Z`);
                xAxisLabels.innerHTML = '<span>—</span><span>—</span><span>—</span><span>—</span><span>—</span><span>—</span>';
                return;
            }

            const totalAmount = data.totals?.amount ?? 0;
            const totalCount = data.totals?.count ?? 0;
            totalAmountEl.textContent = `₵${Number(totalAmount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            totalCountEl.textContent = Number(totalCount);

            const n = points.length;
            let polyPoints = '';
            let areaD = `M0 ${chartHeight}`;

            points.forEach((p, i) => {
                const x = n === 1 ? 0 : (i / (n - 1)) * chartWidth;
                const y = chartHeight - ((Number(p.amount) / maxAmount) * (chartHeight - 60));
                polyPoints += (i === 0 ? '' : ' ') + `${x},${y}`;
                areaD += ` L${x} ${y}`;
            });
            areaD += ` L${chartWidth} ${chartHeight} Z`;

            linePath.setAttribute('points', polyPoints);
            areaPath.setAttribute('d', areaD);

            // X labels: show up to 6 evenly spaced labels
            const maxLabels = 6;
            const labels = [];
            for (let i = 0; i < maxLabels; i++) {
                const idx = Math.round((i / (maxLabels - 1)) * (n - 1));
                labels.push(points[idx]?.month || '');
            }
            xAxisLabels.innerHTML = labels.map(l => `<span>${l}</span>`).join('');
        }

        excelBtn.addEventListener('click', () => {
            const payload = getPayload();
            const params = new URLSearchParams(payload);
            const url = `{{ route('admin.reports.export.excel') }}?` + params.toString();
            window.location.href = url;
        });

        pdfBtn.addEventListener('click', () => {
            alert('PDF export is not implemented yet for this module.');
        });

        resetBtn.addEventListener('click', () => {
            fromInput.value = '';
            toInput.value = '';
            setActiveType('loans');
            fetchData();
        });

        typeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                setActiveType(btn.dataset.type);
                fetchData();
            });
        });

        fromInput.addEventListener('change', fetchData);
        toInput.addEventListener('change', fetchData);

        // Defaults
        setActiveType('loans');
        fetchData();
    })();
</script>
@endsection

