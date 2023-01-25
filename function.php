<?php
session_start();


$conn = mysqli_connect("localhost","root","","stockbarang");


// menambah barang
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock) values ('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index.php');
    }else {
        echo 'Gagal';
        header('location:index.php');
    }
}


// menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST ['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang,keterangan,qty)values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    }else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


// menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST ['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar= mysqli_query($conn,"insert into keluar (idbarang,penerima,qty)values('$barangnya','$penerima','$qty')");
    $updatestockkeluar = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockkeluar){
        header('location:keluar.php');
    }else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}



// Update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn,"update stock set namabarang='$namabarang',deskripsi='$deskripsi'where idbarang='$idb'");
    if($update){
            header('location:index.php');
    }else {
            echo 'Gagal';
            header('location:index.php');
    }
    
}


//Menghapus barang
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus){
            header('location:index.php');
    }else {
            echo 'Gagal';
            header('location:index.php');
    }
}



//mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST ['qty'];

    $liatstock = mysqli_query($conn,"select * from masuk where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($liatstock);
    $stocksekarang = $stocknya['stok'];

    $qtysekarang = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtysekarang);
    $qtysekarang = $qtynya['qty'];

    if($qty>$qtysekarang){
        $selisih = $qty-$qtysekarang;
        $kurangin = $stocksekarang-$selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock ='$kurangin' where idbarang= '$idb'");
        $kurangistoknya = mysqli_query($conn,"update masuk set qty='$qty'where idmasuk= '$idm'");
            if($kuranginstocknya&&$updattenya){
                header('location:masuk.php');
            }else {
                    echo 'Gagal';
                    header('location:masuk.php');
            }  
         }else{
            $selisih = $qtysekarang-$qty;
            $kurangin = $stocksekarang+$selisih;
            $kurangistocknya = mysqli_query($conn,"update stock set stock ='$kurangin' where idbarang= '$idb'");
            $kurangistoknya = mysqli_query($conn,"update masuk set qty='$qty'where idmasuk= '$idm'");
            if($kuranginstocknya&&$updattenya){
                header('location:masuk.php');
            }else {
                    echo 'Gagal';
                    header('location:masuk.php');
            }  
         }

}


// menghapus barang Masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select* from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    }else{
        header('location:masuk.php');
    }

}




?>