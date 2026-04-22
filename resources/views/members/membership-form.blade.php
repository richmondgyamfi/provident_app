@extends('layouts.app')

@section('title', 'Staff Membership Application')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-bold">Staff Membership Application</h1>
        <p class="text-gray-500">Fill in your details to join the fund</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        {{-- let all feeback from the controller show here --}}
            
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            {{-- menbers form --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-4 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif  
            @foreach ($members as $member)
                
            <form action="{{ route('members.store') }}" method="POST" >
                @csrf
                <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">person</span>
                        <h2 class="text-xl font-black tracking-tight uppercase">Personal Information</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Full
                                Name</label>
                            <p>{{ $member->fname.' '.$member->mname.' '.$member->lname }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Staff Number</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" readonly name="staff_no" id="staff_no" placeholder="Staff Number" value="{{ $member->staff_no }}"/>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Contact
                                Number</label>
                            <p>{{ $member->phone }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Office
                                Email</label>
                            <p>{{ $member->ucc_mail }}</p>
                        </div>
                    </div>
                </section>
                <!-- Employment Details -->
                <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">corporate_fare</span>
                        <h2 class="text-xl font-black tracking-tight uppercase">Employment Details</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1 md:col-span-2">
                            <label
                                class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Department</label>
                            <p>{{ $member->department }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Job
                                Title</label>
                            <p>{{ $member->job_title }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Date
                                of Joining</label>
                            <p>{{ $member->appoint_date }}</p>
                        </div>
                    </div>
                </section>
                <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">money</span>
                        <h2 class="text-xl font-black tracking-tight uppercase">Bank Details</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Bank Name</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="bank_name" id="bank_name" placeholder="Bank Name" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Account Number</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="account_number" id="account_number" placeholder="Account Number" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Account Name</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="account_name" id="account_name" placeholder="Account Name" />
                        </div>
                    </div>
                </section>

                {{-- next of kin --}}
                <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-primary">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">family_restroom</span>
                        <h2 class="text-xl font-black tracking-tight uppercase">Next of Kin Details</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Full
                                Name</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="next_of_kin_name" id="next_of_kin_name" placeholder="Next of Kin Full Name" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Relationship</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="next_of_kin_relationship" id="next_of_kin_relationship" placeholder="Relationship to Next of Kin" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Contact
                                Number</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="next_of_kin_phone" id="next_of_kin_phone" placeholder="Next of Kin Contact Number" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Email
                                Address</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="email" name="next_of_kin_email" id="next_of_kin_email" placeholder="Next of Kin Email Address" />
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label
                                class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Residential
                                Address</label>
                            <input
                                class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                type="text" name="next_of_kin_address" id="next_of_kin_address" placeholder="Next of Kin Residential Address" />
                        </div>
                    </div>
                </section>
                
                <!-- Contribution Setup -->
                <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-secondary">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-secondary bg-secondary/10 p-2 rounded-lg"
                            style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                        <h2 class="text-xl font-black tracking-tight uppercase text-on-surface">Contribution</h2>
                    </div>
                    <div class="flex-1 p-4 bg-white border-2 border-primary ring-2 ring-primary/20 text-left">
                        {{-- <p class="text-lg font-black mt-1">Monthly Contribution</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="font-bold text-xl">GHC</span>
                            <input class="w-50 border-none bg-surface-container-low p-2 font-bold text-center"
                                type="number" name="monthly_contribution" value="500" min="1" />
                        </div> --}}
                        <p class="text-lg font-black mt-1">Monthly Percentage</p>
                        <small>Monthly percentage of ut contributions on your basic salary (at least 10%)</small>
                        <div class="mt-4 flex items-center gap-2">
                            <input class="w-16 border-none bg-surface-container-low p-2 font-bold text-center"
                                type="number" value="10" min="10" name="monthly_contribution" />
                            <span class="font-bold text-xl">%</span>
                        </div>
                    </div>
                </section>
                <!-- Consent & Actions -->
                <section class="bg-white p-8">
                    <label class="flex items-start gap-4 cursor-pointer">
                        <input class="mt-1 rounded-none border-slate-300 text-primary focus:ring-primary h-5 w-5"
                            type="checkbox" name="signed_agreement" id="signed_agreement"/>
                        <span class="text-sm font-medium text-on-surface-variant">
                            I hereby declare that the information provided above is true and accurate to the best of my
                            knowledge. I consent to the <a class="text-primary font-bold underline" href="#">Terms of
                                Service</a> and the processing of my employment data for fund
                            administration purposes.
                        </span>
                    </label>
                    <div class="mt-12 flex flex-col md:flex-row gap-4">
                        {{-- <button
                            class="flex-1 py-4 border-2 border-primary text-primary font-bold uppercase tracking-widest hover:bg-primary/5 transition-all">Save
                            Draft</button> --}}
                        <button
                            class="flex-[2] py-4 bg-primary text-white font-bold uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">Submit
                            Application</button>
                    </div>
                </section>
            </form>
            @endforeach
        </div>
        <!-- Sidebar Info/Summary -->
        <div class="space-y-6">
            <div class="bg-slate-900 text-white p-6 shadow-xl relative overflow-hidden">
                <!-- Subtle pattern overlay -->
                <div
                    class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_1px_1px,_#ffffff_1px,_transparent_0)] bg-[size:20px_20px]">
                </div>
                <h3 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Application Summary</h3>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center pb-2 border-b border-white/10">
                        <span class="text-xs uppercase opacity-60 font-bold">Status</span>
                        <span class="text-xs bg-secondary/30 text-secondary px-2 py-1 font-bold">IN PROGRESS</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-white/10">
                        <span class="text-xs uppercase opacity-60 font-bold">Member Type</span>
                        <span class="text-xs font-bold">Institutional Staff</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-white/10">
                        <span class="text-xs uppercase opacity-60 font-bold">Assigned Tier</span>
                        <span class="text-xs font-bold">Premium Ledger</span>
                    </div>
                </div>
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="text-xs font-bold uppercase tracking-widest text-secondary mb-2">Estimated Yield</p>
                    <div class="text-3xl font-black tracking-tighter">GHS 0</div>
                    <p class="text-[10px] opacity-60 mt-1">Projected annual compounding based on 5% base
                        contribution + 5% matching.</p>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 shadow-sm border-l-4 border-secondary">
                <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface mb-4">Support &amp; Audit
                </h4>
                <div class="space-y-3">
                    <a class="flex items-center gap-2 text-xs font-bold text-primary hover:underline" href="#">
                        <span class="material-symbols-outlined text-sm">help</span>
                        Fund Policy Manual
                    </a>
                    <a class="flex items-center gap-2 text-xs font-bold text-primary hover:underline" href="#">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        Processing Timeline
                    </a>
                    <a class="flex items-center gap-2 text-xs font-bold text-primary hover:underline" href="#">
                        <span class="material-symbols-outlined text-sm">contact_support</span>
                        Contact HR Liaison
                    </a>
                </div>
            </div>
            {{-- <div class="rounded-xl overflow-hidden shadow-sm">
                <img alt="Institutional Building" class="w-full h-48 object-cover"
                    data-alt="Monochromatic low angle shot of a modern glass skyscraper with geometric patterns reflecting a clear blue sky"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFK1YLrKup7U7M8MBSW7k4-RCS-YaIAe2ihwP_tSHs0bu8GKeq3zcY7YBJoh7BiYDHMLcJKA8Yh4Kc8_-FDIKmYLnTj-uSJfmmZtVt2PNkPc36Addx5kQWQiOqtgmwk-F8tsvRsKXjn_kWuKfbq6iFgLdSG0EUJNQbF-Y6ZsTyKL26N-_DPobriAMKZL_Hzfe6jA2AWjYZ0lk_gsgwlQd5yVrH9eJvM1SDw2mLavkebXR5AfkeiYQk0ttzpJ_yi5TPTYnh-Jpos8Y" />
            </div> --}}
        </div>
    </div>
@endsection
