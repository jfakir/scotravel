$(document).ready(function () {
    // Access the menu bar
    $('.toggle-sidebar-btn').on('click', function (e) {
        $('body').toggleClass('toggle-sidebar');
    });
});

$(window).on('load', function () {
    // Start Loader
    setTimeout(() => {
        $('.loader').addClass('displayNone');
    }, 200);
    // End Loader
});

function initializePhoneInput() {
    var phoneInput = document.querySelector(".phone-input");
    if (phoneInput) {
        // Initialize the Intl Tel Input plugin
        var iti = window.intlTelInput(phoneInput, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@20.0.5/build/js/utils.js",
            initialCountry: "auto", // Automatically set the initial country
            formatAsYouType: true,
            showSelectedDialCode: true,
            strictMode: true,
            geoIpLookup: function (callback) {
                fetch("https://ipapi.co/json")
                    .then(function (res) { return res.json(); })
                    .then(function (data) { callback(data.country_code); })
                    .catch(function (error) {
                        alertError('Error fetching user location:', error);
                        callback(); // Call callback with no country code
                    });
            }
        });
    }
}

function intializePasswordToggle() {
    $('.passwordToggle').click(function () {
        var inputField = $(this).prev(); // Get the input field preceding the eye icon
        var inputType = inputField.attr('type'); // Get the type of the input field (password or text)
        // Toggle password visibility and change eye icon accordingly
        if (inputType === 'password') {
            inputField.attr('type', 'text');
            $(this).removeClass('bi-eye-slash').addClass('bi-eye');
        } else {
            inputField.attr('type', 'password');
            $(this).removeClass('bi-eye').addClass('bi-eye-slash');
        }
    });
}

function isValidEmail(email) {
    // Regular expression for validating email formatx
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPassword(password) {
    // Check length
    if (password.length <= 8) {
        return false;
    }

    // Check for at least one uppercase letter
    if (!/[A-Z]/.test(password)) {
        console.log(2);
        return false;
    }

    // Check for at least one special character
    if (!/[!@#$%^&*()-_=+{};:,<.>/?\\|`~]/.test(password)) {
        console.log(3);
        return false;
    }

    // Check for at least one digit
    if (!/\d/.test(password)) {
        console.log(4);
        return false;
    }
    // If all conditions are met, return true
    return true;
}

function alertSuccess(message) {
    $('body').append(`
    <div class="alert alert-primary alert-dismissible fade show session-alert" role="alert" style="display:none;" id="alertSuccess">
        <p class="mb-0 message">${message}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `);
    $('#alertSuccess').show().delay(3000).fadeOut(400, function () {
        $(this).remove();
    });
}

function alertError(message) {
    $('body').append(`
    <div class="alert alert-danger alert-dismissible fade show session-alert" role="alert" style="display:none;" id="alertError">
        <p class="mb-0 message">${message}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    `);
    $('#alertError').show().delay(3000).fadeOut(400, function () {
        $(this).remove();
    });
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function intializeSelect2Multiple() {
    $('.select2multiple').select2({
        closeOnSelect: false,
        width: '100%',
        templateResult: function (option) {
            if (!option.element) {
                return option.text;
            }
            var $option = $('<span>' + option.text + '</span>');
            if ($(option.element).prop('selected')) {
                $option.prepend('<input type="checkbox" checked="checked">');
            } else {
                $option.prepend('<input type="checkbox" >');
            }
            return $option;
        }
    });

    $('.select2multiple').on('select2:select select2:unselect', function (e) {
        var $option = $(e.params.data.element);
        var $checkbox = $option.closest('.select2-results__option').find('input[type="checkbox"]');
        $checkbox.prop('checked', $option.prop('selected'));
    });

    $('body').on('click', '.select2-results__option input[type="checkbox"]', function (e) {
        e.stopPropagation();
        var $option = $(this).closest('.select2-results__option');
        var $select = $option.closest('.select2-container').prev('.select2multiple');
        var value = $option.attr('data-select2-id');
        $select.val([$option.attr('data-select2-id')]).trigger('change');
    });

    $('body').on('click', '.select2-results__option', function (e) {
        var $checkbox = $(this).find('input[type="checkbox"]');
        $checkbox.prop('checked', !$checkbox.prop('checked'));
    });
}

function intializeSelect2Single() {
    $('.select2single').select2({
        width: '100%',
        templateResult: function (option) {
            if (!option.element) {
                return option.text;
            }
            var $option = $('<span>' + option.text + '</span>');
            if ($(option.element).prop('selected')) {
                $option.prepend('<input type="radio" checked="checked" name="select2single">');
            } else {
                $option.prepend('<input type="radio" name="select2single">');
            }
            return $option;
        }
    });

    $('.select2single').on('select2:select', function (e) {
        var $option = $(e.params.data.element);
        var $radio = $option.closest('.select2-results__option').find('input[type="radio"]');
        $radio.prop('checked', true);
    });

    $('body').on('click', '.select2-results__option input[type="radio"]', function (e) {
        e.stopPropagation();
        var $option = $(this).closest('.select2-results__option');
        var $select = $option.closest('.select2-container').prev('.select2single');
        var value = $option.attr('data-select2-id');
        $select.val(value).trigger('change');
    });

    $('#notificationTenantID_select').data('select2').$dropdownParent = $('#manageNotification_modal');
}

function removeNonDigitCharacters(phoneNumber) {
    return phoneNumber.replace(/\D/g, ''); // Replace all non-digit characters with an empty string
}


function getAllCompanies(){

    $.ajax({
        type: 'POST',
        url: baseURL + '/tenants/getAllCompanies',
        success: function (response) {
            if(response['status']){
                var companiesArray = response['data'];
                for(var i=0; i<companiesArray.length; i++){   
                    $("#tripTenantID_select2").append(`
                        <option value="${companiesArray[i]['id']}">${companiesArray[i]['name']}</option>
                    `);
                }
            }
    
        },
        error: function (xhr, status, error) {
            alertError('Connection Error');
        }
    });
}

function getAllCities(){

    $.ajax({
        type: 'POST',
        url: baseURL + 'cities/getAllCities',
        success: function (response) {
            if(response['status']){
                var citiesArray = response['data'];
                for(var i=0; i<citiesArray.length; i++){   
                    $("#tripDestination_select").append(`
                        <option value="${citiesArray[i]['id']}">${citiesArray[i]['city']}</option>
                    `);
                }
            }
    
        },
        error: function (xhr, status, error) {
            alertError('Connection Error');
        }
    });

}

function deleteTrip(id){
    $.ajax({
        type: 'POST',
        url: baseURL + 'trips/deleteTrip',
        data: "id=" + id,
        beforeSend: function(){
            $('.loader').removeClass('displayNone');
        },
        success: function (response) {
            console.log(response);
            if(response['status']){
                window.location.href = baseURL;
            }
    
        },
        error: function (xhr, status, error) {
            alertError('Connection Error');
        }
    });
}



function formatDate(dateStr) {
    var date = new Date(dateStr);
    var day = date.getDate();
    var month = date.getMonth() + 1; // Months are zero indexed
    var year = date.getFullYear();
    return month + '/' + day + '/' + year; // Matches 'm/d/Y' format
}
