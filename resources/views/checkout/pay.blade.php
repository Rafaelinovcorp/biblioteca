@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">💳 Pagamento</h1>

    <form id="payment-form">
        <div id="card-element" class="p-4 border rounded mb-4"></div>
        <button id="submit" class="btn btn-primary w-full">
            Pagar
        </button>
    </form>

    <div id="payment-message" class="text-red-500 mt-2 hidden"></div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    const form = document.getElementById("payment-form");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const { error } = await stripe.confirmCardPayment(
            "{{ $clientSecret }}",
            {
                payment_method: { card }
            }
        );

        if (error) {
            document.getElementById("payment-message").textContent = error.message;
            document.getElementById("payment-message").classList.remove("hidden");
        } else {
            window.location.href = "{{ route('checkout.sucesso') }}";
        }
    });
</script>
@endsection
