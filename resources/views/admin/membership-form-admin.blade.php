@extends('layouts.app')

@section('title', 'Staff Membership')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-bold">Add a Staff Member</h1>
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
            {{-- @foreach ($members as $member) --}}
                <form action="{{ route('admin.membership-form-admin') }}" method="POST">
                    @csrf
                    <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-primary">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">person</span>
                            <h2 class="text-xl font-black tracking-tight uppercase">Personal Information</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">First
                                    Name</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="e.g. Alexander" name="fname" type="text" value="{{ old('fname') }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Middle
                                    Name</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="e.g. Gyamfi" name="mname" type="text" value="{{ old('mname') }}" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Last
                                    Name</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="e.g. Nketia" name="lname" type="text" value="{{ old('lname') }}" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Staff
                                    Number / Provident ID</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" readonly name="staff_no" id="staff_no" placeholder="Staff Number"
                                    value="{{ $generatestaffno }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Contact
                                    Number</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="0256188992" maxlength="10" name="phone_no" type="tel" value="{{ old('phone_no') }}"/>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Staff
                                    Email</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="vance.a@prudential.com" name="email" type="email" value="{{ old('email') }}"/>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Date
                                    of Birth</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="e.g. 2023-01-01" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" />
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
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Members
                                    Company and Department</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="e.g. Sasakawa" name="company" type="text" value="{{ old('company') }}" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Job
                                    Title</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="Senior Analyst" type="text" name="job_title" value="{{ old('job_title') }}" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Date
                                    of Employment</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    placeholder="e.g. 2023-01-01" type="date" name="date_of_employment" value="{{ old('date_of_employment') }}" />
                            </div>
                        </div>
                    </section>
                    <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-primary">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">money</span>
                            <h2 class="text-xl font-black tracking-tight uppercase">Bank Details</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Bank
                                    Name</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" name="bank_name" id="bank_name" placeholder="Bank Name" value="{{ old('bank_name') }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Account
                                    Number</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" name="account_number" id="account_number"
                                    placeholder="Account Number" value="{{ old('account_number') }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Account
                                    Name</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" name="account_name" id="account_name" placeholder="Account Name" value="{{ old('account_name') }}" />
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
                                    type="text" name="next_of_kin_name" id="next_of_kin_name"
                                    placeholder="Next of Kin Full Name" value="{{ old('next_of_kin_name') }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Relationship</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" name="next_of_kin_relationship" id="next_of_kin_relationship"
                                    placeholder="Relationship to Next of Kin" value="{{ old('next_of_kin_relationship') }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Contact
                                    Number</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" name="next_of_kin_phone" id="next_of_kin_phone"
                                    placeholder="Next of Kin Contact Number" value="{{ old('next_of_kin_phone') }}" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Email
                                    Address</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="email" name="next_of_kin_email" id="next_of_kin_email"
                                    placeholder="Next of Kin Email Address" value="{{ old('next_of_kin_email') }}" />
                            </div>
                            <div class="space-y-1 md:col-span-2">
                                <label
                                    class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Residential
                                    Address</label>
                                <input
                                    class="w-full border-none bg-surface-container-low focus:ring-2 focus:ring-primary text-on-surface font-semibold p-3"
                                    type="text" name="next_of_kin_address" id="next_of_kin_address"
                                    placeholder="Next of Kin Residential Address" value="{{ old('next_of_kin_address') }}" />
                            </div>
                        </div>
                    </section>

                    <!-- Contribution Setup -->
                    <section class="bg-surface-container-lowest p-8 shadow-sm border-l-4 border-secondary">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-secondary bg-secondary/10 p-2 rounded-lg"
                                style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                            <h2 class="text-xl font-black tracking-tight uppercase text-on-surface">Contribution Setup</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-6">
                            <div class="bg-secondary-container p-4 flex gap-4 items-start">
                                <span class="material-symbols-outlined text-on-secondary-container">verified_user</span>
                                <div>
                                    <p class="text-sm font-bold text-on-secondary-container uppercase tracking-tight">
                                        Matched Employer Contribution</p>
                                    <p class="text-xs text-on-secondary-container opacity-80 mt-1">Prudential Fund
                                        Association matches up to 10% of your monthly base contribution automatically.</p>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row gap-4">
                                <div
                                    class="flex-1 p-4 bg-white border-2 border-primary ring-2 ring-primary/20 text-left">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">Option
                                        A</span>
                                    <p class="text-lg font-black mt-1">Monthly Percentage</p>
                                    <div class="mt-4 flex items-center gap-2">
                                        <input class="w-16 border-none bg-surface-container-low p-2 font-bold text-center"
                                            type="number" value="{{ old('monthly_contribution') }}" min="10" name="monthly_contribution"/>
                                        <span class="font-bold text-xl">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Consent & Actions -->
                    <section class="bg-white p-8">
                        <label class="flex items-start gap-4 cursor-pointer">
                            <input class="mt-1 rounded-none border-slate-300 text-primary focus:ring-primary h-5 w-5"
                                type="checkbox" name="signed_agreement" id="signed_agreement" {{ old('signed_agreement') ? 'checked' : '' }}/>
                            <span class="text-sm font-medium text-on-surface-variant">
                                I hereby declare that the information provided above is true and accurate to the best of my
                                knowledge. I consent to the <a class="text-primary font-bold underline"
                                    href="#">Terms of
                                    Service</a> and the processing of my employment data for fund
                                administration purposes.
                            </span>
                        </label>
                        <div class="mt-12 flex flex-col md:flex-row gap-4">
                            <button
                                class="flex-[2] py-4 bg-primary text-white font-bold uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">Submit
                                Application</button>
                        </div>
                    </section>
                </form>
            {{-- @endforeach --}}
        </div>
        <!-- Sidebar Info/Summary -->
        <div class="space-y-6">
            <div class="bg-slate-900 text-white p-6 shadow-xl relative overflow-hidden">
                <!-- Subtle pattern overlay -->
                <div
                    class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(circle_at_1px_1px,_#ffffff_1px,_transparent_0)] bg-[size:20px_20px]">
                </div>
                <h3 class="text-sm font-bold uppercase tracking-widest text-primary mb-6">Application Summary</h3>

                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="text-xs font-bold uppercase tracking-widest text-secondary mb-2">Total Staff</p>
                    <div class="text-3xl font-black tracking-tighter">{{ $members->count() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
