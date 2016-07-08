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
                            message: 'Porfavor ingrese su Nombre'
                        }
                    }
                },
                txtApellidoP: {
                    validators: {
                        stringLength: {
                            min: 2,
                        },
                        notEmpty: {
                            message: 'Porfavor ingrese su apellido paterno'
                        }
                    }
                },
                txtApellidoM: {
                    validators: {
                        stringLength: {
                            min: 2,
                        },
                        notEmpty: {
                            message: 'Porfavor ingrese su apellido materno'
                        }
                    }
                },
                cbDepartamento: {
                    validators: {
                        notEmpty: {
                            message: 'Porfavor seleccione su departamento'
                        }
                    }
                },
                cbProvincia: {
                    validators: {
                        notEmpty: {
                            message: 'Porfavor seleccione su provincia'
                        }
                    }
                },
                cbDistrito: {
                    validators: {
                        notEmpty: {
                            message: 'Porfavor seleccione su distrito'
                        }
                    }
                },
                txtDireccion: {
                    validators: {
                        stringLength: {
                            min: 15,
                        },
                        notEmpty: {
                            message: 'Porfavor ingrese su direccion'
                        }
                    }
                },
                txtDni: {
                    validators: {
                        notEmpty: {
                            message: 'Porfavor ingrese su numero de Dni'
                        },
                        integer: {
                            message: 'El valor ingresado no es un entero'
                        },
                        stringLength: {
                            min: 8,
                        },
                    }
                },
                txtTelefono: {
                    validators: {
                        notEmpty: {
                            message: 'Porfavor ingrese su numero de telefono'
                        },
                        phone: {
                            country: 'PE',
                            message: 'Porfavor ingrese un telefono valido con un codigo de area'
                        }
                    }
                },
                txtCorreo: {
                    validators: {
                        notEmpty: {
                            message: 'Porfavor ingrese su direccion de correo electronico'
                        },
                        emailAddress: {
                            message: 'Porfavor ingrese una direccion de correo electronico valida'
                        }
                    }
                },


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