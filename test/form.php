<?php
    $message = '';
    $error = array();
    
    // we'll fake the database check, the following names won't be available.
    $taken_usernames = array(
        'remy',
        'julie',
        'andrew',
        'andy',
        'simon',
        'chris',
        'nick'
    );

    // main submit logic
    if (@$_REQUEST['action'] == 'register') {
        $resp = check_username($_REQUEST['username']);
        
        if ($resp['ok']) {
            $message = 'All details fine';
        } else {
            $message = 'There was a problem with your registration details';
            $error = $resp;
        }
    } else if (@$_REQUEST['action'] == 'check_username' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        // means it was requested via Ajax
        echo json_encode(check_username($_REQUEST['username']));
        exit; // only print out the json version of the response
    }
    
    function check_username($username) {
        global $taken_usernames;
        $resp = array();
        $username = trim($username);
        if (!$username) {
            $resp = array('ok' => false, 'msg' => "Please specify a username");
        } else if (!preg_match('/^[a-z0-9\.\-_]+$/', $username)) {
            $resp = array('ok' => false, "msg" => "Your username can only contain alphanumerics and period, dash and underscore (.-_)");
        } else if (in_array($username, $taken_usernames)) {
            $resp = array("ok" => false, "msg" => "The selected username is not available");
        } else {
            $resp = array("ok" => true, "msg" => "This username is free");
        }

        return $resp;        
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>jQuery for Designers - Ajax Form Validation Example</title>
    <style type="text/css" media="screen">
    <!--
      BODY { margin: 10px; padding: 0; font: 1em "Trebuchet MS", verdana, arial, sans-serif; font-size: 100%; }
      H1 { margin-bottom: 2px; font-family: Garamond, "Times New Roman", Times, Serif;}
      TEXTAREA { width: 80%;}
      FIELDSET { border: 1px solid #ccc; padding: 1em; margin: 0; }
      LEGEND { color: #ccc; font-size: 120%; }
      INPUT, TEXTAREA { font-family: Arial, verdana; font-size: 125%; padding: 7px; }
      LABEL { display: block; margin-top: 10px; } 
      IMG { margin: 5px; }
      #message {
          border: 1px solid #ccc;
          background-color: #ffa;
          padding: 5px;
      }
      DIV.submit {
        background: #eee;
        border: 1px solid #ccc;
        border-top: 0;
        padding: 1em;
        text-align: right;
        margin-bottom: 20px;
      }
      IMG.avatar {
          vertical-align: top;
      }
    -->
    </style>

    <script src="../js/jQuery.js" type="text/javascript"></script>
<?php if (!isset($_REQUEST['nojs'])) : ?>
    <script type="text/javascript">
    <!--
    $(document).ready(function () {
        // Username validation logic
        var validateUsername = $('#validateUsername');
        $('#username').keyup(function () {
            // cache the 'this' instance as we need access to it within a setTimeout, where 'this' is set to 'window'
            var t = this; 
            
            // only run the check if the username has actually changed - also means we skip meta keys
            if (this.value != this.lastValue) {
                
                // the timeout logic means the ajax doesn't fire with *every* key press, i.e. if the user holds down
                // a particular key, it will only fire when the release the key.
                                
                if (this.timer) clearTimeout(this.timer);
                
                // show our holding text in the validation message space
                validateUsername.removeClass('error').html('<img src="../images/ajax-loader.gif" height="16" width="16" /> checking availability...');
                
                // fire an ajax request in 1/5 of a second
                this.timer = setTimeout(function () {
                    $.ajax({
                        url: 'form.php',
                        data: 'action=check_username&username=' + t.value,
                        dataType: 'json',
                        type: 'post',
                        success: function (j) {
                            // put the 'msg' field from the $resp array from check_username (php code) in to the validation message
                            validateUsername.html(j.msg);
                        }
                    });
                }, 200);
                
                // copy the latest value to avoid sending requests when we don't need to
                this.lastValue = this.value;
            }
        });
        
        // avatar validation
        // we use keyup *and* change because 
        $('#avatar').keyup(function () {
            var t = this;
            clearTimeout(this.timer);
            this.timer = setTimeout(function () {
                if (t.value == t.current) {
                    return true;
                }

                var preview = $('#validateAvatar').html('<img src="../images/ajax-loader.gif" height="16" width="16" /> trying to load avatar...');
                var i = new Image();

                clearTimeout(t.timeout);

                if (t.value == '') {
                    preview.html('');
                } else {
                    i.src = t.value;
                    i.height = 32;
                    i.width = 32;
                    i.className = 'avatar';

                    // set a timeout of x seconds to load the image, otherwise, show the fail message
                    t.timeout = setTimeout(function () {
                        preview.html('Image could not be loaded.');
                        i = null;
                    }, 3000);

                    // if the dummy image holder loads, we'll show the image in the validation space,
                    // but importantly, we clear the timer set above
                    i.onload = function () {
                        clearTimeout(t.timeout);
                        preview.empty().append(i);
                        i = null;
                    };
                }
                
                t.current = t.value;
            }, 250);
        }).change(function () {
            $(this).keyup(); // call the keyup function
        });
    });
    //-->
    </script>
<?php endif ?>
  </head>
  <body>
    <div>
        <h1>jQuery for Designers - Ajax Form Validation Example</h1>
        <p>This shows two examples of client side validation in a form using JavaScript (with jQuery). The username will check with the server whether the chosen name is a) valid and b) available. The avatar example tries to load the URL in to a hidden image, if it fails, it shows the appropriate message.</p>
        <p><a href="http://jqueryfordesigners.com/using-ajax-to-validate-forms/">Read the article this demonstration relates to</a></p>
        <p><a href="?action=register&amp;username=remy&amp;avatar=http://tbn0.google.com/images?q=tbn:gLMWxXGcr71JVM">Example of failing username and successful avatar</a></p>
        <p><a href="?nojs">See the non-JavaScript version</a></p>
<?php if ($message) : ?>
        <p id="message"><?=$message?></p>
<?php endif ?>
        <form action="" method="post">
            <fieldset>
                <legend>Register</legend>
                <div>
                    <label for="username">Username, valid: a-z.-_</label>
                    <input type="text" name="username" value="<?=@$_REQUEST['username']?>" id="username" />
                    <span id="validateUsername"><?php if ($error) { echo $error['msg']; } ?></span>
                </div>
                <div>
                    <label for="avatar">Avatar URL</label>
                    <input type="text" name="avatar" size="50" value="<?=@$_REQUEST['avatar']?>" id="avatar" />
                    <span id="validateAvatar"><?php if (@$_REQUEST['avatar']) { echo '<img src="' . $_REQUEST['avatar'] . '" height="32" width="32" class="avatar" />'; }?></span>
                </div>
            </fieldset>
            <input type="hidden" name="action" value="register" />
            <div class="submit"><input type="submit" name="register" value="Register" id="register" /></div>
        </form>
        <p>Note that the following usernames are permanently unavailable for the purpose of this demo: <?=join(', ', $taken_usernames)?></p>
    </div>
  </body>
</html>




