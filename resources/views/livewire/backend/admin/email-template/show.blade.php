<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/tinymce.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ $emailTemplate->name }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.email-template.edit', encrypt($emailTemplate->id)) }}" class="w-auto! py-2!">
                    {{-- <flux:icon name="edit" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" /> --}}
                    {{ __('Edit') }}
                </x-ui.button>  <x-ui.button href="{{ route('admin.email-template.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl  mb-6 mx-auto">
       <div class="w-3xl mx-auto py-10 ">
            <div class="flex">
                <h2>{{ __('Subject : ') }}</h2>
                <p class="pl-3">{{ $emailTemplate->subject }}</p>
            </div>
            <div class="mt-3">
                {!! $emailTemplate->template !!}
            </div>
       </div>
    </div>
</section>
