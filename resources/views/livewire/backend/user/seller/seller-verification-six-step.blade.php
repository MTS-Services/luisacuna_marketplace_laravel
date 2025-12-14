<div class="min-h-[70vh] bg-bg-primary py-12 px-4">
    <div class="max-w-4xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
            <div class="text-center w-full rounded-2xl bg-bg-secondary px-5 py-8 lg:p-20">
                <div class="mb-6">
                    <div class="mx-auto flex flex-row items-center justify-center">
                        <span class="text-8xl pr-2.5">
                            <flux:icon name="shield-check" class="stroke-zinc-500"></flux:icon>
                        </span>
                        <p class="font-semibold text-base ">Seller ID verification</p>
                    </div>
                    <div class="text-sm text-text-primary font-normal pt-2">
                        Step <span>6</span>/<span>6</span>
                    </div>
                </div>

                <div class="p-5 lg:px-15 lg:py-10 bg-bg-info  rounded-2xl">
                    @php 
                    $accountType = 'individual';
                    @endphp 

                    @if ($accountType == 'individual')
                        <h2 class="text-base lg:text-xl leading-2 font-semibold  mb-4 text-left">Take a selfie with
                            your ID</h2>

                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('assets/images/verification-selfie.webp') }}"
                                alt="Selfie with ID illustration" class="mx-auto"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        </div>

                        <ul class="space-y-3 text-gray-700 mb-6 max-w-md mx-auto">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Please upload a photo where you are holding your ID next to your face.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Both your face and ID document must be clearly visible.</span>
                            </li>
                        </ul>

                        <div
                            class="flex items-center max-w-md mx-auto  rounded-lg overflow-hidden">
                            <input type="file" wire:model="selfieWithId" accept="image/*" class="hidden"
                                id="selfieWithId">

                            <label for="selfieWithId"
                                class="shrink-0 px-6 py-2 bg-zinc-600 rounded-3xl text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                Choose file
                            </label>
                            
                                <div class="p-2 text-sm w-full text-primary-100 truncate w-full bg-bg-light-black shadow rounded-sm ml-2 text-left">
                                    @if (false)
                                        {{ $idDocument->getClientOriginalName() }}
                                    @else
                                        No file selected
                                    @endif
                                </div>
                        </div>

                        <p class="text-xs text-center text-gray-500 mt-3">
                            Must be JPEG, PNG or HEIC and cannot exceed 10MB.
                        </p>

                        @error('selfieWithId')
                            <p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
                        @enderror
                    @else
                        <h2 class="text-base lg:text-2xl font-bold text-left mb-6">Upload company documents</h2>

                        <div class="max-w-2xl mx-auto mb-8">
                            <p class="text-gray-600 mb-6 text-center">
                                Please upload documents to prove that the individual who submitted the ID is an owner of
                                your company.
                            </p>

                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <ol class="space-y-3 text-sm text-gray-700">
                                    <li>1. Proof of ownership (an extract from a corporate registry or shareholder
                                        register)
                                        (required)</li>
                                    <li>2. Articles of Association (required)</li>
                                    <li>3. Proof of registered company address (utility bill or bank statement, not
                                        older
                                        than 3 months) (required)</li>
                                    <li>4. Misc docs (corporate structure, incorporation document, misc. company
                                        documents,
                                        etc) (optional)</li>
                                </ol>
                            </div>

                            <div class="bg-zinc-50 border-l-4 border-zinc-500 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-zinc-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-zinc-700">
                                            <strong>Note:</strong> If your company's owner is another company, you will
                                            need
                                            to upload documents for both entities and the corporate structure, leading
                                            to
                                            the UBO
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <input type="file" wire:model="companyDocuments"
                                    accept=".jpg,.jpeg,.png,.heic,.pdf,.docx" multiple class="hidden"
                                    id="companyDocuments">
                                <label for="companyDocuments"
                                    class="shrink-0 px-6 py-2 bg-zinc-600 flex justify-center w-40 rounded-lg mx-auto text-white font-semibold hover:bg-gray-800 cursor-pointer transition duration-150">
                                    Choose file
                                </label>
                                @if (!empty($companyDocuments))
                                    <div class="mt-3 space-y-2">
                                        @foreach ($companyDocuments as $index => $doc)
                                            <p class="text-green-600 text-sm">✓ File {{ $index + 1 }}:
                                                {{ $doc->getClientOriginalName() }}</p>
                                        @endforeach
                                    </div>
                                @else
                                @endif
                            </div>

                            <p class="text-xs text-text-white text-center">
                                Must be JPEG, PNG, HEIC, PDF, DOCX and cannot exceed 10MB.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="flex justify-center space-x-4 pt-10">
                    <button wire:click="previousStep"
                        class="px-8 py-2  hover:text-gray-700 rounded-lg hover:bg-gray-50">
                        BACK
                    </button>
                    <button wire:click="submit" class="px-8 py-2 bg-zinc-500 text-white rounded-lg hover:bg-zinc-700"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit" class="text-white">SUBMIT</span>
                        <span wire:loading wire:target="submit">Submitting...</span>
                    </button>
                </div>

            </div>
    </div>
</div>
