<script>
document.addEventListener('DOMContentLoaded', function() {

    const ratingOrderId   = document.getElementById('ratingOrderId');
    const ratingProductId = document.getElementById('ratingProductId');
    const ratingValue     = document.getElementById('ratingValue');
    const ratingComment   = document.getElementById('ratingComment');
    const ratingModalEl   = document.getElementById('ratingModal');
    const detailModalEl   = document.getElementById('orderDetailModal');

    // ===============================
    //  Blur active element (Bootstrap fix)
    // ===============================
    document.querySelectorAll('.modal').forEach(modal => {
        ['show.bs.modal', 'shown.bs.modal', 'hide.bs.modal', 'hidden.bs.modal']
        .forEach(eventName => {
            modal.addEventListener(eventName, () => {
                setTimeout(() => document.activeElement.blur(), 10);
            });
        });
    });


    // ===============================
    // RATE BUTTON
    // ===============================
    document.querySelectorAll('.rate-btn').forEach(btn => {
        btn.addEventListener('click', function () {

            closeDetailModalIfOpen();

            ratingOrderId.value   = this.dataset.order;
            ratingProductId.value = this.dataset.product;


            ratingValue.value   = "";
            ratingComment.value = "";
            resetStars();

            document.querySelector('#ratingModal .modal-title').textContent = 'Rate Your Product';

            new bootstrap.Modal(ratingModalEl).show();
        });
    });


    // ===============================
    // EDIT BUTTON
    // ===============================
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {

            closeDetailModalIfOpen();

            ratingOrderId.value   = this.dataset.order;
            ratingProductId.value = this.dataset.product;
            ratingValue.value     = this.dataset.rating;
            ratingComment.value   = this.dataset.comment;

            highlightStars(this.dataset.rating);

            new bootstrap.Modal(ratingModalEl).show();
        });
    });


    // ===============================
    // STAR CLICK (Rating UI)
    // ===============================
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function () {
            const rating = this.dataset.value;
            ratingValue.value = rating;
            highlightStars(rating);
        });
    });


    function highlightStars(rating) {
        document.querySelectorAll('.star').forEach(star => {
            star.classList.remove('selected');
            if (Number(star.dataset.value) <= Number(rating)) {
                star.classList.add('selected');
            }
        });
    }

    function resetStars() {
        document.querySelectorAll('.star').forEach(star => {
            star.classList.remove('selected');
        });
    }



    // ===============================
    // SUBMIT REVIEW
    // ===============================
    document.getElementById('ratingForm').addEventListener('submit', function (e) {
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
        btn.addEventListener('click', async function () {

            closeRatingModalIfOpen();

            const orderId = this.dataset.id;
            const url = `{{ route('user.orders.show', [':id']) }}`.replace(':id', orderId);

            const container = document.getElementById('orderDetailContent');
            container.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border"></div>
                </div>
            `;

            try {
                const res = await fetch(url);
                const order = await res.json();

                const items = order.items
                    .map(i => `
                        <li>${i.name} — Rp ${Number(i.price).toLocaleString('id-ID')} × ${i.qty}</li>
                    `)
                    .join('');

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
                container.innerHTML = `
                    <p class="text-danger text-center">Failed to load order details.</p>
                `;
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

});
</script>
