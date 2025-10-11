function toggleMenu () {
	document.querySelector(".nav-links").classList.toggle("active");
}

// Cart functionality
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let isCartOpen = false;

function toggleCart(event) {
	if (event) {
		event.stopPropagation();
	}
	isCartOpen = !isCartOpen;
	const dropdown = document.querySelector('.cart-dropdown');
	dropdown.style.display = isCartOpen ? 'block' : 'none';
}

// Close cart when clicking outside
document.addEventListener('click', function(event) {
	const cartContainer = document.querySelector('.cart-container');
	const dropdown = document.querySelector('.cart-dropdown');
	
	if (!cartContainer.contains(event.target) && isCartOpen) {
		isCartOpen = false;
		dropdown.style.display = 'none';
	}
});

function updateCartCount() {
	const cartCount = document.querySelector('.cart-count');
	const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
	cartCount.textContent = totalItems;
}

function updateCartTotal() {
	const totalAmount = cart.reduce((sum, item) => {
		const price = parseFloat(item.price.replace('$', ''));
		return sum + (price * item.quantity);
	}, 0);
	document.getElementById('cart-total-amount').textContent = totalAmount.toFixed(2);
}

function updateCartDisplay() {
	const cartItems = document.querySelector('.cart-items');
	cartItems.innerHTML = cart.map(item => `
		<div class="cart-item">
			<div class="cart-item-details">
				<h4 class="cart-item-name">${item.name}</h4>
				<span class="cart-item-price">${item.price}</span>
			</div>
			<div class="cart-item-quantity">
				<button class="quantity-btn" onclick="updateQuantity('${item.name}', -1, event)">-</button>
				<span>${item.quantity}</span>
				<button class="quantity-btn" onclick="updateQuantity('${item.name}', 1, event)">+</button>
			</div>
			<button class="remove-item" onclick="removeFromCart('${item.name}', event)">
				<i class="fa-solid fa-trash"></i>
			</button>
		</div>
	`).join('');
	
	// Add event listeners to remove buttons
	const removeButtons = cartItems.querySelectorAll('.remove-item');
	removeButtons.forEach(button => {
		button.addEventListener('click', function(event) {
			event.stopPropagation();
			const itemName = this.closest('.cart-item').querySelector('.cart-item-name').textContent;
			removeFromCart(itemName, event);
		});
	});
	
	updateCartCount();
	updateCartTotal();
}

function addToCart(productName, price) {
	const existingItem = cart.find(item => item.name === productName);
	
	if (existingItem) {
		existingItem.quantity += 1;
	} else {
		cart.push({
			name: productName,
			price: price,
			quantity: 1
		});
	}
	
	localStorage.setItem('cart', JSON.stringify(cart));
	updateCartDisplay();
	showCartFeedback(productName);
}

function updateQuantity(productName, change, event) {
	if (event) {
		event.stopPropagation();
	}
	const item = cart.find(item => item.name === productName);
	if (item) {
		item.quantity += change;
		if (item.quantity <= 0) {
			removeFromCart(productName, event);
			return;
		}
		localStorage.setItem('cart', JSON.stringify(cart));
		updateCartDisplay();
	}
}

function removeFromCart(productName, event) {
	if (event) {
		event.stopPropagation();
	}
	cart = cart.filter(item => item.name !== productName);
	localStorage.setItem('cart', JSON.stringify(cart));
	updateCartDisplay();
}

function showCartFeedback(productName) {
	const feedback = document.createElement('div');
	feedback.className = 'cart-feedback';
	feedback.textContent = `${productName} added to cart!`;
	document.body.appendChild(feedback);
	
	setTimeout(() => {
		feedback.remove();
	}, 2000);
}

// Initialize cart display when page loads
document.addEventListener('DOMContentLoaded', function() {
	updateCartDisplay();
	
	// Add cart toggle listener
	const cartContainer = document.querySelector('.cart-container');
	cartContainer.addEventListener('click', function(event) {
		event.stopPropagation();
		toggleCart(event);
	});
	
	// Add to cart button listeners
	const addToCartButtons = document.querySelectorAll('.add-to-cart');
	addToCartButtons.forEach(button => {
		button.addEventListener('click', function(event) {
			event.stopPropagation();
			const productCard = this.closest('.product-card, .product-card1');
			const productName = productCard.querySelector('h3').textContent;
			const price = productCard.querySelector('.price').textContent;
			addToCart(productName, price);
		});
	});
	
	// Checkout button listener
	const checkoutBtn = document.querySelector('.checkout-btn');
	if (checkoutBtn) {
		checkoutBtn.addEventListener('click', function(event) {
			event.stopPropagation();
			if (cart.length === 0) {
				alert('Your cart is empty!');
				return;
			}
			alert('Proceeding to checkout...');
			// Add your checkout logic here
		});
	}
});

// Styling the Slide Show
let slideIndex = 0;
const slides = document.querySelectorAll(".slide");
const slidesContainer = document.querySelector(".slides");

function showSlides(index) {
	if (index >= slides.length) {
		slideIndex = 0;
	}
	if (index < 0) {
		slideIndex = slides.length - 1;
	}
	
	// Calculate the transform value for smooth sliding
	const offset = -slideIndex * 100;
	slidesContainer.style.transform = `translateX(${offset}%)`;
}

function changeSlide(n) {
	slideIndex += n;
	showSlides(slideIndex);
}

// Initialize slideshow
document.addEventListener('DOMContentLoaded', function() {
	showSlides(slideIndex);
	
	// Auto slide every 3 seconds
	setInterval(() => changeSlide(1), 3000);
});

// Enable real-time reviews and forum posts

document.addEventListener("DOMContentLoaded", function () {
	
	
	//User Reviews
	document.getElementById("reviewForm").addEventListener("submit", function (e) {
		e.preventDefault();
		
		let username = document.getElementById("username").value;
		let reviewText = document.getElementById("reviewText").value;
		let reviewList = document.getElementById("reviewList");
		let newReview = `<div class="review"><strong>${username}:</strong> ${reviewText}</div>`;
		reviewList.innerHTML = newReview + reviewList.innerHTML;
		
		this.reset();
	});

	//Discussion Forum
	document.getElementById("forumForm").addEventListener("submit", function (e) {
		e.preventDefault();
		let forumUser = document.getElementById("forumUser").value;
		let forumText = document.getElementById("forumText").value;
		let forumPosts = document.getElementById("forumPosts");
		let newPost = `<div class="forum-post"><strong>${forumUser}:</strong> ${forumText}</div>`;
		forumPosts.innerHTML = newPost + forumPosts.innerHTML;
		
		this.reset();
	});

	//For recommendations
	let products = [
		{id:1, name: "Cyberpunk 2077", category: "RPG", image: "cyberpunk.jpg"},
		{id:2, name: "Elden Ring", category: "RPG", image: "elden_ring.jpg"},
		{id:3, name: "FIFA 23", category: "Sports", image: "fifa23.jpg"},
		{id:4, name: "Call of Duty MW3", category: "Shooter", image: "cod_mw3.jpg"},
		{id:5, name: "Forza Horizon 5", category:"Racing", image: "forza5.jpg"}
	];
	
	function saveBrowsingHistory(productID) {
		let history = JSON.parse(localStorage.getItem("browsingHistory")) || [];
		if (!history.includes(productID)){
			history.push(productID);
		}
		localStorage.setItem("browsingHistory", JSON.stringify(history));
	}
	
	function getRecommendations(){
		let history = JSON.parse(localStorage.getItem("browsingHistory")) || [];
		let recommendedProducts = products.filter(p => history.includes(p.id));
		
		let recommendationList = document.getElementById("recommendationList");
		recommendationList.innerHTML = recommendedProducts.length
		? recommendedProducts.map(p =>
		`<div class="recommendation-item">
			<img src="${p.image}" alt=${p.name}>
		<p>${p.name}</p>
		</div>`).join("")
		: "<p>No recommendations yet. Browse products to get suggestions!</p>";
	}
	
	getRecommendations();
});

//For countdown timer and notification
function startCountdown(timerId, durationInSeconds) {
	let countdownElement = document.getElementById(timerId);
	let remainingTime = durationInSeconds;
	
	function updateTimer () {
		let hours = Math.floor(remainingTime / 3600);
		let minutes = Math.floor((remainingTime % 3600) / 60);
		let seconds = remainingTime % 60;
		
		countdownElement.innerHTML = 
			`<span>${hours.toString().padStart(2, '0')}</span> :
			<span>${minutes.toString().padStart(2, '0')}</span> :
			<span>${seconds.toString().padStart(2, '0')}</span>`;
		
		if (remainingTime > 0) {
			remainingTime--;
			setTimeout(updateTimer, 1000);
		} else {
			countdownElement.innerHTML = "<span>Deal Expired!</span>";
		}
	}
	
	updateTimer();
}

// Start countdowns (Example duration: 2 hours, 1.5 hours, 1 hours)
startCountdown("countdown1", 7200);
startCountdown("countdown2", 5400);
startCountdown("countdown3", 3600);

// Show and Close Notifications
function showNotifications (){
	let notifications = document.querySelectorAll(".notification");
	
	notifications.forEach((notification, index) => {
		setTimeout(() => {
			notification.style.display = "flex";
		}, index * 3000); //show each notification 3 seconds apart
		
		setTimeout(() => {
			notification.style.display = "none";
		}, index * 3000 + 5000); // Hide after 5 seconds
	});
}

function closeNotification(notificationId) {
	document.getElementById(notificationId).style.display = "none";
}

// Show notifications after page loads
window.onload = () => {
	setTimeout(showNotifications, 2000);
};

// To make page transitions smoother
document.addEventListener("DOMContentLoaded", function () {
	document.body.style.opacity = "0";
	document.body.style.transition = "opacity 1s";
	setTimeout(() => {
		document.body.style.opacity = "1";
	}, 100);
});

//To make shop page transitions smoother
document.getElementById("cta-button").addEventListener("click", function(event) {
	event.preventDefault();
	document.body.style.opacity = "0";
	setTimeout(() => {
		window.location.href="shop.html";
	}, 500);
});

document.querySelector('.menu-toggle').addEventListener('click', function () {
	document.querySelector('.nav-links').classList.toggle('active');
});