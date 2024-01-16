<style>
    .search-content {
        text-align: left;
    }

    .search-suggestions {
        display: none; /* Initially hide the "Products" heading */
        padding: 2px;
        text-transform: uppercase;
        font-size: 10px;
        text-align: right;
        color: #6c757d; /* text-muted color */
        background-color: #f8f9fa; /* bg-soft-secondary color */
    }

    .list-group-raw {
        list-style-type: none;
        padding: 0;
    }

    .list-group-item {
        display: none; /* Initially hide all items */
        padding: 8px;
        border: 1px solid #dee2e6; /* border color */
        background-color: #fff; /* background color */
        transition: background-color 0.3s;
    }

    .list-group-item:hover {
        background-color: #f8f9fa; /* hover background color */
    }

    .product-name {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .product-details {
        display: flex;
        align-items: center;
    }

    .product-thumbnail {
        max-width: 40px;
        height: auto;
        margin-right: 10px;
        border-radius: 5px;
    }

    .product-price {
        font-size: 16px;
        font-weight: 600;
        color: #007bff; /* text-primary color */
    }

    .discounted-price {
        text-decoration: line-through;
        opacity: 0.6;
        font-size: 15px;
        margin-right: 5px;
    }

    .product-info {
        margin-top: 5px;
        font-size: 12px;
    }

    .info-label {
        font-weight: 600;
        margin-right: 5px;
    }

    .highlight {
        background-color: #ffeeba; /* Highlight color */
    }
</style>
<div class="container mt-5">
    <div id="search-content" class="search-content">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search">
        <div class="search-suggestions">Products</div>
        <ul class="list-group-raw">
            <!-- Product items here -->
            <li class="list-group-item">
                <a class="text-reset" href="https://demo.activeitzone.com/ecommerce/product/iphone-11-pro-max-256-gb-2brya">
                    <div class="product-details">
                        <img class="product-thumbnail" src="https://demo.activeitzone.com/ecommerce/public/uploads/all/p3gt6nkTAPfDQ4taBaDu2D15xATzTdwIkI38CH9d.webp" alt="Product Thumbnail">
                        <div class="flex-grow-1 overflow--hidden minw-0">
                            <div class="product-name text-truncate">IPhone 11 pro Max 256 GB</div>
                            <div class="product-price">$1,200.000</div>
                            <div class="product-info">
                                <span class="info-label">Purchase Price:</span>$1,000.000
                                <span class="info-label">Sell Price:</span>$1,500.000
                                <span class="info-label">Stock:</span>50
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-group-item">
                <a class="text-reset" href="https://demo.activeitzone.com/ecommerce/product/apple---iphone-12-pro-max-5g-256gb-ohttv">
                    <div class="product-details">
                        <img class="product-thumbnail" src="https://demo.activeitzone.com/ecommerce/public/uploads/all/ct5MTUrbESEaVH71rdkenycBpltX2zwQdoK7b1o9.webp" alt="Product Thumbnail">
                        <div class="flex-grow-1 overflow--hidden minw-0">
                            <div class="product-name text-truncate">Apple - iPhone 12 Pro Max 5G 256GB</div>
                            <div class="product-price">$1,200.000</div>
                            <div class="product-info">
                                <span class="info-label">Purchase Price:</span>$1,100.000
                                <span class="info-label">Sell Price:</span>$1,800.000
                                <span class="info-label">Stock:</span>30
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-group-item">
                <a class="text-reset" href="https://demo.activeitzone.com/ecommerce/product/oneplus-buds-white-headphones-headphones-mics-ovxsj">
                    <div class="product-details">
                        <img class="product-thumbnail" src="https://demo.activeitzone.com/ecommerce/public/uploads/all/5hObtdAm7iV4AD4Fln9EM4UjiPzdqvFzayZNneLo.webp" alt="Product Thumbnail">
                        <div class="flex-grow-1 overflow--hidden minw-0">
                            <div class="product-name text-truncate">ESR for iPhone 15 Pro Max Case with MagSafe, Supports Magnetic Charging, Slim Liquid Silicone Case, Shock Absorbing, Screen and Camera Protection, Cloud Series, Light Tan</div>
                            <div class="product-price">
                                <span class="discounted-price">$399.000</span>
                                $379.050
                            </div>
                            <div class="product-info">
                                <span class="info-label">Purchase Price:</span>$300.000
                                <span class="info-label">Sell Price:</span>$450.000
                                <span class="info-label">Stock:</span>20
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>


<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        var searchInput = this.value.toLowerCase();
        var items = document.querySelectorAll('.list-group-item');

        if (searchInput.trim() === '') {
            items.forEach(function (item) {
                item.style.display = 'none';
            });
            return; // Don't proceed further if the search input is empty
        }

        items.forEach(function (item) {
            var productName = item.querySelector('.product-name').innerText.toLowerCase();
            if (productName.includes(searchInput)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
