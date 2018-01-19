<footer class="relative section">
  <br>
  <br>
  <br>
  <br>
  <div class="row">
    <div class="col s12 m5 l4 offset-m1 offset-l1 hvr-buzz-out">
      <div class="card-panel red center foo">
        <h2>
          <span class="white-text" id="contact">Contact Me!
          </span>
        </h2>
      </div>
    </div>
  </div>

/* Begin code for email form */

<?php

// grab recaptcha library
require_once "recaptchalib.php";

// your secret key
$secret = "6LfQwD0UAAAAAKT4HffObOskIu9oK1bkb575rJ8L";

// empty response
$response = null;

// check secret key
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
  }
?>


<div class="formContainer">
    <div class="form">

      <?php

      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      if ($response != null && $response->success) {
        //create array of data to be posted
        $post_data['recipient'] = "fcb@franklinchristopherbrooks.com";
        $post_data['subject'] = "My FormMail";
        $post_data['name'] = test_input($_POST["name"]);
        $post_data['email'] = $_POST["email"];
        $post_data['comment'] = test_input($_POST["comment"]);

        //traverse array and prepare data for posting (key1=value1)
        foreach ( $post_data as $key => $value) {
        $post_items[] = $key . '=' . $value;
        }

        //create the final string to be posted using implode()
        $post_string = implode ('&', $post_items);

        //we also need to add a question mark at the beginning of the string
        $post_string = '?' . $post_string;

        //we are going to need the length of the data string
        $data_length = strlen($post_string);

        $url = 'https://www.franklinchristopherbrooks.com/cgi-sys/formmail.pl';
        $options = array(
          'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($post_data),
          )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        echo "<h3>Hi " . $_POST["name"] . ", thanks for submitting the form.<br />I'll get back to you soon.</h3>";

      } else {

      ?>

      <iframe width="0" height="0" border="0" name="dummyframe" id="dummyframe"></iframe>

      <form action="" method="post" name="hgmailer" target="dummyframe">
        <br />
        <input type="hidden" name="recipient" value="fcb@franklinchristopherbrooks.com" readonly>
        <input type="hidden" name="subject" value="FormMail E-Mail" readonly>
        <label for="name">Your name: </label>
        <br />
        <input id="nameValue" type="text" name="name" maxlength="100" value="" placeholder="your name" required onblur="hgsubmit()" >
        <div class=""><p id="nameError">Please provide your name</p></div>
        <label>Your E-Mail Address: </label>
        <br />
        <input id="emailValue" type="email" name="email" maxlength="100" value="" placeholder="you@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required oninput="hgsubmit()" >
        <div class=""><p id="emailError">A valid email address is required</p><div>
        <br />
        <label for="comment">Your message: </label>
        <br />
        <textarea name="comment" cols="50" rows="10" maxlength="500" placeholder="your message" required oninput="hgsubmit()" ></textarea>
        <div class=""><p id="commentError">An email message is required</p></div>
        <br />
<div class="myRecaptchaDiv">
        <div class="g-recaptcha" data-sitekey="6LfQwD0UAAAAAIWCUASDEATVBrRzvK52MYp0qqEk" data-callback="enableBtn" ></div>
</div>
        <input type="submit" id="mySubmit" value="Submit" onclick="hideForm();" />
      </form>

      <?php } ?>
    </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal1">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        Thank you!  I'll be in touch soon!
      </div>
    </div>

    <!--js-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
      let hideForm = function(){
        document.getElementsByName("hgmailer")[0].style.visibility = "hidden";
        document.getElementById("mySubmit").style.visibility = "hidden";
        document.getElementsByClassName("g-recaptcha")[0].style.visibility = "hidden";
        document.getElementById('myModal').style.display = "block";
      }
    </script>
    <script>
      window.onload = function() {
        let myRecatcha = document.getElementsByClassName("g-recaptcha")[0];
        if(myRecatcha) {
          myRecatcha.style.visibility = "hidden";
        }
        let myButton = document.getElementById("mySubmit");
          if(myButton) {
            myButton.style.visibility = "hidden";
        }
      }
    </script>
    <script>
      var enableBtn = function(){
        document.getElementById("mySubmit").style.visibility = "visible";
      }
    </script>

    <script>
      // Get the modal
      var modal = document.getElementById('myModal');
      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];
      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
          modal.style.display = "none";
      }
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      }
    </script>





    <script type="text/javascript">
      function hgsubmit() {
        // Get the Recaptcha div
        let myRecaptcha = document.getElementsByClassName("g-recaptcha")[0];
        // check values of input fields before allowing reCaptcha validation
        if (/^[A-Za-z]+((\s)?((\'|\-|\.)?([A-Za-z])+))*$/.test(document.hgmailer.name.value) == false) {
          document.getElementById("nameError").style.visibility = "visible";
        } else if ((/^[A-Za-z]+((\s)?((\'|\-|\.)?([A-Za-z])+))*$/.test(document.hgmailer.name.value) == true) && (/^\S+@[a-z0-9_.-]+\.[a-z]{2,6}$/i.test(document.hgmailer.email.value) == false)) {
          document.getElementById("nameError").style.visibility = "hidden";
          document.getElementById("emailError").style.visibility = "visible";
        } else if ((/^[A-Za-z]+((\s)?((\'|\-|\.)?([A-Za-z])+))*$/.test(document.hgmailer.name.value) == true) && (/^\S+@[a-z0-9_.-]+\.[a-z]{2,6}$/i.test(document.hgmailer.email.value) == true) && (/\S+/.test(document.hgmailer.comment.value) == false)) {
          document.getElementById("nameError").style.visibility = "hidden";
          document.getElementById("emailError").style.visibility = "hidden";
          document.getElementById("commentError").style.visibility = "visible";
        } else {
          document.getElementById("nameError").style.visibility = "hidden";
          document.getElementById("emailError").style.visibility = "hidden";
          document.getElementById("commentError").style.visibility = "hidden";
          myRecaptcha.style.visibility = "visible";
        }
      }
    </script>


/* End email form code */

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <p><a href="mailto:fcb@franklinchristopherbrooks.com?Subject=Hello!!" target="new" class="footerlink">fcb@franklinchristopherbrooks.com</a></p>
  <br>
  <br>
  <br>
  <br>
<span class="social-icon">
  <a href="https://www.facebook.com/franklinchristopherbrooks" target="new"><img src="images/facebook.gif" alt="Facebook Logo"></a></span>
<span class="social-icon">
  <a href="https://twitter.com/franklincbrooks" target="new"><img src="images/twitter-icon.png" alt="Twitter Logo"></a></span>
<span class="social-icon">
  <a href="https://github.com/franklinbrooks" target="new"><img src="images/github-icon.png" alt="Github Logo"></a></span>
<span class="social-icon">
  <a href="https://www.linkedin.com/in/franklinchristopherbrooks/" target="new"><img src="images/linkedin-icon.png" alt="LinkedIn Logo"></a></span>
<span class="social-icon">
  <a href="https://profiles.generalassemb.ly/franklinchristopherbrooks" target="new"><img src="images/ga_logo.png" alt="General Assembly Logo"></a></span>
  <br>
  <br>
  <br>
  <p style="color:white;font-size:1rem"> &copy; 2017 Franklin Christopher Brooks. All rights reserved. </p>
  <p>
    <a href="https://validator.w3.org/check?uri=referer" target="new"><img
      src="https://www.w3.org/Icons/valid-xhtml10-blue.png"
      alt="Valid XHTML 1.0!" height="31" width="88" id="w3c"/></a>
  </p>
  <a data-scroll href="#top" class="footerlink">Back to top</a>
</footer>
