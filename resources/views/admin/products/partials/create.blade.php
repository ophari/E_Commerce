<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="createProductModalLabel">Create New Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createProductForm">
        @csrf
        <div class="modal-body">

          <!-- Progress Indicator -->
          <div class="progress mb-3" style="height: 5px;">
              <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="d-flex justify-content-between mb-3 small text-muted" id="progress-labels">
              <span class="step-label">Basic Info</span>
              <span class="step-label">Details</span>
              <span class="step-label">Description & Image</span>
          </div>

          {{-- STEP 1 --}}
          <div class="step step-1">
            <h5 class="mb-3">Step 1: Basic Information</h5>
            <div class="mb-3">
              <label class="form-label">Product Name</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
              @error('name')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Brand</label>
              <select name="brand_id" class="form-select" required>
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
              </select>
              @error('brand_id')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Model</label>
              <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
              @error('model')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- STEP 2 --}}
          <div class="step step-2 d-none">
            <h5 class="mb-3">Step 2: Details</h5>
            <div class="mb-3">
              <label class="form-label">Type</label>
              <select name="type" class="form-select" required>
                <option value="">Select Type</option>
                <option value="analog" {{ old('type') == 'analog' ? 'selected' : '' }}>Analog</option>
                <option value="digital" {{ old('type') == 'digital' ? 'selected' : '' }}>Digital</option>
                <option value="smartwatch" {{ old('type') == 'smartwatch' ? 'selected' : '' }}>Smartwatch</option>
              </select>
              @error('type')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Price</label>
              <input type="text" id="price_display" class="form-control" value="{{ old('price') }}" required>
              <input type="hidden" name="price" id="price_hidden" value="{{ old('price') }}">
              @error('price')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Stock</label>
              <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
              @error('stock')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- STEP 3 --}}
          <div class="step step-3 d-none">
            <h5 class="mb-3">Step 3: Description & Image</h5>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
              @error('description')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Product Image</label>
              <input type="file" name="image_url" class="form-control" accept="storage/image/*" required>
              @error('image_url')<div class="text-danger invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-prev d-none">Previous</button>
          <button type="button" class="btn btn-primary btn-next">Next</button>
          <button type="submit" class="btn btn-success d-none">Save</button>
        </div>
      </form>
    </div>
  </div>
@push('scripts')
<script>
    $(document).ready(function() {
        let currentStep = 0;
        const steps = $('.step');
        const progressBar = $('.progress-bar');
        const stepLabels = $('#progress-labels .step-label');
        const prevBtn = $('.btn-prev');
        const nextBtn = $('.btn-next');
        const saveBtn = $('#createProductForm .btn-success[type="submit"]'); // Select save button within the form

        function showStep(n) {
            steps.addClass('d-none'); // Hide all steps
            $(steps[n]).removeClass('d-none'); // Show current step

            // Update progress bar
            const progress = ((n + 1) / steps.length) * 100;
            progressBar.css('width', progress + '%').attr('aria-valuenow', progress);

            // Update step labels
            stepLabels.removeClass('active');
            $(stepLabels[n]).addClass('active');

            // Update button visibility
            if (n == 0) {
                prevBtn.addClass('d-none');
            }
            else {
                prevBtn.removeClass('d-none');
            }

            if (n == (steps.length - 1)) {
                nextBtn.addClass('d-none');
                saveBtn.removeClass('d-none');
            }
            else {
                nextBtn.removeClass('d-none');
                saveBtn.addClass('d-none');
            }
        }

        function validateStep(n) {
            // Basic validation for current step
            let isValid = true;
            $(steps[n]).find('input[required], select[required], textarea[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
                else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }

        nextBtn.on('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.on('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        // Initial display
        showStep(currentStep);

        // Format price input
        const priceDisplay = document.getElementById('price_display');
        const priceHidden = document.getElementById('price_hidden');

        priceDisplay.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            priceHidden.value = value;
            if (value) {
                e.target.value = 'Rp. ' + new Intl.NumberFormat('id-ID').format(value);
            }
            else {
                e.target.value = '';
            }
        });

        // Reset form on modal close
        $('#createProductModal').on('hidden.bs.modal', function() {
            $('#createProductForm')[0].reset();
            $('.is-invalid').removeClass('is-invalid'); // Clear validation states
            currentStep = 0;
            showStep(currentStep);
        });
    });
</script>
@endpush
</div>

