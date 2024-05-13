<!-- Modal -->

<div class="modal fade" id="modal-create" tabindex="-1" aria- labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria- label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post"id="formData" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama</label>
                        <input type="text" class="form-control" id="nama_mahasiswa_nim" name="nama_mahasiswa_nim
">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_mahasiswa_nim"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">tempat_lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir
">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tempat_lahir"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">tanggal_lahir
                        </label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir

">

                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal_lahir"></div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">noHp
                        </label>
                        <input type="text" class="form-control" id="noHp" name="noHp

">

                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-noHp"></div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">email
                        </label>
                        <input type="text" class="form-control" id="email" name="email

">

                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email"></div>
                    </div>


            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data- dismiss="modal">TUTUP</button>

                <button type="submit" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Button create post event
    $('body').on('click', '#btn-create-post', function () {
        // Open modal
        $('#modal-create').modal('show');
    });

    // Action create post
    $('body').on('click', '#store', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var data = new FormData(document.getElementById("formData"));

        data.append("nama_mahasiswa_nim", $('#nama_mahasiswa_nim').val());
        data.append("tempat_lahir", $('#tempat_lahir').val());
        data.append("tanggal_lahir", $('#tanggal_lahir').val());
        data.append("noHp", $('#noHp').val());
        data.append("email",$('#email').val());
        // Ajax
        $.ajax({
            url: '{{url('api/posts')}}',
            type: "POST",
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 0,
            mimeType: "multipart/form-data",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response, textStatus, jqXHR) {
                // Show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                // Data post
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
                // Append to table
                $('#table-posts').prepend(post);
                // Clear form
                $('#nama_mahasiswa_nim').val('');
                $('#tempat_lahir').val('');
                $('#tanggal_lahir').val('');
                $('#noHp').val('');
                $('#email').val('');

                // Close modal
                $('#modal-create').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.log(jqXHR.responseText);
                var errors = jqXHR.responseJSON;
                // console.log(errors)
                if(errors.nama_mahasiswa_nim) {
                    // Show alert for title error
                    $('#alert-nama_mahasiswa_nim').removeClass('d-none');
                    $('#alert-nama_mahasiswa_nim').addClass('d-block');
                    $('#alert-nama_mahasiswa_nim').html(errors.nama_mahasiswa_nim[0]);
                }
                if(errors.tempat_lahir) {
                    // Show alert for content error
                    $('#alert-tempat_lahir').removeClass('d-none');
                    $('#alert-tempat_lahir').addClass('d-block');
                    $('#alert-tempat_lahir').html(errors.tempat_lahir[0]);
                }
                if(errors.tanggal_lahir) {
                    // Show alert for content error
                    $('#alert-tanggal_lahir').removeClass('d-none');
                    $('#alert-tanggal_lahir').addClass('d-block');
                    $('#alert-tanggal_lahir').html(errors.tanggal_lahir[0]);
                }
                if(errors.noHp) {
                    // Show alert for content error
                    $('#alert-noHp').removeClass('d-none');
                    $('#alert-noHp').addClass('d-block');
                    $('#alert-noHp').html(errors.noHp[0]);
                }
                if(errors.email) {
                    // Show alert for content error
                    $('#alert-email').removeClass('d-none');
                    $('#alert-email').addClass('d-block');
                    $('#alert-email').html(errors.email[0]);
                }
            }
        });
    });
</script>
