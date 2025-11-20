<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Accept a payment</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- <link rel="stylesheet" href="checkout.css" /> --}}
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: center;
        }

        form {
            width: 35vw;
            min-width: 500px;
            align-self: center;
            box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
                0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
            border-radius: 7px;
            padding: 40px;
            margin-top: auto;
            margin-bottom: auto;
            overflow: scroll;
        }

        .hidden {
            display: none;
        }

        #payment-message {
            color: rgb(105, 115, 134);
            font-size: 16px;
            line-height: 20px;
            padding-top: 12px;
            text-align: center;
        }

        #payment-element {
            margin-bottom: 24px;
            margin-top: 16px;
        }

        #email {
            border-radius: 5px;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(0, 0, 0, 0.02);
            display: block;
            margin-top: 0.25rem;
            padding: 0.75rem;
            background-color: #ffffff;
            color: #30313d;
            border: 1px solid #e5e5e5;
            height: 44px;
            transform: none;
            opacity: 1;
            position: inherit;
            outline: none;
            width: 100%;
        }

        #email:focus {
            border: 1px solid hsl(210, 96%, 45%);
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(0, 0, 0, 0.02), 0 0 0 3px rgba(5, 112, 222, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.08);
        }

        #email-errors {
            margin-top: 4px;
            color: #df1b41;
        }

        #email.error {
            color: #df1b41;
            border: 1px solid #df1b41;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(0, 0, 0, 0.02), 0 0 0 3px rgba(223, 27, 65, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.08);
        }

        /* Buttons and links */
        button {
            background: #0055de;
            font-family: Arial, sans-serif;
            color: #ffffff;
            border-radius: 4px;
            border: 0;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            transition: all 0.2s ease;
            box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
            width: 100%;
        }

        button:hover {
            filter: contrast(115%);
        }

        button:disabled {
            opacity: 0.5;
            cursor: default;
        }

        /* spinner/processing state, errors */
        .spinner,
        .spinner:before,
        .spinner:after {
            border-radius: 50%;
        }

        .spinner {
            color: #ffffff;
            font-size: 22px;
            text-indent: -99999px;
            margin: 0px auto;
            position: relative;
            width: 20px;
            height: 20px;
            box-shadow: inset 0 0 0 2px;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }

        .spinner:before,
        .spinner:after {
            position: absolute;
            content: "";
        }

        .spinner:before {
            width: 10.4px;
            height: 20.4px;
            background: #0055de;
            border-radius: 20.4px 0 0 20.4px;
            top: -0.2px;
            left: -0.2px;
            -webkit-transform-origin: 10.4px 10.2px;
            transform-origin: 10.4px 10.2px;
            -webkit-animation: loading 2s infinite ease 1.5s;
            animation: loading 2s infinite ease 1.5s;
        }

        .spinner:after {
            width: 10.4px;
            height: 10.2px;
            background: #0055de;
            border-radius: 0 10.2px 10.2px 0;
            top: -0.1px;
            left: 10.2px;
            -webkit-transform-origin: 0px 10.2px;
            transform-origin: 0px 10.2px;
            -webkit-animation: loading 2s infinite ease;
            animation: loading 2s infinite ease;
        }

        @-webkit-keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @media only screen and (max-width: 600px) {
            form {
                width: 80vw;
                min-width: initial;
            }
        }
    </style>
    <script src="https://js.stripe.com/clover/stripe.js"></script>
    {{-- <script src="checkout.js" defer></script> --}}
</head>

<body>
    <!-- Display a payment form -->
    <form id="payment-form">
        <label>
            Email
            <input type="email" id="email" /></label>
        <div id="email-errors"></div>
        <h4>Payment</h4>
        <div id="payment-element">
            <!--Stripe.js injects the Payment Element-->
        </div>
        <button id="submit">
            <div class="spinner hidden" id="spinner"></div>
            <span id="button-text">Pay now</span>
        </button>
        <div id="payment-message" class="hidden"></div>
    </form>

    <script defer>
        // This is a public sample test API key.
        // Don’t submit any personally identifiable information in requests made with this key.
        // Sign in to see your own test API key embedded in code samples.
        const stripe = Stripe(
            "pk_test_51SUzTBGVCyJPPH2z0XTuK4SpnwjBBwXDlrJnWSnViCv1ikxcdjHswBU1oKZbKgoD19JdLO8qWPZ2xHhdkJeoJeDE00xjffdeVs"
        );

        let checkout;
        let actions;
        initialize();
        const emailInput = document.getElementById("email");
        const emailErrors = document.getElementById("email-errors");

        const validateEmail = async (email) => {
            const updateResult = await actions.updateEmail(email);
            const isValid = updateResult.type !== "error";

            return {
                isValid,
                message: !isValid ? updateResult.error.message : null
            };
        };

        document
            .querySelector("#payment-form")
            .addEventListener("submit", handleSubmit);

        // Fetches a Checkout Session and captures the client secret
        async function initialize() {
            const promise = fetch('/create.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                .then((r) => r.json())
                .then((r) => r.clientSecret);

            const appearance = {
                theme: 'stripe',
            };
            checkout = stripe.initCheckout({
                clientSecret: promise,
                elementsOptions: {
                    appearance
                },
            });

            checkout.on('change', (session) => {
                // Handle changes to the checkout session
            });

            const loadActionsResult = await checkout.loadActions();
            if (loadActionsResult.type === 'success') {
                actions = loadActionsResult.actions;
                const session = loadActionsResult.actions.getSession();
                document.querySelector("#button-text").textContent = `Pay ${
      session.total.total.amount
    } now`;
            }

            emailInput.addEventListener("input", () => {
                // Clear any validation errors
                emailErrors.textContent = "";
                emailInput.classList.remove("error");
            });

            emailInput.addEventListener("blur", async () => {
                const newEmail = emailInput.value;
                if (!newEmail) {
                    return;
                }

                const {
                    isValid,
                    message
                } = await validateEmail(newEmail);
                if (!isValid) {
                    emailInput.classList.add("error");
                    emailErrors.textContent = message;
                }
            });

            const paymentElement = checkout.createPaymentElement();
            paymentElement.mount("#payment-element");
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const email = document.getElementById("email").value;
            const {
                isValid,
                message
            } = await validateEmail(email);
            if (!isValid) {
                emailInput.classList.add("error");
                emailErrors.textContent = message;
                showMessage(message);
                setLoading(false);
                return;
            }

            const {
                error
            } = await actions.confirm();

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`. For some payment methods like iDEAL, your customer will
            // be redirected to an intermediate site first to authorize the payment, then
            // redirected to the `return_url`.
            showMessage(error.message);

            setLoading(false);
        }

        // ------- UI helpers -------

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");

            messageContainer.classList.remove("hidden");
            messageContainer.textContent = messageText;

            setTimeout(function() {
                messageContainer.classList.add("hidden");
                messageContainer.textContent = "";
            }, 4000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("#submit").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
                document.querySelector("#button-text").classList.add("hidden");
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
                document.querySelector("#button-text").classList.remove("hidden");
            }
        }
    </script>
</body>

</html>
