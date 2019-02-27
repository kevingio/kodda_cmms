$(document).ready(function () {
    $('#update-profile-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('_method', 'PATCH');
        $.ajax({
            url: "/profile",
            type: "POST",
            data:  formData,
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                if(response.avatar) {
                    $('#profile-picture').attr('src', response.avatar);
                    $('#update-profile-form img').attr('src', response.avatar);
                }
                $('#profile-name').text(response.name);
                $('button.close').click();
                swal(
                    "Success!",
                    "Profile updated!",
                    "success"
                );
            },
            error: function () {
                swal(
                    "Oops!",
                    "Something went wrong!",
                    "error"
                );
            }
        });
    });

    $('#update-profile-form input[name=avatar]').on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = (e) => {
                $(this).siblings('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#change-password-form').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        data.push({ name: '_method', value: 'PATCH' });
        $.ajax({
            url: '/change-password/' + data[2].value,
            data: data,
            type: 'POST',
            success: function (response) {
                if (response.status == 200) {
                    $(this).find("input").val('');
                    $('button.close').click();
                    swal(
                        "Success!",
                        "Password changed!",
                        "success"
                    );
                }
            },
            error: function (response) {
                swal(
                    "Oops!",
                    "Something went wrong!" + response.responseJSON.message,
                    "error"
                );
            }
        });
    });
});
