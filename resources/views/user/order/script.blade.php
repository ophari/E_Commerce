<script>
document.addEventListener('DOMContentLoaded', function() {

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#C5A572'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#C5A572'
        });
    @endif

    const ratingOrderId   = document.getElementById('ratingOrderId');
    const ratingProductId = document.getElementById('ratingProductId');
    const ratingValue     = document.getElementById('ratingValue');
    const ratingComment   = document.getElementById('ratingComment');
    const ratingModalEl   = document.getElementById('ratingModal');
    const detailModalEl   = document.getElementById('orderDetailModal');

    // ===============================
    // BLUR ACTIVE ELEMENT (Bootstrap fix)
    // ===============================
    document.querySelectorAll('.modal').forEach(modal => {
        ['show.bs.modal', 'shown.bs.modal', 'hide.bs.modal', 'hidden.bs.modal'].forEach(eventName => {
            modal.addEventListener(eventName, () => setTimeout(() => document.activeElement.blur(), 10));
        });
    });

    // ===============================
    // RATE & EDIT BUTTON
    // ===============================
    function openRatingModal(orderId, productId, rating = '', comment = '', isEdit = false) {
        closeDetailModalIfOpen();

        ratingOrderId.value   = orderId;
        ratingProductId.value = productId;
        ratingValue.value     = rating;
        ratingComment.value   = comment;

        resetStars();
        if (rating) highlightStars(rating);

        document.querySelector('#ratingModal .modal-title').textContent = isEdit ? 'Edit Your Review' : 'Rate Your Product';
        new bootstrap.Modal(ratingModalEl).show();
    }

    document.querySelectorAll('.rate-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            openRatingModal(btn.dataset.order, btn.dataset.product);
        });
    });

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            openRatingModal(btn.dataset.order, btn.dataset.product, btn.dataset.rating, btn.dataset.comment, true);
        });
    });

    // ===============================
    // STAR CLICK (Rating UI)
    // ===============================
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.value;
            ratingValue.value = rating;
            highlightStars(rating);
        });
    });

    function highlightStars(rating) {
        document.querySelectorAll('.star').forEach(star => {
            star.classList.toggle('selected', Number(star.dataset.value) <= Number(rating));
        });
    }

    function resetStars() {
        document.querySelectorAll('.star').forEach(star => star.classList.remove('selected'));
    }

    // ===============================
    // SUBMIT REVIEW
    // ===============================
    document.getElementById('ratingForm').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(`{{ route('user.review.submit') }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id:   ratingOrderId.value,
                product_id: ratingProductId.value,
                rating:     ratingValue.value,
                comment:    ratingComment.value
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) location.reload();
            else console.error(data);
        })
        .catch(err => console.error('ERROR:', err));
    });

    // ===============================
    // VIEW ORDER DETAIL
    // ===============================
    document.querySelectorAll('.view-order-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            closeRatingModalIfOpen();

            const orderId = btn.dataset.id;
            const url = `{{ route('user.orders.show', [':id']) }}`.replace(':id', orderId);
            const container = document.getElementById('orderDetailContent');

            container.innerHTML = `<div class="text-center py-3"><div class="spinner-border"></div></div>`;

            try {
                const res = await fetch(url);
                const order = await res.json();

                const items = order.items.map(i => `<li>${i.name} — Rp ${Number(i.price).toLocaleString('id-ID')} × ${i.qty}</li>`).join('');

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
                container.innerHTML = `<p class="text-danger text-center">Failed to load order details.</p>`;
            }
        });
    });

    // ===============================
    // CLOSE MODALS
    // ===============================
    function closeRatingModalIfOpen() {
        const modal = bootstrap.Modal.getInstance(ratingModalEl);
        if (modal) modal.hide();
    }

    function closeDetailModalIfOpen() {
        const modal = bootstrap.Modal.getInstance(detailModalEl);
        if (modal) modal.hide();
    }

    // ===============================
    // BAYAR SEKARANG - AJAX SAFE
    // ===============================
    document.querySelectorAll('.pay-now-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
                    body: formData
                });

                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Replace body content with payment view
                document.body.innerHTML = doc.querySelector('body').innerHTML;
            } catch (err) {
                alert('Gagal memproses pembayaran.');
                console.error(err);
            }
        });
    });

});
</script>
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

        // close rating modal if open
        const ratingModal = bootstrap.Modal.getInstance(ratingModalEl);
        if (ratingModal) ratingModal.hide();

        const orderId = btn.dataset.id;
        orderDetailContent.innerHTML = `<div class="text-center py-3"><div class="spinner-border" role="status"></div></div>`;

        fetch(`{{ route('user.orders.show', [':id']) }}`.replace(':id', orderId))
            .then(r => {
                if (!r.ok) throw new Error('Network response was not ok');
                return r.json();
            })
            .then(order => {
                const itemsHtml = order.items.map(i => `<li>${i.name} — Rp ${Number(i.price).toLocaleString('id-ID')} × ${i.qty}</li>`).join('');
                orderDetailContent.innerHTML = `
                    <p><strong>Order ID:</strong> #${order.id}</p>
                    <p><strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</p>
                    <p><strong>Status:</strong> ${order.status}</p>
                    <p><strong>Total:</strong> Rp ${Number(order.total).toLocaleString('id-ID')}</p>
                    <hr>
                    <h6 class="fw-bold">Product Details:</h6>
                    <ul>${itemsHtml}</ul>
                `;
                // show modal (ensure it is open)
                new bootstrap.Modal(detailModalEl).show();
            })
            .catch(err => {
                console.error(err);
                orderDetailContent.innerHTML = `<p class="text-danger text-center">Failed to load order details.</p>`;
            });
    });

    // Ensure any modal close doesn't keep focus on buttons
    document.querySelectorAll('.modal').forEach(m => m.addEventListener('hidden.bs.modal', () => { document.activeElement?.blur(); }));
});
</script>
