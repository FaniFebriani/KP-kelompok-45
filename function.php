<?php
session_start();
//Membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stock barang");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"insert into stock(nama_barang, deskripsi, stock) values('$nama_barang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};

//Menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qyt'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;
    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, keterangan, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock = '$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//Menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qyt'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, penerima, qty) values ('$barangnya','$penerima','$qty')");
    $updatestockkeluar = mysqli_query($conn, "update stock set stock = '$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&$updatestockkelauar){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

//update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn."update stock namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
    if($update){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
    
}

//Menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};

//Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb =$_POST['idb'];
    $idm =$_POST['idm'];
    $keterangan = $_POST['keterangan'];
    $qty =$_POST['qty'];

    $lhatstock = mysqli_query($conn,"select * from stock where idbarang='$idm'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty-$qtyskrg;
        $kurangi = $stockskrg-$selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty' keterangan='$deskripsi' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
            header('location:masuk.php');
            } else {
                echo 'Gagal';
                header('location:masuk.php');
            }
    } else { 
        $selisih = $qtyskrg-$qty;
        $kurangi = $stockskrg+$selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty' keterangan='$deskripsi' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
            header('location:masuk.php');
            } else {
                echo 'Gagal';
                header('location:masuk.php');
     
    }
    }
}

//menghapus barang masuk
if(isset($_POST['hapusabarangmasuk'])){
    $idb =$_POST['idb'];
    $qty =$_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn, "update stock set stock'$selisih where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');

    } else {
        header('location:masuk.php');
    }
}
?>

