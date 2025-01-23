		//JS function called on small screen
		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}

		//menu navigation active, upon page load
		document.addEventListener("DOMContentLoaded", function() {
			const navLinks = document.querySelectorAll(".topnav a");
			const currentPath = window.location.pathname;

			// Remove any existing 'active' class from all links initially
			navLinks.forEach(link => link.classList.remove("active"));

			// Add 'active' class to the link that matches the current path
			navLinks.forEach(link => {
				const linkPath = new URL(link.href).pathname; // Get path part of link's URL
				if (linkPath === currentPath) {
					link.classList.add("active");
				}
			});
		});

		//Login & Reg Form Popup
		function openLoginPopup() {
			document.getElementById("login-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeLoginPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}

		function openRegPopup() {
			document.getElementById("reg-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
			document.getElementById("login-popup").style.display = "none";

		}

		function closeRegPopup() {
			document.getElementById("reg-popup").style.display = "none";
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}
