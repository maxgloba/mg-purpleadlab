<style>
    .taboola-container {
        padding: 20px;
        padding-left: 0;
        width: 400px;
        font-size: 14px;
    }
    table {
        width: 380px;
        margin-left: 20px;
    }
    table td img {
        position: relative;
        top: 3px;
        margin-left: 5px;
    }
        /*    table {
                padding: 12px;
                border: 3px solid #467FD7;
                border-radius: 5px;
                margin-top: 10px;
                width: 100%;
            }*/
    table tr td:first-child {
        width: 110px;
    }
    table input {
        width: 100%;
    }
    input[type='text'] {
        border-radius: 3px;
    }
    hr {
        margin-top: 15px;
        margin-bottom: 15px;
        border-bottom: none;
    }
    input[type='checkbox'] {

    }
    input[type='submit']{
        float: right;
    }
    .checkbox {
        margin-bottom: 10px;
    }
    .request_link {
        float: right;
        margin-right: 10px;
        line-height: 26px;
    }
    table .tooltip {
        /*        position:relative;
                top:50px;
                left:50px;*/
    }
    .tooltip div { /* hide and position tooltip */
        background-color: black;
        color: white;
        border-radius: 5px;
        opacity: 0;
        position: absolute;
        -webkit-transition: opacity 0.5s;
        -moz-transition: opacity 0.5s;
        -ms-transition: opacity 0.5s;
        -o-transition: opacity 0.5s;
        transition: opacity 0.5s;
        width: 200px;
        padding: 10px;
        margin-left: 30px;
        margin-top: -45px;
    }
    table .tooltip:hover div { /* display tooltip on hover */
        opacity:1;
    }
    .label-success {
        font-size: 17px;
        display: block;
        margin-top: 10px;
        color: green;
    }
    .label-error {
        font-size: 17px;
        display: block;
        margin-top: 10px;
        color: red;
    }

    .toggle_icon{
        background: url(<?php echo $this->plugin_url.'img/arrow_right_32.png' ?>) no-repeat;
        background-size:contain;
        width:24px;
        height:24px;
        display:inline-block;
        vertical-align: middle;
    }

    .toggle_icon_on{
        -ms-transform: rotate(90deg); /* IE 9 */
        -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
        transform: rotate(90deg);
    }
    .apply_button{
        margin-top: 20px !important;
    }

</style>

<div class="taboola-container">
    <img src='<?php echo $this->plugin_url.'img/taboola.png' ?>' style='width:200px;'/>
    <hr>

    <form method="POST">
        <table>
            <tr>
                <td>Publisher ID</td>
                <td>
                    <input type="text" name="publisher_id" placeholder="publisher" value="<?php echo htmlspecialchars($settings->publisher_id) ?>"/>
                </td>
                <td class='tooltip'>
                    <img src='<?php echo $this->plugin_url.'img/question-mark.png' ?>'/>
                    <div>Please contact your Taboola representative to receive the Publisher ID </div>
                </td>
            </tr>
            <tr>
                <td colspan='2' style='line-height: 26px; font-size: 13px;'>
                    Don't have a Publisher ID?
                    <a style='float: inherit; margin-left:5px; class='request_link' href=' http://taboola.com/contact' target='_blank'>Contact Taboola here</a>
                </td>
            </tr>
        </table>

        <hr style='margin-bottom: 25px; margin-top: 5px;'>

        <div class='checkbox'>
            <input id="first_bc_enabled" type="checkbox" <?php echo $settings->first_bc_enabled ? "checked='checked'" : "" ?> name="first_bc_enabled"/>
            Below Article
        </div>
        <table>
            <tr>
                <td>Widget ID</td>
                <td>
                    <input type="text" value="<?php echo $settings->first_bc_widget_id ?>" name="first_bc_widget_id" placeholder="Widget ID" />
                </td>
                <td class='tooltip'>
                    <img src='<?php echo $this->plugin_url.'img/question-mark.png' ?>'/>
                    <div>Please contact your Taboola representative to receive the Widget ID</div>
                </td>
            </tr>

        </table>
        <hr>

        <div class='checkbox'>
            <input id="second_bc_enabled" type="checkbox" <?php echo $settings->second_bc_enabled ? "checked='checked'" : "" ?> name="second_bc_enabled"/>
            Below Article 2nd
        </div>

        <table>
            <tr>
                <td>Widget ID</td>
                <td>
                    <input type="text" value="<?php echo htmlspecialchars($settings->second_bc_widget_id) ?>" name="second_bc_widget_id" placeholder="Widget ID" />
                </td>
                <td class='tooltip'>
                    <img src='<?php echo $this->plugin_url.'img/question-mark.png' ?>'/>
                    <div>Please contact your Taboola representative to receive the Widget ID</div>
                </td>
            </tr>

        </table>
        <hr style='border-bottom: 1px solid #fafafa;'>

        <?php $location_defined = (htmlspecialchars($settings->location_string) != ""); ?>


        <div class='toggle_intercept checkbox'>
            <?php if ($location_defined): ?>
                <div class='toggle_icon toggle_icon_on'></div>
                 Advanced Settings
                </div>
                <table class='location_section'>

            <?php else: ?>
                <div class='toggle_icon'></div>
                 Advanced Settings
                </div>
                <table class='location_section' style='display:none'>

            <?php endif; ?>

                   
            <tr>
                <td>Location</td>
                <td>
                    <input type="text" value="<?php echo htmlspecialchars($settings->location_string) ?>" name="location_string" placeholder="" />
                </td>
                <td class='tooltip'>
                    <img src='<?php echo $this->plugin_url.'img/question-mark.png' ?>'/>
                    <div>This field controls the location of these widgets on the page. If you would like to move your widget from its default location directly below the article a Taboola representative will provide you with the necessary information.</div>
                </td>
            </tr>
            <tr>
                <td colspan="2"> <div class='checkbox'>
                        <input id="out_of_content_enabled" type="checkbox" <?php echo $settings->out_of_content_enabled ? "checked='checked'" : "" ?> name="out_of_content_enabled"/>
                        Place widget after main content DOM element
                    </div></td>
                <td class='tooltip'>
                    <img src='<?php echo $this->plugin_url.'img/question-mark.png' ?>'/>
                    <div>This may be disabled if your website doesn't use Taboola's "Read more" feature, or if the widget is not placed correctly. DO NOT disable it if your widget includes "Read More"</div>
                </td>

            </tr>


        </table>
        <input class='button-secondary apply_button' type="submit" value="Apply Changes ✔"/>
        <!--         <a class='request_link' href=' http://taboola.com/contact' target='_blank'>Request Widget</a> -->
    </form>
    <div style='clear:both'></div>

    <?php
        $logPublisher = ($settings->publisher_id == "") ? "wordpressplugin" : $settings->publisher_id;
        $userDetails = wp_get_current_user();
        $detailsString = $userDetails->first_name." ".$userDetails->last_name;
    ?>
    <img src="https://logs-01.loggly.com/inputs/d14862f3-64ad-49ca-b28d-1b5d155414ec.gif?source=wp&type=settings&pub=<?=$logPublisher?>&user=<?=urlencode($detailsString)?>&email=<?=urlencode($userDetails->user_email)?>&url=<?=urlencode("//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}")?>"/>
    <!-- <form name="install_log" style="display:none;" method="post" action="http://logs-01.loggly.com/inputs/d14862f3-64ad-49ca-b28d-1b5d155414ec/tag/http/">
        <input name="tim" type="hidden" value="<?=date("H:i:s.000")?>">
        <input name="pub" type="hidden" value="<?=$logPublisher?>">
        <input name="data" type="hideen" value="WORDPRESS_PLUGIN_INSTALL|<?="//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}|{$detailsString}"?>">
    </form> -->

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && count($taboola_errors) == 0){
        echo "<span class='label-success'>Your changes have been made! You can now see them on your site</span>";
    }

    if(count($taboola_errors) > 0){
        for($i = 0; $i < count($taboola_errors); $i++){
            echo "<span class='label-error'>".$taboola_errors[$i]."</span>";
        }
    }
    ?>
</div>
<script>
    function sync_checkboxes(){
        if(jQuery('#first_bc_enabled').attr("checked")){
            jQuery('#second_bc_enabled').attr('disabled',false)
        } else {
            jQuery('#second_bc_enabled').attr('checked', false);
            jQuery('#second_bc_enabled').attr('disabled',true)
        }
    }
    jQuery('#first_bc_enabled').change(sync_checkboxes);
    setTimeout(function(){jQuery('.label-success').fadeOut()}, 6000);
    setTimeout(function(){jQuery('.label-error').fadeOut()}, 6000);
    sync_checkboxes()

    jQuery('.toggle_intercept').click(function(){
        if (jQuery('.location_section').fadeToggle != undefined){
            jQuery('.location_section').fadeToggle('fast');
        }else{
            jQuery('.location_section').toggle();
        }
        jQuery('.toggle_icon').toggleClass('toggle_icon_on');
    });

    window.onload = function(){
        document.forms['install_log'].submit()

    }
</script>