$(document).ready(() => {
    var userId = sessionStorage.getItem('user_id');
    $.ajax({
        method: 'GET',
        url: 'http://localhost/newProject/backEnd/fetchCartData',
        data: {
            userId: userId,
        },
        success: function (data) {
            var imgUrl = "./../../../assets/upload/";
            data.forEach(function (item) {
                var cartItem = `
                    <tr>
                        <td>
                            <div class="media">
                                <div class="d-flex">
                                    <img src="${imgUrl}${item.image}" alt="" class="img img-fluid" style="width:10rem">
                                </div>
                                <div class="media-body">
                                    <p>${item.productName}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h5>${item.price}</h5>
                        </td>
                        <td>
                            <button class="confirmbutton" data-id="${item.id}" data-product-name="${item.productName}" data-image="${item.image}" data-price="${item.price}">Purchase Now</button>
                        </td>
                        <td>
                            <button class="btn btn-danger" data-id="${item.id}">Delete</button>
                        </td>
                    </tr>
                `;
                $('#showCart').append(cartItem);
            });

            // Delete button click event
            $('.btn-danger').on('click', function () {
                var itemId = $(this).data('id');

                // Show confirmation prompt using SweetAlert
                swal.fire({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this item!',
                    icon: 'warning',
                    buttons: ['Cancel', 'Delete'],
                    dangerMode: true,
                }).then((confirmDelete) => {
                    if (confirmDelete) {
                        deleteCartItem(itemId);
                    }
                });
            });

            // Purchase button click event
            $('.confirmbutton').on('click', function () {
                var productId = $(this).data('product-id');
                var productName = $(this).data('product-name');
                var image = $(this).data('image');
                var price = $(this).data('price');

                // Show confirmation prompt using SweetAlert
                swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to purchase this item?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed the purchase, send data to the server
                        sendPurchaseData(productName, image, price);
                    }
                });
            });
        },
        error: function () {
            console.log('Error occurred during the AJAX request.');
        },
    });
});

// Function to delete cart item
function deleteCartItem(itemId) {
    $.ajax({
        method: 'POST',
        url: 'http://localhost/newProject/backEnd/deleteCartItem',
        data: {
            itemId: itemId,
        },
        success: function (response) {
            if (response.success) {
                $("#item-" + itemId).remove();
                swal.fire({
                    title: "Success",
                    text: "Item deleted successfully.",
                    icon: "success",
                    timer: 3000,
                    buttons: false
                }).then(window.location.reload());
            } else {
                swal.fire({
                    title: "Error",
                    text: "Failed to delete the item.",
                    icon: "error",
                    timer: 2000,
                    buttons: false
                });
            }
        },
        error: function () {
            console.log('Error occurred during the AJAX delete request.');
        },
    });
}

// Function to send purchase data to the server
function sendPurchaseData(productName, image, price) {
    $.ajax({
        method: 'POST',
        url: 'http://localhost/newProject/backEnd/purchase',
        data: {
            productName: productName,
            image: image,
            price: price
        },
        success: function (response) {
            if (response.success) {
                swal.fire({
                    title: 'Success',
                    text: 'Purchase successful!',
                    icon: 'success',
                    timer: 2000,
                    buttons: false
                });
            } else {
                swal.fire({
                    title: 'Error',
                    text: 'Failed to complete the purchase.',
                    icon: 'error',
                    timer: 2000,
                    buttons: false
                });
            }
        },
        error: function () {
            console.log('Error occurred during the AJAX request.');
        }
    });
}
function logoutUser() {
    $.ajax({
        method: 'GET',
        url: "http://localhost/newProject/backEnd/logout",
        success: function () {
            sessionStorage.removeItem('user_id');
            window.location.href = "./../../../index.html";
        },
        error: function () {
            window.location.href = "./../../../index.html";
        },
    });
}