/**
 * Created by ucweb03 on 08/07/2016.
 */
$(document).ready(function(){
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }
    //function getAbsolutePath() {
    //    var l = window.location;
    //    var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
    //    return base_url+"/";
    //}
    var base_url = getAbsolutePath();

    $("#btnSignIn").on("click", function(evt){
        evt.preventDefault();
        //$(location).attr("href", "<?php echo base_url().'admin'; ?>");
        if ( $("#txtEmail").val().length > 0 && $("#txtPassword").val().length > 0 ) {
            $.LoadingOverlay("show");
            var request = $.ajax({
                url: base_url+'signIn',
                type: "post",
                data: $("#Form").serialize(),
                dataType: 'json'
            });

            request.done(function( response ) {
                $.LoadingOverlay("hide");
                if (response.status) {
                    $(location).attr("href", response.data.url_redirect);
                } else {
                    swal("Error", response.message, "error");

                }
            });

            request.fail(function( jqXHR, textStatus ) {
                $.LoadingOverlay("hide");
                swal("Error", textStatus, "error");

            });
        } else {

            swal("Error", "Ingrese sus datos de usuario correctamente.", "error");

        }
    });


    $("#btnRegister").on("click", function(evt){
        evt.preventDefault();

        $.LoadingOverlay("show");
        var request = $.ajax({
            url: base_url+'registerIn',
            type: "post",
            data: $("#RegisterForm").serialize(),
            dataType: 'json'
        });

        request.done(function( response ) {
            $.LoadingOverlay("hide");
            if (response.status) {
                $(location).attr("href", response.data.url_redirect);
            } else {
                swal("Error", response.message, "error");
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            $.LoadingOverlay("hide");
            swal("Error", textStatus, "error");

        });

    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });


    $('#contact_form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                txtNombre: {
                    validators: {
                        stringLength: {
                            min: 2,
                        },
                        notEmpty: {
                            message: 'Please supply your first name'
                        }
                    }
                },
                last_name: {
                    validators: {
                        stringLength: {
                            min: 2,
                        },
                        notEmpty: {
                            message: 'Please supply your last name'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your email address'
                        },
                        emailAddress: {
                            message: 'Please supply a valid email address'
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your phone number'
                        },
                        phone: {
                            country: 'US',
                            message: 'Please supply a vaild phone number with area code'
                        }
                    }
                },
                address: {
                    validators: {
                        stringLength: {
                            min: 8,
                        },
                        notEmpty: {
                            message: 'Please supply your street address'
                        }
                    }
                },
                city: {
                    validators: {
                        stringLength: {
                            min: 4,
                        },
                        notEmpty: {
                            message: 'Please supply your city'
                        }
                    }
                },
                state: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your state'
                        }
                    }
                },
                zip: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your zip code'
                        },
                        zipCode: {
                            country: 'US',
                            message: 'Please supply a vaild zip code'
                        }
                    }
                },
                comment: {
                    validators: {
                        stringLength: {
                            min: 10,
                            max: 200,
                            message:'Please enter at least 10 characters and no more than 200'
                        },
                        notEmpty: {
                            message: 'Please supply a description of your project'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
            $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });



});