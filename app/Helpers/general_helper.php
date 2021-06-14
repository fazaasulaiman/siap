<?php
function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Jan',
        'Feb',
        'Maret',
        'Apr',
        'Mei',
        'Juni',
        'Juli',
        'Agust',
        'Sept',
        'Okt',
        'Nov',
        'Des'
    );
    $pecahkan = explode('-', $tanggal);
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>