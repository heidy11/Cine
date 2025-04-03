@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => 'bg-white text-black font-semibold border border-yellow-400 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm w-full'
    ]) }} 
/>
