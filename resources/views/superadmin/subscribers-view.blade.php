
<div class="container">
    <div class="mt-4">
        <h2>Subscriber Details</h2>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $subscriber->id }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $subscriber->email }}</td>
            </tr>
            <tr>
                <th>Subscribed At</th>
                <td>{{ \Carbon\Carbon::parse($subscriber->subscribed_at)->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $subscriber->is_active ? 'Active' : 'Inactive' }}</td>
            </tr>
        </table>
        <a href="{{ route('superadmin.subscribers') }}" class="btn btn-dark">Back</a>
    </div>
</div>

