document.addEventListener("DOMContentLoaded", function() {
    // AJAX: Fetch books and build UI dynamically
    window.loadBooks = function(catId) {
        const display = document.getElementById('book-display');
        display.innerHTML = "Loading...";

        fetch(`fetch_books.php?cat_id=${catId}`)
            .then(res => res.json())
            .then(data => {
                display.innerHTML = "";
                data.forEach(book => {
                    display.innerHTML += `
                        <div class="book-card">
                            <img src="../public/uploads/books/${book.image_path || 'default.png'}">
                            <h4>${book.title}</h4>
                            <p>${book.author}</p>
                            <p class="price">$${book.price}</p>
                        </div>`;
                });
            });
    };

    // Client-side Validation
    const regForm = document.getElementById('regForm');
    if (regForm) {
        regForm.addEventListener('submit', function(e) {
            const pass = document.getElementById('password').value;
            if (pass.length < 8) {
                alert("Password must be at least 8 characters!");
                e.preventDefault();
            }
        });
    }
});