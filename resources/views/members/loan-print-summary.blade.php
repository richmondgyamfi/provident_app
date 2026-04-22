@section('content')
<div class="print-only hidden">
  <div class="print-header flex items-center gap-4 mb-12 pb-8 border-b-2 border-slate-200">
    <img src="{{ asset('public/ucclogo_horizontal_blue.png') }}" alt="UCC PF Logo" class="h-12">
    <div>
      <h1 class="text-2xl font-black">LOAN APPLICATION FORM</h1>
      <p class="text-sm font-bold">Provident Fund Management System</p>
      <p class="text-lg font-black">Reference: <span id="print-ref-number">LN-2024-00000</span></p>
    </div>
  </div>

  <!-- Loan Details -->
  <div class="print-section mb-12">
    <h2 class="text-xl font-bold mb-6 pb-4 border-b">1. Loan Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div><strong>Amount:</strong> <span id="print-amount">₵0.00</span></div>
      <div><strong>Type:</strong> <span id="print-type">—</span></div>
      <div><strong>Term:</strong> <span id="print-term">— months</span></div>
      <div><strong>Purpose:</strong> <span id="print-purpose">—</span></div>
    </div>
  </div>

  <!-- Repayment Schedule -->
  <div class="print-section mb-12 page-break-before-avoid">
    <h2 class="text-xl font-bold mb-6 pb-4 border-b">2. Repayment Schedule</h2>
    <div class="overflow-x-auto">
      <table class="w-full border-collapse border border-slate-300">
        <thead>
          <tr class="bg-slate-100">
            <th class="border border-slate-300 p-3 text-left font-bold">Month</th>
            <th class="border border-slate-300 p-3 text-left font-bold">Opening Bal.</th>
            <th class="border border-slate-300 p-3 text-left font-bold">Principal</th>
            <th class="border border-slate-300 p-3 text-left font-bold">Interest</th>
            <th class="border border-slate-300 p-3 text-left font-bold">Payment</th>
            <th class="border border-slate-300 p-3 text-left font-bold">Closing Bal.</th>
          </tr>
        </thead>
        <tbody id="print-amort-table">
          <tr><td colspan="6" class="p-8 italic text-center">Schedule will appear here</td></tr>
        </tbody>
      </table>
    </div>
    <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
      <div><strong>Monthly:</strong> <span id="print-monthly">₵0.00</span></div>
      <div><strong>Total Interest:</strong> <span id="print-interest">₵0.00</span></div>
      <div><strong>Total Repayable:</strong> <span id="print-total">₵0.00</span></div>
    </div>
  </div>

  <!-- Supporting Documents -->
  <div class="print-section mb-12">
    <h2 class="text-xl font-bold mb-6 pb-4 border-b">3. Supporting Documents</h2>
    <div class="space-y-3">
      @php
        $docs = [
          ['id' => 'doc-id', 'label' => 'National ID / Passport'],
          ['id' => 'doc-payslip', 'label' => 'Latest 3 Pay Slips'],
          ['id' => 'doc-letter', 'label' => 'Employment Letter'],
          ['id' => 'doc-bank', 'label' => 'Bank Statement (3 months)'],
          ['id' => 'doc-purpose', 'label' => 'Proof of Purpose'],
          ['id' => 'doc-other', 'label' => 'Other Documents'],
        ];
      @endphp
      @foreach ($docs as $doc)
        <div class="flex justify-between">
          <span>{{ $doc['label'] }}</span>
          <span id="print-{{ $doc['id'] }}" class="font-mono text-sm">Not uploaded</span>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Terms Summary -->
  <div class="print-section mb-12">
    <h2 class="text-xl font-bold mb-6 pb-4 border-b">4. Terms Accepted</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div><strong>Full Name:</strong> <span id="print-fullname">—</span></div>
      <div><strong>Date:</strong> <span id="print-date">{{ date('Y-m-d') }}</span></div>
      <div class="md:col-span-2"><strong>Declarations:</strong> All checkboxes confirmed</div>
    </div>
  </div>

  <!-- Footer -->
  <div class="mt-16 pt-8 border-t text-xs text-center text-slate-500">
    <p>Generated on {{ date('Y-m-d H:i') }} | Provident Fund Management System</p>
    <p>This is a computer-generated document. Original application stored securely.</p>
  </div>
</div>
@endsection

