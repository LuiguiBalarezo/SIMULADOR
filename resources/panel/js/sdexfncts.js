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


    $('#RegisterForm').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            txtNombre: {
                validators: {
                    notEmpty: {
                        message: 'The full name is required and cannot be empty'
                    }
                }
            },
            txtCorreo: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The email address is not valid'
                    }
                }
            }
        }
    });



});