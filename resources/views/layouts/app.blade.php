<!doctype html>
<html lang="en">
@include('layouts.chank.header')
@include('layouts.chank.navbar')

<body style="background: url('/img/page-bg-1.jpg')">

<div class="container">
    @yield('content')
</div>

@include('layouts.chank.footer')
<script type="text/javascript" src="{{URL::asset('js/image-load.js')}}"></script>
</body>
</html>