<?php // Nugraha, Sun May  9 15:51:37 WIT 2004
      // sfdn, 18-05-2004
      // sfdn, 01-06-2004
 
$r = pg_query($con,
        "SELECT a.id, to_char(a.tanggal_reg,'DD/MM/YYYY') AS tanggal_reg, a.waktu_reg, ".
        "    a.mr_no, e.nama, to_char(e.tgl_lahir, 'DD/MM/YYYY') AS tgl_lahir, ".
        "    e.tmp_lahir, e.jenis_kelamin, f.tdesc AS agama, ".
        "    e.alm_tetap, e.kota_tetap, e.pos_tetap, e.tlp_tetap, ".
        "    a.id_penanggung, b.tdesc AS penanggung, a.id_penjamin, ".
        "    c.tdesc AS penjamin, a.no_jaminan, a.rujukan, a.rujukan_rs_id, ".
        "    d.tdesc AS rujukan_rs, a.rujukan_dokter, a.rawat_inap, ".
        "    a.status, a.tipe, g.tdesc AS tipe_desc, a.diagnosa_sementara, ".
        "    to_char(a.tanggal_reg, 'DD/MM/YYYY') AS tanggal_reg_str, ".
        "        CASE ".
        "            WHEN a.rawat_inap = 'Y' THEN 'Rawat Inap'  ".
        "            WHEN a.rawat_inap = 'N' THEN 'Rawat Jalan' ".
        "            ELSE 'IGD' ".
        "        END AS rawatan, ".
        "        age(a.tanggal_reg , e.tgl_lahir ) AS umur ".
        "FROM rs00006 a ".
        "   LEFT JOIN rs00001 b ON a.id_penanggung = b.tc AND b.tt = 'PEN'".
        "   LEFT JOIN rs00001 c ON a.id_penjamin = c.tc AND c.tt = 'PJN' ".
        "   LEFT JOIN rs00002 e ON a.mr_no = e.mr_no ".
        "   LEFT JOIN rs00001 f ON e.agama_id = f.tc AND f.tt = 'AGM' ".
        "   LEFT JOIN rs00001 g ON a.tipe = g.tc AND g.tt = 'JEP' ".
        "   LEFT JOIN rs00001 d ON a.id_penjamin = d.tc AND d.tt = 'RUJ' ".
        "WHERE to_number(id,'9999999999') = ".$_GET["rg"]);

$n = pg_num_rows($r);
if($n > 0) $d = pg_fetch_object($r);
pg_free_result($r);

$id_min = getFromTable("select min(id) from rs00010 where no_reg = '".$_GET["rg"]."'");
$chkind = getFromTable("select to_char(ts_check_in,'DD/MM/YYYY') from rs00010 where id = '$id_min'");
$chkint = getFromTable("select to_char(ts_check_in,'HH24:MI:SS') from rs00010 where id = '$id_min'");
$daycnt = getFromTable("select sum(extract(day from case when ts_calc_stop is null then current_timestamp ".
                       "else ts_calc_stop end - ts_calc_start)) from rs00010 ".
                       "where no_reg = '".$_GET["rg"]."'");
$bangsal = getFromTable("select d.bangsal || ' / ' || c.bangsal || ' / ' || e.tdesc || ' / ' || b.bangsal ".
                       "from rs00010 as a ".
                       "    join rs00012 as b on a.bangsal_id = b.id ".
                       "    join rs00012 as c on c.hierarchy = substr(b.hierarchy,1,6) || '000000000' ".
                       "    join rs00012 as d on d.hierarchy = substr(b.hierarchy,1,3) || '000000000000' ".
                       "    join rs00001 as e on c.klasifikasi_tarif_id = e.tc and e.tt = 'KTR' ".
                       "where a.id = '$id_min'");

$q = pg_query("select ts_calc_stop from rs00010 where no_reg = '".$_GET["rg"]."' and ts_calc_stop is null");
$qn = pg_num_rows($q);

if ($qn > 0) {
 	$akhir = getFromTable("select to_char(CURRENT_TIMESTAMP,'DD MONTH YYYY HH24:MI:SS')");

} else {
	$akhir = getFromTable("select to_char(ts_calc_stop,'DD MONTH YYYY HH24:MI:SS') from rs00010 where no_reg='".$_GET["rg"]."'");	
}

//echo " xxxx: $akhir";
echo "<table border=0 width='100%'><tr><td valign=top>";
    $f = new ReadOnlyForm();
    $f->text("Nomor Registrasi", formatRegNo($d->id) . " - " .
        getFromTable("select count(mr_no) from rs00006 where mr_no = '$d->mr_no'"));
    $f->text("Nomor MR", $d->mr_no);
    $f->text("Nama", $d->nama);
    $f->text("Tanggal Registrasi", $d->tanggal_reg);
	$f->text("Sampai dgn. Tgl",$akhir);
    $f->execute();
echo "</td><td valign=top>";
    $f = new ReadOnlyForm();
    $f->text("Tanggal Masuk", $chkind);
    $f->text("Jam Masuk", $chkint);
    $f->text("Lama Dirawat", "$daycnt hari");
    $f->text("Bangsal", $bangsal);
    $f->execute();
echo "</td></tr></table>";


$SQL =  "select to_char(case when a.id = '$id_min' then a.ts_check_in else a.ts_calc_start end,".
        "'DD/MM/YYYY HH24:MI:SS') as ts_calc_start,".
        "to_char(case when a.ts_calc_stop is null then current_timestamp else a.ts_calc_stop end,".
        "'DD/MM/YYYY HH24:MI:SS') as ts_calc_stop,".
        "extract(day from case when a.ts_calc_stop is null then current_timestamp else a.ts_calc_stop ".
        "end - a.ts_calc_start) as jumlah_hari, ".
        "case when a.ts_calc_stop is not null then 'Sudah Posting' else ".
        "  case when extract(day from current_timestamp - a.ts_calc_start) = 0 then '' ".
        "  else 'Belum Posting' end ".
        "end as dummy ".
        "from rs00010 as a ".
        "where a.no_reg = '".$_GET["rg"]."'";

$t = new PgTable($con, "100%");
$t->SQL = $SQL;
$t->ColHeader = array("DARI", "SAMPAI", "JUMLAH HARI", "STATUS");
$t->ShowRowNumber = true;
$t->DefaultSort = "id";
$t->ColAlign[0] = "CENTER";
$t->ColAlign[1] = "CENTER";
$t->ColAlign[2] = "RIGHT";
$t->ColAlign[3] = "CENTER";
$t->execute();

echo "<br>";
/*
echo "<div align=right>";
echo "<form>";
echo "<input type=button value='Posting'>&nbsp;";
echo "<input type=button value='Check Out'>&nbsp;";
echo "</form>";
echo "</div>";
*/

?>
