<div class="flex items-center space-x-3">
    <!-- Profile Image with Initials -->
    <div class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full"
        style="background: black;margin: 0 .5rem">
        {{ $initials }}
    </div>
    <!-- Name and Email -->
    <div>
        <div class="font-semibold">{{ $name }}</div>
        <div class="text-sm text-gray-500">{{ $email }}</div>
    </div>
</div>
