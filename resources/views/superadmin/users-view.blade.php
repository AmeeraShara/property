
<div class="container mt-5">
    <h3 class="mb-4">User Details</h3>

    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $user->phone }}</li>
        <li class="list-group-item"><strong>User Type:</strong> {{ ucfirst($user->user_type) }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
        <li class="list-group-item"><strong>Created At:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</li>
    </ul>

</div>
