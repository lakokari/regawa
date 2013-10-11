<style>
    .radio_data_reg_list_scrol {
        overflow-x: hidden;
        overflow-y: scroll;
        width : 200px;
        height: 300px;
    }
    .frame_view_rq {display : none;}
    #view_radio_req {display : none;}
</style>

<div style="font-size: 18px; width: auto; height: auto; padding: 5px;">
    <a href="javascript:send_radio_req();" style="font-weight : bold;" id="send_rq_menu">Send Request</a> | 
    <a href="javascript:view_radio_req();" style="" id="view_rq_menu">View Request</a>
</div>

<div class="rod_list_scrol">



    <div class="box-container" id="send_radio_req">
        <table width="100%">
            <tr>
                <th><h2 style="text-align: center;">Send Request</h2></th>
            </tr>
            <tr><td><h3>Select Radio List</h3></td></tr>
            <tr>
                <td>
                    <select id="radio">
                        <?php foreach ($list_radio_data_request as $lrr) { ?>
                            <option value="<?php echo $lrr->id; ?>"><?php echo $lrr->radio_name; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr><td>Request Message</td></tr>
            <tr>
                <td>
                    <form id="userForm">
                        <textarea name="request" id="request" style="width : 480px; height: 120px;"></textarea>
                        <div id="button_submit_req"><input type="submit" value="Submit" onclick="return sendMessage(this);"/></div>
                    </form>
                </td>
            </tr>

        </table>
    </div>

    <div class="box-container" id="view_radio_req">
        <table width="100%">
            <tr>
                <td width="100%">
                    <table width="100%">
                        <tr>
                            <th align="center"><h2>View Radio Request</h2></th>
            </tr>
        </table>
        </td>
        </tr>
        <tr>
            <td align="center">

                <select name="radiolistreq" id="radiolistreq">
                    <option value="">Select Radio</option>
                    <?php
                    $urut = 1;
                    foreach ($list_radio_data_request as $lrr) {
                        ?>
                        <option value="<?php
                        echo base_url() . "radio/channel/data_request/?api_url=";
                        echo $lrr->radio_site;
                        ?>/apis/data/request">

                            <?php echo $lrr->radio_name; ?>

                            </option>
                            <?php
                            $urut++;
                        }
                        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <div class="frame_view_rq" >
                    <iframe style="overflow-x : hidden; overflow-y: scroll;" class="data_request_box" name="data_request" width="480" height='300' scrolling="yes" frameborder="1"></iframe>
                </div>
            </td>
        </tr>

        </table>
    </div>
</div>

<script language="javascript">
                            $('select#radiolistreq').change(function() {
                                var isi = $('select#radiolistreq').val();
                                if (isi == "") {
                                    alert("Silahkan pilih salah satu  Radio List...!!!");
                                } else {
                                    $('.frame_view_rq').show();
                                    top.frames['data_request'].location.href = isi;
                                }
                            });
</script>



<script>


    function send_radio_req() {
        $('#send_rq_menu').attr("style", "font-weight : bold;");
        $('#view_rq_menu').attr("style", "font-weight : normal;");
        $('#send_radio_req').show();
        $('#view_radio_req').hide();
    }
    function view_radio_req() {
        $('#view_rq_menu').attr("style", "font-weight : bold;");
        $('#send_rq_menu').attr("style", "font-weight : normal;");
        $('#view_radio_req').show();
        $('#send_radio_req').hide();
    }
    function viewRadioReq(radioname) {
        $('span#radio-request-title').text(capitaliseFirstLetter(radioname));
    }
    function sendMessage(obj) {
        //get message content
        var message = $('textarea#request').val();
        if (message == '') {
            alert('Isi pesan belum ada');
            return;
        }


        //get radio id
        var radio = $('select#radio').val();

        //preserve button original label
        var btn_label = $(obj).val();
        //change button label that showing proccessing
        $(obj).val('Submitting ...');
        $(obj).attr({disabled: 'disabled'});
        $('textarea#request').attr({disabled: 'disabled'});
        //submit send message request via ajax call
        $.post('<?php echo site_url("ajax/radioajax") ?>', {func: 'send_radio_message', message: message, radio: radio}, function(result) {
            alert(result['message']);
            //empty message box
            $('textarea#request').val('');

        }, 'json').always(function() {
            $(obj).val(btn_label);
            $(obj).removeAttr('disabled');
            $('textarea#request').removeAttr('disabled');
        }).error(function() {
            alert('<?php echo config_item('text_server_load_error');?>');
        });


        return false;
    }
</script>