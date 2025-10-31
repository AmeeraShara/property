
<div class="container">

    <div class="mt-4">
        <h2>Edit Subscriber</h2>

        <form action="{{ route('superadmin.subscribers.update', $subscriber->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $subscriber->email) }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <select name="is_active" id="is_active" class="form-select" required>
                    <option value="1" {{ $subscriber->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$subscriber->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-dark">Update</button>
            <a href="{{ route('superadmin.subscribers') }}" class="btn btn-dark">Cancel</a>
        </form>
    </div>
</div>

