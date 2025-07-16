document.addEventListener("DOMContentLoaded", function () {
    displayCart();
});

let products = [
    { id: 1, name: "Apple", price: 1.5 },
    { id: 2, name: "Banana", price: 0.5 },
    { id: 3, name: "Milk", price: 2.0 }
];

function addToCart(id) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let product = products.find(p => p.id === id);

    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`${product.name} added to cart!`);
    displayCart();
}

function displayCart() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartItems = document.getElementById("cart-items");
    let totalPrice = document.getElementById("total-price");

    if (cartItems) {
        cartItems.innerHTML = "";
        let total = 0;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            let li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                ${item.name} ($${item.price} x ${item.quantity}) - $${(item.price * item.quantity).toFixed(2)}
                <div>
                    <button class="btn btn-sm btn-success" onclick="increaseQuantity(${index})">+</button>
                    <button class="btn btn-sm btn-warning" onclick="decreaseQuantity(${index})">-</button>
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">Remove</button>
                </div>
            `;
            cartItems.appendChild(li);
        });

        totalPrice.innerText = `Total: $${total.toFixed(2)}`;
    }
}

function increaseQuantity(index) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart[index].quantity += 1;
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

function decreaseQuantity(index) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (cart[index].quantity > 1) {
        cart[index].quantity -= 1;
    } else {
        cart.splice(index, 1); // Remove item if quantity reaches zero
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

function generateSampleProducts() {
    let sampleProducts = [];
    for (let i = 1; i <= 100; i++) {
        let product = {
            name: `Product ${i}`,
            price: (Math.random() * (100 - 10) + 10).toFixed(2), // Random price between $10 and $100
            image: `https://via.placeholder.com/50x50?text=Product+${i}`, // Placeholder image
            description: `This is a description for Product ${i}. It's a great product that you can use for many purposes.`
        };
        sampleProducts.push(product);
    }

    // Store the sample products in localStorage
    localStorage.setItem("products", JSON.stringify(sampleProducts));
    products = sampleProducts; // Update the current products array
    displayProducts(); // Display the newly added products
}

// Call the function to generate 100 sample products when the page loads
generateSampleProducts();

