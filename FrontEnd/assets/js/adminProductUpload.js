$(document).ready(function() {
    $('#uploadProduct').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form values
        var productName = $('#productName').val();
        var price = $('#price').val();
        var image = $('#image')[0].files[0];

        var formData = new FormData();
        formData.append('productName', productName);
        formData.append('price', price);
        formData.append('image', image);

        $.ajax({
            method: 'POST',
            url: 'http://localhost/newProject/backEnd/product/upload',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Product Uploaded',
                    text: 'Product uploaded successfully.',
                }).then(() => {
                    // Reset form fields
                    $('#uploadProduct')[0].reset();

                    // Refresh the product list
                    $("#showProductDetails").empty();
                    displayProduct();
                });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while uploading the product.',
                });
            }
        });
    });
});

function logOut(){
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