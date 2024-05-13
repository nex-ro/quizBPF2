<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData_edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="post_id">
                    <div class="form-group">
                        <label for="name" class="control-label">nama_mahasiswa_nim                        </label>
                        <input type="text" class="form-control" id="nama_mahasiswa_nim-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_mahasiswa_nim-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">tempat_lahir                        </label>
                        <input type="text" class="form-control" id="tempat_lahir-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tempat_lahir-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">tanggal_lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir-edit"></input>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_lahir-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">noHp</label>
                        <input type="text" class="form-control" id="noHp-edit"></input>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-noHp-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">email</label>
                        <input class="form-control"  id="email-edit"></textarea>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email-edit"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary" id="update">UPDATE</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Button to edit post event
    $('body').on('click', '#btn-edit-post', function () {
        let post_id = $(this).data('id');
        // Fetch post details with AJAX
        $.ajax({
            url: '{{url('api/posts')}}/' + post_id,
            type: "GET",
            cache: false,
            success: function (response) {
                // Fill data into the form
                $('#post_id').val(response.data.id);
                $('#nama_mahasiswa_nim-edit').val(response.data.nama_mahasiswa_nim);
                $('#tempat_lahir-edit').val(response.data.tempat_lahir);
                $('#tanggal_lahir-edit').val(response.data.tanggal_lahir);
                $('#noHp-edit').val(response.data.noHp);
                $('#email-edit').val(response.data.email);

                // Open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    // Action to update post
    $('body').on('submit', '#formData_edit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let post_id = $('#post_id').val();
        var form = new FormData();
        form.append("nama_mahasiswa_nim", $('#nama_mahasiswa_nim-edit').val());
        form.append("tempat_lahir", $('#tempat_lahir-edit').val());
        form.append("tanggal_lahir", $('#tanggal_lahir-edit').val());
        form.append("noHp", $('#noHp-edit').val());
        form.append("email",$('#email-edit').val());
        form.append("_method", "PUT");

        console.log(form.get("nama_mahasiswa_nim"))
        // AJAX request to update post
        $.ajax({
            url: '{{url('api/posts')}}/' + post_id,
            type: "POST",
            data: form,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 0,
            mimeType: "multipart/form-data",
            success: function (response) {
                // Show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                console.log(response)
                // Update post data in the table
                let post = `
                <tr id="index_${response.data.id}">
                    <td>${response.data.nama_mahasiswa_nim}</td>
                    <td>${response.data.tempat_lahir}</td>
                    <td>${response.data.tanggal_lahir}</td>
                    <td>${response.data.noHp}</td>
                    <td>${response.data.email}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
                `;
                $(`#index_${response.data.id}`).replaceWith(post);

                // Close modal
                $('#modal-edit').modal('hide');
            },
            error: function (error) {
    console.log(error);

    // Clear any previous error messages
    $('.alert').removeClass('d-block').addClass('d-none').html('');

    // Display error messages for each field
    if (error.responseJSON.errors) {
        Object.keys(error.responseJSON.errors).forEach(function(key) {
            let alert_id = "#alert-" + key + "-edit";
            $(alert_id).removeClass('d-none');
            $(alert_id).addClass('d-block');
            $(alert_id).html(error.responseJSON.errors[key][0]);
        });
    }
}

        });
    });
</script>
