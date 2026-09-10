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
<script src="{{asset('backend/js/index.js')}}"></script>
<!-- sweetalet js -->
<script src="{{asset('backend/js/sweetalert.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
{{-- Custom --}}
<script src="{{ asset('plugins/validation-setup/validation-setup.js') }}"></script>
<script src="{{ asset('plugins/custom/notification.js') }}"></script>
<script src="{{ asset('plugins/custom/form.js') }}"></script>
<!-- notification js -->
<script src="{{asset('backend/assets/notifications/js/lobibox.min.js')}}"></script>
<script src="{{asset('backend/assets/notifications/js/notifications.min.js')}}"></script>
<!-- Form Validation Script -->
<script src="{{asset('backend/js/additional-methods.min.js')}}"></script>
<!-- Selec2 -->
<script src="{{asset('backend/js/select2.min.js')}}"></script>
<script src="{{asset('backend/js/summernote-lite.min.js')}}"></script>

@stack('js')

<script>
    "use strict";

    @if (Session::has('message'))
    var type = "{{Session::get('alert-type','success')}}"
    var message = "{{Session::get('message')}}";
    notification(type, message);
    @endif

    function notification(type, message) {
        let image;
        if (type == "success")
            image = 'fa fa-check-circle';
        else if (type == "error")
            image = 'fa fa-times-circle';
        else
            image = 'fa fa-info-circle';
        Lobibox.notify(type, {
            pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
            icon: image,
            sound: false,
            position: 'top right',
            showClass: 'zoomIn',
            hideClass: 'zoomOut',
            size: 'mini',
            rounded: true,
            width: 250,
            height: 'auto',
            delay: 2000,
            msg: message,

        });
    }

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
            }else{

            }
        });
    }

</script>
