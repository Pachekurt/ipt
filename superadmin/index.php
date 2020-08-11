<?php
  $ruta="../";  
  session_start();  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Nuevo Registro";
      include_once($ruta."includes/head_basico.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                  <ol></ol>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <!--Input fields-->
              <div id="input-fields">
                <h4 class="header">Input fields</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>Text fields allow user input. The border should light up simply and clearly indicating which field the user is currently editing. You must have a <code class=" language-markup">.input-field</code> div wrapping your input and label. This
                      helps our jQuery animate the label. This is only used in our Input and Textarea form elements.</p>
                    <p>If you don't want the Green and Red validation states, just remove the <code class=" language-markup">validate</code> class from your inputs.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="row">
                      <form class="col s12">
                        <div class="row">
                          <div class="input-field col s6">
                            <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                            <label for="first_name">First Name</label>
                          </div>
                          <div class="input-field col s6">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Last Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <input disabled value="I am not editable" id="disabled" type="text" class="validate">
                            <label for="disabled">Disabled</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <input id="password" type="password" class="validate">
                            <label for="password">Password</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <input id="email" type="email" class="validate">
                            <label for="email">Email</label>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Prefilling Text Inputs-->
              <div id="prefilling-text" class="section">
                <h4 class="header">Prefilling Text Inputs</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>If you are having trouble with the labels overlapping prefilled content, Try adding <code class=" language-markup">class="active"</code> to the label</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="row">
                      <div class="input-field col s6">
                        <input value="Dr." id="first_name2" type="text" class="validate">
                        <label class="active" for="first_name2">First Name</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Icon Prefixes-->
              <div id="icon-prefixes" class="section">
                <h4 class="header">Icon Prefixes</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>You can add an icon prefix to make the form input label even more clear. Just add an icon with the class <code class=" language-markup">prefix</code> before the input and label.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="row">
                      <form class="col s12">
                        <div class="row">
                          <div class="input-field col s6">
                            <i class="mdi-action-account-circle prefix"></i>
                            <input id="icon_prefix3" type="text" class="validate">
                            <label for="icon_prefix3">First Name</label>
                          </div>
                          <div class="input-field col s6">
                            <i class="mdi-communication-phone prefix"></i>
                            <input id="icon_telephone" type="tel" class="validate">
                            <label for="icon_telephone">Telephone</label>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Input Textarea-->
              <div id="input-textarea" class="section">
                <h4 class="header">Textarea</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>Textareas allow larger expandable user input. The border should light up simply and clearly indicating which field the user is currently editing. You must have a <code class=" language-markup">.input-field</code> div wrapping your input
                      and label. This helps our jQuery animate the label. This is only used in our Input and Textarea form elements.</p>
                    <p><strong>Textareas will auto resize to the text inside.</strong>
                    </p>
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="row">
                      <form class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <textarea id="textarea1" class="materialize-textarea"></textarea>
                            <label for="textarea1">Textarea</label>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>You can add an icon prefix to make the form input label even more clear. Just add an icon with the class <code class=" language-markup">prefix</code> before the input and label.</p>                  
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="row">
                      <div class="input-field col s12">
                        <i class="mdi-editor-mode-edit prefix"></i>
                        <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
                        <label for="icon_prefix2" class="">Message</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Input Select-->
              <div class="section">
                <h4 class="header">Input Select</h4>
                <div id="input-select" class="row">
                  <div class="col s12 m4 l3">
                    <p> Select allows user input through specified options. Make sure you wrap it in a <code class=" language-markup">.input-field </code> for proper alignment with other text fields. </p>
                  </div>
                  <div class="col s12 m8 l9">
                  <form>
                    
                    <div class="input-field col s12">
                      <label>Materialize Select</label>
                      <select>
                        <option value="" disabled selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                      </select>
                    </div>
                  </form>
                  </div>
                </div>                  
                <!--multiple select-->
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>You can add the property <code>multiple</code> to get the multiple select and select several options.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="input-field col s12">
                      <select multiple>
                        <option value="" disabled selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                      </select>
                      <label>Materialize Multiple Select</label>
                    </div>
                  </div>
                </div>                  
                <!--optgroups select-->
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>We also support optgroups with selected.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <div class="input-field col s12">
                      <select>
                        <option value="" disabled >Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2" selected>Option 2</option>
                        <option value="3">Option 3</option>
                        <option value="4">Option 4</option>
                        <option value="5">Option 5</option>
                        <option value="6">Option 6</option>
                        <option value="7">Option 7</option>
                        <option value="8">Option 8</option>
                        <option value="9">Option 9</option>
                      </select>
                      <label>Materialize Select optgroups with selected</label>
                    </div>
                  </div>
                </div>                 
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>You can add the class <code class=" language-markup">browser-default</code> to get the browser default.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <label>Browser Select</label>
                    <select class="browser-default">
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="3">Option 3</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>You can also add <code class=" language-markup">disabled</code> to the select element to make the whole thing disabled. Or if you add <code class=" language-markup">disabled</code> to the options, the individual options will be unselectable.
                    </p>
                  </div>
                  <div class="col s12 m8 l9">
                    <label>Materialize Disabled</label>
                    <select disabled>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="3">Option 3</option>
                    </select>

                    <label>Browser Disabled</label>
                    <select class="browser-default" disabled>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="3">Option 3</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Radio Buttons-->
              <div id="input-radio-buttons" class="section">
                <h4 class="header">Radio Buttons</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>Radio Buttons are used when the user must make only one selection out of a group of items.</p>
                    <p>Add radio buttons to a group by adding the name attribute along with the same corresponding value for each of the radio buttons in the group. Create disabled radio buttons by adding the disabled attribute as shown below.</p>

                  </div>
                  <div class="col s12 m8 l9">
                    <form action="#">
                      <p>
                        <input name="group1" type="radio" id="test1" />
                        <label for="test1">Red</label>
                      </p>
                      <p>
                        <input name="group1" type="radio" id="test2" />
                        <label for="test2">Yellow</label>
                      </p>
                      <p>
                        <input class="with-gap" name="group1" type="radio" id="test3" />
                        <label for="test3">Green</label>
                      </p>
                      <p>
                        <input name="group1" type="radio" id="test4" disabled="disabled" />
                        <label for="test4">Brown</label>
                      </p>
                    </form>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Input Checkboxes-->
              <div id="input-checkboxes" class="section">
                <h4 class="header">Checkboxes</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>Checkboxes are used when the user want to make selection out of a group of items.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <form action="#">
                      <p>
                        <input type="checkbox" id="test5" />
                        <label for="test5">Red</label>
                      </p>
                      <p>
                        <input type="checkbox" id="test6" checked="checked" />
                        <label for="test6">Yellow</label>
                      </p>
                      <p>
                        <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                        <label for="filled-in-box">Filled in</label>
                      </p>
                      <p>
                        <input type="checkbox" id="indeterminate-checkbox">
                        <label for="indeterminate-checkbox">Indeterminate Style</label>
                      </p>
                      <p>
                        <input type="checkbox" id="test7" checked="checked" disabled="disabled" />
                        <label for="test7">Green</label>
                      </p>
                        <p>
                          <input type="checkbox" id="test8" disabled="disabled" />
                          <label for="test8">Brown</label>
                      </p>
                    </form>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Input Switches-->
              <div id="input-switches" class="section">
                <h4 class="header">Switches</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                      <p></p>
                  </div>
                  <div class="col s12 m8 l9">
                    <!-- Switch -->
                    <div class="switch">
                      Enabled : 
                      <label>
                        Off
                        <input type="checkbox">
                        <span class="lever"></span> On
                      </label>
                    </div>
                    <br>
                    <!-- Disabled Switch -->
                    <div class="switch">
                      Diabled : 
                      <label>
                        Off
                        <input disabled type="checkbox">
                        <span class="lever"></span> On
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <!--Input File Input-->
              <div id="input-file-input" class="section">
                <h4 class="header">File Input</h4>
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>If you want to style an input button with a path input we provide this structure.</p>
                  </div>
                  <div class="col s12 m8 l9">
                    <form action="#">
                      <div class="file-field input-field">
                        <div class="btn">
                          <span>File</span>
                          <input type="file">
                        </div>
                        <div class="file-path-wrapper">
                          <input class="file-path validate" type="text">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>                  
                <div class="row">
                  <div class="col s12 m4 l3">
                    <p>You can also use the <code class=" language-markup">multiple</code> attribute to allow multiple file uploads. </p>
                  </div>
                  <div class="col s12 m8 l9">
                     <form action="#">
                        <div class="file-field input-field">
                          <div class="btn">
                            <span>File</span>
                            <input type="file" multiple>
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload one or more files">
                          </div>
                        </div>
                      </form>
                  </div>
                </div>                  
              </div>

              <div class="divider"></div>
              <!--Input Character Counter-->
              <div id="input-character-counter" class="section">
                <h4 class="header">Character Counter</h4>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <p>Use a character counter in fields where a character restriction is in place.</p>
                  </div>
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <form class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <input id="input_text" type="text" length="10">
                            <label for="input_text">Input text</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <textarea id="textarea2" class="materialize-textarea" length="120"></textarea>
                            <label for="textarea1">Textarea</label>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>        
            </div>
          </div>
          <!--start container-->
          <div class="container">
            <!-- //////////////////////////////////////////////////////////////////////////// -->
            <!-- Floating Action Button -->
            <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
              <a class="btn-floating btn-large">
                <i class="mdi-action-stars"></i>
              </a>
              <ul>
                <li><a href="css-helpers.html" class="btn-floating red"><i class="large mdi-communication-live-help"></i></a></li>
                <li><a href="app-widget.html" class="btn-floating yellow darken-1"><i class="large mdi-device-now-widgets"></i></a></li>
                <li><a href="app-calendar.html" class="btn-floating green"><i class="large mdi-editor-insert-invitation"></i></a></li>
                <li><a href="app-email.html" class="btn-floating blue"><i class="large mdi-communication-email"></i></a></li>
              </ul>
            </div>
          </div>
          <!--end container-->
        </section>
      </div>
    </div>
    <!-- end -->
    <!-- jQuery Library -->
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins/jquery-1.11.2.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/materialize.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>    
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/plugins.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?php echo $ruta ?>recursos/js/custom-script.js"></script>
    <!-- Toast Notification -->
    <script type="text/javascript">
    // Toast Notification
    $(window).load(function() {
        
        setTimeout(function() {
            Materialize.toast('<span>Hiya! I am a toast.</span>', 1500);
        }, 1500);
        setTimeout(function() {
            Materialize.toast('<span>You can swipe me too!</span>', 3000);
        }, 5000);
        setTimeout(function() {
            Materialize.toast('<span>You have new order.</span><a class="btn-flat yellow-text" href="#">Read<a>', 3000);
        }, 15000);*/
    </script>
</body>

</html>