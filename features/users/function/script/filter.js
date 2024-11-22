function filterProducts(type) {
    const products = document.querySelectorAll('.product-item');
    products.forEach(product => {
        if (type === 'all' || product.dataset.type === type) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}