<div x-data="verificationApp()" class="w-full py-10 flex flex-col items-center">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-2 mb-2">
            {{-- <svg class="w-6 h-6 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg> --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#853EFF"
                class="w-6 h-6 sm:w-7 sm:h-7">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
            <h1 class="text-text-white text-xl font-medium">Seller ID verification</h1>
        </div>
        <p class="text-purple-300 text-sm">Step 6/6</p>
    </div>

    <div
        class="dark:bg-zinc-800/30 bg-zinc-300/20 bg-opacity-40 backdrop-blur-sm rounded-2xl p-8 shadow-2xl  border-opacity-30 w-full max-w-7xl">
        <h2 class="dark:text-white text-black text-lg font-medium mb-6">Take a selfie with your ID</h2>

        <!-- Upload Area -->
        <div class="relative mb-6">
            <label for="fileInput" class="block cursor-pointer">
                <div
                    class="border-2 border-dashed border-purple-100 border-opacity-50 rounded-2xl p-8  bg-opacity-20 hover:bg-opacity-30 transition-all max-w-md mx-auto">
                    <template x-if="!preview">
                        <div class="text-center">
                            <div class="#">
                             
                                <img src="{{ asset('assets/images/Rectangle24609.png') }}" alt="img"
                                    class="w-full h-auto rounded">
                            </div>
                        </div>
                    </template>

                    <template x-if="preview">
                        <div class="relative">
                            <img :src="preview" alt="Preview" class="w-full h-auto rounded-lg">
                            <button @click.prevent="removeImage"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>

                            </button>
                        </div>
                    </template>
                </div>
            </label>
            <input type="file" id="fileInput" @change="handleFileChange" accept="image/jpeg,image/png,image/heic"
                class="hidden">
        </div>

        <!-- Instructions -->
        <div class="space-y-2 mb-4">
            <div class="flex items-start gap-2 text-purple-200 text-sm">
                <span class="text-purple-400 mt-0.5">•</span>
                <p>Accepted documents: Driver's license, Government issued ID or Passport, international student ID.</p>
            </div>
            <div class="flex items-start gap-2 text-purple-200 text-sm">
                <span class="text-purple-400 mt-0.5">•</span>
                <p>Make sure personal details on the document are clearly visible and easy to read.</p>
            </div>
        </div>

        <!-- File Upload -->

        <div class="flex flex-col items-center space-y-4">
            <div class="flex items-center space-x-4">
                <button @click="$refs.fileInput.click()"
                    class="px-8 py-2 rounded-full text-sm text-white bg-purple-600 hover:bg-purple-700 transition duration-150">
                    Change file
                </button>
                <div
                    class="flex items-center bg-gray-700/50 rounded-lg p-2 text-sm text-file-text w-64 justify-between">
                    <span class="truncate">e8bae79d2f63f39e4a2bff9f9e0cb6fe.......</span>
                    <svg class="w-4 h-4 text-red-500 cursor-pointer ml-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-red-400">
                File uploaded
            </p>
            <p class="text-xs text-gray-400 mt-2">
                Must be JPEG, PNG or HEIC and cannot exceed **10MB**.
            </p>
        </div>

        <!-- File Requirements -->
        <p class="text-purple-300 text-xs text-center mb-2">
            <span x-show="fileName" x-text="fileName" class="block mb-2 text-purple-200"></span>
            Must be JPEG, PNG or HEIC and cannot exceed 10MB.
        </p>

        <!-- Error Message -->
        <p x-show="error" x-text="error" class="text-red-400 text-sm text-center mb-4"></p>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-center gap-4 mt-6">
        <button class="bg-white hover:bg-gray-100 text-purple-900 font-medium py-3 px-8 rounded-full transition-colors">
            Back
        </button>
        <button @click="submit" :disabled="!preview"
            :class="preview ? 'bg-purple-600 hover:bg-purple-700' : 'bg-purple-800 opacity-50 cursor-not-allowed'"
            class="text-white font-medium py-3 px-8 rounded-full
             transition-colors">
            next
        </button>
    </div>
</div>

<script>
    function verificationApp() {
        return {
            preview: null,
            fileName: '',
            error: '',

            handleFileChange(event) {
                const file = event.target.files[0];
                if (!file) return;

                this.error = '';

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/heic'];
                if (!validTypes.includes(file.type)) {
                    this.error = 'Invalid file type. Please upload JPEG, PNG or HEIC.';
                    return;
                }

                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    this.error = 'File size exceeds 10MB limit.';
                    return;
                }

                this.fileName = file.name;

                // Create preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage() {
                this.preview = null;
                this.fileName = '';
                this.error = '';
                document.getElementById('fileInput').value = '';
            },

            submit() {
                if (!this.preview) {
                    this.error = 'Please upload a photo first.';
                    return;
                }

                // Handle submission
                alert('Verification submitted successfully!');
                console.log('Submitting verification with file:', this.fileName);
            }
        }
    }
</script>
