@props([
    'title'
])

<div>
    <div class="page-header min-height-500 border-radius-xl"
         style="background-image: url('../assets/img/bison-logo.jpg'); background-position-y: 50%;">
        <span class="mask bg-success opacity-5">
            <h2 class="font-semibold text-xl-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __($title) }}
            </h2>
        </span>
    </div>
    {{ $slot }}
</div>
