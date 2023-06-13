function displayProduct() {
    $.ajax({
        method: 'GET',
        url: 'http://localhost/newProject/backEnd/products',
        success: function (response) {
            var products = response;
            var userId = sessionStorage.getItem('user_id');
            for (var i = 0; i < products.length; i++) {
                var product = products[i];
                var productId = product.id;
                var productName = product.productName;
                var price = product.price;
                var image = product.image;

                // Create editable fields with initial values
                var productNameField = `<td class="editable-field" contenteditable="true" data-field="productName" data-id="${productId}">${productName}</td>`;
                var priceField = `<td class="editable-field" contenteditable="true" data-field="price" data-id="${productId}">${price}</td>`;
                var imageField = `<td>${image} <input type="file" name="image" data-field="image" data-id="${productId}"></td>`;

                // Append the row with editable fields
                $("#showProductDetails").append(`
                    <tr>
                        <td>${productId}</td>
                        ${productNameField}
                        ${priceField}
                        ${imageField}
                        <td>
                            <a href="#" onclick="return confirm('Do you want to execute')">Delete</a>
                        </td>
                    </tr>
                `);
            }

            // Add event listener for editable fields
            $(".editable-field").on("input", function () {
                var field = $(this).data("field");
                var id = $(this).data("id");
                var value = $(this).text();
                updateProductField(id, field, value);
            });

            // Add event listener for file input change
            $("input[type='file']").on("change", function () {
                var field = $(this).data("field");
                var id = $(this).data("id");
                var file = $(this).prop("files")[0];
                var value = file ? file.name : ""; // Extract the filename
                updateProductField(id, field, value, file);
            });
        },
        error: function () {
            console.log('An error occurred while fetching product details.');
        }
    });
}

function updateProductField(id, field, value, file) {
    // Send the updated field value to the server
    var formData = new FormData();
    formData.append("id", id);
    formData.append("field", field);
    formData.append("value", value);
    if (file) {
        formData.append("file", file);
    }

    $.ajax({
        method: 'POST',
        url: 'http://localhost/newProject/backEnd/updateProduct',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log('Field updated successfully.');
        },
        error: function () {
            console.log('An error occurred while updating the field.');
        }
    });
}

displayProduct();

function deleteProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this product.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: 'DELETE',
                url: `http://localhost/newProject/backEnd/products/${id}`,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Product Deleted',
                        text: 'Product deleted successfully.',
                    }).then(() => {
                        $("#showProductDetails").empty();
                        displayProduct();
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the product.',
                    });
                }
            });
        }
    });
}
displayProduct();

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