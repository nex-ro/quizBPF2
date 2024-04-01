<script>
    // Button to delete post event
    $('body').on('click', '#btn-delete-post', function () {
        let post_id = $(this).data('id');
        let token = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF dari meta tag

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: 'Ingin menghapus data ini!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Fetch to delete data
                $.ajax({
                    url: '{{url('api/posts')}}/'+post_id,
                    type: 'DELETE',
                    cache: false,
                    data: {
                        '_token': token
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        // Remove post from table
                        $(`#index_${post_id}`).remove();
                    },
                    error: function(error) {
                        console.log(error); // Log error ke konsol browser
                        // Tambahkan penanganan kesalahan di sini jika diperlukan
                    }
                });
            }
        });
    });
</script>
