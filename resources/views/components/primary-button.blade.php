<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-[#ffd700] text-[#320064] hover:bg-yellow-400 focus:ring-2 focus:ring-[#ffd700] focus:outline-none px-4 py-2 rounded-full font-semibold transition']) }}>
    {{ $slot }}
</button>
