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
                        <label for="name" class="control-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">

                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">

                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Content</label>
                        <textarea class="form-control" id="content" rows="4" name="content"></textarea>

                        
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content"></div>
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
        data.append('image', $('input[id="image"]')[0].files[0]);
        data.append("title", $('#title').val());
        data.append("content",$('#content').val());
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
                    <td>${response.data.title}</td>
                    <td>${response.data.content}</td>
                    <td>
                        <img src="{{ url('storage/posts') }}${"/"+response.data.image}">
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
                `;
                // Append to table
                $('#table-posts').prepend(post);
                // Clear form
                $('#title').val('');
                $('#content').val('');
                $('#image').val('');
                // Close modal
                $('#modal-create').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                var errors = jqXHR.responseJSON;
                if(errors.title) {
                    // Show alert for title error
                    $('#alert-title').removeClass('d-none');
                    $('#alert-title').addClass('d-block');
                    $('#alert-title').html(errors.title[0]);
                }
                if(errors.content) {
                    // Show alert for content error
                    $('#alert-content').removeClass('d-none');
                    $('#alert-content').addClass('d-block');
                    $('#alert-content').html(errors.content[0]);
                }
            }
        });
    });
</script>
