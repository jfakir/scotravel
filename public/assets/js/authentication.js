$(document).ready(function () {
    $('body').on('submit', '#signup_form', function (event) {
        event.preventDefault();
        $('.error-message').text('');
        let error = 0;
        if ($('#fname_signup_input').val() == '') {
            $('#fname_signup_input').parent().find('.error-message').text('This field is required');
            error = -1;
        }
        if ($('#lname_signup_input').val() == '') {
            $('#lname_signup_input').parent().find('.error-message').text('This field is required');
            error = -1;
        }

        if ($('#email_signup_input').val() == '' || !isValidEmail($('#email_signup_input').val())) {
            $('#email_signup_input').parent().find('.error-message').text('Invalid email format');
            error = -1;
        }
        if ($('#phone_signup_input').val() == '') {
            $('#phone_signup_input').parent().parent().find('.error-message').text('This field is required');
            error = -1;
        }
        if (!isValidPassword($('#password_signup_input').val())) {
            $('#password_signup_input').parent().parent().find('.error-message').text('Password should at least be 8 characters, contains 1 uppercase, 1 lower case and 1 special character');
            error = -1;
        }
        if ($('#password_signup_input').val() != $('#confirm_password_signup_input').val()) {
            $('#confirm_password_signup_input').parent().parent().find('.error-message').text('Password missmatch');
            error = -1;
        }
        if (!$('#is_agree_to_terms_and_conditions').is(':checked')) {
            $('#is_agree_to_terms_and_conditions').parent().find('.error-message').text('Please agree on terms and conditions');
            error = -1;
        }

        if (error == -1) {
            return false;
        }
        var formData = $(this).serialize();

        var iti = window.intlTelInputGlobals.getInstance(document.querySelector('#phone_signup_input'));
        var phone_signup_input = iti.getNumber();
        var country_data = iti.getSelectedCountryData();
        var dial_code_not_encoded = country_data.dialCode;
        var dial_code = encodeURIComponent('+') + country_data.dialCode;
        var country_code = country_data.iso2.toUpperCase();
        var phone_formatted = phone_signup_input.replace('+' + dial_code_not_encoded, '');

        formData += '&phone_formatted=' + removeNonDigitCharacters(phone_formatted);
        formData += '&phone_code=' + dial_code;
        formData += '&country_code=' + country_code;
        $.ajax({
            type: 'POST',
            url: baseURL + '/signup',
            data: formData,
            success: function (response) {
                $('input[name="csrf_test_name"]').val(response.token);
                if (response.status) {
                    window.location.href = baseURL;
                } else {
                    if (response.data) {
                        alertError(response.data);
                    }
                }
            },
            error: function (xhr, status, error) {
                alertError(xhr.responseText);
            }
        });
        return false;
    });

    $('body').on('submit', '#login_form', function (event) {
        event.preventDefault();
        $('.error-message').text('');
        let error = 0;
        if ($('#email_login_input').val() == '') {
            $('#email_login_input').parent().find('.error-message').text('This field is required');
            error = -1;
        }
        if ($('#password_login_input').val() == '') {
            $('#password_login_input').parent().parent().find('.error-message').text('This field is required');
            error = -1;
        }
        if (error == -1) {
            return false;
        }
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: baseURL + '/login',
            data: formData,
            success: function (response) {
                $('input[name="csrf_test_name"]').val(response.token);
                if (response.status) {
                    window.location.href = baseURL + 'trips/upcoming';
                } else {
                    alertError('Invalid credentials');
                }
            },
            error: function (xhr, status, error) {
                alertError(xhr.responseText);
            }
        });
        return false;
    });

    $('body').on('click', '#forgot_password_button', function () {
        $('.error-message').text('');
        let error = 0;
        if ($('#email_login_input').val() == '') {
            $('#email_login_input').parent().find('.error-message').text('This field is required');
            error = -1;
        }
        if (error == -1) {
            return false;
        }
        var formData = $('#login_form').serialize();
        $.ajax({
            type: 'POST',
            url: baseURL + '/resetPassword',
            data: formData,
            beforeSend: function () {
            },
            success: function (response) {
                if (response.status) {
                    alertSuccess('Check your inbox to reset your password');
                } else {
                    alertError(response.data);
                }
            },
            complete: function () {
            },
            error: function (xhr, status, error) {
                alertError(xhr.responseText);
            }
        });
        return false;
    });

    $('body').on('submit', '#reset_password_form', function (event) {
        event.preventDefault();
        $('.error-message').text('');
        let error = 0;
        if (!isValidPassword($('#password_reset_password_input').val())) {
            $('#password_reset_password_input').parent().parent().find('.error-message').text('Password should at least be 8 characters, contains 1 uppercase, 1 lower case and 1 special character');
            error = -1;
        }
        if ($('#confirm_password_reset_password_input').val() != $('#password_reset_password_input').val()) {
            $('#confirm_password_reset_password_input').parent().parent().find('.error-message').text('Password missmatch');
            error = -1;
        }
        if (error == -1) {
            return false;
        }
        var urlParams = new URLSearchParams(window.location.search);
        var formData = $(this).serialize();
        formData += '&token=' + urlParams.get('token');
        $.ajax({
            type: 'POST',
            url: baseURL + '/updatePassword',
            data: formData,
            success: function (response) {
                if (response.status) {
                    window.location.href = baseURL;
                } else {
                    if (response.data) {
                        alertError(response.data);
                    }
                }
            },
            error: function (xhr, status, error) {
                alertError(error);
            }
        });
        return false;
    });


    $('body').on('submit', '#verify_account', function (event) {
        event.preventDefault();
        console.log(123);
        var formData = $(this).serialize();
        // $('.error-message').text('');
        // let error = 0;
        // if (!isValidPassword($('#password_reset_password_input').val())) {
        //     $('#password_reset_password_input').parent().parent().find('.error-message').text('Password should at least be 8 characters, contains 1 uppercase, 1 lower case and 1 special character');
        //     error = -1;
        // }
        // if ($('#confirm_password_reset_password_input').val() != $('#password_reset_password_input').val()) {
        //     $('#confirm_password_reset_password_input').parent().parent().find('.error-message').text('Password missmatch');
        //     error = -1;
        // }
        // if (error == -1) {
        //     return false;
        // }
        // var urlParams = new URLSearchParams(window.location.search);
        // var formData = $(this).serialize();\
        var urlParams = new URLSearchParams(window.location.search);
        formData += '&token=' + urlParams.get('userID');
        $.ajax({
            type: 'POST',
            url: baseURL + '/verifyAccount',
            data: formData,
            success: function (response) {
                if (response.status) {
                    window.location.href = baseURL;
                } else {
                    if (response.data) {
                        alertError(response.data);
                    }
                }
            },
            error: function (xhr, status, error) {
                alertError(error);
            }
        });
        return false;
    });

    // Start Alert
    $('.alert-container').each(function () {
        if ($(this).find('.alert').length) {
            $(this).css('opacity', 1);
        }
    });

    $('.btn-close').click(function () {
        $(this).closest('.alert-container').css('opacity', 0);
    });
    // End Alert

    initializePhoneInput();
    intializePasswordToggle();
});
