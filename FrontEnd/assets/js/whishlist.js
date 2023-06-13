$(document).ready(() => {
    var userId = sessionStorage.getItem('user_id');
    $.ajax({
        method: 'GET',
        url: 'http://localhost/newProject/backEnd/fetchwishlistData',
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
                            <button class="confirmbutton" data-id="${item.id}">Remove From WishList</button>
                        </td>
                    </tr>
                `;
                $('#showWhislist').append(cartItem);
            });

            // Delete button click event
            $('.confirmbutton').on('click', function () {
                var itemId = $(this).data('id');

                // Show confirmation prompt using SweetAlert
                swal.fire({
                    title: 'Are you sure?',
                    text: 'Once Removed, It will be hard for you to find again!',
                    icon: 'warning',
                    buttons: ['Cancel', 'Delete'],
                    dangerMode: true,
                }).then((confirmDelete) => {
                    if (confirmDelete) {
                        deleteCartItem(itemId);
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
        url: 'http://localhost/newProject/backEnd/deletewhislistItem',
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

