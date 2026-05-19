document.addEventListener("DOMContentLoaded", function() {
    updateCartCount();
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', searchBooks);
    }
});
// myscript.js এ যুক্ত করো:

function updateCartCount() {
    fetch('../control/cart_count_process.php')
        .then(res => res.json())
        .then(data => {
            let span = document.getElementById('cart-count');
            if(span) span.innerText = data.count;
        })
        .catch(err => console.error('Error:', err));
}

function changeQty(cartId, change) {
    let qtyElement = document.getElementById('qty-' + cartId);
    if (!qtyElement) return;
    
    let currentQty = parseInt(qtyElement.innerText);
    let newQty = currentQty + change;
    
    if(newQty < 1) {
        removeItem(cartId);
    } else {
        updateQty(cartId, newQty);
    }
}

function updateQty(cartId, newQty) {
    fetch('../control/update_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId + '&quantity=' + newQty
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('qty-' + cartId).innerText = newQty;
            document.getElementById('sub-' + cartId).innerHTML = '$' + data.subtotal.toFixed(2);
            document.getElementById('cart-total').innerHTML = '$' + data.cart_total.toFixed(2);
            updateCartCount();
        }
    })
    .catch(err => console.error('Error:', err));
}

function removeItem(cartId) {
    if(confirm('Remove this item?')) {
        fetch('../control/remove_cart_process.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'cart_id=' + cartId
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let row = document.getElementById('row-' + cartId);
                if(row) row.remove();
                document.getElementById('cart-total').innerHTML = '$' + data.cart_total.toFixed(2);
                updateCartCount();
                if(data.cart_total == 0) location.reload();
            }
        })
        .catch(err => console.error('Error:', err));
    }
}

function submitCart() {
    let total = document.getElementById('cart-total').innerText;
    alert('Order placed successfully!\nTotal: ' + total + '\nThank you for shopping!');
}

function searchBooks() {
    let q = document.getElementById('searchInput').value.trim();
    let f = document.getElementById('filterSelect').value;
    
    fetch('/Bookstore/control/search_process.php?q=' + encodeURIComponent(q) + '&filter=' + f)
        .then(res => res.json())
        .then(data => {
            let resultsDiv = document.getElementById('results');
            if(!resultsDiv) return;
            
            let html = '<h3>Results:</h3><div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:20px; margin-top:15px;">';
            
            if(!data.success || !data.books || data.books.length === 0) {
                html += '<p style="grid-column: 1/-1; text-align:center;">No books found matching criteria.</p>';
            } else {
                data.books.forEach(book => {
                    html += `
                        <div style="border:1px solid #ddd; padding:15px; background:white; border-radius:8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            <h4 style="margin-bottom:8px; color:#333;">${book.Title}</h4>
                            <p style="margin:4px 0; font-size:14px; color:#666;"><strong>Author:</strong> ${book.Author}</p>
                            <p style="margin:4px 0; font-size:14px; color:#e74c3c;"><strong>Price:</strong> $${parseFloat(book.Price).toFixed(2)}</p>
                            <a href="book_detail.php?id=${book.ID}" style="display:inline-block; margin-top:10px; color:#764ba2; font-weight:bold; text-decoration:none; font-size:14px;">View Details →</a>
                        </div>
                    `;
                });
            }
            html += '</div>';
            resultsDiv.innerHTML = html;
        })
        .catch(err => console.error('Error searching books:', err));
}

function addToCart(bookId) {
    let qtyInput = document.getElementById('qty');
    let qty = qtyInput ? parseInt(qtyInput.value) : 1;
    
    if (isNaN(qty) || qty <= 0) {
        alert("Quantity must be a positive integer!");
        return;
    }

    fetch('/Bookstore/control/add_to_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'book_id=' + bookId + '&quantity=' + qty
    })
    .then(res => res.json())
    .then(data => {
        let msgEl = document.getElementById('msg');
        if(data.success){
            if(msgEl) msgEl.innerHTML = '<span style="color:green; font-weight:bold;">✓ Added to cart successfully!</span>';
            updateCartCount();
        } else {
            if(msgEl) msgEl.innerHTML = '<span style="color:red; font-weight:bold;">Failed to add product</span>';
        }
        setTimeout(() => { if(msgEl) msgEl.innerHTML = ''; }, 2500);
    })
    .catch(err => console.error('Error executing add to cart:', err));
}

function updateQty(cartId, newQty) {
    if(newQty < 1) {
        removeItem(cartId);
        return;
    }
    
    fetch('/Bookstore/control/update_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId + '&quantity=' + newQty
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('qty-' + cartId).innerText = newQty;
            document.getElementById('sub-' + cartId).innerHTML = '$' + data.subtotal.toFixed(2);
            document.getElementById('cart-total').innerHTML = '$' + data.cart_total.toFixed(2);
            updateCartCount();
        } else {
            alert('Failed to update quantity');
        }
    })
    .catch(err => console.error('Error updating quantity:', err));
}

function removeItem(cartId) {
    if(confirm('Are you sure you want to remove this item?')) {
        fetch('/Bookstore/control/remove_cart_process.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'cart_id=' + cartId
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                let row = document.getElementById('row-' + cartId);
                if(row) row.remove();
                
                document.getElementById('cart-total').innerHTML = '$' + data.cart_total.toFixed(2);
                updateCartCount();
                
                if(data.cart_total == 0) {
                    location.reload();
                }
            } else {
                alert('Failed to remove item');
            }
        })
        .catch(err => console.error('Error removing item:', err));
    }
}
function submitCart() {
    let total = document.getElementById('cart-total').innerText;
    alert('Order placed successfully! Total amount: ' + total + '\nThank you for shopping with us!');
    
    // Optional: Redirect to home or clear cart
    // window.location.href = '../control/clear_cart.php';
}