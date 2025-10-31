<div class="container-fluid">
    <form id="editUserForm" action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
        @csrf

        <div class="row g-2">
            {{-- Column 1: Basic Information --}}
            <div class="col-md-4">
                <div class="card mb-2 border-dark">
                    <div class="card-header fw-bold">Basic Information</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label small">First Name *</label>
                            <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Last Name *</label>
                            <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Email *</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Phone *</label>
                            <input type="text" name="phone" value="{{ $user->phone }}" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">User Type *</label>
                            <select name="user_type" class="form-select form-select-sm" required>
                                @foreach(['tenant','landlord','agent'] as $type)
                                    <option value="{{ $type }}" {{ $user->user_type == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Role *</label>
                            @php
                                $roles = DB::table('users')->select('role')->distinct()->pluck('role');
                            @endphp
                            <select name="role" class="form-select form-select-sm" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Column 2: Location & Budget + Company Info --}}
            <div class="col-md-4">
                {{-- Location & Budget --}}
                <div class="card mb-2 border-dark">
                    <div class="card-header fw-bold">Location & Budget</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label small">Preferred Location</label>
                            <input type="text" name="preferred_location" value="{{ $user->preferred_location }}" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Budget Min</label>
                            <input type="number" step="0.01" name="budget_min" value="{{ $user->budget_min }}" class="form-control form-control-sm" placeholder="0.00">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Budget Max</label>
                            <input type="number" step="0.01" name="budget_max" value="{{ $user->budget_max }}" class="form-control form-control-sm" placeholder="0.00">
                        </div>
                    </div>
                </div>

                {{-- Company Information --}}
                <div class="card mb-2 border-dark">
                    <div class="card-header fw-bold">Company Information</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label small">Company Name</label>
                            <input type="text" name="company_name" value="{{ $user->company_name }}" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Tax ID</label>
                            <input type="text" name="tax_id" value="{{ $user->tax_id }}" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Column 3: Professional Details --}}
            <div class="col-md-4">
                <div class="card mb-2 border-dark">
                    <div class="card-header fw-bold">Professional Details</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label small">Agency Name</label>
                            <input type="text" name="agency_name" value="{{ $user->agency_name }}" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">License Number</label>
                            <input type="text" name="license_number" value="{{ $user->license_number }}" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Experience</label>
                            <input type="text" name="experience" value="{{ $user->experience }}" class="form-control form-control-sm" placeholder="e.g., 5 years">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('superadmin.users') }}" class="btn btn-dark btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-dark  btn-sm">Update User</button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .form-label { margin-bottom: 0.25rem; }
    .form-control-sm, .form-select-sm { font-size: 0.875rem; padding: 0.375rem 0.75rem; }
    .card-header { font-size: 0.9rem; font-weight: bold; background-color: #fff; color: #000; }
    .card { background-color: #fff; color: #000; }
    .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
</style>
