<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full sm:w-auto px-6 py-2 text-base font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition']) }}>
    {{ $slot }}
</button>
