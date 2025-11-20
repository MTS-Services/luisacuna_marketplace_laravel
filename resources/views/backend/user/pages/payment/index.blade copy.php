<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Method</title>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e0a3c 0%, #2d1b4e 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .payment-container {
            background: #2a1548;
            border-radius: 16px;
            padding: 40px;
            max-width: 650px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: white;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .payment-method {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #8b5cf6;
            background: rgba(139, 92, 246, 0.1);
        }

        .payment-method.active {
            border-color: #8b5cf6;
            background: rgba(139, 92, 246, 0.15);
        }

        .payment-icons img {
            height: 30px;
        }

        .payment-label {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        input,
        #card-element {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
            color: white;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: #8b5cf6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #7c3aed;
        }

        .error {
            color: #ef4444;
            font-size: 14px;
            margin-top: 10px;
        }

        .success {
            color: #10b981;
            font-size: 14px;
            margin-top: 10px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="payment-container">

        <h1>Select Payment Method</h1>

        <!-- CARD -->
        <div class="payment-method active" id="card-method" onclick="selectPaymentMethod('card')">
            💳 <span class="payment-label">Credit / Debit Card</span>
        </div>

        <div id="card-form">
            <form id="payment-form">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" id="amount" value="100" min="1" step="0.01">
                </div>

                <div class="form-group">
                    <label>Card Info</label>
                    <div id="card-element"></div>
                </div>

                <div class="form-group">
                    <label>Card Holder Name</label>
                    <input type="text" id="card-holder">
                </div>

                <button id="submit-button">Pay Now</button>
                <div id="card-errors" class="error"></div>
            </form>
        </div>

        <!-- DIGITAL WALLET -->
        <div class="payment-method" id="wallet-method" onclick="selectPaymentMethod('wallet')">
            📱 <span class="payment-label">Digital Wallet (Apple Pay / Google Pay)</span>
        </div>

        <div id="wallet-container" class="hidden" style="margin-top:20px;">
            <div id="wallet-button"></div>
        </div>

        <!-- CRYPTO -->
        <div class="payment-method" id="crypto-method" onclick="selectPaymentMethod('crypto')">
            ₿ <span class="payment-label">Crypto Payment</span>
        </div>

        <div id="crypto-container" class="hidden" style="margin-top:20px;">
            <button onclick="startCryptoPayment()">Pay with Crypto</button>
        </div>

    </div>

    <script>
        const stripe = Stripe("{{ $stripe_key }}");
        const elements = stripe.elements();

        let selectedMethod = "card";

        /* CARD ELEMENT */
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');


        /* SELECT METHOD */
        function selectPaymentMethod(method) {
            selectedMethod = method;

            document.querySelectorAll('.payment-method')
                .forEach(el => el.classList.remove('active'));
            document.getElementById(method + "-method").classList.add("active");

            document.getElementById("card-form").classList.add("hidden");
            document.getElementById("wallet-container").classList.add("hidden");
            document.getElementById("crypto-container").classList.add("hidden");

            if (method === "card") document.getElementById("card-form").classList.remove("hidden");
            if (method === "wallet") document.getElementById("wallet-container").classList.remove("hidden");
            if (method === "crypto") document.getElementById("crypto-container").classList.remove("hidden");
        }


        /* CARD PAYMENT SUBMIT */
        document.getElementById("payment-form").addEventListener("submit", async (e) => {
            e.preventDefault();

            let btn = document.getElementById("submit-button");
            btn.disabled = true;
            btn.innerText = "Processing...";

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: "card",
                card: cardElement,
                billing_details: {
                    name: document.getElementById("card-holder").value,
                },
            });

            if (error) {
                document.getElementById("card-errors").innerText = error.message;
                btn.disabled = false;
                btn.innerText = "Pay Now";
                return;
            }

            const response = await fetch("{{ route('user.payment.card') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    amount: document.getElementById("amount").value,
                    payment_method_id: paymentMethod.id,
                    card_type: paymentMethod.card.brand,
                    card_brand: paymentMethod.card.brand,
                    card_last4: paymentMethod.card.last4
                }),
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = "{{ route('user.payment.success') }}";
            } else {
                document.getElementById("card-errors").innerText = result.message;
            }

            btn.disabled = false;
            btn.innerText = "Pay Now";
        });


        /* DIGITAL WALLET */
        const paymentRequest = stripe.paymentRequest({
            country: "US",
            currency: "usd",
            total: {
                label: "Recharge",
                amount: 10000
            },
        });

        const prButton = elements.create("paymentRequestButton", {
            paymentRequest
        });

        paymentRequest.canMakePayment().then(result => {
            if (result) {
                document.getElementById("wallet-button").innerHTML = "";
                prButton.mount("#wallet-button");
            }
        });

        paymentRequest.on("paymentmethod", async (ev) => {
            const res = await fetch("{{ route('user.payment.digital-wallet') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    amount: document.getElementById("amount").value,
                    payment_method_id: ev.paymentMethod.id,
                    wallet_type: "gpay",
                }),
            });

            const result = await res.json();

            if (result.success) {
                ev.complete("success");
                window.location.href = "{{ route('user.payment.success') }}";
            } else {
                ev.complete("fail");
            }
        });


        /* CRYPTO PAYMENT */
        function startCryptoPayment() {
            fetch("{{ route('user.payment.crypto') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        amount: document.getElementById("amount").value,
                        crypto_type: "bitcoin",
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.hosted_url) {
                        window.location.href = data.hosted_url;
                    } else {
                        alert("Crypto payment failed");
                    }
                });
        }
    </script>

</body>

</html>
