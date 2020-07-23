

<html>
<head>
  <title>Firebase Login</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <form id="login_div" method="get" action="javascript: void(0);" class="login-form" autocomplete="off" role="main">
    <h1 class="a11y-hidden">Login Form</h1>

    <figure aria-hidden="true">
      <div class="person-body"></div>
      <div class="neck skin"></div>
      <div class="head skin">
        <div class="eyes"></div>
        <div class="mouth"></div>
      </div>
      <div class="hair"></div>
      <div class="ears"></div>
      <div class="shirt-1"></div>
      <div class="shirt-2"></div>
    </figure>
    <div>
      <label class="label-email">
        <input type="email" placeholder="Email..." id="email_field" class="text" name="email" tabindex="1" required />
        <span class="required">Email</span>
      </label>
    </div>
    <div>
      <label class="label-password">
        <input type="password" placeholder="Password..." id="password_field" class="text" name="password" tabindex="2" required />
        <span class="required">Password</span>
      </label>
    </div>
    <input onclick="login()" type="submit" value="Log In" />
  </form>

  <div id="user_div">

    <form action="cekout.php" method="post" class="login-form">
      <span align="center">LENGKAPI DATA</span>
      <div>
      <label class="label-email">
        <input id="nama" type="text" name="nama" placeholder="Nama..." class="text" tabindex="1" readonly/>
        <span>Nama</span>
      </label>
    </div>
    <div>
      <label class="label-email">
        <input id="hp" type="text" name="hp" placeholder="Nama..." class="text" tabindex="1" readonly/>
        <span>Nomor Handphone</span>
      </label>
    </div>
    <div>
      <label class="label-email">
        <input id="email"  type="text" name='email' placeholder="Nama..." class="text" tabindex="1" readonly/>
        <span>Email</span>
      </label>
    </div>
    <div>
      <label class="label-email">
        <input id="alamat" type="text" name="alamat" placeholder="Alamat" class="text" tabindex="1" required/>
        <span class="required">Alamat</span>
      </label>
    </div>
    <div>
      <label class="label-email">
        <input id="kota" type="text" name="kota" placeholder="Kota" class="text" tabindex="1" required/>
        <span class="required">Kota</span>
      </label>
    </div>
    <div>
      <label class="label-email">
        <input id="kodepos" type="text" name="kodepos" placeholder="Kode Pos" class="text" tabindex="1" required/>
        <span class="required">Kode Pos</span>
      </label>
    </div>
    <tr><td></td><td><input id="array" type="text" name='array' hidden/></td></tr>
    <input type="submit" value="Simpan" name="simpan"/>
  </form>
  <center><button style="display:inline-block; padding:0.3em 1.2em; margin:0 0.1em 0.1em 0; border:0.16em solid rgba(255,255,255,0); border-radius:2em; box-sizing: border-box; text-decoration:none; font-family:'Roboto',sans-serif; font-weight:300; color:#FFFFFF; text-shadow: 0 0.04em 0.04em rgba(0,0,0,0.35); text-align:center; transition: all 0.2s; background-color:#f14e4e" onclick="logout()">Logout</button></center>
</div>


<script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
      apiKey: "AIzaSyCCaNsCpUvsucsm5zCWl4zPq2399Gq1Ypw",
      authDomain: "printshop-123.firebaseapp.com",
      databaseURL: "https://printshop-123.firebaseio.com",
      projectId: "printshop-123",
      storageBucket: "printshop-123.appspot.com",
      messagingSenderId: "660500440921"
    };
    firebase.initializeApp(config);
  </script>

  <script>

    firebase.auth().onAuthStateChanged(function(user) {
      if (user) {
    // User is signed in.

    document.getElementById("user_div").style.display = "block";
    document.getElementById("login_div").style.display = "none";

    var user = firebase.auth().currentUser;

    if(user != null){

      var ido = user.uid;
      var db, db2 , ArtikelRef;

      db = firebase.database();
      ArtikelRef = db.ref('admin/'+ido+'/pesanan').orderByChild("status").equalTo("pesan masuk");

      ArtikelRef.on('value' , dataBerhasil , dataGagal);

      function dataBerhasil(data) {
        console.log(data);
      }
      function dataGagal(err) {
        console.log(err);
      }

      ArtikelRef.on('value' , dataBerhasil , dataGagal);
      var isi_tabel = document.getElementById('list_konten');

      function dataBerhasil(data) {

        var index = 0;
        var array = [];
        data.forEach(function(konten) {

          var idA = konten.val().id;
          var jobA = konten.val().job;
          var hargaA = konten.val().harga;
          var banyaknyaA = konten.val().banyaknya;
          var totalA = konten.val().total;

          array.push([idA,hargaA,banyaknyaA,jobA,totalA]);
          index++;

        });

        document.getElementById("array").value = array;

      }
      function dataGagal(err) {
        console.log(err);
      }

      db2 = firebase.database();
      var query = db2.ref('admin/'+ido);

      query.once('value').then(isiDataEdit);

      function isiDataEdit(dataEdit) {
        var data = dataEdit.val();

        document.getElementById("nama").value = data.nama;
        document.getElementById("hp").value = data.hp;
        document.getElementById("email").value = data.email;
      }

    }

  } else {
    // No user is signed in.

    document.getElementById("user_div").style.display = "none";
    document.getElementById("login_div").style.display = "block";

  }
});

    function login(){

      var userEmail = document.getElementById("email_field").value;
      var userPass = document.getElementById("password_field").value;

      firebase.auth().signInWithEmailAndPassword(userEmail, userPass).catch(function(error) {
    // Handle Errors here.
    var errorCode = error.code;
    var errorMessage = error.message;

    window.alert("Error : " + errorMessage);

    // ...
  });

    }

    function logout(){
      firebase.auth().signOut();
    }

  </script>

</body>
</html>
