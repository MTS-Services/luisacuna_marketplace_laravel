<div>
    <div class="bg-bg-primary text-white font-sans min-h-screen">
        <div class="max-w-7xl mx-auto py-12 px-6">

            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-5xl font-semibold mb-2">
                    {{ __('Trade Protect For Buyers') }}
                </h1>
                <p class="text-text-secondary text-sm">
                    {{ __('Update Time : 2025-09-10 16:41:31') }}
                </p>
            </div>

            <div class="space-y-8">

                <!-- Section 1 -->
                <section>
                    <h2 class="text-xl font-bold mb-4 text-text-baground3">
                        {{ __('Swapy.gg Buyer Protection Policy') }}
                    </h2>
                    <p class="text-text-secondary mb-6">
                        {{ __('Swapy.gg is dedicated to ensuring a secure and satisfying buying experience for all users. Our Buyer Protection policy offers peace of mind by guaranteeing that sellers fulfill orders precisely as described.') }}
                    </p>
                </section>

                <!-- Section 2 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('1. What Buyer Protection Covers:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __("Swapy.gg's Buyer Protection safeguards you in the event of:") }}
                    </p>

                    <ul class="list-none space-y-2 pl-4 text-gray-300">
                        <li>
                            <span class="font-semibold text-text-white">a.</span>
                            {{ __('Non-receipt of the purchased order.') }}
                        </li>
                        <li>
                            <span class="font-semibold text-text-white">b.</span>
                            {{ __('The product or service received significantly deviates from its description on the listing.') }}
                        </li>
                    </ul>
                </section>

                <!-- Section 3 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('2. Situations Not Covered By Buyer Protection:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __('Buyer Protection does not extend to the following circumstances:') }}
                    </p>

                    <ul class="list-none space-y-2 pl-4 text-gray-300">
                        <li>
                            <span class="font-semibold text-text-white">a.</span>
                            {{ __('When the buyer has explicitly confirmed receipt of the order.') }}
                        </li>
                        <li>
                            <span class="font-semibold text-text-white">b.</span>
                            {{ __("Buyer's remorse or a change of mind after an order has been placed.") }}
                        </li>
                        <li>
                            <span class="font-semibold text-text-white">c.</span>
                            {{ __('Transactions initiated or conducted outside the Swapy.gg platform.') }}
                        </li>
                        <li>
                            <span class="font-semibold text-text-white">d.</span>
                            {{ __('Any alterations to an account or its contents by the game publisher/developer after a transaction is finalized.') }}
                        </li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('3. Fraudulent Claims:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __("Swapy.gg's Buyer Protection is strictly designed to prevent fraudulent claims. For instance, if a seller successfully transferred items but the buyer falsely claims non-receipt, such actions constitute fraud. Any buyer found engaging in fraudulent claims will face immediate account suspension. Swapy.gg reserves the right to pursue legal action against individuals making fraudulent claims.") }}
                    </p>
                </section>

                <!-- Section 5 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('4. Confirming Receipt:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __('It is essential for the buyer to confirm receipt only after thoroughly verifying that the received items or services are fully functional and accurately match the product description. A "Confirmed Receipt" status signifies the completion of the transaction, indicating that the buyer is satisfied with their purchase and authorizes the release of payment to the seller.') }}
                    </p>
                </section>

                <!-- Section 6 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('5. Implied Acceptance of Product/Service:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __("If a buyer does not raise a claim or complaint within 72 hours following the seller's dispatch or delivery of the goods, the buyer will be considered to have accepted the purchased item or service. No refunds will be processed for orders that have reached a confirmed received and completed status.") }}
                    </p>
                </section>

                <!-- Section 7 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('6. Dispute Resolution Engagement:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __("In the event of a transaction dispute, the buyer is required to promptly respond to our requests and submit all pertinent evidence (such as in-game screenshots, official proofs, etc.). Failure to respond within the stipulated timeframe will imply the buyer's acknowledgement that the issue has been resolved, and Swapy.gg will close the dispute.") }}
                    </p>
                </section>

                <!-- Section 8 -->
                <section class="space-y-3">
                    <h3 class="text-lg font-bold text-text-baground3">
                        {{ __('7. Payment Disputes or Chargebacks:') }}
                    </h3>
                    <p class="text-text-secondary">
                        {{ __('Our Buyer Protection policy does not cover payment disputes or chargebacks initiated directly with payment providers. Should such an event occur, our internal investigation will cease, and no refund requests related to that transaction will be considered by Swapy.gg.') }}
                    </p>
                </section>

            </div>

            <!-- Helpful Buttons -->
            <div class="flex justify-end space-x-4 pt-10">
                <button
                    class="flex items-center px-5 py-2.5 rounded-full bg-gray-100 text-text-purple font-medium transition duration-150 text-sm shadow-md">
                    <x-phosphor-thumbs-up-fill class="w-5 h-5 fill-zinc-500 mr-2" />
                    {{ __("It's helpful") }}
                </button>

                <button
                    class="flex items-center px-5 py-2.5 rounded-full bg-gray-100 text-text-purple font-medium transition duration-150 text-sm shadow-md">
                    <x-phosphor-thumbs-down-fill class="w-5 h-5 fill-zinc-500 mr-2" />
                    {{ __("It's not helpful") }}
                </button>
            </div>

            <!-- CTA -->
            <div class="mt-18 py-12 text-center rounded-lg bg-bg-primary dark:bg-bg-secondary shadow-2xl">
                <h2 class="text-3xl font-extrabold mb-4 tracking-wider">
                    {{ __('Your Purchase is Protected!') }}
                </h2>
                <p class="text-text-white mb-6 max-w-3xl mx-auto">
                    {{ __('Digital Commerce priorities your security. Our escrow system safeguards your payment until you confirm delivery, and our Buyer Protection Policy ensures fair resolution in case of any issues. Buy with absolute confidence!') }}
                </p>
                <x-ui.button href="{{ url('/') }}"
                    class="px-6 py-3 bg-purple-800 text-text-secondery font-medium rounded-full hover:bg-bg-white hover:text-zinc-500">
                    {{ __('Start Shopping Now') }}
                </x-ui.button>
            </div>

        </div>
    </div>
</div>
