<footer class="dark:bg-bg-secondary">
    <div class="pt-30">
        <div class="container flex flex-col md:flex-row justify-start gap-8 mb-12">
            <div class="w-full md:w-1/4 flex flex-col items-start justify-start md:justify-start">
                <div class="mb-4">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/header_logo.png') }}" alt="">
                    </a>
                </div>
                <p class="text-text-secondary text-md text-center md:text-start">
                    {{ __('Digital Commerce connects buyers and verified sellers for secure, fast, and seamless digital transactions.') }}
                </p>
                <div class="flex gap-4 mt-6">
                    <a href="#" target="_blank"
                        class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center hover:bg-zinc-500/40 transition">
                        <img src="{{ asset('assets/svgs/twiter.svg') }}" class="w-5 h-5" alt="">
                    </a>
                    <a href="#" target="_blank"
                        class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center hover:bg-zinc-500/40 transition">
                        <img src="{{ asset('assets/svgs/instagram.svg') }}" class="w-5 h-5" alt="">
                    </a>
                    <a href="#" target="_blank"
                        class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center hover:bg-zinc-500/40 transition">
                        <img src="{{ asset('assets/svgs/youtube.svg') }}" class="w-5 h-5" alt="">
                    </a>
                    <a href="#" target="_blank"
                        class="w-10 h-10 rounded-lg bg-zinc-800 flex items-center justify-center hover:bg-zinc-500/40 transition">
                        <img src="{{ asset('assets/svgs/linkdin.svg') }}" class="w-5 h-5" alt="">
                    </a>
                </div>
            </div>

            <div class="w-full md:w-3/4 flex flex-wrap justify-start md:justify-around gap-8">
                <div>
                    <h4 class="font-bold mb-4 text-text-white text-xl">{{ __('Quick Links') }}</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('home') }}#popular-games" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Explore Products') }}</a>
                        </li>
                        <li><a href="{{ route('how-to-buy') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('How to Buy') }}</a>
                        </li>
                        <li><a href="{{ route('buyer-protection') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Buyer Protection') }}</a>
                        </li>
                        <li> <a href="{{ route('register.signUp') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Become a Seller') }}</a>
                        </li>
                        <li><a href="{{ route('how-to-sell') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('How to Sell') }}</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-text-white text-xl">{{ __('Support') }}</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('faq') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('FAQ') }}</a>
                        </li>
                        <li><a href="{{ route('contact-us') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Contact Us') }}</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-text-white text-xl">{{ __('Legal') }}</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('terms-and-conditions') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Terms & Conditions') }}</a>
                        </li>
                        <li>
                            <a href="privacy-policy" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li><a href="{{ route('refund-policy') }}" wire:navigate
                                class="hover:text-purple-400 transition text-text-secondary text-md">{{ __('Refund Policy') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-bg-primary py-4 text-center text-md text-text-secondary">
        <p class="text-text-secondary">{{ __('© 2025 DigitalCommerce. All rights reserved') }}</p>
    </div>
</footer>
