@if (session('status'))
@php
    $texto = session('status');
@endphp
<script>
    Swal.fire({
       title: '{{$texto}}',
       icon: "success",
       showConfirmButton: false,
       timer: 1500
     });
</script>
@endif