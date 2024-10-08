<div>
    <!-- Name Input -->
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" class="form-control" value="{{ $user->name }} {{ $user->last_name }}" readonly>
    </div>

    <!-- Email Input -->
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
    </div>

    <!-- Phone Input -->
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" class="form-control" value="{{ $user->phone_number }}" readonly>
    </div>

    <!-- Add more user details as needed -->
</div>
