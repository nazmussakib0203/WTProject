<h2><?= $data['title'] ?></h2>
<p><?= $data['author'] ?></p>
<p><?= $data['description'] ?></p>
<p><?= $data['price'] ?></p>

<input type="number" id="qty" value="1">

<button onclick="addToCart(<?= $data['id'] ?>)">Add to Cart</button>

<script src="/js/script.js"></script>