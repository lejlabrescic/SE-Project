$(document).ready(() => {
    $("#registartion").on('submit', (e) => {
        e.preventDefault();
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var user = $("#user").val();
        var conformpassword = $("#conformpassword").val();
        if (name != '' && email != '' && password != '' && conformpassword != '') {
            if (password != conformpassword) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please match the password and confirm password.',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                $.ajax({
                    method: 'POST',
                    url: "http://localhost/newProject/backEnd/register",
                    data: {
                        username: name,
                        email: email,
                        password: password,
                        conformpassword: conformpassword,
                        user:user
                    },
                    success: function (response) {
                        // Process the response
                        var data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                // Redirect or perform other actions for successful registration
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                    error: function () {
                        // Handle the AJAX request error
                        Swal.fire({
                            icon: 'error',
                            text: 'An error occurred during registration. Please try again later.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }
        }
    });

    // login form
    $(document).ready(() => {
      $("#loginForm").on('submit', (e) => {
          e.preventDefault();
          var email = $("#email").val();
          var password = $("#password").val();
          $.ajax({
              method: 'POST',
              url: "http://localhost/newProject/backEnd/login",
              data: {
                  email: email,
                  password: password
              },
              success: function (response) {
                  // Process the response
                  var data = JSON.parse(response);
                  if (data.success) {
                      // Store userId in sessionStorage
                      sessionStorage.setItem('user_id', data.userId);
  
                      Swal.fire({
                          icon: 'success',
                          text: data.message,
                          showConfirmButton: false,
                          timer: 2000
                      }).then(() => {
                          if (data.role === 'admin') {
                              window.location.href = "./admin/pages/home/home.html";
                          } else {
                              window.location.href = "./modules/pages/home.html";
                          }
                      });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          text: data.message,
                          showConfirmButton: false,
                          timer: 2000
                      });
                  }
              },
              error: function () {
                  Swal.fire({
                      icon: 'error',
                      text: 'An error occurred during login. Please try again later.',
                      showConfirmButton: false,
                      timer: 2000
                  });
              },
          });
      });
  });
  
});
// logout function
function logoutUser() {
    $.ajax({
        method: 'GET',
        url: "http://localhost/newProject/backEnd/logout",
        success: function () {
            window.location.href = "./../../index.html";
        },
        error: function () {
            window.location.href = "./../../index.html";
        },
    });
}

function displayProduct() {
    $.ajax({
      method: 'GET',
      url: 'http://localhost/newProject/backEnd/products',
      success: function (response) {
        var products = response;
        var userId = sessionStorage.getItem('user_id');
        for (var i = 0; i < products.length; i++) {
          var product = products[i];
          $('#appendProduct').append(`
            <div class="col-lg-3 col-md-6">
              <div class="single-product">
                <img class="img-fluid" src="./../../assets/upload/${product.image}" alt="">
                <div class="product-details">
                  <h6>${product.productName}</h6>
                  <div class="price">
                    <h6><span>$</span>${product.price}</h6>
                  </div>
                  <div class="prd-bottom">
                    <a href="#" class="social-info addToCart" 
                      data-product-id="${product.id}"
                      data-user-id="${userId}"
                      data-product-name="${product.productName}"
                      data-image="${product.image}"
                      data-price="${product.price}">
                      <span class="ti-bag"></span>
                      <p class="hover-text">add to bag</p>
                    </a>
                    <a href="#" class="social-info addToWishlist" 
                      data-product-id="${product.id}"
                      data-user-id="${userId}"
                      data-product-name="${product.productName}"
                      data-image="${product.image}"
                      data-price="${product.price}">
                      <span class="lnr lnr-heart"></span>
                      <p class="hover-text">Wishlist</p>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          `);
        }
        // Bind click events after products are loaded
        $('.addToCart').on('click', function (e) {
          e.preventDefault();
          var productId = $(this).data('product-id');
          var userId = $(this).data('user-id');
          var productName = $(this).data('product-name');
          var image = $(this).data('image');
          var price = $(this).data('price');
          addToCart(productId, userId, productName, image, price);
        });
  
        $('.addToWishlist').on('click', function (e) {
          e.preventDefault();
          var productId = $(this).data('product-id');
          var userId = $(this).data('user-id');
          var productName = $(this).data('product-name');
          var image = $(this).data('image');
          var price = $(this).data('price');
          addToWishlist(productId, userId, productName, image, price);
        });
      },
      error: function () {
        console.log('An error occurred while fetching product details.');
      }
    });
  }
  
  function addToCart(productId, userId, productName, image, price) {
    $.ajax({
      method: 'POST',
      url: 'http://localhost/newProject/backEnd/product/chart/upload',
      data: {
        productId: productId,
        userId: userId,
        productName: productName,
        image: image,
        price: price,
      },
      success: function () { },
      error: function () { },
    });
  }
  
  function addToWishlist(productId, userId, productName, image, price) {
    $.ajax({
      method: 'POST',
      url: 'http://localhost/newProject/backEnd/product/chart/upload/wishlist',
      data: {
        productId: productId,
        userId: userId,
        productName: productName,
        image: image,
        price: price,
      },
      success: function () { },
      error: function () { },
    });
  }
  

displayProduct();

