document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete this product?')) {
                const row = this.closest('tr');
                const productId = row.dataset.id;

                fetch(`/delete-product/${productId}`, {
                    method: 'DELETE',
                })
                    .then(response => {
                        if (response.ok) {
                            alert('Product deleted successfully!');
                            row.remove();
                        } else {
                            alert('Failed to delete product.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });
});