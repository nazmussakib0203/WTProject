function searchBook() {

    let q = document.getElementById("search").value;
    let filter = document.getElementById("filter").value;

    fetch("/controllers/api.php?action=search&q=" + q + "&filter=" + filter)
    .then(res => res.json())
    .then(data => {

        let html = "";

        data.forEach(book => {
            html += `
                <div>
                    <h3>${book.title}</h3>
                    <p>${book.author}</p>
                    <a href="/controllers/bookController.php?id=${book.id}">View</a>
                </div>
            `;
        });

        document.getElementById("result").innerHTML = html;
    });
}


/* ADD */
function addToCart(id) {

    let qty = document.getElementById("qty").value;

    fetch("/controllers/api.php?action=add", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "book_id=" + id + "&qty=" + qty
    })
    .then(res => res.json())
    .then(data => alert(data.msg));
}


/* REMOVE */
function removeCart(id) {

    fetch("/controllers/api.php?action=remove", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "book_id=" + id
    })
    .then(() => location.reload());
}


/* UPDATE */
function updateCart(id, qty) {

    fetch("/controllers/api.php?action=update", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "book_id=" + id + "&qty=" + qty
    })
    .then(() => location.reload());
}