<!doctype html>
<html lang="en">

<head>
    @include('layouts.header')
</head>

<body>

    <!-- /END HEADER -->
    @include('layouts.navigation')
    <!-- /END HEADER -->

    @yield('content')


	@include('layouts.footer')

</body>

</html>