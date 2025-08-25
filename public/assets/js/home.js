$(document).ready(function () {
   
    // Start Profile
  
    $(document).on('submit', '#profile_form', function (event) {
        event.preventDefault();
        $('.error-message').text('');
        let error_flag = 0;
        if ($('#fname_profile_input').val() == '') {
            $('#fname_profile_input').parent().find('.error-message').text('This field is required');
            error_flag = -1;
        }
        if ($('#lname_profile_input').val() == '') {
            $('#lname_profile_input').parent().find('.error-message').text('This field is required');
            error_flag = -1;
        }

        if ($('#phone_profile_input').val() == '') {
            $('#phone_profile_input').parent().find('.error-message').text('Invalid email format');
            error_flag = -1;
        }
        if (error_flag == -1) {
            return false;
        }
        var formData = $(this).serialize();
        var iti = window.intlTelInputGlobals.getInstance(document.querySelector('#phone_profile_input'));
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
            url: baseURL + '/users/updatemyprofile',
            data: formData,
            success: function (response) {
                // Update CSRF
                $('input[name="csrf_test_name"]').val(response.token);
                if (response.status) {
                    alertSuccess(response.data);
                    // Update the overview
                    $('#profile_full_name').text($('#fname_profile_input').val() + ' ' + $('#lname_profile_input').val());
                    $('#profile_phone').text(phone_signup_input);
                    // Update navbar
                    $('#profile_nav').find('.nav-profile').text($('#fname_profile_input').val().charAt(0).toUpperCase() + '.' + ' ' + $('#lname_profile_input').val());
                    $('#profile_nav').find('.dropdown-menu').find('.dropdown-header').find('h6').text($('#fname_profile_input').val() + ' ' + $('#lname_profile_input').val());
                } else {
                    alertError(response.data);
                }
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });
        return false;
    });

    $(document).on('submit', '#password_form', function (event) {
        event.preventDefault();
        $('.error-message').text('');
        let error_flag = 0;
        if ($('#password_current_profile_input').val() == '') {
            $('#password_current_profile_input').parent().parent().find('.error-message').text('This field is required');
            error_flag = -1;
        }
        if ($('#password_profile_input').val() == '') {
            $('#password_profile_input').parent().parent().find('.error-message').text('This field is required');
            error_flag = -1;
        }

        if (!isValidPassword($('#password_profile_input').val())) {
            $('#password_profile_input').parent().parent().find('.error-message').text('Password should at least be 8 characters, contains 1 uppercase, 1 lower case and 1 special character');
            error_flag = -1;
        }

        if ($('#password_confirm_profile_input').val() != $('#password_profile_input').val()) {
            $('#password_confirm_profile_input').parent().parent().find('.error-message').text('Password missmatch');
            error_flag = -1;
        }
        if (error_flag == -1) {
            return false;
        }
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: baseURL + '/users/updatemyprofile',
            data: formData,
            success: function (response) {
                // Update CSRF
                $('input[name="csrf_test_name"]').val(response.token);
                if (response.status) {
                    alertSuccess(response.data);
                } else {
                    alertError(response.data);
                }
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });
        return false;
    });
    // End Profile

    // Start Swiper configuration
    var swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000, 
            disableOnInteraction: false, 
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 50,
            },
        },
    });
    // End swiper configuration

    // Start datatable configuration
    var basicFamillyAllocationTable = $('.datatable').DataTable({
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, 'All']], // Set default entries to 50
        'pageLength': -1, // Set the default number of rows per page to 50
    });
    basicFamillyAllocationTable.search('').draw();
    // End dattable configuration

    // Start date picker
    $('.datepicker').flatpickr({
        enableTime: false,
        dateFormat: 'm/d/Y',
        defaultDate: $(this).val() ,
    });
    $('.timepicker').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
    });
    // End date picker

    // Start Cost Formating
    $('.cost-input').on('keyup click change paste input', function (event) {
        // $(this).val(function (index, value) {
        //     if (value != "") {
        //         var decimalCount;
        //         value.match(/\./g) === null ? decimalCount = 0 : decimalCount = value.match(/\./g);

        //         if (decimalCount.length > 1) {
        //             value = value.slice(0, -1);
        //         }

        //         var components = value.toString().split(".");
        //         if (components.length === 1)
        //             components[0] = value;
        //         components[0] = components[0].replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        //         if (components.length === 2) {
        //             components[1] = components[1].replace(/\D/g, '').replace(/^\d{3}$/, '');
        //         }

        //         if (components.join('.') != '')
        //             return components.join('.');
        //         else
        //             return '';
        //     }
        // });
        var input = $(this).val();
        input = input.replace(/[^0-9.]/g, '');
        $(this).val(input);
    });
    // End Cost Formating

    // Start Manage Users
    $('#userBirthDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        maxDate: 'today'
    });
    // End Manage Users

    // Start Manage Trip
    $('#tripStartingDate_input').flatpickr({
        // defaultDate: $('#tripStartingDate_input').val() ? formatDate($('#tripStartingDate_input').val()) : 'today',
        // defaultDate: $('#tripStartingDate_input').val()!='' ? $('#tripStartingDate_input').val() : 'today',
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#tripEndingDate_input').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#tripEndingDate_input').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#tripEndingDate_input').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    // Initialize the ending date picker
    $('#tripEndingDate_input').flatpickr({
        // defaultDate: $('#tripEndingDate_item').val() ? formatDate($('#tripEndingDate_item').val()) : 'today',
        // defaultDate: $('#tripEndingDate_item').val()!='' ? $('#tripEndingDate_item').val() : 'today',
        dateFormat: 'm/d/Y',
        minDate: $('#tripStartingDate_input').val() || 'today'
    });
    // $('#tripStartingDate_input').flatpickr({
    //     defaultDate: 'today',
    //     dateFormat: 'm/d/Y',
    //     onChange: function (selectedDates) {
    //         var selectedDate = selectedDates[0];
    //         var selectedEndingDate = $('#tripEndingDate_input').val();
    //         if ((new Date(selectedEndingDate) > selectedDate)) {
    //             $('#tripEndingDate_input').flatpickr({
    //                 minDate: selectedDate,
    //                 dateFormat: 'm/d/Y',
    //                 defaultDate: selectedEndingDate
    //             });
    //         } else {
    //             $('#tripEndingDate_input').flatpickr({
    //                 defaultDate: selectedDate,
    //                 minDate: selectedDate,
    //                 dateFormat: 'm/d/Y'
    //             });
    //         }
    //     }
    // });

    // $('#tripEndingDate_input').flatpickr({
    //     defaultDate: 'today',
    //     dateFormat: 'm/d/Y',
    //     minDate: $('#tripStartingDate_input').val()
    // });
    // End Manage Trip

    // Start Upcoming / Past Trips
    $('.userLists').each(function () {
        var $this = $(this);
        var totalUsers = $this.find('li').length;
        if (totalUsers > 3) {
            $this.find('.showHideAllUsersLists').show();
        }
    });
    $('.showHideAllUsersLists').click(function () {
        var $userList = $(this).closest('.userLists');
        $userList.find('.additional-users').slideToggle();
        $(this).text(function (_, text) {
            return text === 'Show All Users' ? 'Hide Users' : 'Show All Users';
        });
    });
    // END Upcoming / Past Trips

    // Start timeline
    $('.date_separator').click(function () {
        $(this).next('.plans').slideToggle(500);
        // Toggle caret icon
        var icon = $(this).find('i');
        icon.toggleClass('bi-caret-up-fill');
        icon.toggleClass('bi-caret-down-fill');
    });
    // End timeline



    // Start manage trip form start

    $(document).on("change", '#tripTenantID_select2', function () {
        $("#tripTravelersID_select").val("");
        $("#tripTravelersID_select").html("");

        //    alert($('#tripTenantID_select2').val());
            if(parseInt($("#tripTenantID_select2").val())>0){
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'tenants/getTenantUsers',
                    data: "id=" + parseInt($("#tripTenantID_select2").val()),
                    success: function (response) {
                        if(response['status']){
                            var array = response['data'];
                            for(var i=0; i<array.length; i++){   
                                $("#tripTravelersID_select").append(`
                                    <option value="${array[i]['user_id']}">  ${array[i]['fname']} ${array[i]['lname']}</option>
                                `);
                            }
                        }
                
                    },
                    complete: function(){
                        $("#tripFormTravelersSelectPickerRow").removeClass('displayNone');
                    },
                    error: function (xhr, status, error) {
                        alertError('Connection Error');
                    }
                });
            }else{

                $("#tripFormTravelersSelectPickerRow").addClass('displayNone');

            }
    });

    $(document).on("change", '#tripDestination_select', function () {
        var selectedOption = $(this).find('option:selected');
        var search = selectedOption.attr('city-name');
        $.ajax({
            async: true,
            crossDomain: true,
            url:
                "https://api.unsplash.com/search/photos?query=" +
                search +
                "&client_id=pgLs0XVfuvfRORUt03Rl1-zGhdmTfJgYXoaC4upKLqw",
            method: "GET",
            beforeSend: function () {
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                var randomNumber = Math.floor(Math.random() * 9) + 1;
                if (response) {
                    $("#trip_form_image_url").val(response.results[randomNumber].urls.small);
                } else {
                    $("#trip_form_image_url").val("");
                }
            },
            complete: function () {
                $('.loader').fadeOut(200);
            },
            error: function (xhr, status, error) {

            },
        });
    });

        $(document).on('submit', '#trip_form', function () {
            
            $('#tripName_input').parent().find('.error-message').text('');
            $('#tripDestination_select').parent().find('.error-message').text('');
            $('#tripTenantID_select2').parent().find('.error-message').text('');
            $('#tripTravelersID_select').parent().find('.error-message').text('');

            // console.log($('#tripTravelersID_select').val());
            if ($('#tripName_input').val() == '') {
                $('#tripName_input').parent().find('.error-message').text('This field is required');
                return false;
            }

            if ($('#tripStartingDate_input').val() == '') {
                $('#tripStartingDate_input').parent().find('.error-message').text('This field is required');
                return false;
            }

            if (parseInt($('#tripDestination_select').val()) <0) {
                $('#tripDestination_select').parent().find('.error-message').text('This field is required');
                return false;
            }

            if (parseInt($('#tripTenantID_select2').val()) <0) {
                $('#tripTenantID_select2').parent().find('.error-message').text('This field is required');
                return false;
            }

            if (parseInt($('#tripTravelersID_select').val().length)==0) {
                $('#tripTravelersID_select').parent().find('.error-message').text('This field is required');
                return false;
            }

          
    
            var formData = $(this).serialize();

            if ($("#is_round_tripFormInput").prop('checked')) {
                formData = formData + "&is_round_trip=1";
            } else {
                formData = formData + "&is_round_trip=0";
            }
            $.ajax({
                type: 'POST',
                url: baseURL + '/trips/manage',
                data: formData,
                beforeSend: function () {
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    // console.log(response);
                    // Update CSRF
                    $('input[name="csrf_test_name"]').val(response.token);
                    $('#tripId').val(response.tripId);
                    
                    if (response.status) {
                        alertSuccess(response.data);
                        window.location.href = baseURL;
                    } else {
                        alertError(response.data);
                        // $('.loader').fadeOut(200);

                    }
                },
                error: function (xhr, status, error) {
                    $('.loader').fadeOut(200);
                    alertError('Connection Error');
                }
            });
            return false;
        });

        $(document).on('click', '.editTripBtn', function () {
            var tripId = $(this).attr('tripId');
            // window.location.replace(baseURL + 'trips/manage');

            $.ajax({
                type: 'POST',
                url: baseURL + 'trips/getTripDetails',
                data: { id: tripId },
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                    // window.location.replace(baseURL + 'trips/manage');
                },
                success: function (response) {
                    // console.log(response);
                    // console.log(response['tripDetails']);

                    // var tripDetails = response['tripDetails'][0];
                    // console.log(tripDetails['name']);

                    // var tripTravelers = response['tripTravelers'];
                    // $('input[name="csrf_test_name"]').val(response.token);
                    // $('#tripName_input').val(tripDetails['name']);
                    // $('#tripId').val(response.tripId);
                    
                    // if (response.status) {
                    //     alertSuccess(response.data);
                    // } else {
                    //     alertError(response.data);
                    // }
                },
                complete: function () {
                    $('.loader').fadeOut(200);
                   
                    // window.location.replace(baseURL + 'trips/manage');
                },
                error: function (xhr, status, error) {
                    $('.loader').fadeOut(200);
                    alertError('Connection Error');
                }
            });
            return false;

        });


        $(document).on('click', '#viewAllTripTravelersBtn', function () {
            $("#tripTravelersModal").modal('show');
        });

        $(document).on('click', '.tripTravelersMakeOrganizerIcon', function () {
            $("#trip_traveler_make_organizer_modal_trip_user_id").val($(this).attr('trip-user-id'));
            $("#trip_traveler_make_organizer_modal").modal('show');
        });

        $(document).on('click', '#trip_traveler_make_organizer_modal_Btn', function () {
            var id =  $("#trip_traveler_make_organizer_modal_trip_user_id").val();
            
            $.ajax({
                type: 'POST',
                url: baseURL + 'trips/makeOrganizer',
                data: { id: id },
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
              
  
                    if (response.status) {
                        // alertSuccess(response.data);
                        $(`.tripTravelerAccess${response.data}`).html(`
                            <p class="d-flex align-items-center m-0 text-primary">Organizer</p>
                        `);

                        $(`.tripTravlersModalIconDiv${response.data}`).html(`
                            <i class="bi bi-three-dots-vertical pointer" style="font-size: 22px" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"></i>
                            <div class="dropdown-menu pointer tripTravelersDismissAsOrganizerIcon" trip-user-id="${response.data}" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" >
                                    <i class="fas fa-user-times pointer " style="color: var(--blue) !important;"></i> Dismiss as organizer
                                </a>
                            </div>
                        `);
                      
                    } else {
                        alertError(response.data);
                    }
                },
                complete: function () {
                    $('.loader').fadeOut(200);
                   
                },
                error: function (xhr, status, error) {
                 
                    alertError('Connection Error');
                }
            });
            //make organizer
        });

        $(document).on('click', '.tripTravelersDismissAsOrganizerIcon', function () {
            $("#trip_traveler_dismiss_organizer_modal_trip_user_id").val($(this).attr('trip-user-id'));
            $("#trip_traveler_dismiss_organizer_modal").modal('show');
        });

        $(document).on('click', '#trip_traveler_dismiss_organizer_modal_dismissBtn', function () {
            var id =  $("#trip_traveler_dismiss_organizer_modal_trip_user_id").val();

            $.ajax({
                type: 'POST',
                url: baseURL + 'trips/dismissOrganizer',
                data: { id: id },
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
              
  
                    if (response.status) {
                  
                        $(`.tripTravelerAccess${response.data}`).html(``);

                        $(`.tripTravlersModalIconDiv${response.data}`).html(`
                            <i class="bi bi-three-dots-vertical pointer" style="font-size: 22px" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"></i>
                            <div class="dropdown-menu pointer tripTravelersMakeOrganizerIcon" trip-user-id="${response.data}"  aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" >
                                    <i class="fas fa-user-shield pointer "  style="color: var(--blue) !important;"></i> Make organizer
                                </a>
                            </div>
                        `);
                    } else {
                        alertError(response.data);
                    }
                },
                complete: function () {
                    $('.loader').fadeOut(200);
                   
                },
                error: function (xhr, status, error) {
                 
                    alertError('Connection Error');
                }
            });
            //dismiss organizer
        });
    // End manage trip form start


    //start delete modal
    $(document).on('click', '.deleteTripBtn', function () {
        $("#delete_modal_title").html("Delete Trip");
        $("#delete_modal_record_id").val($(this).attr('tripId'));
        $("#delete_modal_record_type").val('trip');
        $("#delete_modal").modal('show');
    });

    $(document).on('click','.deletePlanBtn',function(){
        $("#delete_modal_title").html("Delete Plan");
        $("#delete_modal_record_id").val($(this).attr('planId'));
        $("#delete_modal_record_type").val('plan');
        $("#delete_modal").modal('show');
    });

    
    $(document).on('click','.deleteUserIcon',function(){
        $("#delete_modal_title").html(`Delete ${$(this).attr("user-name")}`);
        $("#delete_modal_record_id").val($(this).attr('userId'));
        $("#delete_modal_record_type").val('user');
        $("#delete_modal").modal('show');
    });

    $(document).on('click','.deleteCompany',function(){
        $("#delete_modal_title").html("Delete Tenant");
        $("#delete_modal_record_id").val($(this).attr('companyId'));
        $("#delete_modal_record_type").val('company');
        $("#delete_modal").modal('show');
    });

    $(document).on('click','.tripAttachment_deleteIcon',function(){
        $("#delete_modal_title").html("Delete Attachment");
        $("#delete_modal_record_id").val($(this).attr('attach-id'));
        $("#delete_modal_record_type").val('trip-attachment');
        $("#delete_modal").modal('show');
    });

    $(document).on('click','.mileageAccountDeleteIcon',function(){
        $("#delete_modal_title").html("Delete Mileage Account");
        $("#delete_modal_record_id").val($(this).attr('account_id'));
        $("#delete_modal_record_type").val('mileage_account');
        $("#delete_modal").modal('show');
    });

    $(document).on('click','.deleteNotificationIcon',function(){
        $("#delete_modal_title").html("Delete Notification");
        $("#delete_modal_record_id").val($(this).attr('notification-id'));
        $("#delete_modal_record_type").val('notification');
        $("#delete_modal").modal('show');
    });

    
    

    $(document).on("click","#delete_modal_deleteBtn",function (){
        // console.log($("#delete_modal_record_type").val());
        var type = $("#delete_modal_record_type").val();
        var id = $("#delete_modal_record_id").val();
        if(type=='trip'){
            deleteTrip(id);
        }else if(type=='plan'){
            $.ajax({
                type: 'POST',
                url: baseURL + 'plan/deletePlan',
                data: "id=" + id,
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        var tripId = response['trip_id'];
                        window.location.href = baseURL+'trips/trip?id='+tripId;
                    }
            
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                    $('.loader').fadeOut(200);

                }
            });
        }else if(type=='user'){
            $.ajax({
                type: 'POST',
                url: baseURL + 'users/delete',
                data: "id=" + id,
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        window.location.href = baseURL+'users/view';
                    }
            
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                    $('.loader').fadeOut(200);

                }
            });
        }else if(type=='company'){
            $.ajax({
                type: 'POST',
                url: baseURL + 'tenants/delete',
                data: "id=" + id,
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        window.location.href = baseURL+'tenants/view';
                    }
            
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                    $('.loader').fadeOut(200);

                }
            });
        }else if(type=='trip-attachment'){
            $.ajax({
                type: 'POST',
                url: baseURL + 'trips/deleteAttachment',
                data: "id=" + id,
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        location.reload();
                    }
            
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                    $('.loader').fadeOut(200);
                }
            });
        }else if(type=='mileage_account'){
            $.ajax({
                type: 'POST',
                url: baseURL + 'users/deleteMileageAccount',
                data: "id=" + id,
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        location.reload();
                    }
            
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                    $('.loader').fadeOut(200);
                }
            });
        }else if(type=='notification'){
            $.ajax({
                type: 'POST',
                url: baseURL + 'notification/delete',
                data: "id=" + id,
                beforeSend: function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        location.reload();
                        // $(this).parent().parent().hide();

                    }

            
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                    $('.loader').fadeOut(200);
                }
            });
        }
        // console.log( $("#delete_modal_record_id").val());
    });
    //end delete modal

    // Flight form start
    $(document).on('change','#arrival_airport_id',function(){
        var selectedOption = $(this).find('option:selected');
        $('#arrival_airport_name').val(selectedOption.attr('arrival_airport_name'));
        $('#arrival_airport_code').val(selectedOption.attr('arrival_airport_code'));

      
    });

    $(document).on('change','#departure_airport_id',function(){
        var selectedOption = $(this).find('option:selected');
        $('#departure_airport_name').val(selectedOption.attr('departure_airport_name'));
        $('#departure_airport_code').val(selectedOption.attr('departure_airport_code'));

    });

    $(document).on('change','#airline_id',function(){
        var selectedOption = $(this).find('option:selected');
        $('#airline_name').val(selectedOption.attr('airline_name'));
    });

    $(document).on('click','.flightFormSubmitBtn',function(event){
        event.preventDefault(); 
        var $this = $(this);
        $this.prop('disabled', true);

        if($("#flight_travelers_id").val().length==0 || $("#address").val().length==0 || $("#airline_id").val()==-1 || $("#confirmation").val().trim() == '' || $("#flight_number").val().trim() == ''
            || $("#starting_date").val().trim() == '' || $("#ending_date").val().trim() == '' || $("#departure_airport_id").val()==-1  || $("#arrival_airport_id").val()==-1 ){
                $(".flightFormErrorMessage").html('Please fill the required fields');
                $this.prop('disabled', false);

            }else{
                $(".flightFormErrorMessage").html('');
                var formData = $("#flight_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend: function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }else{
                            $this.prop('disabled', false);

                        }

                    },
                    error: function (xhr, status, error) {
                        $('.loader').fadeOut(200);
                        $this.prop('disabled', false);

                        // alertError('Connection Error');
                    }
                });

            }
    });

$(document).ready(function () {
    $('#flight_travelers_id').on('change', function () {
        let selected = $(this).val(); 
        let container = $('#confirmation_fields');
        container.empty();

        console.log("Selected travelers:", selected);
        console.log("All travelers:", travelers);

        if (selected && selected.length > 0) {
            selected.forEach(function (id) {
                let traveler = travelers.find(t => String(t.user_id) === String(id));
                console.log("Matched traveler:", traveler);
                if (traveler) {
                    container.append(`
                        <div class="row mb-2 traveler-confirmation" data-user="${traveler.user_id}">
                            <label class="col-sm-2 col-form-label">
                                Confirmation for ${traveler.fname} ${traveler.lname}<i class="text-danger">*</i>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" 
                                    name="confirmation[${traveler.user_id}]" 
                                    class="form-control" 
                                    value="">
                            </div>
                        </div>
                    `);
                }
            });
        }
    });
});

    // Flight form end

    // layover form start
    $(document).on('change','#layover_arrival_airport_id',function(){
        var selectedOption = $(this).find('option:selected');
        $('#layover_arrival_airport_name').val(selectedOption.attr('arrival_airport_name'));
        $('#layover_arrival_airport_code').val(selectedOption.attr('arrival_airport_code'));

      
    });

    $(document).on('change','#layover_departure_airport_id',function(){
        var selectedOption = $(this).find('option:selected');
        $('#layover_departure_airport_name').val(selectedOption.attr('departure_airport_name'));
        $('#layover_departure_airport_code').val(selectedOption.attr('departure_airport_code'));

    });

    $(document).on('change','#layover_airline_id',function(){
        var selectedOption = $(this).find('option:selected');
        $('#layover_airline_name').val(selectedOption.attr('airline_name'));
    });

    $(document).on('click','.layoverFormSubmitBtn',function(event){
        event.preventDefault(); 
        var $this = $(this);
        $this.prop('disabled', true);
        if( $("#layover_airline_id").val()==-1  || $("#layover_flight_number").val().trim() == ''
            || $("#layover_starting_date").val().trim() == '' || $("#layover_ending_date").val().trim() == '' || $("#layover_departure_airport_id").val()==-1  || $("#layover_arrival_airport_id").val()==-1 ){
                $(".layoverFormErrorMessage").html('Please fill the required fields');
                $this.prop('disabled', false);
            }else{
                $(".layoverFormErrorMessage").html('');
                var formData = $("#layover_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend: function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }else{
                            $this.prop('disabled', false);
                        }

                    },
                    error: function (xhr, status, error) {
                        $('.loader').fadeOut(200);
                        // alertError('Connection Error');
                        $this.prop('disabled', false);

                    }
                });

            }
    });
    // layover form end

    // activity form start
    $(document).on('click','.activitySubmitBtn',function(){
        if($("#manageActivityTravelersID_select").val().length==0 || $("#activityName_input").val().length==0 || $("#activityStartingDate_input").val().trim() == '' ){
                $(".activityErrorMsg").html('Please fill the required fields');
            }else{
                $(".activityErrorMsg").html('');
                var formData = $("#activity_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend:function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }
                    },
                    complete: function () {
                        // $('.loader').fadeOut(200);
                       
                        // window.location.replace(baseURL + 'trips/manage');
                    },
                    error: function (xhr, status, error) {
                        $('.loader').fadeOut(200);
                     
                        // alertError('Connection Error');
                    }
                });

            }
    });
    // activity form end


    // car renting form start
    $(document).on('click','#saveCarRentingBtn',function(){
        if($("#manageCarRentingTravelersID_select").val().length==0 || $("#carRentingName_input").val().trim()=='' || $("#carRentingStartingDate_input").val().trim() == '' || $("#carRentingStartingTime_input").val().trim() == ''){
                $(".carRentingErrorMsg").html('Please fill the required fields');
            }else{
                $(".carRentingErrorMsg").html('');
                var formData = $("#carRenting_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend:function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }
                    },
                    complete: function () {
                        // $('.loader').fadeOut(200);
                       
                        // window.location.replace(baseURL + 'trips/manage');
                    },
                    error: function (xhr, status, error) {
                     
                        // alertError('Connection Error');
                    }
                });

            }
    });
    // car renting form end

    // transportation form start
    $(document).on('click','#saveTransportaionBtn',function(){
        if($("#manageTransportationTravelersID_select").val().length==0 || $("#transportationName_input").val().trim()=='' || $("#transportationStartingDate_input").val().trim() == '' || $("#transportationStartingTime_input").val().trim() == ''){
                $(".transportationErrorMsg").html('Please fill the required fields');
            }else{
                $(".transportationErrorMsg").html('');
                var formData = $("#transportation_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend:function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }
                    },
                    complete: function () {
                        // $('.loader').fadeOut(200);
                       
                        // window.location.replace(baseURL + 'trips/manage');
                    },
                    error: function (xhr, status, error) {
                     
                        // alertError('Connection Error');
                    }
                });

            }
    });
    // car renting form end

     // lodging form start
     $(document).on('click','#lodgingFormSaveBtn',function(){
        if($("#manageLodgingTravelersID_select").val().length==0 || $("#lodgingName_input").val().trim()=='' || $("#lodgingStartingTime_input").val().trim() == '' || $("#lodgingStartingDate_input").val().trim() == ''){
                $(".lodgingErrorMessage").html('Please fill the required fields');
            }else{
                $(".lodgingErrorMessage").html('');
                var formData = $("#lodging_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend:function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }
                    },
                    complete: function () {
                        // $('.loader').fadeOut(200);
                       
                        // window.location.replace(baseURL + 'trips/manage');
                    },
                    error: function (xhr, status, error) {
                     
                        // alertError('Connection Error');
                    }
                });

            }
    });
    // car lodging form end


    // car restaurant form start
    
    $(document).on('click','#restaurantFormSaveBtn',function(){
        if($("#manageRestaurantTravelersID_select").val().length==0 || $("#restaurantName_input").val().trim()=='' || $("#restaurantStartingDate_input").val().trim() == '' || $("#restaurantStartingTime_input").val().trim() == ''){
                $(".restaurantErrorMsg").html('Please fill the required fields');
            }else{
                $(".restaurantErrorMsg").html('');
                var formData = $("#restaurant_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/plan/save',
                    data: formData,
                    beforeSend:function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                            var tripId = response['trip_id'];
                            window.location.href = baseURL+'trips/trip?id='+tripId;
                        }
                    },
                    complete: function () {
                        // $('.loader').fadeOut(200);
                       
                        // window.location.replace(baseURL + 'trips/manage');
                    },
                    error: function (xhr, status, error) {
                     
                        // alertError('Connection Error');
                    }
                });

            }
    });
    // car restaurant form end
    
    //edit plan start
    $(document).on('click','.editPlan',function(event){
        var planId = $(this).attr('planId');
        $.ajax({
            type: 'POST',
            url: baseURL + 'plan/editPlan',
            data: "id=" + planId,
    
            success: function (response) {
                // if(response['status']){
                //     window.location.href = baseURL;
                // }
        
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });
    });
    //edit plan end

    //plan travelers start
    $(document).on('click','.planTravelersDiv',function(){
        var planId = $(this).attr('plan-id');
        $.ajax({
            type: 'POST',
            url: baseURL + 'plan/getPlanTravelers',
            data: "id=" + planId,
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if (response['status']) {
                    $("#planTravelersModal_travelersContainer").html('');
                    var array = response['data'];
                    for (var i = 0; i < array.length; i++) {
                        let confirmation = array[i]['confirmationNumber'] ? " - " + array[i]['confirmationNumber'] : "";
                        $("#planTravelersModal_travelersContainer").append(`
                <p class="d-flex align-items-center m-0">
                    <i class="bi bi-person me-2" style="font-size: 22px"></i>
                    ${array[i]['fname']} ${array[i]['lname']}${confirmation}
                </p>
            `);
                    }
                    $('#planTravelersModal').modal('show');
                }
            },
            complete: function () {
                $('.loader').fadeOut(200);
               
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });
    });
    //plan travelers end


    //tripAttachment
    
    $(document).on('click','#addTripAttachmentBtn',function(){
        $("#tripAttachment").click();
    });

    $(document).on('change', '#tripAttachment', function () {
        var attachment = document.querySelector("#tripAttachment").files[0];

       var formData = new FormData();

       formData.append("attachment", attachment);
       $("#addTripAttachmentBtn_errorMsg").html('');
       $.ajax({
           url: `${baseURL}trips/uploadAttachment`,
           method: 'POST',
           data: formData,
           dataType: 'json',
           cache: false,
           contentType: false,
           processData: false,
           beforeSend: function () {

            $('.loader').removeClass('displayNone').fadeIn();
                // $("#addTripAttachmentBtn_errorMsg").html('');

           },
           success: function (data) {
            console.log(data);
            if(data['status']){
                $("#tripAttachmentModal_id").val(data['id']);
                $("#tripAttachmentName_trip_id").val(data['trip_id']);
                $("#tripAttachmentName").val(data['name'].split('.').slice(0, -1).join('.'));
                $("#tripAttachmentModal").modal('show');

            }else{
                $("#addTripAttachmentBtn_errorMsg").html(data['data']);
            }
           },
           complete: function () {
                $('.loader').fadeOut(200);
           }
       });
    });

    $(document).on('click','#tripAttachmentSaveBtn',function(){
        var id = $("#tripAttachmentModal_id").val();
        var name = $("#tripAttachmentName").val();
        var trip_id = $("#tripAttachmentName_trip_id").val();

        $.ajax({
            type: 'POST',
            url: baseURL + 'trips/updateAttachment',
            data: {
                id: id,
                name: name,
                trip_id: trip_id,
            },
            beforeSend: function () {
                $('.loader').removeClass('displayNone');

           },
            success: function (response) {
                
                if(response['status']){
                    // window.location.href = baseURL+'trips/trip?id='+response['trip_id'];
                    location.reload();

                }else{
                    alertError(response['data']);
                }
        
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            },
            complete: function () {
                $("#tripAttachmentModal").modal('hide');
                $('.loader').fadeOut(200);
           }
        });
    });

    $(document).on('click','.tripAttachment_editIcon',function(){
        var id=$(this).attr('attach-id');
        var name=$(this).attr('attach-name');
        var tripId=$(this).attr('attach-trip-id');

        $("#tripAttachmentModal_id").val(id);
        $("#tripAttachmentName_trip_id").val(tripId);
        $("#tripAttachmentName").val(name);
        $("#tripAttachmentModal").modal('show');


    });

 
    //trip attachment end


    //plan attachment start
    $(document).on('click', '#addPlanAttachmentBtn', function () {
        let planId = $(this).data('plan-id');   
        $("#planAttachment").data('plan-id', planId); 
        $("#planAttachment").click();
    });

    $(document).on('change', '#planAttachment', function () {
        var attachment = document.querySelector("#planAttachment").files[0];
        var planId = $(this).data('plan-id'); 

       var formData = new FormData();

       formData.append("planAttachment", attachment);
       formData.append("id", planId);

       $("#addTripAttachmentBtn_errorMsg").html('');
       $.ajax({
           url: `${baseURL}plan/addAttachment`,
           method: 'POST',
           data: formData,
           dataType: 'json',
           cache: false,
           contentType: false,
           processData: false,
           beforeSend: function () {

            $('.loader').removeClass('displayNone').fadeIn();
                // $("#addTripAttachmentBtn_errorMsg").html('');

           },
           success: function (data) {
            console.log(data);
            if(data['status']){
                $("#planAttachmentModal_id").val(data['id']);
                $("#planAttachmentName_plan_id").val(data['plan_id']);
                $("#planAttachmentName").val(data['name'].split('.').slice(0, -1).join('.'));
                $("#planAttachmentModal").modal('show');

            }else{
                $("#addTripAttachmentBtn_errorMsg").html(data['data']);
            }
           },
           complete: function () {
                $('.loader').fadeOut(200);
           }
       });
    });

     $(document).on('click','#planAttachmentSaveBtn',function(){
        var id = $("#planAttachmentModal_id").val();
        var name = $("#planAttachmentName").val();
        var plan_id = $("#planAttachmentName_plan_id").val();

        $.ajax({
            type: 'POST',
            url: `${baseURL}plan/updateAttachment`,
            data: {
                id: id,
                name: name,
                plan_id: plan_id,
            },
            beforeSend: function () {
                $('.loader').removeClass('displayNone');

           },
            success: function (response) {
                
                if(response['status']){
                    // window.location.href = baseURL+'trips/trip?id='+response['trip_id'];
                    location.reload();

                }else{
                    alertError(response['data']);
                }
        
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            },
            complete: function () {
                $("#planAttachmentModal").modal('hide');
                $('.loader').fadeOut(200);
           }
        });
    });

    $(document).on('click','.tripAttachment_editIcon',function(){
        var id=$(this).attr('attach-id');
        var name=$(this).attr('attach-name');
        var tripId=$(this).attr('attach-trip-id');

        $("#tripAttachmentModal_id").val(id);
        $("#tripAttachmentName_trip_id").val(tripId);
        $("#tripAttachmentName").val(name);
        $("#tripAttachmentModal").modal('show');


    });

    $(document).on("click", ".view-attachments-btn", function() {
    let planId = $(this).data("plan-id");

    $.ajax({
        url: baseURL + "plan/getAttachments",  
        type: "GET",
        data: { plan_id: planId },
        success: function(res) {
            let data = res.data; 
            let html = "";

            if(data.length > 0){
                data.forEach(att => {
                    // let fileUrl = baseURL + "../public/assets/plan_attachments" + att.name;
                    let fileUrl = baseURL + "assets/plan_attachments/" + att.id + "." + att.extension;
                    // if image, show thumbnail, else show link
                    // if(/\.(jpg|jpeg|png|gif)$/i.test(att.name)){
                    //     html += `<div class="mb-3">
                    //                <img src="${fileUrl}" class="img-fluid rounded shadow-sm" style="max-height:150px">
                    //              </div>`;
                    // } else {
                    //     html += `<p><a href="${fileUrl}" target="_blank">${att.name}</a></p>`;
                    // }
                    if (/\.(jpg|jpeg|png|gif)$/i.test(att.extension)) {
                        html += `<div class="mb-3 d-flex align-items-center justify-content-between">
                        <img src="${fileUrl}" class="img-fluid rounded shadow-sm" style="max-height:150px">
                         <button class="btn  delete-attachment-btn" style="background:white; color:red; border:none;" data-attachment-id="${att.id}">
                            <i class="fa fa-trash"></i>
                        </button>
                       </div>`;
                    } else {
                        html += `<div class="d-flex align-items-center justify-content-between mb-2">
                       <a href="${fileUrl}" target="_blank">${att.name}</a>
                       <button class="btn  delete-attachment-btn" style="background:white; color:red; border:none;" data-attachment-id="${att.id}">
                        <i class="fa fa-trash"></i>
                       </button>
                      </div>`;
                    }
                });
            } else {
                html = "<p>No attachments found.</p>";
            }

            $("#attachmentsList").html(html);
            $("#attachmentsModal").modal("show");
        }
    });
 });

    $(document).on("click", ".delete-attachment-btn", function () {
        let attachmentId = $(this).data("attachment-id");

        if (confirm("Are you sure you want to delete this attachment?")) {
            $.ajax({
                url: baseURL + "plan/deleteAttachment",
                type: "POST",
                dataType: "json",
                data: { id: attachmentId },
                success: function (res) {
                    if (res.status) {
                        alert("Attachment deleted successfully!");
                        // reload attachments
                        $(".view-attachments-btn[data-plan-id='" + res.plan_id + "']").click();
                    } else {
                        alert("Error deleting attachment!");
                    }
                }
            });
        }
    });
    // end for plan attachments


    //users form start
    $(document).on('click','#user_form_saveBtn',function(){
        var fname = $('#userFirstName_input').val();
        var lname = $('#userLastName_input').val();
        var email = $('#userEmail_input').val();

        if(fname.trim() == '' || lname.trim() == '' || email.trim() == ''){
            $("#userFormErrorMessage").html('Please fill the required fields');
        }else{
            $("#userFormErrorMessage").html('');
            var formData = $("#user_form").serialize();
            if ($("#userAdmin_input").prop('checked')) {
                formData = formData + "&access_type=2";
            } else {
                formData = formData + "&access_type=1";
            }
            $.ajax({
                type: 'POST',
                url: baseURL + '/users/save',
                data: formData,
                beforeSend:function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        window.location.href = baseURL+'/users/view';
                    }else{
                        alertError(response['msg']);
                        $('.loader').fadeOut(200);
                    }
                },
                complete: function () {
                    // $('.loader').fadeOut(200);
                   
                    // window.location.replace(baseURL + 'trips/manage');
                },
                error: function (xhr, status, error) {
                 
                    // alertError('Connection Error');
                }
            });
        }
    });
    //users form end

    // companies form start
    $(document).on('click','#companyFormSaveBtn',function(){
        var name = $('#tenantName_input').val();

        if(name.trim() == ''){
            $("#companiesFormErrorMsg").html('Please fill the required fields');
        }else{
            $("#companiesFormErrorMsg").html('');
            var formData = $("#company_form").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'tenants/save',
                data: formData,
                beforeSend:function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        window.location.href = baseURL+'/tenants/view';
                    }
                },
                complete: function () {
                    // $('.loader').fadeOut(200);
                   
                    // window.location.replace(baseURL + 'trips/manage');
                },
                error: function (xhr, status, error) {
                 
                    // alertError('Connection Error');
                }
            });
        }
    });

    $(document).on('click','.tenantsDismissUserAsAdminBtn',function(){
        $("#tenant_dismiss_admin_modal_user_id").val($(this).attr('user_id'));
        $("#tenant_dismiss_admin_modal_tenant_id").val($(this).attr('tenant_id'));
        $("#tenant_dismiss_admin_modal_record_id").val($(this).attr('record_id'));
        
        $("#tenant_dismiss_admin_modal").modal('show');
       
    });

    $(document).on('click','#tenant_dismiss_admin_modal_dismissBtn',function(){
        var user_id = $("#tenant_dismiss_admin_modal_user_id").val();
        var tenant_id = $("#tenant_dismiss_admin_modal_tenant_id").val();
        var record_id = $("#tenant_dismiss_admin_modal_record_id").val();


        $.ajax({
            type: 'POST',
            url: baseURL + 'tenants/dismissAdmin',
            data: {
                user_id: user_id,
                tenant_id: tenant_id,
                record_id:record_id
            },
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if(response['status']){
                    location.reload();
                }
            },
            complete: function () {
                // $('.loader').fadeOut(200);
               
                // window.location.replace(baseURL + 'trips/manage');
            },
            error: function (xhr, status, error) {
             
                // alertError('Connection Error');
            }
        });
    });

    $(document).on('click','.tenantsMakeUserAdminBtn',function(){
        $("#tenant_make_admin_modal_tenant_id").val($(this).attr('tenant_id'));
        $("#tenant_make_admin_modal_user_id").val($(this).attr('user_id'));
        $("#tenant_make_admin_modal_record_id").val($(this).attr('record_id'));

        $("#tenant_make_admin_modal").modal('show');
    });


    $(document).on('click','#tenant_make_admin_modal_Btn',function(){
        var user_id = $("#tenant_make_admin_modal_user_id").val();
        var tenant_id = $("#tenant_make_admin_modal_tenant_id").val();
        var record_id = $("#tenant_make_admin_modal_record_id").val();



        $.ajax({
            type: 'POST',
            url: baseURL + 'tenants/makeAdmin',
            data: {
                user_id: user_id,
                tenant_id: tenant_id,
                record_id:record_id
            },
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if(response['status']){
                    location.reload();
                }
            },
            complete: function () {
                // $('.loader').fadeOut(200);
               
                // window.location.replace(baseURL + 'trips/manage');
            },
            error: function (xhr, status, error) {
             
                // alertError('Connection Error');
            }
        });
    });



    $(document).on('click','.tenantsRemoveUserBtn',function(){
        $("#tenant_remove_user_modal_user_id").val($(this).attr('user_id'));
        $("#tenant_remove_user_modal_tenant_id").val($(this).attr('tenant_id'));
    
       $("#tenant_remove_user_modal").modal('show');
    });

    $(document).on('click','#tenant_remove_user_modal_removeBtn',function(){
        var user_id = $("#tenant_remove_user_modal_user_id").val();
        var tenant_id = $("#tenant_remove_user_modal_tenant_id").val();

        $.ajax({
            type: 'POST',
            url: baseURL + 'tenants/removeUser',
            data: {
                user_id: user_id,
                tenant_id: tenant_id,
            },
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if(response['status']){
                    location.reload();
                }
            },
            complete: function () {
                // $('.loader').fadeOut(200);
               
                // window.location.replace(baseURL + 'trips/manage');
            },
            error: function (xhr, status, error) {
             
                // alertError('Connection Error');
            }
        });
    });

    // companies form end

    // notifications form start
    // $(document).on('click','#notificationSubmitBtn',function(){
    //     var name = $('#notificationTitle_input').val();

    //     if(name.trim() == ''){
    //         $(".notificationErrorMsg").html('Please fill the required fields');
    //     }else{
    //         $(".notificationErrorMsg").html('');
    //         var formData = $("#notification_form").serialize();
    //         if ($("#notificationIsRedeemed_input").prop('checked')) {
    //             formData = formData + "&is_redeemed=1";
    //         } else {
    //             formData = formData + "&is_redeemed=0";
    //         }
    //         $.ajax({
    //             type: 'POST',
    //             url: baseURL + 'notification/save',
    //             data: formData,
    //             beforeSend:function(){
    //                 $('.loader').removeClass('displayNone');
    //             },
    //             success: function (response) {
    //                 if(response['status']){
    //                     location.reload();
    //                 }else{
    //                     $('.loader').fadeOut(200);
    //                 }
    //             },
    //             complete: function () {
    //                 // $('.loader').fadeOut(200);
                   
    //                 // window.location.replace(baseURL + 'trips/manage');
    //             },
    //             error: function (xhr, status, error) {
                 
    //                 // alertError('Connection Error');
    //             }
    //         });
    //     }
    // });


    $(document).on('click', '#notificationSubmitBtn', function(){
        event.preventDefault();
        var $this = $(this);
        $this.prop('disabled', true);
    
        var name = $('#notificationTitle_input').val();
    
        if(name.trim() == ''){
            $(".notificationErrorMsg").html('Please fill the required fields');
            $this.prop('disabled', false);
        } else {
            $(".notificationErrorMsg").html('');
            var formData = $("#notification_form").serialize();
            if ($("#notificationIsRedeemed_input").prop('checked')) {
                formData += "&is_redeemed=1";
            } else {
                formData += "&is_redeemed=0";
            }
            $.ajax({
                type: 'POST',
                url: baseURL + 'notification/save',
                data: formData,
                beforeSend:function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response['status']){
                        location.reload();
                    }else{
                        $('.loader').fadeOut(200);
                        $this.prop('disabled', false);
                    }
                },
                error: function () {
                    $this.prop('disabled', false);
                    // Handle error
                }
            });
        }
    });

    
    $(document).on('click','.editNotificationIcon',function(){
        $('#notificationFormid').val($(this).attr('notification-id'));
        $('#notificationTitle_input').val($(this).siblings('.notificationTitleHiddenInput').val());
        $('#notificationDescription_input').val($(this).siblings('.notificationDescriptionHiddenInput').val());
        var is_redeemed = $(this).siblings('.notificationIsRedeemedHiddenInput').val();
        if(is_redeemed == 1) {
            $("#notificationIsRedeemed_input").prop('checked', true);
        } else {
            $("#notificationIsRedeemed_input").prop('checked', false);
        }
        

        $("#manageNotification_modal").modal('show');
    });

    $(document).on('click','.addNotificationIcon',function(){
        $('#notificationFormid').val(0);
        $('#notificationTitle_input').val('');
        $('#notificationDescription_input').val('');
       
        $("#notificationIsRedeemed_input").prop('checked', false);
        

        $("#manageNotification_modal").modal('show');
    });

    // notifications form end


    // trips filters start

    
    $(document).on('change','#filterTrips_FromDate',function(){

    });

    $(document).on('change','#filterTrips_ToDate',function(){
        
    });


    $(document).on('change','#filterTrips_ByTenants',function(){
        $("#filterTrips_ByTravelers").val("");
        $("#filterTrips_ByTravelers").html("");


        if($("#filterTrips_ByTenants").val().length>0){
            var ids = $("#filterTrips_ByTenants").val();
        }else{
            var ids = -1;
        }
            $.ajax({
                type: 'POST',
                url: baseURL + 'tenants/getTenantsUsers',
                data: "ids=" + ids,
                success: function (response) {
                    if(response['status']){
                        var array = response['data'];
                        for(var i=0; i<array.length; i++){   
                            $("#filterTrips_ByTravelers").append(`
                                <option  value="${array[i]['user_id']}">  ${array[i]['fname']} ${array[i]['lname']}</option>
                            `);
                        }
                    }
            
                },
                complete: function(){
                    // $(".select2-results__option input[type='checkbox']").css('margin-right', '5px');


                    $("#filterTrips_ByTravelersDiv").removeClass('displayNone');
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                }
            });
        // }else{
        //     $("#filterTrips_ByTravelersDiv").addClass('displayNone');
        // }
    });


    $(document).on('change','#filterTrips_ByTravelers',function(){

    });

    $(document).on('click','#filterTrips_submitBtn',function(){

        var tenants = $('#filterTrips_ByTenants').val();
        var travelers = $('#filterTrips_ByTravelers').val();
        var fromDate = $('#filterTrips_FromDate').val();
        var toDate = $('#filterTrips_ToDate').val();

       

        $.ajax({
            type: 'POST',
            url: baseURL + 'trips/filterTrips',
            data: {
                tenants: tenants,
                travelers: travelers,
                fromDate: fromDate,
                toDate: toDate
            },
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if(response['status']){
                    location.reload();
                }
        
            },
            complete: function(){
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });


    });

    $(document).on('click','#filterTrips_clearBtn',function(){
        $.ajax({
            type: 'POST',
            url: baseURL + 'trips/filterTrips',
            data: {
        
            },
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if(response['status']){
                    location.reload();
                }
            },
            complete: function(){
                $('#tripFilter_section').collapse('show');
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });
    });
    
    // trips filters end

    // mileage account form start
    $(document).on('click','#manageMileageAccount_modalSaveBtn',function(){
        if($("#mileageAccountNumber_input").val().trim()=='' || $("#mileageAccountAirlineID_select").val().trim()==''|| parseInt($("#mileageAccountAirlineID_select").val())==-1 ){
                $(".manageMileageAccount_modalErrorMsg").html('Please fill the required fields');
            }else{
                $(".manageMileageAccount_modalErrorMsg").html('');
                var formData = $("#mileageAccount_form").serialize();
                $.ajax({
                    type: 'POST',
                    url: baseURL + '/users/saveMileageAccount',
                    data: formData,
                    beforeSend:function(){
                        $('.loader').removeClass('displayNone');
                    },
                    success: function (response) {
                        if(response['status']){
                          location.reload();
                        }
                    },
                    complete: function () {
                        // $('.loader').fadeOut(200);
                       
                        // window.location.replace(baseURL + 'trips/manage');
                    },
                    error: function (xhr, status, error) {
                     
                        // alertError('Connection Error');
                    }
                });

            }
    });

    $(document).on('change','#mileageAccountAirlineID_select',function(){
        var selectedOption = $(this).find('option:selected');
        $('#manageMileageAccount_airlineName').val(selectedOption.attr('airline_name'));
    });

    $(document).on('click','#userAddMileageAccountBtn',function(){
        $("#mileageAccountAirlineID_select").val(-1).trigger('change');
        $("#manageMileageAccount_accountId").val(0);
        $("#manageMileageAccount_airlineName").val('');
        $("#mileageAccountNumber_input").val('');

        $("#manageMileageAccount_modal").modal('show');
    });

    $(document).on('click','.mileageAccountEditIcon',function(){
        $("#mileageAccountAirlineID_select").val($(this).attr('airline_id')).trigger('change');
        // $("#mileageAccountAirlineID_select").select2();
        $("#manageMileageAccount_accountId").val($(this).attr('account_id'));
        $("#manageMileageAccount_airlineName").val($(this).attr('airline_name'));
        $("#mileageAccountNumber_input").val($(this).attr('account-name'));

        $("#manageMileageAccount_modal").modal('show');
    });
    
    // mileage account form end

    $(document).on('click','.resetStartingTime',function(){
        $(this).prev('input[type="text"]').val('');
    });

    //flight api
    $(document).on('click','#searchFlightApi', function () {
		if ($('#flight_number').val().trim() == '') {
             alertError('Flight number is required');
		} else if ($('#starting_date').val().trim() == '') {
            alertError('Departure date is required');

		} else {
			var flightNumber = $('#flight_number').val();
			var departureDate = $('#starting_date').val();
			var dateParts = departureDate.split('/');
			var day = dateParts[1].padStart(2, '0');
			var month = dateParts[0].padStart(2, '0');
			var year = dateParts[2];
			var formatedDepartureDate = year + '-' + month + '-' + day;
			$.ajax({
				async: true,
				crossDomain: true,
				url:
					'https://aerodatabox.p.rapidapi.com/flights/number/' +
					flightNumber +
					'/' +
					formatedDepartureDate +
					'?withAircraftImage=false&withLocation=false',
				method: 'GET',
				headers: {
					'X-RapidAPI-Key':
						'b39b48308dmsha859ddc4820a56dp1c9265jsn81954e6ce80f',
					'X-RapidAPI-Host': 'aerodatabox.p.rapidapi.com',
				},
				beforeSend: function () {
                    $('.loader').removeClass('displayNone');
				},
				success: function (response) {
					// Departure Section
					if (!response) {
						alertError('Flight not found');
					} else {
						var latestUpdate = response[response.length - 1];

                        $('#airline_id option').each(function() {
                            if ($(this).text().trim() === latestUpdate.airline.name.trim()) {
                                $(this).remove();
                            }
                        });
                        $('#airline_id').append(`
                            <option selected>
                                ${latestUpdate.airline.name}
                            </option>
                        `);
                        $("#airline_name").val(latestUpdate.airline.name);

                        $('#departure_airport_id option').each(function() {
                            if ($(this).text().trim() === latestUpdate.departure.airport.name.trim()) {
                                $(this).remove();
                            }
                        });

                        $('#departure_airport_id').append(`
                            <option departure_airport_name="${latestUpdate.departure.airport.name}" departure_airport_code="${latestUpdate.departure.airport.iata}" selected>
                                ${latestUpdate.departure.airport.name}
                            </option>
                        `);

                        $("#departure_airport_code").val(latestUpdate.departure.airport.iata);
                        $("#departure_airport_name").val(latestUpdate.departure.airport.name);
						$('#departure_terminal').val(latestUpdate.departure.terminal);
						var departureDateTime = latestUpdate.departure.scheduledTime.local;
						var departureDate = departureDateTime.substr(0, 10);
						var departureTime = departureDateTime.substr(11, 5);
						var formattedDepartureDate = new Intl.DateTimeFormat('en-US', {
							month: '2-digit',
							day: '2-digit',
							year: 'numeric',
						}).format(new Date(departureDate));

						$('#starting_time').val(convertTo12HourFormat(departureTime));
						$('#starting_date').val(formattedDepartureDate);
						// Arrival


                        $('#arrival_airport_id option').each(function() {
                            if ($(this).text().trim() === latestUpdate.arrival.airport.name.trim()) {
                                $(this).remove();
                            }
                        });
                        $('#arrival_airport_id').append(`
                            <option departure_airport_name="${latestUpdate.arrival.airport.name}" departure_airport_code="${latestUpdate.arrival.airport.iata}" selected>
                                ${latestUpdate.arrival.airport.name}
                            </option>
                        `);

                        $("#arrival_airport_code").val(latestUpdate.arrival.airport.iata);
                        $("#arrival_airport_name").val(latestUpdate.arrival.airport.name);
						$('#arrival_terminal').val(latestUpdate.arrival.terminal);
						var arrivalDateTime = latestUpdate.arrival.scheduledTime.local;
						var ending_date = arrivalDateTime.substr(0, 10);
						var ending_time = arrivalDateTime.substr(11, 5);
						var formattedArrivalDate = new Intl.DateTimeFormat('en-US', {
							month: '2-digit',
							day: '2-digit',
							year: 'numeric',
						}).format(new Date(ending_date));
						$('#ending_time').val(convertTo12HourFormat(ending_time));
						$('#ending_date').val(formattedArrivalDate);

						// Flight Information
						$('#aircraft').val(latestUpdate.aircraft.model);
				
					}
				},
				complete: function () {
					$('.loader').fadeOut(200);
				},
				error: function (xhr, status, error) {
					$('.loader').fadeOut(200);
					showErrorMessage(error);
				},
			});
		}
	});

    $(document).on('click','#layoverSearchFlightApi', function () {
		if ($('#layover_flight_number').val().trim() == '') {
             alertError('Flight number is required');
		} else if ($('#layover_starting_date').val().trim() == '') {
            alertError('Departure date is required');

		} else {
			var flightNumber = $('#layover_flight_number').val();
			var departureDate = $('#layover_starting_date').val();
			var dateParts = departureDate.split('/');
			var day = dateParts[1].padStart(2, '0');
			var month = dateParts[0].padStart(2, '0');
			var year = dateParts[2];
			var formatedDepartureDate = year + '-' + month + '-' + day;
			$.ajax({
				async: true,
				crossDomain: true,
				url:
					'https://aerodatabox.p.rapidapi.com/flights/number/' +
					flightNumber +
					'/' +
					formatedDepartureDate +
					'?withAircraftImage=false&withLocation=false',
				method: 'GET',
				headers: {
					'X-RapidAPI-Key':
						'b39b48308dmsha859ddc4820a56dp1c9265jsn81954e6ce80f',
					'X-RapidAPI-Host': 'aerodatabox.p.rapidapi.com',
				},
				beforeSend: function () {
                    $('.loader').removeClass('displayNone');
				},
				success: function (response) {
					// Departure Section
					if (!response) {
						alertError('Flight not found');
					} else {
						var latestUpdate = response[response.length - 1];

                  
                        $('#layover_airline_id option').each(function() {
                            if ($(this).text().trim() === latestUpdate.airline.name.trim()) {
                                $(this).remove();
                            }
                        });
                        $('#layover_airline_id').append(`
                            <option selected>
                                ${latestUpdate.airline.name}
                            </option>
                        `);

                        $("#layover_airline_name").val(latestUpdate.airline.name);


                        $('#layover_departure_airport_id option').each(function() {
                            if ($(this).text().trim() === latestUpdate.departure.airport.name.trim()) {
                                $(this).remove();
                            }
                        });

                        $('#layover_departure_airport_id').append(`
                            <option departure_airport_name="${latestUpdate.departure.airport.name}" departure_airport_code="${latestUpdate.departure.airport.iata}" selected>
                                ${latestUpdate.departure.airport.name}
                            </option>
                        `);

                        $("#layover_departure_airport_code").val(latestUpdate.departure.airport.iata);
                        $("#layover_departure_airport_name").val(latestUpdate.departure.airport.name);
						$('#layover_departure_terminal').val(latestUpdate.departure.terminal);
						var departureDateTime = latestUpdate.departure.scheduledTime.local;
						var departureDate = departureDateTime.substr(0, 10);
						var departureTime = departureDateTime.substr(11, 5);
						var formattedDepartureDate = new Intl.DateTimeFormat('en-US', {
							month: '2-digit',
							day: '2-digit',
							year: 'numeric',
						}).format(new Date(departureDate));

						$('#layover_starting_time').val(convertTo12HourFormat(departureTime));
						$('#layover_starting_date').val(formattedDepartureDate);
						// Arrival
        

                        $('#layover_arrival_airport_id option').each(function() {
                            if ($(this).text().trim() === latestUpdate.arrival.airport.name.trim()) {
                                $(this).remove();
                            }
                        });

                        $('#layover_arrival_airport_id').append(`
                            <option departure_airport_name="${latestUpdate.arrival.airport.name}" departure_airport_code="${latestUpdate.arrival.airport.iata}" selected>
                                ${latestUpdate.arrival.airport.name}
                            </option>
                        `);

                        $("#layover_arrival_airport_code").val(latestUpdate.arrival.airport.iata);
                        $("#layover_arrival_airport_name").val(latestUpdate.arrival.airport.name);
						$('#layover_arrival_terminal').val(latestUpdate.arrival.terminal);
						var arrivalDateTime = latestUpdate.arrival.scheduledTime.local;
						var ending_date = arrivalDateTime.substr(0, 10);
						var ending_time = arrivalDateTime.substr(11, 5);
						var formattedArrivalDate = new Intl.DateTimeFormat('en-US', {
							month: '2-digit',
							day: '2-digit',
							year: 'numeric',
						}).format(new Date(ending_date));
						$('#layover_ending_time').val(convertTo12HourFormat(ending_time));
						$('#layover_ending_date').val(formattedArrivalDate);

						// Flight Information
						$('#layover_aircraft').val(latestUpdate.aircraft.model);
				
					}
				},
				complete: function () {
					$('.loader').fadeOut(200);
				},
				error: function (xhr, status, error) {
					$('.loader').fadeOut(200);
					showErrorMessage(error);
				},
			});
		}
	});

    $(document).click(function(event) {    
        if ((!$(event.target).closest('#filter_wraper').length && $('#tripFilter_section').hasClass('show')) &&
        !$(event.target).closest('#filterTrips_ByTravelers').length &&
        !$(event.target).closest('#filterTrips_ByTenants').length &&
        !$(event.target).is('option')&&
        !$(event.target).hasClass('select2-results__option')&&
        !$(event.target).closest('.select2-container').length &&
        !$(event.target).closest('.select2-selection__choice').length
        ) {
        $('#tripFilter_section').collapse('hide');
    }      
    });

    $(document).on('click',"#filter_wraper",function(){
        if(!$('#tripFilter_section').hasClass('show')){
            $('#tripFilter_section').collapse('show');
        }
    });

    $(document).on('select2:open', () => {
      setTimeout(function(){ // wait a bit, to make sure all other select2s dropdowns are closed
            document.querySelector('.select2-container--open .select2-search__field').focus();
        }, 100);
    });

    $(document).on('click',".sidebar-icon-div",function(){
        $('#sidebar').toggleClass('sidebar-hidden');
        $('body').toggleClass('toggle-sidebar');

        if ($('#sidebar').hasClass('sidebar-hidden')) {
            $('.sidebar-icon').removeClass('fa-arrow-left').addClass('fa-arrow-right');
        } else {
            $('.sidebar-icon').removeClass('fa-arrow-right').addClass('fa-arrow-left');
        }

    });


    $(document).on('click','#add_user_to_tenant_modal_user_email_search',function(){
        var email = $("#add_user_to_tenant_modal_user_email").val();

        if(!isValidEmail(email)){
            alertError("Please enter a valid email.");
        }else{
        
            $.ajax({
                type: 'POST',
                url: baseURL + 'tenants/searchUsersForCompany',
                data: {
                    username: email,
                    company_id: $("#add_user_to_tenant_modal_tenant_id").val(),
                 
                },
                beforeSend:function(){
                    $('.loader').removeClass('displayNone');
                },
                success: function (response) {
                    if(response.status){
                        if(response.data.length==0){
                            $("#add_user_to_tenant_modal_user_div").html(`
                            `);
                            alertError("No user found");
                        }else{
                            var user=response.data[0];
                            $("#add_user_to_tenant_modal_user_id").val(user['id']);
                            $("#add_user_to_tenant_modal_user_div").html(`
                                <p class="d-flex align-items-center m-0">
                                    <i class="fa-solid fa-plus-circle text-primary pointer" id="add_user_to_tenant_modal_addUserIcon" title="Add this user" style="margin-right:5px;font-size: 17px;"></i>
                                    ${user['fname']} ${user['lname']}
                                </p>
                            `);
                        }   
                    }
                    // if(response['status']){
                    //     location.reload();
                    // }
            
                },
                complete: function(){
                    $('.loader').fadeOut(200);
                },
                error: function (xhr, status, error) {
                    alertError('Connection Error');
                }
            });
        }
        //query email
    });

    $(document).on('click',"#add_user_to_tenant_modal_addUserIcon",function(){
        var user_id = $("#add_user_to_tenant_modal_user_id").val();
        var company_id = $("#add_user_to_tenant_modal_tenant_id").val();

        $.ajax({
            type: 'POST',
            url: baseURL + 'tenants/addUserToCompany',
            data: {
                user_id: user_id,
                company_id: company_id,
             
            },
            beforeSend:function(){
                $('.loader').removeClass('displayNone');
            },
            success: function (response) {
                if(response['status']){
                    location.reload();
                }
            },
            complete: function(){
                // $('.loader').fadeOut(200);
            },
            error: function (xhr, status, error) {
                alertError('Connection Error');
            }
        });
        
    });

    $(document).on('click',".formCancelBtn",function(){
       
        window.history.back();
        
    });


    $('#starting_date').flatpickr({
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#ending_date').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#ending_date').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#ending_date').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    // Initialize the ending date picker
    $('#ending_date').flatpickr({
        dateFormat: 'm/d/Y',
        minDate: $('#starting_date').val() || 'today'
    });


    //lodging
    $('#lodgingStartingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#lodgingEndingDate_input').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#lodgingEndingDate_input').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#lodgingEndingDate_input').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    $('#lodgingEndingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        minDate: $('#lodgingStartingDate_input').val() || 'today'
    });

     //layover
     $('#layover_starting_date').flatpickr({
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#layover_ending_date').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#layover_ending_date').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#layover_ending_date').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    $('#layover_ending_date').flatpickr({
        dateFormat: 'm/d/Y',
        minDate: $('#layover_starting_date').val() || 'today'
    });

    //car renting
    $('#carRentingStartingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#carRentingEndingDate_input').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#carRentingEndingDate_input').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#carRentingEndingDate_input').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    $('#carRentingEndingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        minDate: $('#carRentingStartingDate_input').val() || 'today'
    });

    //activity
    $('#activityStartingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#activityEndingDate_input').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#activityEndingDate_input').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#activityEndingDate_input').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    $('#activityEndingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        minDate: $('#activityStartingDate_input').val() || 'today'
    });

      //transportation
      $('#transportationStartingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        onChange: function (selectedDates) {
                var selectedDate = selectedDates[0];
                var selectedEndingDate = $('#transportationEndingDate_input').val();
                if ((new Date(selectedEndingDate) > selectedDate)) {
                    $('#transportationEndingDate_input').flatpickr({
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y',
                        defaultDate: selectedEndingDate
                    });
                } else {
                    $('#transportationEndingDate_input').flatpickr({
                        defaultDate: selectedDate,
                        minDate: selectedDate,
                        dateFormat: 'm/d/Y'
                    });
                }
            }
    });

    $('#transportationEndingDate_input').flatpickr({
        dateFormat: 'm/d/Y',
        minDate: $('#transportationStartingDate_input').val() || 'today'
    });


    $(".logocontainer").html(`
        <a href="${baseURL}"><img src="${baseURL}/public/assets/images/logo.png" class="logo "/></a>
    `);

    intializeSelect2Multiple();
    intializeSelect2Single();
    initializePhoneInput();
    intializePasswordToggle();
    

    /**
     END DOCUMENT READY
     */






});

function convertTo12HourFormat(time24h) {
	if (time24h === "" || time24h === "Unknown") {
		return "Unknown";
	} else {
		var formattedTime = moment(time24h, 'HH:mm').format('h:mm A');
		return formattedTime;
	}
}

function isValidEmail(email) {
    // Regular expression to validate email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
