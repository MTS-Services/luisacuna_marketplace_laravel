<x-frontend::app>
    <x-slot name="pageSlug">Home Page</x-slot>
    <div class="flex flex-col items-center justify-center">
        <h1 class="text-2xl font-bold">Home Page</h1>
        @if (Auth::guard('web')->check())
            User is logged in
        @elseif (Auth::guard('admin')->check())
            Admin is logged in
        @else
            User is not logged in
        @endif
    </div>
</x-frontend::app>
