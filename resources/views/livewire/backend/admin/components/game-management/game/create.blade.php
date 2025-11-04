<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.game.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                
               

                {{-- Category --}}


                <div>
                    <x-ui.label for="game_category_id" :value="__('Category')" required />
                    <x-ui.select id="game_category_id" class="mt-1 block w-full" wire:model="form.game_category_id">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach ($categories as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.game_category_id')" class="mt-2" />
                </div>

                {{-- Name --}}

                <div>
                    <x-ui.label for="name" :value="__('Name')" required />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder="category name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>

                {{-- Status --}}


                <div>
                    <x-ui.label for="status" :value="__('Status')" required />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>

                {{-- Developer --}}


                <div>
                    <x-ui.label for="developer" :value="__('Developer')" required />

                    <x-ui.input id="developer" type="text" class="mt-1 block w-full" wire:model="form.developer"
                        placeholder="developer name" />
                    <x-ui.input-error :messages="$errors->get('form.developer')" class="mt-2" />

                </div>

                {{-- Publisher --}}
                <div>
                    <x-ui.label for="publisher" :value="__('Publisher')" required />
                    <x-ui.input id="publisher" type="text" class="mt-1 block w-full" wire:model="form.publisher"
                        placeholder="publisher name" />
                    <x-ui.input-error :messages="$errors->get('form.publisher')" class="mt-2" />
                </div>

                {{-- Game --}}
                <div>
                    <x-ui.label for="game" :value="__('Game')" required />
                    <x-ui.input id="game" type="text" class="mt-1 block w-full" wire:model="form.game"
                        placeholder="game name" />
                    <x-ui.input-error :messages="$errors->get('form.game')" class="mt-2" />
                </div>

                {{-- Release Date --}}

                <div class="col-span-2">
                    <x-ui.label for="release_date" :value="__('Release Date')" required />
                    <x-ui.input id="release_date" type="date" class="mt-1 block w-full" wire:model="form.release_date"
                        placeholder="release date" />
                    <x-ui.input-error :messages="$errors->get('form.release_date')" class="mt-2" />

                </div>

        
                {{-- Description --}}

                <div class="col-span-2">
                    <x-ui.label for="description" :value="__('Description')" required />
                    <textarea wire:model="form.description" rows="4"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></textarea>
                    <x-ui.input-error :messages="$errors->get('form.description')" class="mt-2" />
                </div>

                {{-- Images --}}


              <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Logo') }}
                </h3>
                <x-ui.file-input wire:model="form.logo" label="Game Logo" accept="image/*" :error="$errors->first('form.logo')"
                    hint="Upload a game logo (Max: 2MB)" />
             </div>

              <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Thumbnail') }}
                </h3>
                <x-ui.file-input wire:model="form.thumbnail" label="Game Thumbanail" accept="image/*" :error="$errors->first('form.thumbnail')"
                    hint="Upload a game thumbnail (Max: 2MB)" />
             </div>
                

              <div class="col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Banner') }}
                </h3>
                <x-ui.file-input wire:model="form.banner" label="Game Banner" accept="image/*" :error="$errors->first('form.banner')"
                    hint="Upload a game banner (Max: 2MB)" />
             </div>
                
                {{-- Boolean Checkboxes --}}
                <div class="flex gap-6 mt-3">

                     <div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox"  id="is_featured" wire:model="form.is_featured">
                             <x-ui.label for="is_featured" :value="__('Featured')" />
                        </div>
                        <x-ui.input-error :messages="$errors->get('form.is_featured')" class="mt-2" />
                    </div>

                     <div>
                        <div class="flex items-center gap-2">
                           <input type="checkbox"  id="is_trending" wire:model="form.is_trending">
                             <x-ui.label for="is_trending" :value="__('Trending')" />
                        </div>
                        <x-ui.input-error :messages="$errors->get('form.is_trending')" class="mt-2" />
                    </div>
                </div>

                {{-- SEO Fields --}}
                <div class="col-span-2">

                    <x-ui.label for="meta_title" :value="__('Meta Title')" />

                   <x-ui.input id="meta_title" type="text" class="mt-1 block w-full" wire:model="form.meta_title"
                        placeholder="Meta Title" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" class="mt-2" />
                   
                </div>

                <div class="col-span-2">
                    <x-ui.label for="meta_description" :value="__('Meta Description')" />


                     <textarea wire:model="form.meta_description" rows="2"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" placeholder="Meta Description"></textarea>

                    <x-ui.input-error :messages="$errors->get('form.meta_description')" class="mt-2" />
                </div>

                <div class="col-span-2">
                    <x-ui.label for="meta_keywords" :value="__('Meta Keywords')" />
                    
                    <x-ui.input id="meta_keywords" type="text" class="mt-1 block w-full" wire:model="form.meta_keywords"
                        placeholder="Meta Keywords" />

                    <x-ui.input-error :messages="$errors->get('form.meta_keywords')" class="mt-2" />
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:clilck="resetFrom" type="danger" class="w-auto!">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" class="w-auto!">
                    <span wire:loading.remove wire:target="save" class="text-white">Create Game</span>
                    <span wire:loading wire:target="save" class="text-white">Creating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
