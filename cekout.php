<?php
require_once(dirname(__FILE__) . '/vendor/autoload.php');

Veritrans_Config::$serverKey = "SB-Mid-server-5i3Cs2KJndvzticgAt45EexJ";

Veritrans_Config::$isSanitized = true;

Veritrans_Config::$is3ds = true;

$array   = $_POST['array'];
$arr_kalimat = explode (",",$array);
$array2d = [];

if(isset($_POST['simpan'])){

  $nama     = $_POST["nama"];
  $hp    = $_POST["hp"];
  $email  = $_POST['email'];
  $alamat      = $_POST['alamat'];
  $kota   = $_POST['kota'];
  $kodepos   = $_POST['kodepos'];
  $today   = $_POST['today'];

  $no = 0;
  for ($i = 0; $i < (count($arr_kalimat)/5); $i++){ 
    for ($j = 0; $j < 5; $j++){
      $array2d[$i][$j] = $arr_kalimat[$no];
      $no++;
    }    
  }
}

$transaction_details = array(
  'order_id' => $today,
  'gross_amount' => 40000, 
);

$item_details = array();


for ($i = 0; $i < (count($arr_kalimat)/5); $i++){ 
  $item_details[$i] = array(
    'id' => $array2d[$i][0],
    'price' => $array2d[$i][1],
    'quantity' => $array2d[$i][2],
    'name' => $array2d[$i][3]
  );
}

$billing_address = array(
  'first_name'    => $nama,
  'last_name'     => "",
  'address'       => $alamat,
  'city'          => $kota,
  'postal_code'   => $kodepos,
  'phone'         => $hp,
  'country_code'  => 'IDN'
);

$shipping_address = array(
  'first_name'    => "Panji",
  'last_name'     => "Mahesa",
  'address'       => "Sorosutan, Kec. Umbulharjo, Kota Yogyakarta, DIY",
  'city'          => "Yogyakarta",
  'postal_code'   => "55162",
  'phone'         => "081228358653",
  'country_code'  => 'IDN'
);

$customer_details = array(
  'first_name'    => $nama,
  'last_name'     => "",
  'email'         => $email,
  'phone'         => $hp,
  'billing_address'  => $billing_address,
  'shipping_address' => $shipping_address
);

$enable_payments = array('credit_card','bca_klikbca', 'bri_epay', 'echannel',
    'bca_va', 'bni_va', 'other_va','indomaret','alfamart');

$transaction = array(
  'enabled_payments' => $enable_payments,
  'transaction_details' => $transaction_details,
  'customer_details' => $customer_details,
  'item_details' => $item_details,
);

$snapToken = Veritrans_Snap::getSnapToken($transaction);

?>

<html>
<head>
  <title>CEKOUT</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
</head>
<style type="text/css">
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #333;
  }

  table {
    text-align: left;
    line-height: 40px;
    border-collapse: separate;
    border-spacing: 0;
    border: 2px solid #ed1c40;
    width: 300px;
    margin: 10px auto;
    border-radius: .50rem;
  }

  thead tr:first-child {
    background: #ed1c40;
    color: #fff;
    border: none;
  }

  th:first-child,
  td:first-child {
    padding: 0 15px 0 20px;
  }

  th {
    font-weight: 500;
  }

  thead tr:last-child th {
    border-bottom: 3px solid #ddd;
  }

  tbody tr:hover {
    background-color: #f2f2f2;
    cursor: default;
  }

  tbody tr:last-child td {
    border: none;
  }

  tbody td {
    border-bottom: 1px solid #ddd;
  }

  td:last-child {
    text-align: left;
    padding-right: 10px;
  }

  .button {
    color: #aaa;
    cursor: pointer;
    vertical-align: middle;
    margin-top: -4px;
  }

  .edit:hover {
    color: #0a79df;
  }

  .delete:hover {
    color: #dc2a2a;
  }
</style>
<body>
  <br>
  <center><h1>Detail Pemesanan</h1></center><br>
  <tr><td></td><td><input id="arraymukidi" type="text" name='arrayid' hidden/></td></tr>
  <tr><td></td><td><input id="arraymukidi2" type="text" name='arrayid' hidden/></td></tr>
  <tr><td></td><td><input id="arraymukidi3" type="text" name='arrayid'hidden/></td></tr>
  <tr><td></td><td><input id="arraymukidi4" type="text" name='arrayid'hidden/></td></tr>
  <tr><td></td><td><input id="arraymukidi5" type="text" name='arrayid'hidden/></td></tr>
  <tr><td></td><td><input id="arraymukidi6" type="text" name='arrayid'hidden/></td></tr>
  <?php echo'<tr><td></td><td><input id="today" type="text" name="arrayid" value="'.$today.'" hidden/></td></tr>';?>
  <?php
  for ($i = 0; $i < (count($arr_kalimat)/5); $i++){ 
    echo'<table>
    <thead>
    <tr>
    <th colspan="3">'.$array2d[$i][0].'</th>
    </tr>
    <tr>
    <th>Variable</th>
    <th colspan="2">Value</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Produk</td>
    <td>'.$array2d[$i][3].'</td>
    </tr>
    <tr>
    <td>Harga</td>
    <td>'.$array2d[$i][1].'</td>
    </tr>
    <tr>
    <td>Banyaknya</td>
    <td>'.$array2d[$i][2].'</td>
    </tr>
    <tr>
    <td>Total</td>
    <td>'.$array2d[$i][4].'</td>
    </tr>
    </tbody>
    </table>';
  }?>
  <center><button style="display:inline-block; padding:0.5em 1.2em; margin:0 0.1em 0.1em 0; border:0.16em solid rgba(255,255,255,0); border-radius:2em; box-sizing: border-box; text-decoration:none; font-family:'Roboto',sans-serif; font-weight:300; color:#FFFFFF; text-shadow: 0 0.04em 0.04em rgba(0,0,0,0.35); text-align:center; transition: all 0.2s; background-color:#ED1C40" id="pay-button" type="submit">Transaksi Pembayaran</button></center>
  <br>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-QBR75dd52EajbqT_"></script>
  <script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
      snap.pay('<?=$snapToken?>', {
        onSuccess: function(result){
          tpl();
          logout();
          document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        },
        onPending: function(result){
          tpl();
          logout();
          document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        },
        onError: function(result){
          document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        }
      });
    };
  </script>

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

        var user = firebase.auth().currentUser;

        if(user != null){

          var ido = user.uid;
          var db, ArtikelRef;

          db = firebase.database();
          ArtikelRef = db.ref('admin/'+ido+'/pesanan').orderByChild("status").equalTo(1);

          ArtikelRef.on('value' , dataBerhasil , dataGagal);

          function dataBerhasil(data) {
            console.log(data);
          }
          function dataGagal(err) {
            console.log(err);
          }

          function dataBerhasil(data) {

            var arrayid = [];
            var nomey = 0;
            data.forEach(function(konten) {

              var idA = konten.val().key;
              var jobA = konten.val().job;
              var hargaA = konten.val().harga;
              var banyaknyaA = konten.val().banyaknya;
              var totalA = konten.val().total;
              var ketA = konten.val().ket;
              var lebarA = konten.val().lebar;
              var panjangA = konten.val().panjang;
              var tglA = konten.val().tgl;
              var urlA = konten.val().url;

              arrayid.push([idA,hargaA,banyaknyaA,jobA,totalA,ketA,lebarA,panjangA,tglA,urlA]);
              nomey++;
            });

            document.getElementById("arraymukidi").value = arrayid;
            document.getElementById("arraymukidi2").value = nomey;

            var db2 = firebase.database();
            var query = db2.ref('Sadmin/'+ido);

            query.once('value').then(isiDataEdit);

            function isiDataEdit(dataEdit) {
              var data = dataEdit.val();
              document.getElementById("arraymukidi3").value = data.jumlahOrder;
              document.getElementById("arraymukidi4").value = data.email;
              document.getElementById("arraymukidi5").value = data.nama;
              document.getElementById("arraymukidi6").value = data.hp;
            }

          }
          function dataGagal(err) {
            console.log(err);
          }
        }

      } 
    });

  </script>

  <script>
    function tpl(){
      
        var date = new Date();
      
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
      
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;
      
        var dino = day + "/" + month + "/" + year;

      var user3 = firebase.auth().currentUser;
      var ido3 = user3.uid;
      var db3 = firebase.database();
      var arr1 = document.getElementById("arraymukidi").value;
      var arr2 = arr1.split(",");
      var arr3 = [];

      var user4 = firebase.auth().currentUser;
      var ido4 = user4.uid;

      var db4 = firebase.database();
      var arr5 = document.getElementById("arraymukidi2").value;
      var lamaJml = document.getElementById("arraymukidi3").value;
      var email = document.getElementById("arraymukidi4").value;
      var nama = document.getElementById("arraymukidi5").value;
      var hp = document.getElementById("arraymukidi6").value;
      var detail = document.getElementById("today").value;
      
      var user5 = firebase.auth().currentUser;
      var ido5 = user5.uid;
      var db5 = firebase.database();

      var n = 0;
      for(let i = 0; i < (arr2.length/10); i++){
        arr3.push([arr2[n],arr2[n+1],arr2[n+2],arr2[n+3],arr2[n+4],arr2[n+5],arr2[n+6],arr2[n+7],arr2[n+8],arr2[n+9]]);
        n=n+10;
      }

      for (let k = 0; k < arr3.length; k++)
      {
        db3.ref('admin/'+ido3+'/pesanan/'+arr3[k][0]).set({
          admin   : "",
          banyaknya   : arr3[k][2],  
          harga   : arr3[k][1],
          job   : arr3[k][3],
          karyawan   : "",
          ket   : arr3[k][5],
          key   : arr3[k][0],
          lebar   : arr3[k][6],
          panjang   : arr3[k][7],
          status   : 2, 
          tgl   : dino,
          total   : arr3[k][4],
          url   : arr3[k][9],
          pembayaran : "belum lunas",
          detail : detail
        });
      }

      db4.ref('Sadmin/'+ido4).set({
        jumlahOrder : (Number(lamaJml) - Number(arr5)),
        email : email,
        hp : hp,
        nama : nama
      });
    }
    
    db5.ref('detail_pesanan/'+ido5+'/'+detail).set({
          detail   : detail,
          status   : 2
        });

    function logout(){
      firebase.auth().signOut();
    }
  </script>
</body>
</html>
