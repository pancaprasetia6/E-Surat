<?php
include '../konek.php';

// Set header untuk JSON
header('Content-Type: application/json');

// Debug log
error_log("AJAX Request: " . print_r($_POST, true));

if(isset($_POST['id_request_sku']) && isset($_POST['action'])){
    $id = intval($_POST['id_request_sku']);
    $action = $_POST['action'];
    
    // Validasi ID
    if($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
        exit;
    }
    
    if($action == 'acc'){
        // Proses ACC
        $no_surat = "SKU/" . date('Y') . "/" . str_pad($id, 4, '0', STR_PAD_LEFT);
        $sql = "UPDATE data_request_sku SET status='1', no_surat='$no_surat', acc=NOW(), keterangan='Telah disetujui oleh Admin' WHERE id_request_sku='$id'";
        $query = mysqli_query($konek, $sql);

        if($query){
            echo json_encode(['success' => true, 'message' => 'Pengajuan SKTM telah disetujui']);
        } else {
            $error = mysqli_error($konek);
            error_log("Database Error: " . $error);
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan database: ' . $error]);
        }
        
    } elseif($action == 'tolak'){
        // Proses Tolak
        $sql = "UPDATE data_request_sku SET status='0', keterangan='Ditolak - data tidak lengkap ' WHERE id_request_sku='$id'";
        $query = mysqli_query($konek, $sql);

        if($query){
            echo json_encode(['success' => true, 'message' => 'Pengajuan SKTM telah ditolak']);
        } else {
            $error = mysqli_error($konek);
            error_log("Database Error: " . $error);
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan database: ' . $error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}

// Tutup koneksi
mysqli_close($konek);
?>