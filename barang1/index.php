<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "barang1";

$koneksi    = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$kode_barang    = "";
$nama_barang    = "";
$diskon         = "";
$harga          = "";
$sukses         = "";
$error          = ""; 

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from data_brg where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "berhasil delete";
    }else{
        $error  = "gagal delete";
    }
}
if($op == 'edit'){
    $id          = $_GET['id'];
    $sql1        = "select * from data_brg where id = '$id'";
    $q1          = mysqli_query($koneksi,$sql1);
    $r1          = mysqli_fetch_array($q1);
    $kode_barang = $r1['kode_barang'];
    $nama_barang = $r1['nama_barang'];
    $harga       = $r1['harga'];
    $diskon      = $r1['diskon'];

    if($kode_barang == ''){
        $error = "Data tidak ada";
    }
}

if(isset($_POST['simpan'])){
    $kode_barang  = $_POST['kode_barang'];
    $nama_barang  = $_POST['nama_barang'];
    $harga        = $_POST['harga'];
    $diskon       = $_POST['diskon'];

    if($kode_barang && $nama_barang && $harga && $diskon){
        if($op == 'edit'){
            $sql1       = "update data_brg set kode_barang ='$kode_barang',nama_barang= '$nama_barang',harga ='$harga',diskon ='$diskon' where id = '$id'";
            $q1         = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "berhasil";
            }else{
                $error = "gagal";
            }
        }else{
             $sql1 = "insert into data_brg(kode_barang,nama_barang,harga,diskon) values ('$kode_barang','$nama_barang','$harga','$diskon')";
             $q1   = mysqli_query($koneksi,$sql1);
             if($q1){
                $sukses   = "Berhasil";
            }else{
                $error     = "Gagal";
            }
        }
    } else{
        $error = "masukan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<body background="background-batik-putih-2-300x300-1.png">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto { 
            width: 800px 
        }
        .card { 
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if($error){
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if($sukses){
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                }
                ?>
                <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="kode_barang" class="col-sm-2 col-form-label">kode_barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?php echo $kode_barang?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_barang" class="col-sm-2 col-form-label">nama_barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $nama_barang ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga" class="col-sm-2 col-form-label">harga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="diskon" class="col-sm-2 col-form-label">diskon</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="diskon" id="diskon">
                            <option value="">- diskon harga -</option>
                            <option value="5persen" <?php if($diskon == "5persen") echo "selected"?>>5persen</option>
                            <option value="10persen" <?php if($diskon == "10persen") echo "selected"?>>10persen</option>
							<option value="Tidak Ada" <?php if($diskon == "Tidak Ada") echo "selected"?>>Tidak Ada</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"/>
                </div>
            </form>
            </div>
        </div>
        <p><center><b>NB JIKA PEMBELIAN DIATAS RP.500.000 AKAN MENDAPAT DISKON 5%</b></center></P>

        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Barang
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">kode_barang</th>
                            <th scope="col">nama_barang</th>
                            <th scope="col">harga</th>
                            <th scope="col">diskon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2   = "select * from data_brg order by id desc";
                            $q2     = mysqli_query($koneksi,$sql2);
                            $urut   = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id          = $r2['id'];
                                $kode_barang = $r2['kode_barang'];
                                $nama_barang = $r2['nama_barang'];
                                $harga       = $r2['harga'];
                                $diskon      = $r2['diskon'];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $kode_barang ?></td>
                                    <td scope="row"><?php echo $nama_barang ?></td>
                                    <td scope="row"><?php echo $harga ?></td>
                                    <td scope="row"><?php echo $diskon ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&id=<?php echo $id?>" onClick="return confirm('yakin')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    </td>
                                    </tr>
                                <?php
                                 }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>