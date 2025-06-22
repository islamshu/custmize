<script src="{{ asset('backend/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/charts/jquery.sparkline.min.js') }}">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/data/jvector/visitor-data.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{ asset('backend/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}">
</script>
<script src="{{ asset('backend/app-assets/js/scripts/pages/dashboard-sales.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('backend/app-assets/vendors/js/forms/select/selectivity-full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/select/form-selectivity.js') }}" type="text/javascript"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"
    type="text/javascript"></script>
@if (app()->getLocale() == 'en')
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advanced.js') }}"
        type="text/javascript"></script>
@else
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advancedar.js') }}"
        type="text/javascript"></script>
@endif
<script src="{{ asset('backend/app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/custom-js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/jquery.steps.min.js') }}" type="text/javascript">
</script>

<!-- END PAGE VENDOR JS-->
<script src="{{ asset('backend/app-assets/js/scripts/forms/wizard-steps.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/editors/ckeditor/ckeditor.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/js/scripts/editors/editor-ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/tags/tagging.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/tags/tagging.js') }}" type="text/javascript"></script>




<script>
    $(".image").change(function() {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
    $(".imagee").change(function() {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-previeww').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
    $('.delete-confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `هل متأكد من حذف العنصر ؟`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>

<script>
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        let switchery = new Switchery(html, {
            size: 'small'
        });
    });
</script>

@yield('script')
<!-- END PAGE LEVEL JS-->
</body>

</html>
