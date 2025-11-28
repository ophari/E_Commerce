<script>
document.addEventListener('DOMContentLoaded', function() {

    // =========================
    // FETCH ORDER DETAILS
    // =========================
    document.querySelectorAll('.view-order-btn').forEach(btn => {
        btn.addEventListener('click', async function () {

            const orderId = this.dataset.id;
            const url = `{{ route('user.orders.show', [':id']) }}`.replace(':id', orderId);
            const container = document.getElementById('orderDetailContent');

            container.innerHTML =
                '<div class="text-center"><div class="spinner-border"></div></div>';

            try {
                const res = await fetch(url);
                const order = await res.json();

                const items = order.items?.map(
                    i => `<li>${i.name} — Rp ${Number(i.price).toLocaleString('id-ID')} × ${i.qty}</li>`
                ).join('');

                container.innerHTML = `
                    <p><strong>Order ID:</strong> #${order.id}</p>
                    <p><strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</p>
                    <p><strong>Status:</strong> ${order.status}</p>
                    <p><strong>Total:</strong> Rp ${Number(order.total).toLocaleString('id-ID')}</p>
                    <hr>
                    <h6 class="fw-bold">Product Details:</h6>
                    <ul>${items}</ul>
                `;

            } catch (e) {
                container.innerHTML = '<p class="text-danger text-center">Failed to load order details.</p>';
            }

        });
    });



    // =========================
    // OPEN RATING MODAL
    // =========================
    document.querySelectorAll('.rate-btn').forEach(btn => {
        btn.addEventListener('click', function () {

            document.getElementById('ratingOrderId').value = this.dataset.order;
            document.getElementById('ratingProductId').value = this.dataset.product;

            new bootstrap.Modal('#ratingModal').show();
        });
    });



    // =========================
    // SUBMIT RATING
    // =========================
    document.getElementById('ratingForm').addEventListener('submit', function (e) {
        e.preventDefault();

        fetch(`/user/review/submit`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id: ratingOrderId.value,
                product_id: ratingProductId.value,
                rating: ratingValue.value,
                comment: ratingComment.value
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    });
});
</script>