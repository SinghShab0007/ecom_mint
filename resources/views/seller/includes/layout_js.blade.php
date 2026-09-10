<!-- jQuery -->
<script src="{{asset('backend/js/vendor/jquery-3.6.0.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('backend/js/vendor/bootstrap.min.js')}}"></script>
<!-- Waypoints -->
<script src="{{asset('backend/js/vendor/waypoints.min.js')}}"></script>
<!-- Counter Up -->
<script src="{{asset('backend/js/vendor/counterup.min.js')}}"></script>
<!-- Wow -->
<script src="{{asset('backend/js/vendor/countdown.js')}}"></script>
<!-- Index -->
<script src="{{asset('seller/js/index.js')}}"></script>

<!-- sweetalet js -->
<script src="{{asset('backend/js/sweetalert.min.js')}}"></script>
<!-- notification js -->
<script src="{{asset('backend/assets/notifications/js/lobibox.min.js')}}"></script>
<script src="{{asset('backend/assets/notifications/js/notifications.min.js')}}"></script>
<!-- Form Validation Script -->
<script src="{{ asset('backend/assets/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/validation-setup/validation-setup.js') }}"></script>
<script src="{{ asset('plugins/custom/notification.js') }}"></script>
<script src="{{ asset('backend/js/additional-methods.min.js') }}"></script>
<!-- Selec2 -->
<script src="{{asset('backend/js/select2.min.js')}}"></script>
<script src="{{asset('backend/js/summernote-lite.min.js')}}"></script>
<script src="{{ asset('plugins/custom/form.js') }}"></script>

@stack('js')
<script>
   " use strict";
    var seller = "{{ auth('seller')->user()->is_approve ?? 0 }}";
    $('.side-bar-manu,.seller-pan').on("click", function (e) {

        if( seller==0){
            e.preventDefault();
            //alert('Sorry! Your Account is pending..')
            swal({

                position: 'top-end',
                icon: 'error',
                title: 'Sorry! Your Account is pending..',
                showConfirmButton: false,
                //timer: 1500
            });
        }

        //toastr.warning('Sorry! This is demo version.');
        /*if ('.edit-item'){
            $(this).attr('data-target','');
        }*/
    });

</script>

<script>
    "use strict";

    @if (Session::has('success'))
    var type = "{{Session::get('alert-type','success')}}"
    var message = "{{Session::get('success')}}";
    notification(type, message);
    @endif

    /* ensure delete action */
    function deleteWithSweetAlert(event, form) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            } else {

            }
        });
    }

</script>
