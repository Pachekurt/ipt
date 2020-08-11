$("#idLog").click(function(){
  var user=document.getElementById('username').value;
  var pass=document.getElementById('password').value;
  $.ajax({
    url: "session/login.php",
    type: "POST",
    data: "usuarios="+user+"&contrasenia="+pass,
    success: function(resp){
      $('#msgLoginREsp').html(resp)
      console.log(resp);
    }   
  });
});