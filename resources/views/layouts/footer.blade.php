<footer>

    <div class="container">
        
        <!-- SOCIAL ICONS -->
        <ul class="social-icons">
            <li><a href=""><i class="social_facebook_square"></i></a></li>
            <li><a href=""><i class="social_twitter_square"></i></a></li>
            <li><a href=""><i class="social_instagram_square"></i></a></li>
            {{-- <li><a href=""><i class="social_dribbble_square"></i></a></li>
            <li><a href=""><i class="social_flickr_square"></i></a></li> --}}
        </ul>
        
        <!-- COPYRIGHT TEXT -->
        <p class="copyright">
            ©{{ date('Y') }} {{ config('app.name') }}, All Rights Reserved
        </p>

    </div>
    <!-- /END CONTAINER -->
 
</footer>
<!-- /END FOOTER -->


<!-- =========================
     SCRIPTS 
============================== -->
{{-- Notice modal --}}
@php
    $notification = \App\Models\Notification::first();
@endphp
@if(isset($notification) && $notification->status == 1)
        <script>
	$(document).ready(function(){
		$("#notice").modal('show');
	});
    </script>
    <div id="notice" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <strong>{{ $notification->title }}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!! $notification->content !!}
                </div>
            </div>
        </div>
    </div>
@endif

{{-- end notice modal --}}
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/smoothscroll.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/jquery.localScroll.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/nivo-lightbox.min.js') }}"></script>
<script src="{{ asset('js/simple-expand.min.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('js/retina.min.js') }}"></script>
<script src="{{ asset('js/jquery.nav.js') }}"></script>
<script src="{{ asset('js/matchMedia.js') }}"></script>
<script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('js/jquery.fitvids.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
