// Add these functions to your existing myscript.js file

function updateCartCount() {
    fetch('../control/cart_count_process.php')
        .then(res => res.json())
        .then(data => {
            let span = document.getElementById('cart-count');
            if(span) span.innerText = data.count;
        });
}

function addToCart(bookId) {
    let quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
    
    fetch('../control/add_to_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'book_id=' + bookId + '&quantity=' + quantity
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('Added to cart successfully!');
            updateCartCount();
        } else {
            alert(data.message);
        }
    });
}