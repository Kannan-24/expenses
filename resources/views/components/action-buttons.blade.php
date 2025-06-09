@props(['model', 'id'])

<td class="px-6 py-4 border-b border-gray-200">
    <div class="flex flex-col gap-3 sm:flex-row">
        <a href="{{ route($model . '.show', $id) }}" aria-label="View {{ $model }}">
            <button
                class="px-4 py-2 text-sm text-white transition-all duration-300 bg-indigo-500 rounded-lg hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-700 hover:shadow-lg focus:ring-2 focus:ring-indigo-300">
                View
            </button>
        </a>
        <a href="{{ route($model . '.edit', $id) }}" aria-label="Edit {{ $model }}">
            <button
                class="px-4 py-2 text-sm text-white transition-all duration-300 rounded-lg bg-emerald-500 hover:bg-gradient-to-r hover:from-emerald-500 hover:to-emerald-700 hover:shadow-lg focus:ring-2 focus:ring-emerald-300">
                Edit
            </button>
        </a>
        <form action="{{ route($model . '.destroy', $id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="px-4 py-2 text-sm text-white transition-all duration-300 rounded-lg bg-rose-500 hover:bg-gradient-to-r hover:from-rose-500 hover:to-rose-700 hover:shadow-lg focus:ring-2 focus:ring-rose-300"
                onclick="return confirm('Are you sure you want to delete this?');">
                Delete
            </button>
        </form>
    </div>
</td>
