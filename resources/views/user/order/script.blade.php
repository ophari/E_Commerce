<script>
document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const ratingOrderId   = document.getElementById('ratingOrderId');
    const ratingProductId = document.getElementById('ratingProductId');
    const ratingValue     = document.getElementById('ratingValue');
    const ratingComment   = document.getElementById('ratingComment');
    const ratingModalEl   = document.getElementById('ratingModal');
    const detailModalEl   = document.getElementById('orderDetailModal');
    const orderDetailContent = document.getElementById('orderDetailContent');

    // Utility: blur active element when modal events fire (accessibility fix)
    document.querySelectorAll('.modal').forEach(modal => {
        ['show.bs.modal', 'shown.bs.modal', 'hide.bs.modal', 'hidden.bs.modal'].forEach(evt => {
            modal.addEventListener(evt, () => setTimeout(() => document.activeElement?.blur(), 10));
        });
    });

    // ----- Rating modal helpers -----
    function resetStars() {
        document.querySelectorAll('#starContainer .star').forEach(s => s.classList.remove('selected'));
    }
    function highlightStars(rating) {
        resetStars();
        document.querySelectorAll('#starContainer .star').forEach(star => {
            if (Number(star.dataset.value) <= Number(rating)) {
                star.classList.add('selected');
                star.setAttribute('aria-checked', 'true');
            } else {
                star.setAttribute('aria-checked', 'false');
            }
        });
    }

    function openRatingModal(orderId, productId, rating = '', comment = '', isEdit = false) {
        // Close detail modal if open
        const detailModal = bootstrap.Modal.getInstance(detailModalEl);
        if (detailModal) detailModal.hide();

        ratingOrderId.value = orderId || '';
        ratingProductId.value = productId || '';
        ratingValue.value = rating || '';
        ratingComment.value = comment || '';

        resetStars();
        if (rating) highlightStars(rating);

        document.querySelector('#ratingModal .modal-title').textContent = isEdit ? 'Edit Your Review' : 'Rate Your Product';
        new bootstrap.Modal(ratingModalEl).show();
    }

    // attach to rate & edit buttons (delegation)
    document.body.addEventListener('click', function (e) {
        const target = e.target.closest('.rate-btn, .edit-btn');
        if (!target) return;

        if (target.classList.contains('edit-btn')) {
            openRatingModal(target.dataset.order, target.dataset.product, target.dataset.rating, target.dataset.comment, true);
        } else {
            openRatingModal(target.dataset.order, target.dataset.product, '', '', false);
        }
    });

    // star click
    document.getElementById('starContainer').addEventListener('click', function (e) {
        const star = e.target.closest('.star');
        if (!star) return;
        const value = star.dataset.value;
        ratingValue.value = value;
        highlightStars(value);
    });

    // rating submit (AJAX)
    document.getElementById('ratingForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        try {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const payload = {
                order_id: ratingOrderId.value,
                product_id: ratingProductId.value,
                rating: ratingValue.value,
                comment: ratingComment.value,
            };

            const res = await fetch('{{ route("user.review.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (data.success) {
                location.reload();
            } else {
                console.error('Review error', data);
                alert(data.message || 'Gagal submit review.');
            }
        } catch (err) {
            console.error(err);
            alert('Gagal submit review.');
        }
    });

    // ----- Order detail (fetch JSON) -----
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.view-order-btn');
        if (!btn) return;

        const orderId = btn.dataset.id;
        const container = document.getElementById('orderDetailContent');

        container.innerHTML = `<div class="text-center py-3">
            <div class="spinner-border"></div>
        </div>`;

        fetch(`{{ route('user.orders.show', [':id']) }}`.replace(':id', orderId))
            .then(res => res.json())
            .then(order => {
                const items = order.items.map(i =>
                    `<li>${i.name} — Rp ${Number(i.price).toLocaleString('id-ID')} × ${i.qty}</li>`
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

                new bootstrap.Modal(
                    document.getElementById('orderDetailModal')
                ).show();
            });
    });

    // Ensure any modal close doesn't keep focus on buttons
    document.querySelectorAll('.modal').forEach(m => m.addEventListener('hidden.bs.modal', () => { document.activeElement?.blur(); }));
});
</script>
