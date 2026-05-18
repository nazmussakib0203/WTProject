<h2>Cart</h2>

<?php while($row = $cart->fetch_assoc()) { ?>
    <div>
        <h3><?= $row['title'] ?></h3>
        <p><?= $row['price'] ?></p>

        <input type="number" value="<?= $row['quantity'] ?>"
        onchange="updateCart(<?= $row['book_id'] ?>, this.value)">

        <button onclick="removeCart(<?= $row['book_id'] ?>)">Remove</button>
    </div>
<?php } ?>