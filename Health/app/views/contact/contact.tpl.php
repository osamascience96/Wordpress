<?php echo $header; ?>
<!-- Start Contact Detail Section -->
<div class="layer-stretch animated-wrapper">
    <div class="layer-wrapper pb-2">
        <div class="row text-center">
            <?php if (!empty($page['page_data']['contact']['block'])) foreach ($page['page_data']['contact']['block'] as $key => $value) { { ?>
                <div class="col-md-3 contact-info-block animated animated-up">
                    <div class="contact-info-inner">
                        <i class="<?php echo $value['icon']; ?>"></i>
                        <span><?php echo $value['title']; ?></span>
                        <p class="paragraph-medium paragraph-black"><?php echo $value['data1']; ?></p>
                        <p class="paragraph-medium paragraph-black mb-0"><?php if (!empty($value['data2'])) { echo $value['data2']; } ?> </p>
                    </div>
                </div>
            <?php } } ?>
        </div>
    </div>
</div><!-- End Contact Detail Section -->
<!-- Start Request Section -->
<div id="contact-form" class="layer-stretch">
    <div class="layer-wrapper">
        <div class="layer-ttl">
            <h3><?php echo $lang['text_make_a_request']; ?></h3>
        </div>
        <div class="layer-container">
            <form class="contact-form row" action="<?php echo URL.DIR_ROUTE; ?>contact" method="post">
                <input type="hidden" name="_token" value="<?php echo $token ?>">
                <div class="col-md-4">
                    <div class="input-box">
                        <input id="contact-name" class="" type="text" name="name" pattern="[A-Z,a-z, ]*" value="">
                        <label for="contact-name"><?php echo $lang['text_name']; ?></label>
                    </div>
                    <div class="input-box">
                        <input type="text" class="" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="contact-email">
                        <label class="mdl-textfield__label" for="contact-email"><?php echo $lang['text_email_address']; ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <input type="text" class="" name="mobile" pattern="[0-9]*" id="contact-mobile">
                        <label class="" for="contact-mobile"><?php echo $lang['text_mobile_number']; ?></label>
                    </div>
                    <div class="input-box">
                        <input class="" type="text" name="subject" id="contact-subject">
                        <label class="" for="contact-subject"><?php echo $lang['text_subject']; ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <textarea class="" type="text" name="message" id="contact-message"></textarea>
                        <label class="" for="contact-message"><?php echo $lang['text_message']; ?></label>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button id="contact-submit" class="btn btn-primary btn-outline btn-outline-2x" name="make-request"><?php echo $lang['text_submit']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div><!-- End Request Section -->
<?php if (isset($page['page_data']['googlemap']['status']) && $page['page_data']['googlemap']['status'] == '1') { ?>
    <!-- Start Google Map Section -->
    <div id="map" class="animated-wrapper">
        <div class="map-wrapper">
            <div id="map-container"></div>
        </div>
        <div class="map-address animated animated-up">
            <div class="map-icon">
                <i class="fa fa-map-marker"></i>
            </div>
            <div class="map-address-ttl"><?php echo $lang['text_our_location']; ?></div>
            <div class="paragraph-medium paragraph-black"><?php echo $page['page_data']['contact']['block'][3]['data1']; ?></div>
        </div>
    </div><!-- End Google Map Section -->
    <!-- Map Block Script -->
    <script>
        var map;

        function initMap() {
            var loc = {
             lat: <?php echo $page['page_data']['contact']['latitude'];; ?>,
             lng: <?php echo $page['page_data']['contact']['longitude'];; ?>
         };
         var isDraggable = !('ontouchstart' in document.documentElement);

         map = new google.maps.Map(document.getElementById('map-container'), {
            center: loc,
                zoom: 14, // Map Zoom
                draggable: isDraggable,
                scrollwheel: false
            });

         var marker = new google.maps.Marker({
            position: loc,
            map: map
        });
     }
 </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo$page['page_data']['contact']['googleapikey']; ?>&amp;callback=initMap" async defer></script>
 <?php } echo $footer; ?>