<div class="product-details-tab">
    <ul class="nav nav-pills justify-content-center" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#product-desc-tab">Description</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product-info-tab">Additional information</a>
        </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product-shipping-tab">Shipping & Returns</a>
        </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product-review-tab">Reviews
                ({{ $product['reviews'] }})</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="product-desc-tab">
            {!! $product['description'] ?? '<p>No description available.</p>' !!}
        </div>
        <div class="tab-pane fade" id="product-info-tab">
            <p>Additional product info...</p>
        </div>
        <div class="tab-pane fade" id="product-shipping-tab">
            <p>Shipping & returns details...</p>
        </div>
        <div class="tab-pane fade" id="product-review-tab">
            <p>Customer reviews...</p>
        </div>
    </div>
</div>