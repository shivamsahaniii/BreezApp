<div class="flex flex-col items-center space-y-1">
    <a href="{{ route($routeBase . '.show', $id) }}" class="text-yellow-600 hover:underline">View</a>
    <a href="{{ route($routeBase . '.edit', $id) }}" class="text-blue-600 hover:underline">Edit</a>
    <form action="{{ route($routeBase . '.destroy', $id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline">Trash</button>
    </form>
</div>
